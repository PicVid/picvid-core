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
     * The absolute path of the application.
     * @var string
     */
    public $ABSPATH = '';

    /**
     * The directory of the data files.
     * @var string
     */
    public $DATADIR = '';

    /**
     * The URL of the data files.
     * @var string
     */
    public $DATAURL = '';

    /**
     * The hostname to connect with database.
     * @var string
     */
    public $DB_HOST = '';

    /**
     * The name of the database to connect with database.
     * @var string
     */
    public $DB_NAME = '';

    /**
     * The password of the database to connect with database.
     * @var string
     */
    public $DB_PASS = '';

    /**
     * The port number to connect with database.
     * @var int
     */
    public $DB_PORT = 0;

    /**
     * The username of the database to connect with database.
     * @var string
     */
    public $DB_USER = '';

    /**
     * The directory of the image files.
     * @var string
     */
    public $IMGDIR = '';

    /**
     * The URL of the image files.
     * @var string
     */
    public $IMGURL = '';

    /**
     * The maximum file size of the image files (bytes).
     * @var int
     */
    public $MAX_IMAGE_SIZE = 0;

    /**
     * The maximum size of the storage to store image files (bytes).
     * @var int
     */
    public $MAX_STORAGE_SIZE = 0;

    /**
     * The API key for the Project Honeypot API.
     * @var string
     */
    public $PROJECT_HONEYPOT_KEY = '';

    /**
     * The resource path of the application.
     * @var string
     */
    public $RESPATH = '';

    /**
     * The source path of the application.
     * @var string
     */
    public $SRCPATH = '';

    /**
     * The directory of the View files.
     * @var string
     */
    public $VIEWDIR = '';

    /**
     * The directory for the uploaded files.
     * @var string
     */
    public $UPLOADDIR = '';

    /**
     * The URL of the application.
     * @var string
     */
    public $URL = '';

    /**
     * The instance of the Configuration.
     * @var Configuration|null
     */
    private static $instance = null;

    /**
     * Private constructor to prevent a new instance.
     */
    private function __construct()
    {
       $this->detect();
    }

    /**
     * Private clone method to prevent a new instance.
     */
    private function __clone()
    {
    }

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
     * Method to detect the settings from server and user information.
     */
    private function detect()
    {
        //get the absolute path and URL of the application.
        $this->ABSPATH = $this->getAbsolutePath();
        $this->URL = $this->getURL();

        //we can get the other path and URL values from absolute path and URL.
        $this->DATADIR = $this->ABSPATH.'data'.DIRECTORY_SEPARATOR;
        $this->DATAURL = $this->URL.'data'.DIRECTORY_SEPARATOR;
        $this->IMGDIR = $this->DATADIR.'images'.DIRECTORY_SEPARATOR;
        $this->IMGURL = $this->DATAURL.'images'.DIRECTORY_SEPARATOR;
        $this->RESPATH = $this->ABSPATH.'resource'.DIRECTORY_SEPARATOR;
        $this->SRCPATH = $this->ABSPATH.'src'.DIRECTORY_SEPARATOR;
        $this->UPLOADDIR = $this->DATADIR.'upload'.DIRECTORY_SEPARATOR;
        $this->VIEWDIR = $this->SRCPATH.'View'.DIRECTORY_SEPARATOR;
    }

    /**
     * Method to get the absolute path of the application.
     * @return string The absolute path of the application.
     */
    private function getAbsolutePath() : string
    {
        return getcwd().DIRECTORY_SEPARATOR;
    }

    /**
     * Method to get the configuration path of the application.
     * @return string The configuration path of the application.
     */
    private function getConfigPath() : string
    {
        return $this->getAbsolutePath().'config.php';
    }

    /**
     * Method to get the URL of the application.
     * @return string The URL of the application.
     */
    private function getURL() : string
    {
        return (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/';
    }

    /**
     * Method to load the configuration from configuration file (constants).
     */
    public function load()
    {
        //check whether a installation is needed.
        if (!file_exists($this->getConfigPath()) && strpos($_SERVER['REQUEST_URI'], 'install') === false) {
            header('Location: install');
            exit;
        }

        //check whether the configuration file is available.
        if (file_exists($this->getConfigPath())) {
            require($this->getConfigPath());
        }

        //loading the database information from global configuration (constants).
        $this->DB_HOST = (defined('DB_HOST') ? \DB_HOST : '');
        $this->DB_PORT = (defined('DB_PORT') ? \DB_PORT : 0);
        $this->DB_PASS = (defined('DB_PASS') ? \DB_PASS : '');
        $this->DB_NAME = (defined('DB_NAME') ? \DB_NAME : '');
        $this->DB_USER = (defined('DB_USER') ? \DB_USER : '');

        //loading the API key of the Project Honeypot API from global configuration (constants).
        $this->PROJECT_HONEYPOT_KEY = (defined('PROJECT_HONEYPOT_KEY') ? \PROJECT_HONEYPOT_KEY : '');

        //load the image and storage size from global configuration (constants).
        $this->MAX_STORAGE_SIZE = (defined('MAX_STORAGE_SIZE') ? \MAX_STORAGE_SIZE : 0);
        $this->MAX_IMAGE_SIZE = (defined('MAX_IMAGE_SIZE') ? \MAX_IMAGE_SIZE : 0);

        //check whether the configuration file is available.
        if (file_exists($this->getConfigPath()) && strpos($_SERVER['REQUEST_URI'], 'install') !== false) {
            header('Location: '.$this->getURL());
            exit;
        }
    }

    /**
     * Method to write the configuration from properties to file.
     * @return bool The state if the configuration file could be written.
     */
    public function write() : bool
    {
        //create the file content based on the properties.
        $fileContent = "<?php\n";
        $fileContent .= "//database configuration.\n";
        $fileContent .= "define('DB_HOST', '".$this->DB_HOST."');\n";
        $fileContent .= "define('DB_PORT', ".$this->DB_PORT.");\n";
        $fileContent .= "define('DB_NAME', '".$this->DB_NAME."');\n";
        $fileContent .= "define('DB_USER', '".$this->DB_USER."');\n";
        $fileContent .= "define('DB_PASS', '".$this->DB_PASS."');\n\n";
        $fileContent .= "//the project honeypot key.\n";
        $fileContent .= "define('PROJECT_HONEYPOT_KEY', '".$this->PROJECT_HONEYPOT_KEY."');\n\n";
        $fileContent .= "//max image size and storage size.\n";
        $fileContent .= "define('MAX_IMAGE_SIZE', ".$this->MAX_IMAGE_SIZE.");\n";
        $fileContent .= "define('MAX_STORAGE_SIZE', ".$this->MAX_STORAGE_SIZE.");\n";

        //write the file and return the state.
        return (file_put_contents($this->getConfigPath(), $fileContent) !== false);
    }
}