<?php
/**
 * Namespace for all TableMapper of PicVid.
 */
namespace PicVid\Domain\TableMapper;

/**
 * Class TableMapper
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\TableMapper
 */
abstract class TableMapper implements ITableMapper
{
    /**
     * An instance of PDO to use the database.
     * @var null|\PDO
     */
    protected $pdo = null;

    /**
     * TableMapper constructor.
     * @param \PDO $pdo An instance of PDO to use the database.
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}