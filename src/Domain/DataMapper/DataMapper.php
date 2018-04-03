<?php
/**
 * Namespace for all DataMapper of PicVid.
 */
namespace PicVid\Domain\DataMapper;

use PicVid\Domain\Entity\Entity;
use PicVid\Domain\Entity\IEntity;

/**
 * Class DataMapper
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\DataMapper
 */
abstract class DataMapper implements IDataMapper
{
    /**
     * The ID of a new created Entity on database (ID > 0).
     * @var int
     */
    protected $insert_id = 0;

    /**
     * An instance of PDO to use the database.
     * @var null|\PDO
     */
    protected $pdo = null;

    /**
     * The name of the table.
     * @var string
     */
    protected $table = '';

    /**
     * Method to delete an Entity on database.
     * @param IEntity $entity The Entity to be deleted on the database.
     * @return bool The status of whether the Entity could be deleted.
     */
    public function delete(IEntity $entity) : bool
    {
        //check whether a Entity is available.
        if (!($entity instanceof Entity)) {
            return false;
        }

        //check whether an ID exists.
        if (!$entity->hasID()) {
            return false;
        }

        //create and set the sql query.
        $sql = 'DELETE FROM '.$this->table.' WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query and execute the query.
        $sth->bindParam(':id', $entity->id, \PDO::PARAM_INT);
        return $sth->execute();
    }

    /**
     * Method to find Entities by a SQL condition for an Entity.
     * @param string $condition The SQL condition to filter the Entities.
     * @param IEntity $entity The object of the Entity which will be loaded.
     * @return array An array with all found Entities.
     */
    protected function findForEntity(string $condition, IEntity $entity) : array
    {
        //create and set the sql query.
        $sql = 'SELECT * FROM '.$this->table.((trim($condition) !== '') ? ' WHERE '.$condition : '');
        $sth = $this->pdo->prepare($sql);
        $sth->execute();

        //fetch all the results as Entities.
        return $sth->fetchAll(\PDO::FETCH_CLASS, get_class($entity));
    }

    /**
     * Method to get the ID of a new created Entity on database.
     * @return int The ID of the new created Entity on database.
     */
    public function getInsertID() : int
    {
        return $this->insert_id;
    }
}
