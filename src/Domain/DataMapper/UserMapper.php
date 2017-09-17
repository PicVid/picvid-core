<?php
/**
 * Namespace for all DataMapper of PicVid.
 */
namespace PicVid\Domain\DataMapper;

use PicVid\Core\Database;
use PicVid\Domain\Entity\IEntity;
use PicVid\Domain\Entity\User;

/**
 * Class UserMapper
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\DataMapper
 */
class UserMapper extends DataMapper
{
    /**
     * UserMapper constructor.
     * @param \PDO $pdo An instance of PDO to use the database.
     */
    public function __construct(\PDO $pdo)
    {
        $this->table = 'user';
        $this->pdo = $pdo;
    }

    /**
     * Method to build the DataMapper to organize the Entity.
     * @return UserMapper The DataMapper to organize the Entity.
     */
    public static function build()
    {
        return new self(Database::getInstance()->getConnection());
    }

    /**
     * Method to create an User Entity on database.
     * @param IEntity $user The User Entity to save on database.
     * @return bool The status of whether the entity could be created.
     */
    public function create(IEntity $user) : bool
    {
        //check if a User Entity is available.
        if (!($user instanceof User)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'INSERT INTO '.$this->table.' (email, firstname, lastname, password, salt, username) ';
        $sql .= 'VALUES (:birthday, :email, :firstname, :gender, :lastname, :password, :salt, :username);';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':email', $user->email, \PDO::PARAM_STR);
        $sth->bindParam(':firstname', $user->firstname, \PDO::PARAM_STR);
        $sth->bindParam(':lastname', $user->lastname, \PDO::PARAM_STR);
        $sth->bindParam(':password', $user->password, \PDO::PARAM_STR);
        $sth->bindParam(':salt', $user->salt, \PDO::PARAM_STR);
        $sth->bindParam(':username', $user->username, \PDO::PARAM_STR);
        return $sth->execute();
    }

    /**
     * Method to delete an User Entity on database.
     * @param IEntity $user The User Entity to delete on database.
     * @return bool The status of whether the entity could be deleted.
     */
    public function delete(IEntity $user) : bool
    {
        //check if a User Entity is available.
        if (!($user instanceof User)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'DELETE FROM '.$this->table.' WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':id', $user->id, \PDO::PARAM_INT);
        return $sth->execute();
    }

    /**
     * Method to find User Entities by a SQL condition.
     * @param string $condition The SQL condition to filter the User Entities.
     * @return array An array with all found User Entities.
     */
    public function find(string $condition = '') : array
    {
        return $this->findForEntity($condition, new User());
    }

    /**
     * Method to save an User Entity on database.
     * @param IEntity $user The User Entity to save on database.
     * @return bool The status of whether the User Entity could be saved.
     */
    public function save(IEntity $user) : bool
    {
        //check if a User Entity is available.
        if (!($user instanceof User)) {
            return false;
        }

        //create or update the User Entity.
        return ($user->id > 0) ? $this->update($user) : $this->create($user);
    }

    /**
     * Method to update an User Entity on database.
     * @param IEntity $user The User Entity to update on database.
     * @return bool The status of whether the User Entity could be updated.
     */
    public function update(IEntity $user)
    {
        //check if a User Entity is available.
        if (!($user instanceof User)) {
            return false;
        }

        //create and set the sql query.
        $sql = 'UPDATE '.$this->table.' SET email = :email, firstname = :firstname, ';
        $sql .= 'lastname = :lastname, password = :password, salt = :salt, ';
        $sql .= 'username = :username WHERE id = :id';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query.
        $sth->bindParam(':email', $user->email, \PDO::PARAM_STR);
        $sth->bindParam(':firstname', $user->firstname, \PDO::PARAM_STR);
        $sth->bindParam(':lastname', $user->lastname, \PDO::PARAM_STR);
        $sth->bindParam(':password', $user->password, \PDO::PARAM_STR);
        $sth->bindParam(':salt', $user->salt, \PDO::PARAM_STR);
        $sth->bindParam(':username', $user->username, \PDO::PARAM_STR);
        $sth->bindParam(':id', $user->id, \PDO::PARAM_INT);
        return $sth->execute();
    }
}