<?php
/**
 * Namespace for all Specifications of the Image Entities.
 */
namespace PicVid\Domain\Specification\Image;

use PicVid\Domain\Entity\IEntity;
use PicVid\Domain\Entity\Image;
use PicVid\Domain\Specification\ISpecification;

/**
 * Class IsValidDescription
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Specification\Image
 */
class IsValidDescription implements ISpecification
{
    /**
     * Method to check whether the Image Entity satisfies the Specification.
     * @param IEntity $image The Image Entity which will be checked.
     * @return bool The state if the Image Entity satisfies the Specification.
     */
    public function isSatisfiedBy(IEntity $image): bool
    {
        //check if the Entity is an Image Entity.
        if (!($image instanceof Image)) {
            return false;
        }

        //check whether the description of the Image Entity is valid.
        return strlen($image->description) <= 65535;
    }
}