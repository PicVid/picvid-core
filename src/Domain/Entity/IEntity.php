<?php
/**
 * Namespace for all Entities of PicVid.
 */
namespace PicVid\Domain\Entity;

/**
 * Interface IEntity
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Entity
 */
interface IEntity
{
    /**
     * Method to load an array to the Entity.
     * @param array $array The array to load into the Entity.
     * @param string $prefix The prefix of the properties.
     */
    public function loadFromArray($array, $prefix = '');

    /**
     * Method to load an object to the Entity.
     * @param object $object The object to load into the Entity.
     * @param string $prefix The prefix of the properties.
     */
    public function loadFromObject($object, $prefix = '');
}