<?php
/**
 * Namespace for all core classes of PicVid.
 */
namespace PicVid\Core;

/**
 * Class Database
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Core
 */
class Database
{
    /**
     * The instance of the Database.
     * @var Database|null
     */
    private static $instance = null;

    /**
     * The instance of PDO to use the database.
     * @var \PDO|null
     */
    private static $pdo = null;

    /**
     * Private constructor to prevent a new instance.
     */
    private function __construct()
    {
    }

    /**
     * Private clone method to prevent a new instance.
     */
    private function __clone()
    {
    }

    /**
     * Method to get a PDO connection to use the database.
     * @return null|\PDO An instance of PDO to use the database.
     */
    public function getConnection()
    {
        //check if a PDO database connection is available.
        if (self::$pdo === null) {
            $config = Configuration::getInstance();

            //get the Encryption object to decrypt the database information.
            $encryption = new Encryption($config->ENCRYPTION_METHOD, $config->ENCRYPTION_SECURITY_KEY);

            //set the connection with the decrypted database information.
            $this->setConnection(
                $encryption->decrypt($config->DATABASE_DRIVER),
                $encryption->decrypt($config->DATABASE_NAME),
                $encryption->decrypt($config->DATABASE_HOST),
                $encryption->decrypt($config->DATABASE_USER),
                $encryption->decrypt($config->DATABASE_PASS),
                intval($encryption->decrypt($config->DATABASE_PORT))
            );
        }

        //return the PDO database connection.
        return self::$pdo;
    }

    /**
     * Method to set a database connection with PDO.
     * @param string $driver The driver of the database system.
     * @param string $name The name of the database.
     * @param string $hostname The hostname of the database.
     * @param string $username The username of the database,
     * @param string $password The password of the database.
     * @param int $port The port of the database.
     * @return bool The status whether the connection was set successfully.
     */
    public function setConnection(string $driver, string $name, string $hostname, string $username, string $password, int $port) : bool
    {
        try {

            //check if the driver of the database system is available.
            if (!in_array($driver, \PDO::getAvailableDrivers())) {
                return false;
            }

            //set the data source name to connect with database.
            $dsn = $driver.':host='.$hostname.';port='.$port.';dbname='.$name;
            self::$pdo = new \PDO($dsn, $username, $password);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Method to get the instance of the Database.
     * @return Database An instance of the Database.
     */
    public static function getInstance() : Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
