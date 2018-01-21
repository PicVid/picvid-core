<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\Configuration;
use PicVid\Core\Database;
use PicVid\Core\Encryption;
use PicVid\Core\Service\AuthenticationService;
use PicVid\Core\View;
use PicVid\Domain\Entity\User;
use PicVid\Domain\Specification\User\IsUniqueEmail;
use PicVid\Domain\Specification\User\IsUniqueUsername;
use PicVid\Domain\Specification\User\IsValidEmail;
use PicVid\Domain\Specification\User\IsValidPassword;
use PicVid\Domain\Specification\User\IsValidUsername;

/**
 * Class InstallController
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Controller
 */
class InstallController extends Controller
{
    /**
     * The different tasks of the installation.
     */
    private const TASK_ADMIN_SAVE = 'admin-save';
    private const TASK_DATABASE_SAVE = 'database-save';
    private const TASK_STORAGE_SAVE = 'storage-save';

    /**
     * Method to get the task value from POST array and return if valid.
     * @return string The valid task or a empty value if the task value is not valid.
     */
    private function getTask() : string
    {
        //get the task from POST array and create an array with valid task values.
        $taskValue = filter_input(INPUT_POST, 'install-task', FILTER_DEFAULT);
        $validTasks = [self::TASK_ADMIN_SAVE, self::TASK_DATABASE_SAVE, self::TASK_STORAGE_SAVE];

        //check whether the task is valid and return the valid task.
        return (in_array($taskValue, $validTasks)) ? $taskValue : '';
    }

    /**
     * The default method / action of the Controller.
     * This is the first step of the installation, showing the requirements to successfully install.
     */
    public function index()
    {
        //get the requirements to install the system on the webserver.
        $isValidVersionPHP = version_compare(PHP_VERSION, '7.1') >= 0;
        $isAvailablePDO = extension_loaded('pdo');
        $isAvailableMySQL = extension_loaded('pdo_mysql');
        $isAvailableOpenSSL = extension_loaded('openssl');
        $isAvailableFileUpload = ini_get('file_uploads') === '1';

        //get the state to continue to the next step.
        $canContinue = $isValidVersionPHP && $isAvailablePDO && $isAvailableMySQL && $isAvailableOpenSSL & $isAvailableFileUpload;

        //get the configuration.
        $config = Configuration::getInstance();

        //set the values for the template tags / placeholders on CitoEngine and load the view.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'install-view');
        $cito->setValue('PAGE_TITLE', 'PicVid &raquo; Installation &raquo; Voraussetzungen');
        $cito->setValue('LOGO_URL', $config->getUrlResource().'template/img/picvid-logo.png');
        $cito->setValue('URL', $config->getUrl());
        $cito->setValue('php-version', PHP_VERSION);
        $cito->setValue('php-version-success', ($isValidVersionPHP ? 'fas fa-check' : 'fas fa-times'));
        $cito->setValue('pdo-status', ($isAvailablePDO && $isAvailableMySQL ? 'Aktiviert (MySQL)' : 'Deaktiviert'));
        $cito->setValue('pdo-status-success', ($isAvailablePDO ? 'fas fa-check' : 'fas fa-times'));
        $cito->setValue('openssl-status', ($isAvailableOpenSSL ? 'Aktiviert' : 'Deaktiviert'));
        $cito->setValue('openssl-status-success', ($isAvailableOpenSSL ? 'fas fa-check' : 'fas fa-times'));
        $cito->setValue('file-upload-status', ($isAvailableFileUpload ? 'Aktiviert' : 'Deaktiviert'));
        $cito->setValue('file-upload-status-success', ($isAvailableFileUpload ? 'fas fa-check' : 'fas fa-times'));
        $cito->setValue('file-upload-max-post-size', ini_get('post_max_size'));
        $cito->setValue('file-upload-max-file-size', ini_get('upload_max_filesize'));
        $cito->setValue('can-continue', ($canContinue ? '' : 'disabled'));
        (new View('Install'))->load();
    }

