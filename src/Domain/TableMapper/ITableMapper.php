<?php
/**
 * Namespace for all TableMapper of PicVid.
 */
namespace PicVid\Domain\TableMapper;

/**
 * Interface ITableMapper
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\TableMapper
 */
interface ITableMapper
{
    /**
     * ITableMapper constructor.
     * @param \PDO $pdo An instance of PDO to use the database.
     */
    public function __construct(\PDO $pdo);

    /**
     * Method to build the TableMapper to organize the mapping between Entities.
     * @return ITableMapper The TableMapper to organize the mapping between Entities.
     */
    public static function build();
}