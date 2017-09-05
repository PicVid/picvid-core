<?php
/**
 * Namespace for all Entities of PicVid.
 */
namespace PicVid\Domain\Entity;

/**
 * Class Entity
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Entity
 */
abstract class Entity
{
    /**
     * The id of the Entity.
     * @var int
     */
    public $id = 0;
}