    /**
     * The database method / action of the Controller.
     * This is the second step of the installation to configure the database connection.
     */
    public function database()
    {
        //get the configuration.
        $config = Configuration::getInstance();

        //check whether the database configuration should be saved.
        if ($this->getTask() === self::TASK_DATABASE_SAVE) {

            //set the information to encrypt and decrypt the information.
            $config->ENCRYPTION_SECURITY_KEY = Encryption::getRandomKey();
            $encryption = new Encryption($config->ENCRYPTION_METHOD, $config->ENCRYPTION_SECURITY_KEY);

            //set the filter for the database information.
            $database_filter = [
                'database_host' => FILTER_DEFAULT,
                'database_port' => FILTER_VALIDATE_INT,
                'database_name' => FILTER_DEFAULT,
                'database_user' => FILTER_DEFAULT,
                'database_pass' => FILTER_DEFAULT
            ];

            //validate the information on POST.
            $database = filter_input_array(INPUT_POST, $database_filter);

            //check if the information is valid.
            if ($database === false) {
                $this->jsonOutput('Die Einstellungen der Datenbank sind nicht gültig!', 'database_host', 'error');
                exit;
            }

            //check if the hostname is available.
            if (trim($database['database_host']) === '') {
                $this->jsonOutput('Der Hostname wurde nicht angegeben!', 'database_host', 'error');
                exit;
            }

            //check if the port is available.
            if (trim($database['database_port']) === '') {
                $this->jsonOutput('Der Port wurde nicht angegeben!', 'database_port', 'error');
                exit;
            }

            //check if the database name is available.
            if (trim($database['database_name']) === '') {
                $this->jsonOutput('Der Name der Datenbank wurde nicht angegeben!', 'database_name', 'error');
                exit;
            }

            //check if the username is available.
            if (trim($database['database_user']) === '') {
                $this->jsonOutput('Der Benutzername wurde nicht angegeben!', 'database_username', 'error');
                exit;
            }

            //set and encrypt the database information.
            $config->DATABASE_HOST = $encryption->encrypt($database['database_host']);
            $config->DATABASE_PORT = $encryption->encrypt($database['database_port']);
            $config->DATABASE_NAME = $encryption->encrypt($database['database_name']);
            $config->DATABASE_USER = $encryption->encrypt($database['database_user']);
            $config->DATABASE_PASS = $encryption->encrypt($database['database_pass']);

            //parse the install.sql file on the resource folder and get all queries.
            $sqlContent = file_get_contents($config->getPathResource().'install.sql');
            $sqlContent = trim(preg_replace('/--.*\s/','', $sqlContent));
            $sqlContent = trim(preg_replace('/\s\s+/', ' ', $sqlContent));
            $sqlQueries = preg_split('/;/', $sqlContent);

            //filter all empty queries from the array (would cause an exception on PDO).
            $sqlQueries = array_filter($sqlQueries, function($v) {
                return (trim($v) !== '');
            });

            //get the database connection.
            $pdo = Database::getInstance()->getConnection();

            //execute all sql queries from install.sql file.
            foreach ($sqlQueries as $sqlQuery) {
                $pdo->exec($sqlQuery);
            }

            //write / save the configuration to the file.
            if (!$config->save()) {
                $this->jsonOutput('Die Einstellungen konnten nicht gespeichert werden!', '', 'error');
                exit;
            } else {
                $config->load();
            }

            //redirect to the next step (configure the admin user).
            $this->jsonOutput('', '', 'success', $config->getUrl().'install/admin');
            exit;
        } else {

            //set the values for the template tags / placeholders on CitoEngine.
            $cito = CitoEngine::getInstance();
            $cito->setValue('BODY_ID', 'install-view');
            $cito->setValue('PAGE_TITLE', 'PicVid &raquo; Installation &raquo; Datenbank');
            $cito->setValue('LOGO_URL', $config->getUrlResource().'template/img/picvid-logo.png');
            $cito->setValue('URL', $config->getUrl());

            //check if a security key is available to decrypt the information.
            if ($config->ENCRYPTION_SECURITY_KEY !== '' && $config->ENCRYPTION_METHOD !== '') {

                //get the object to encrypt and decrypt information.
                $encryption = new Encryption($config->ENCRYPTION_METHOD, $config->ENCRYPTION_SECURITY_KEY);

                //set the decrypted values to the form.
                $cito->setValue('database-host', $encryption->decrypt($config->DATABASE_HOST));
                $cito->setValue('database-port', $encryption->decrypt($config->DATABASE_PORT));
                $cito->setValue('database-name', $encryption->decrypt($config->DATABASE_NAME));
                $cito->setValue('database-user', $encryption->decrypt($config->DATABASE_USER));
            }

            //load the view.
            (new View('Install', 'Database'))->load();
        }
    }

