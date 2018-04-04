<?php
/**
 * Namespace for all core classes of PicVid.
 */
namespace PicVid\Core;

/**
 * Class Configuration
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Core
 */
class Configuration
{
    /**
     * The API key for the Project Honeypot API.
     * @see https://www.projecthoneypot.org/httpbl_api.php
     * @var string
     */
    public $API_PROJECT_HONEYPOT_KEY = '';

    /**
     * The encryption method to encrypt and decrypt the information.
     * @see http://php.net/manual/en/function.openssl-get-cipher-methods.php
     * @var string
     */
    public $ENCRYPTION_METHOD = 'AES-256-CBC';

    /**
     * The security key to encrypt and decrypt the information.
     * @var string
     */
    public $ENCRYPTION_SECURITY_KEY = '';

    /**
     * The driver of the database system.
     * @var string
     */
    public $DATABASE_DRIVER = '';

    /**
     * The hostname to connect with database.
     * @var string
     */
    public $DATABASE_HOST = '';

    /**
     * The name of the database to connect with database.
     * @var string
     */
    public $DATABASE_NAME = '';

    /**
     * The password to connect with database.
     * @var string
     */
    public $DATABASE_PASS = '';

    /**
     * The port number to connect with database.
     * @var int
     */
    public $DATABASE_PORT = 0;

    /**
     * The username to connect with database.
     * @var string
     */
    public $DATABASE_USER = '';

    /**
     * The valid image file types (for upload).
     * @var array
     */
    public $IMAGE_ALLOWED_FILETYPES = ['image/jpeg', 'image/png', 'image/tiff', 'image/x-windows-bmp', 'image/bmp'];

    /**
     * The maximum file size of the image files (bytes).
     * @var float
     */
    public $IMAGE_MAX_FILESIZE = 0.0;

    /**
     * The maximum size of the storage to store image files (bytes).
     * @var float
     */
    public $IMAGE_MAX_STORAGESIZE = 0.0;

    /**
     * The instance of the Configuration.
     * @var Configuration|null
     */
    private static $instance = null;

    /**
     * Method to get the instance of the Configuration.
     * @return Configuration An instance of the Configuration.
     */
    public static function getInstance() : Configuration
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Method to get the absolute path of the application.
     * @return string The absolute path of the application.
     */
    public function getPathAbsolute() : string
    {
        return getcwd().DIRECTORY_SEPARATOR;
    }

    /**
     * Method to get the configuration path of the application.
     * @return string The configuration path of the application.
     */
    public function getPathConfiguration() : string
    {
        return $this->getPathAbsolute().'config.json';
    }

    /**
     * Method to get the image path of the application.
     * @return string The image path of the application.
     */
    public function getPathImage() : string
    {
        return $this->getPathAbsolute().'data'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR;
    }

    /**
     * Method to get the resource path of the application.
     * @return string The resource path of the application.
     */
    public function getPathResource() : string
    {
        return $this->getPathAbsolute().'resource'.DIRECTORY_SEPARATOR;
    }

    /**
     * Method to get the source path of the application.
     * @return string The source path of the application.
     */
    public function getPathSource() : string
    {
        return $this->getPathAbsolute().'src'.DIRECTORY_SEPARATOR;
    }

    /**
     * Method to get the view path of the application.
     * @return string The view path of the application.
     */
    public function getPathView() : string
    {
        return $this->getPathSource().'View'.DIRECTORY_SEPARATOR;
    }

    /**
     * Method to get the max POST size of the PHP server.
     * @return int The max POST size of the PHP server.
     */
    public function getPostMaxSize() : int
    {
        return (int) (str_replace('M', '', ini_get('post_max_size')) * pow(1024, 2));
    }

    /**
     * Method to get the resource URL of the application.
     * @return string The resource URL of the application.
     */
    public function getUrlResource() : string
    {
        return $this->getUrl().'resource'.DIRECTORY_SEPARATOR;
    }

    /**
     * Method to get the URL of the application.
     * @return string The URL of the application.
     */
    public function getUrl() : string
    {
        return (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/';
    }

    /**
     * Method to get the images url of the application.
     * @return string The images url of the application.
     */
    public function getUrlImage() : string
    {
        return $this->getUrl().'data/images/';
    }

    /**
     * Method to save the Configuration to the JSON file.
     * @return bool The state if the Configuration could be written.
     */
    public function save() : bool
    {
        //initialize the array of the configuration properties.
        $config = [];

        //run through all properties of the configuration.
        foreach (get_object_vars($this) as $property_name => $property_value) {
            $arr = preg_split('/[\_]/', $property_name, 2);

            //get the group of the property and the property itself.
            $group = $arr[0];
            $property = $arr[1];

            //add the group if the group doesn't exists.
            if (!isset($config[$group])) {
                $config[$group] = [];
            }

            //add the property with value if the property doesn't exists on the group.
            if (!isset($config[$group][$property])) {
                $config[$group][$property] = $property_value;
            }
        }

        //write the configuration to the JSON file.
        return file_put_contents($this->getPathConfiguration(), json_encode($config, JSON_PRETTY_PRINT));
    }

    /**
     * Method to load the Configuration of the JSON file.
     */
    public function load()
    {
        //check if the configuration exists.
        if (!$this->exists()) {
            return;
        }

        //get the configuration array from JSON file.
        $config = json_decode(file_get_contents($this->getPathConfiguration()), true);

        //run through all properties of the configuration.
        foreach (get_object_vars($this) as $property_name => $property_value) {
            $arr = preg_split('/[\_]/', $property_name, 2);

            //get the group of the property and the property itself.
            $group = $arr[0];
            $property = $arr[1];

            //check if the group is available.
            if (!isset($config[$group])) {
                continue;
            }

            //check if the property on the group is available.
            if (!isset($config[$group][$property])) {
                continue;
            } else {
                $this->$property_name = $config[$group][$property];
            }
        }
    }

    /**
     * Method to get the status if the Configuration file exists.
     * @return bool The state if the Configuration file exists.
     */
    public function exists() : bool
    {
        return file_exists($this->getPathConfiguration());
    }
}
