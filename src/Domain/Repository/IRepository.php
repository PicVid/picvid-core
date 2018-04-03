<?php
/**
 * Namespace for all Repositories of PicVid.
 */
namespace PicVid\Domain\Repository;

use PicVid\Domain\DataMapper\IDataMapper;

/**
 * Interface IRepository
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Repository
 */
interface IRepository
{
    /**
     * IRepository constructor.
     * @param IDataMapper $dataMapper The DataMapper to use the database.
     */
    public function __construct(IDataMapper $dataMapper);

    /**
     * Method to build the Repository to get the Entities.
     * @return IRepository The Repository to get the Entities.
     */
    public static function build();

    /**
     * Method to find and get all Entities.
     * @return array An array with all found Entities.
     */
    public function findAll() : array;

    /**
     * Method to find and get Entities by ID.
     * @param int $id The ID to find and get the Entities.
     * @return array An array with all found Entities.
     */
    public function findByID(int $id) : array;
}
