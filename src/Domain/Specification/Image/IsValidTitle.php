<?php
/**
 * Namespace for all Specifications of the Image Entities.
 */
namespace PicVid\Domain\Specification\Image;

use PicVid\Domain\Entity\IEntity;
use PicVid\Domain\Entity\Image;
use PicVid\Domain\Specification\ISpecification;

/**
 * Class IsValidTitle
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Specification\Image
 */
class IsValidTitle implements ISpecification
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

        //return the state whether the Image Entity has a valid title.
        return strlen($image->title) <= 255;
    }
}
