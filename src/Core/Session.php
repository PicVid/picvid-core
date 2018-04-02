<?php
/**
 * Namespace for all core classes of PicVid.
 */
namespace PicVid\Core;

/**
 * Class Session
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Core
 */
class Session
{
    /**
     * The database connection.
     * @var null|\PDO
     */
    private $pdo = null;

    /**
     * Session constructor.
     * @param \PDO $pdo The database connection.
     */
    public function __construct(\PDO $pdo)
    {
        //set the database connection.
        $this->pdo = $pdo;

        //set the session handler to the methods of this class (if session is not active).
        if (!$this->isActive()) {
            session_set_save_handler(
                [$this, 'open'],
                [$this, 'close'],
                [$this, 'read'],
                [$this, 'write'],
                [$this, 'destroy'],
                [$this, 'gc']
            );
        }
    }

    /**
     * Method to close the session.
     * @return bool The status whether the session was closed.
     * @see https://secure.php.net/manual/en/sessionhandler.close.php
     */
    public function close() : bool
    {
        $this->pdo = null;
        return true;
    }

    /**
     * Method to create the session.
     * @return bool The status whether the session could be created.
     */
    public function create() : bool
    {
        //start the session (if not already started).
        if (!$this->isActive()) {
            session_start();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method to destroy the session.
     * @return bool The status whether the session could be destroyed.
     */
    public function delete() : bool
    {
        //destroy only the session (if started).
        if ($this->isActive()) {
            session_destroy();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method to destroy a session.
     * @param string $session_id The session id being destroyed.
     * @return bool The status whether the session was successfully destroyed.
     * @see https://secure.php.net/manual/en/sessionhandler.destroy.php
     */
    public function destroy(string $session_id) : bool
    {
        //create and set the sql query.
        $sql = 'DELETE FROM session WHERE id = :id';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query and return the state.
        $sth->bindParam(':id', $session_id, \PDO::PARAM_STR);
        return $sth->execute();
    }

    /**
     * Method to cleanup old sessions.
     * @param int $maxlifetime Sessions that have not updated for the last maxlifetime seconds will be removed.
     * @return bool The status of whether the cleanup was successful.
     * @see https://secure.php.net/manual/en/sessionhandler.gc.php
     */
    public function gc(int $maxlifetime) : bool
    {
        //set the statement to cleanup old sessions.
        $sql = 'DELETE FROM session WHERE access < :expired';
        $sth = $this->pdo->prepare($sql);

        //get the time for cleanup.
        $expired = (time() - $maxlifetime);

        //bind the values to the query and return the state.
        $sth->bindValue(':expired', $expired, \PDO::PARAM_INT);
        return $sth->execute();
    }

    /**
     * Method to get the status if the session is active.
     * @return bool The status if the session is active.
     */
    public function isActive() : bool
    {
        return (session_status() === PHP_SESSION_ACTIVE);
    }

    /**
     * Method to open the session.
     * @return bool The status whether the session was opened.
     * @see https://secure.php.net/manual/en/sessionhandler.open.php
     */
    public function open() : bool
    {
        return ($this->pdo instanceof \PDO);
    }

    /**
     * Method to read data from the session.
     * @param string $session_id The session id.
     * @return string The data or empty if the session was not found or is not valid.
     * @see https://secure.php.net/manual/en/sessionhandler.read.php
     */
    public function read(string $session_id) : string
    {
        //create and set the sql query.
        $sql = 'SELECT data, user_agent FROM session WHERE id = :id';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $session_id, \PDO::PARAM_STR);

        //execute the query and get the row from database.
        if ($sth->execute() && ($row = $sth->fetch(\PDO::FETCH_ASSOC))) {
            if ($row['user_agent'] === substr(getenv('HTTP_USER_AGENT'), 0, 255)) {
                return $row['data'];
            } else {
                $this->delete();
            }
        }

        //the session is not available or not valid.
        return '';
    }

    /**
     * Method to write data into the session.
     * @param string $session_id The session id.
     * @param string $session_data The encoded session data.
     * @return bool The status whether the data could be written to the session.
     * @see https://secure.php.net/manual/en/sessionhandler.write.php
     */
    public function write(string $session_id, string $session_data) : bool
    {
        //set the statement to insert or update the session data.
        $sql = 'INSERT INTO session (id, access, data, user_agent) VALUES (:id, :access, :data, :user_agent) ';
        $sql .= 'ON DUPLICATE KEY UPDATE access = :access, data = :data, user_agent = :user_agent';
        $sth = $this->pdo->prepare($sql);

        //set the time and user-agent.
        $time = time();
        $user_agent = substr(getenv('HTTP_USER_AGENT'), 0, 255);

        //bind the values to the query and return the state.
        $sth->bindParam(':id', $session_id, \PDO::PARAM_STR);
        $sth->bindParam(':access', $time, \PDO::PARAM_INT);
        $sth->bindParam(':data', $session_data, \PDO::PARAM_STR);
        $sth->bindParam(':user_agent', $user_agent, \PDO::PARAM_STR);
        return $sth->execute();
    }
}