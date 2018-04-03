<?php
/**
* Namespace for all DataMapper of PicVid.
*/
namespace PicVid\Domain\DataMapper;

use PicVid\Domain\Entity\IEntity;

/**
 * Interface IDataMapper
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\DataMapper
 */
interface IDataMapper
{
    /**
     * IDataMapper constructor.
     * @param \PDO $pdo An instance of PDO to use the database.
     */
    public function __construct(\PDO $pdo);

    /**
     * Method to build the DataMapper to organize the Entity.
     * @return IDataMapper The DataMapper to organize the Entity.
     */
    public static function build() : IDataMapper;

    /**
     * Method to create an Entity on database.
     * @param IEntity $entity The Entity to be stored on the database.
     * @return bool The status of whether the Entity could be created.
     */
    public function create(IEntity $entity) : bool;

    /**
     * Method to delete an Entity on database.
     * @param IEntity $entity The Entity to be deleted on the database.
     * @return bool The status of whether the Entity could be deleted.
     */
    public function delete(IEntity $entity) : bool;

    /**
     * Method to find Entities by a SQL condition.
     * @param string $condition The SQL condition to filter the Entities.
     * @return array An array with all found Entities.
     */
    public function find(string $condition) : array;

    /**
     * Method to get the ID of a new created Entity on database.
     * @return int The ID of the new created Entity on database.
     */
    public function getInsertID() : int;

    /**
     * Method to save an Entity on database.
     * @param IEntity $entity The Entity to be saved on the database.
     * @return bool The status of whether the Entity could be saved.
     */
    public function save(IEntity $entity) : bool;

    /**
     * Method to update an Entity on database.
     * @param IEntity $entity The Entity to be updated on the database.
     * @return bool The status of whether the Entity could be updated.
     */
    public function update(IEntity $entity) : bool;
}
