<?php
/**
 * Namespace for all Repositories of PicVid.
 */
namespace PicVid\Domain\Repository;

use PicVid\Domain\DataMapper\IDataMapper;

/**
 * Class Repository
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Repository
 */
abstract class Repository implements IRepository
{
    /**
     * The DataMapper to use the database.
     * @var null|IDataMapper
     */
    protected $dataMapper = null;

    /**
     * Repository constructor.
     * @param IDataMapper $dataMapper The DataMapper to use the database.
     */
    public function __construct(IDataMapper $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    /**
     * Method to find and get all Entities without filter.
     * @param string $className The name of the DataMapper.
     * @return array An array with all found Entities.
     */
    protected function findAllEntities(string $className) : array
    {
        //check if a specific DataMapper is available.
        if (!($this->dataMapper instanceof $className)) {
            return [];
        }

        //return the result of the DataMapper.
        return $this->dataMapper->find('');
    }

    /**
     * Method to find and get Entities by ID.
     * @param int $id The ID to find and get the Entities.
     * @param string $className The name of the DataMapper.
     * @return array An array with all found Entities.
     */
    protected function findEntityByID(int $id, string $className) : array
    {
        //check if a specific DataMapper is available.
        if (!($this->dataMapper instanceof $className)) {
            return [];
        }

        //check if the parameter is an array.
        if (is_array($id)) {
            $condition = 'id IN ('.implode(', ', $id).')';
        } else {
            $condition = 'id = '.$id;
        }

        //return the result of the DataMapper.
        return $this->dataMapper->find($condition);
    }
}