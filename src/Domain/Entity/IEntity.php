<?php
/**
 * Namespace for all Entities of PicVid.
 */
namespace PicVid\Domain\Entity;

/**
 * Interface IEntity
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Entity
 */
interface IEntity
{
    /**
     * Method to check whether an ID exists in the Entity.
     * @return bool The status of whether an ID exists in the Entity.
     */
    public function hasID() : bool;

    /**
     * Method to load an array to the Entity.
     * @param array $array The array to load into the Entity.
     * @param string $prefix The prefix of the properties.
     * @return void
     */
    public function loadFromArray(array $array, string $prefix = '');

    /**
     * Method to load the GET array to the Entity.
     * @param string $prefix The prefix of the array index.
     * @return void
     */
    public function loadFromGET(string $prefix = '');

    /**
     * Method to load an object to the Entity.
     * @param object $object The object to load into the Entity.
     * @param string $prefix The prefix of the properties.
     * @return void
     */
    public function loadFromObject($object, string $prefix = '');

    /**
     * Method to load the POST array to the Entity.
     * @param string $prefix The prefix of the array index.
     * @return void
     */
    public function loadFromPOST(string $prefix = '');
}