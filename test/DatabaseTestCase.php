<?php
/**
 * Namespace for all test classes of PicVid.
 */
namespace PicVid\Test;

use PHPUnit\DbUnit\Database\DefaultConnection;
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

/**
 * Class DatabaseTestCase
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Test
 */
abstract class DatabaseTestCase extends TestCase
{
    use TestCaseTrait;

    /**
     * The database connection with PDO.
     * @var null|\PDO
     */
    static private $pdo = null;

    /**
     * The database connection for PHPUnit test cases.
     * @var null|DefaultConnection
     */
    private $connection = null;

    /**
     * Method to get the PHPUnit database connection.
     * @return null|DefaultConnection
     */
    final public function getConnection() : DefaultConnection
    {
        //check whether a connection is already available.
        if ($this->connection === null) {

            //set the PDO connection if not available.
            if (self::$pdo == null) {

                //set the data source name depending on test environment.
                if (getenv('DB') === 'postgres') {
                    $dsn = getenv('DB_PGSQL_DSN');
                } elseif (getenv('DB') === 'mysql') {
                    $dsn = getenv('DB_MYSQL_DSN');
                } else {
                    $dsn = '';
                }

                //create and set the PDO database connection.
                self::$pdo = new \PDO($dsn, getenv('DB_USER'), getenv('DB_PASSWD'));
            }

            //create and set the PHPUnit database connection.
            $this->connection = $this->createDefaultDBConnection(self::$pdo, getenv('DB_DBNAME'));
        }

        //return the PHPUnit database connection.
        return $this->connection;
    }
}