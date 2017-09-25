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
     * The PDO object to connect with the database.
     * @var null|\PDO
     */
    private $pdo = null;

    /**
     * Method to close the session.
     * @return bool The status whether the session is closed.
     */
    public function close() : bool
    {
        $this->pdo = null;
        return true;
    }

    /**
     * Method to create a session and set the information.
     * @param \PDO $pdo The PDO object to connect with database.
     * @return void
     */
    public function create(\PDO $pdo)
    {
        $this->pdo = $pdo;

        //override the session handler with the own.
        session_set_save_handler(
            array($this, 'open'),
            array($this, 'close'),
            array($this, 'read'),
            array($this, 'write'),
            array($this, 'destroy'),
            array($this, 'gc')
        );

        //start the session (if not already started).
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Method to destroy a session.
     * @param string $id The ID of the session.
     * @return bool The status of whether the session could be destroyed.
     */
    public function destroy(string $id) : bool
    {
        //create and set the sql query.
        $sql = 'DELETE FROM session WHERE id = :id';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query and return the state.
        $sth->bindParam(':id', $id, \PDO::PARAM_STR);
        return $sth->execute();
    }

    /**
     * Method which represent the garbage collector to destroy expired sessions.
     * @param int $lifetime The lifetime of the session in seconds.
     * @return bool The state if the garbage collector was successful.
     */
    public function gc(int $lifetime) : bool
    {
        //create and set the sql query.
        $sql = 'DELETE FROM session WHERE create_time < :expired';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query and return the state.
        $sth->bindValue(':expired', (time() - $lifetime), \PDO::PARAM_INT);
        return $sth->execute();
    }

    /**
     * Method to open the session.
     * @return bool The status of whether the session could be opened.
     */
    public function open() : bool
    {
        return ($this->pdo instanceof \PDO);
    }

    /**
     * Method to read the session.
     * @param string $id The ID of the session.
     * @return string The content of the session.
     */
    public function read(string $id) : string
    {
        //create and set the sql query.
        $sql = 'SELECT content, user_agent FROM session WHERE id = :id';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $id, \PDO::PARAM_STR);

        //execute the query and get the row from database.
        if ($sth->execute() && ($row = $sth->fetch(\PDO::FETCH_ASSOC))) {
            if ($row['user_agent'] !== md5(getenv('HTTP_USER_AGENT'))) {
                session_destroy();
                return '';
            } else {
                return $row['content'];
            }
        } else {
            return '';
        }
    }

    /**
     * Method to write the session.
     * @param string $id The ID of the session.
     * @param string $content The content of the session.
     * @return bool The status of whether the session could be written.
     */
    public function write(string $id, string $content) : bool
    {
        //create and set the sql query.
        $sql = 'REPLACE INTO session (id, content, create_time, user_agent) VALUES (:id, :content, :create_time, :user_agent)';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query and return the state.
        $sth->bindParam(':id', $id, \PDO::PARAM_STR);
        $sth->bindParam(':content', $content, \PDO::PARAM_STR);
        $sth->bindValue(':create_time', time(), \PDO::PARAM_INT);
        $sth->bindValue(':user_agent', md5(getenv('HTTP_USER_AGENT')), \PDO::PARAM_STR);
        return $sth->execute();
    }
}