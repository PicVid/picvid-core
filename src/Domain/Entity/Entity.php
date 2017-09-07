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
abstract class Entity implements IEntity
{
    /**
     * The id of the Entity.
     * @var int
     */
    public $id = 0;

    /**
     * Method to load an array to the Entity.
     * @param array $array The array to load into the Entity.
     * @param string $prefix The prefix of the properties.
     */
    public function loadFromArray($array, $prefix = '')
    {
        foreach (array_keys(get_class_vars(get_class($this))) as $property) {
            $arrayProperty = $prefix.$property;

            if (isset($array[$arrayProperty]) === true) {
                $this->$property = $array[$arrayProperty];
            }
        }
    }

    /**
     * Method to load an object to the Entity.
     * @param object $object The object to load into the Entity.
     * @param string $prefix The prefix of the properties.
     */
    public function loadFromObject($object, $prefix = '')
    {
        foreach (array_keys(get_class_vars(get_class($this))) as $property) {
            $objectProperty = $prefix.$property;

            if (isset($object->$objectProperty) === true) {
                $this->$property = $object->$objectProperty;
            }
        }
    }
}