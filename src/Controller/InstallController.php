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
     * The default method / action of the Controller.
     */
    public function index()
    {
        //get the requirements to install the system on the webserver.
        $isValidVersionPHP = version_compare(PHP_VERSION, '7.1') >= 0;
        $isAvaiablePDO = extension_loaded('pdo');
        $isAvailableMySQL = extension_loaded('pdo_mysql');
        $isAvailableFileUpload = ini_get('file_uploads') === '1';
        $isAvailableOpenSSL = extension_loaded('openssl');

        //get the configuration.
        $config = Configuration::getInstance();

        //set the values for the template tags / placeholders on CitoEngine.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'install-requirements');
        $cito->setValue('PAGE_TITLE', 'PicVid - Voraussetzungen');
        $cito->setValue('LOGO_URL', $config->getUrl().'/resource/template/img/picvid-logo.png');
        $cito->setValue('URL', $config->getUrl());
        $cito->setValue('php-version', PHP_VERSION);
        $cito->setValue('php-version-success', ($isValidVersionPHP ? 'fas fa-check' : 'fas fa-times'));
        $cito->setValue('pdo-status', ($isAvaiablePDO && $isAvailableMySQL ? 'Aktiviert (MySQL)' : 'Deaktiviert'));
        $cito->setValue('pdo-status-success', ($isAvaiablePDO ? 'fas fa-check' : 'fas fa-times'));
        $cito->setValue('openssl-status', ($isAvailableOpenSSL ? 'Aktiviert' : 'Deaktiviert'));
        $cito->setValue('openssl-status-success', ($isAvailableOpenSSL ? 'fas fa-check' : 'fas fa-times'));
        $cito->setValue('file-upload-status', ($isAvailableFileUpload ? 'Aktiviert' : 'Deaktiviert'));
        $cito->setValue('file-upload-status-success', ($isAvailableFileUpload ? 'fas fa-check' : 'fas fa-times'));
        $cito->setValue('file-upload-max-post-size', ini_get('post_max_size'));
        $cito->setValue('file-upload-max-file-size', ini_get('upload_max_filesize'));

        //load the view.
        (new View('Install', 'Requirements'))->load();
    }

    /**
     * The settings method / action of the Controller.
     */
    public function settings()
    {
        //get the configuration.
        $config = Configuration::getInstance();

        //set the values for the template tags / placeholders on CitoEngine.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'install-settings');
        $cito->setValue('PAGE_TITLE', 'PicVid - Einstellungen');
        $cito->setValue('LOGO_URL', $config->getUrl().'/resource/template/img/picvid-logo.png');
        $cito->setValue('URL', $config->getUrl());
        $cito->setValue('url', str_replace('install/settings', '', $config->getUrl()));
        $cito->setValue('absolute_path', $config->getPathAbsolute());

        //load the view.
        (new View('Install', 'Settings'))->load();
    }

    /**
     * The install method / action of the Controller.
     */
    public function install()
    {
        //get the configuration.
        $config = Configuration::getInstance();

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
        $config_database = filter_input_array(INPUT_POST, $database_filter);

        //check if the information is valid.
        if ($config_database === false) {
            $this->jsonOutput('The database settings are not valid!', 'database_host', 'error');
            return false;
        } else {
            $config->DATABASE_HOST = $config_database['database_host'];
            $config->DATABASE_PORT = intval($config_database['database_port']);
            $config->DATABASE_NAME = $config_database['database_name'];
            $config->DATABASE_USER = $config_database['database_user'];
            $config->DATABASE_PASS = $config_database['database_pass'];
        }

        //check if the properties are valid.
        if (trim($config->DATABASE_HOST) === '' || trim($config->DATABASE_USER) === '' || trim($config->DATABASE_NAME) === '' || trim($config->DATABASE_PORT) === '') {
            $this->jsonOutput('The database settings are not valid!', 'database_host', 'error');
            return false;
        }

        //encrypt the database information.
        $config->DATABASE_HOST = $encryption->encrypt($config->DATABASE_HOST);
        $config->DATABASE_PORT = $encryption->encrypt($config->DATABASE_PORT);
        $config->DATABASE_NAME = $encryption->encrypt($config->DATABASE_NAME);
        $config->DATABASE_USER = $encryption->encrypt($config->DATABASE_USER);
        $config->DATABASE_PASS = $encryption->encrypt($config->DATABASE_PASS);

        //set the API keys.
        $config->API_PROJECT_HONEYPOT_KEY = $_POST['api_project_honeypot_key'];

        //set the filter for the size limits.
        $size_filter = [
            'max_file_size' => FILTER_VALIDATE_INT,
            'max_storage_size' => FILTER_VALIDATE_INT
        ];

        //validate the information on POST.
        $config_size = filter_input_array(INPUT_POST, $size_filter);

        //check if the information is valid.
        if ($config_size === false) {
            $this->jsonOutput('The size limits are not valid!', 'max_file_size', 'error');
            return false;
        } else {
            $config->IMAGE_MAX_FILESIZE = intval($_POST['max_file_size']);
            $config->IMAGE_MAX_STORAGESIZE = intval($_POST['max_storage_size']);
        }

        //write the configuration.
        if (!$config->save()) {
            $this->jsonOutput('The configuration could not be written!', '', 'error');
            return false;
        } else {
            $config->load();
        }

        //parse the install.sql file to get all the queries.
        $sqlContent = file_get_contents($config->getPathResource().'install.sql');
        $sqlContent = trim(preg_replace('/--.*\s/','', $sqlContent));
        $sqlContent = trim(preg_replace('/\s\s+/', ' ', $sqlContent));
        $sqlQueries = preg_split('/;/', $sqlContent);

        //get the database connection.
        $pdo = Database::getInstance()->getConnection();

        //execute all sql queries from install.sql file.
        foreach ($sqlQueries as $sqlQuery) {
            if (trim($sqlQuery) !== '') {
                $pdo->exec($sqlQuery);
            }
        }

        //create a new User Entity on database.
        $user = new User();
        $user->loadFromPOST('admin_');

        //check if the username of the User Entity is valid.
        if (!(new IsValidUsername())->isSatisfiedBy($user)) {
            $this->jsonOutput('The username is not valid!', 'admin_username', 'error');
            return false;
        }

        //check if the email of the User Entity is valid.
        if (!(new IsValidEmail())->isSatisfiedBy($user)) {
            $this->jsonOutput('The email is not valid!', 'admin_email', 'error');
            return false;
        }

        //check if the password of the User Entity is valid.
        if (!(new IsValidPassword())->isSatisfiedBy($user)) {
            $this->jsonOutput('The password is not valid!', 'admin_password', 'error');
            return false;
        }

        //check if the email of the User Entity already exists.
        if (!(new IsUniqueEmail())->isSatisfiedBy($user)) {
            $this->jsonOutput('The email already exists!', 'admin_email', 'error');
            return false;
        }

        //check if the username of the User Entity already exists.
        if (!(new IsUniqueUsername())->isSatisfiedBy($user)) {
            $this->jsonOutput('The username already exists!', 'admin_username', 'error');
            return false;
        }

        //register the new User Entity.
        if ((new AuthenticationService())->register($user)) {
            $this->jsonOutput('The User was successfully registered!', '', 'info', $config->getUrl());
            return true;
        } else {
            $this->jsonOutput('The User could not be registered!', '', 'error');
            return false;
        }
    }
}