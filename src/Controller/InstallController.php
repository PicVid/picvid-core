<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\Configuration;
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

        //get the configuration.
        $config = Configuration::getInstance();

        //set the values for the template tags / placeholders on CitoEngine.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'install-requirements');
        $cito->setValue('PAGE_TITLE', 'PicVid - Voraussetzungen');
        $cito->setValue('LOGO_URL', $config->URL.'/resource/template/img/picvid-logo.png');
        $cito->setValue('URL', $config->URL);
        $cito->setValue('php-version', PHP_VERSION);
        $cito->setValue('php-version-success', ($isValidVersionPHP ? 'fa-check' : 'fa-times'));
        $cito->setValue('pdo-status', ($isAvaiablePDO && $isAvailableMySQL ? 'Aktiviert (MySQL)' : 'Deaktiviert'));
        $cito->setValue('pdo-status-success', ($isAvaiablePDO ? 'fa-check' : 'fa-times'));
        $cito->setValue('file-upload-status', ($isAvailableFileUpload ? 'Aktiviert' : 'Deaktiviert'));
        $cito->setValue('file-upload-status-success', ($isAvailableFileUpload ? 'fa-check' : 'fa-times'));
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
        $cito->setValue('LOGO_URL', $config->URL.'/resource/template/img/picvid-logo.png');
        $cito->setValue('URL', $config->URL);
        $cito->setValue('url', str_replace('install/settings', '', $config->URL));
        $cito->setValue('absolute_path', $config->ABSPATH);

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
            $config->DB_HOST = $config_database['database_host'];
            $config->DB_PORT = intval($config_database['database_port']);
            $config->DB_NAME = $config_database['database_name'];
            $config->DB_USER = $config_database['database_user'];
            $config->DB_PASS = $config_database['database_pass'];
        }

        //check if the properties are valid.
        if (trim($config->DB_HOST) === '' || trim($config->DB_USER) === '' || trim($config->DB_NAME) === '' || trim($config->DB_PORT) === '') {
            $this->jsonOutput('The database settings are not valid!', 'database_host', 'error');
            return false;
        }

        //set the API keys.
        $config->PROJECT_HONEYPOT_KEY = $_POST['api_project_honeypot_key'];

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
            $config->MAX_IMAGE_SIZE = intval($_POST['max_file_size']);
            $config->MAX_STORAGE_SIZE = intval($_POST['max_storage_size']);
        }

        //write the configuration.
        if (!$config->write()) {
            $this->jsonOutput('The configuration could not be written!', '', 'error');
            return false;
        }

        //include the configuration.
        include($config->ABSPATH.'config.php');

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
            $this->jsonOutput('The User was successfully registered!', '', 'info', $config->URL);
            return true;
        } else {
            $this->jsonOutput('The User could not be registered!', '', 'error');
            return false;
        }
    }
}