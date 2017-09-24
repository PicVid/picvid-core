<?php
/**
 * Namespace for all Entities of PicVid.
 */
namespace PicVid\Domain\Entity;

/**
 * Class Entity
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
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
     * @return void
     */
    public function loadFromArray(array $array, string $prefix = '')
    {
        foreach (array_keys(get_class_vars(get_class($this))) as $property) {
            $arrayProperty = $prefix.$property;

            if (array_key_exists($arrayProperty, $array) === true) {
                $this->$property = $array[$arrayProperty];
            }
        }
    }

    /**
     * Method to load the GET array to the Entity.
     * @param string $prefix The prefix of the array index.
     * @return void
     */
    public function loadFromGET(string $prefix = '')
    {
        $this->loadFromGlobalArray(INPUT_GET, $prefix);
    }

    /**
     * Method to load an object to the Entity.
     * @param object $object The object to load into the Entity.
     * @param string $prefix The prefix of the properties.
     * @return void
     */
    public function loadFromObject($object, string $prefix = '')
    {
        foreach (array_keys(get_class_vars(get_class($this))) as $property) {
            $objectProperty = $prefix.$property;

            if (property_exists($object, $objectProperty) === true) {
                $this->$property = $object->$objectProperty;
            }
        }
    }

    /**
     * Method to load the POST array to the Entity.
     * @param string $prefix The prefix of the array index.
     * @return void
     */
    public function loadFromPOST(string $prefix = '')
    {
        $this->loadFromGlobalArray(INPUT_POST, $prefix);
    }

    /**
     * Method to load a value from a global array.
     * @param int $global The constant of the global array which will be loaded to the Entity.
     * @param string $prefix The prefix of the properties of the global array.
     * @return void
     */
    private function loadFromGlobalArray(int $global, string $prefix = '')
    {
        //map all the doc comment types to the globals.
        $filterMap['string'] = FILTER_DEFAULT;
        $filterMap['int'] = FILTER_VALIDATE_INT;
        $filterMap['bool'] = FILTER_VALIDATE_BOOLEAN;

        //run through all class properties.
        foreach (array_keys(get_class_vars(get_class($this))) as $property) {
            $globalProperty = $prefix.$property;

            //check if the property name exists on the global.
            if (filter_has_var($global, $globalProperty) === true) {
                $reflection = new \ReflectionProperty(get_class($this), $property);

                //get type from doc comments.
                if (preg_match('/@var\s+([^\s]+)/', $reflection->getDocComment(), $matches)) {
                    $value = filter_input($global, $globalProperty, $filterMap[$matches[1]], FILTER_NULL_ON_FAILURE);

                    //check if the validation was successfully.
                    if ($value !== null) {
                        $this->$property = $value;
                    }
                }
            }
        }
    }
}