    /**
     * The admin method / action of the Controller.
     * This is the third step of the installation to configure the admin user.
     */
    public function admin()
    {
        //get the configuration.
        $config = Configuration::getInstance();

        //check whether the admin user configuration should be saved.
        if ($this->getTask() === self::TASK_ADMIN_SAVE) {

            //create a new User Entity on database.
            $user = new User();
            $user->loadFromPOST('admin_');

            //check if the username of the User Entity is valid.
            if (!(new IsValidUsername())->isSatisfiedBy($user)) {
                $this->jsonOutput('Der Benutzername ist nicht gültig!', 'admin_username', 'error');
                exit;
            }

            //check if the email of the User Entity is valid.
            if (!(new IsValidEmail())->isSatisfiedBy($user)) {
                $this->jsonOutput('Die E-Mail ist nicht gültig!', 'admin_email', 'error');
                exit;
            }

            //check if the password of the User Entity is valid.
            if (!(new IsValidPassword())->isSatisfiedBy($user)) {
                $this->jsonOutput('Das Passwort ist nicht gültig!', 'admin_password', 'error');
                exit;
            }

            //check if the email of the User Entity already exists.
            if (!(new IsUniqueEmail())->isSatisfiedBy($user)) {
                $this->jsonOutput('Die E-Mail ist bereits vorhanden!', 'admin_email', 'error');
                exit;
            }

            //check if the username of the User Entity already exists.
            if (!(new IsUniqueUsername())->isSatisfiedBy($user)) {
                $this->jsonOutput('Der Benutzername ist bereits vorhanden!', 'admin_username', 'error');
                exit;
            }

            //register the new User Entity.
            if ((new AuthenticationService())->register($user)) {
                $this->jsonOutput('', '', 'info', $config->getUrl().'install/storage');
                exit;
            } else {
                $this->jsonOutput('Der Benutzer konnte nicht registriert werden!', '', 'error');
                exit;
            }
        } else {

            //set the values for the template tags / placeholders on CitoEngine and load the view.
            $cito = CitoEngine::getInstance();
            $cito->setValue('BODY_ID', 'install-view');
            $cito->setValue('PAGE_TITLE', 'PicVid &raquo; Installation &raquo; Administrator');
            $cito->setValue('LOGO_URL', $config->getUrlResource().'template/img/picvid-logo.png');
            $cito->setValue('URL', $config->getUrl());
            (new View('Install', 'Admin'))->load();
        }
    }

    /**
     * The storage and API method / action of the Controller.
     * This is the last step of the installation to configure the storage sizes and API keys.
     */
    public function storage()
    {
        //get the configuration.
        $config = Configuration::getInstance();

        //check whether the storage and API configuration should be saved.
        if ($this->getTask() === self::TASK_STORAGE_SAVE) {

            //set the API keys to the configuration.
            $config->API_PROJECT_HONEYPOT_KEY = $_POST['api_project_honeypot_key'];

            //set the filter for the limits of storage and file size.
            $size_filter = [
                'max_file_size' => FILTER_VALIDATE_INT,
                'max_storage_size' => FILTER_VALIDATE_INT
            ];

            //validate the information on POST.
            $limits = filter_input_array(INPUT_POST, $size_filter);

            //check if the information is valid.
            if ($limits === false) {
                $this->jsonOutput('Die Einstellungen der Speichergrößen sind nicht gültig!', 'max_file_size', 'error');
                exit;
            } else {
                $config->IMAGE_MAX_FILESIZE = intval($_POST['max_file_size']);
                $config->IMAGE_MAX_STORAGESIZE = intval($_POST['max_storage_size']);
            }

            //write / save the configuration to the file.
            if (!$config->save()) {
                $this->jsonOutput('Die Einstellungen konnten nicht gespeichert werden!', '', 'error');
                exit;
            } else {
                $config->load();
            }

            //redirect to the front page of the application.
            $this->jsonOutput('', '', 'info', $config->getUrl());
            exit;
        } else {

            //set the values for the template tags / placeholders on CitoEngine and load the view.
            $cito = CitoEngine::getInstance();
            $cito->setValue('BODY_ID', 'install-view');
            $cito->setValue('PAGE_TITLE', 'PicVid &raquo; Installation &raquo; Speicher und API');
            $cito->setValue('LOGO_URL', $config->getUrl().'/resource/template/img/picvid-logo.png');
            $cito->setValue('URL', $config->getUrl());
            (new View('Install', 'Storage'))->load();
        }
    }
}