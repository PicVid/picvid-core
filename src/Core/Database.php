<?php
/**
 * Namespace for all core classes of PicVid.
 */
namespace PicVid\Core;

/**
 * Class Database
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
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
            $this->setConnection(DB_NAME, DB_HOST, DB_USER, DB_PASS, DB_PORT);
        }

        //return the PDO database connection.
        return self::$pdo;
    }

    /**
     * Method to set a database connection with PDO.
     * @param string $name The name of the database.
     * @param string $hostname The hostname of the database.
     * @param string $username The username of the database,
     * @param string $password The password of the database.
     * @param int $port The port of the database (default 3306).
     * @return bool The status whether the connection was set successfully.
     */
    public function setConnection(string $name, string $hostname, string $username, string $password, int $port = 3306)
    {
        try {
            $dsn = 'mysql:host='.$hostname.';port='.$port.';dbname='.$name;
            self::$pdo = new \PDO($dsn, $username, $password);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Method to get the instance of the Database.
     * @return Database|null An instance of the Database.
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}