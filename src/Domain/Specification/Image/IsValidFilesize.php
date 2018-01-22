<?php
/**
 * Namespace for all Specifications of the User Entities.
 */
namespace PicVid\Domain\Specification\Image;

use PicVid\Core\Configuration;
use PicVid\Domain\Entity\IEntity;
use PicVid\Domain\Entity\Image;
use PicVid\Domain\Specification\ISpecification;

/**
 * Class IsValidFilesize
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Specification\Image
 */
class IsValidFilesize implements ISpecification
{
    /**
     * Method to check whether the Image Entity satisfies the Specification.
     * @param IEntity $image The Image Entity which will be checked.
     * @return bool The state if the Image Entity satisfies the Specification.
     */
    public function isSatisfiedBy(IEntity $image): bool
    {
        //check if the Entity is an User Entity.
        if (!($image instanceof Image)) {
            return false;
        }

        //get the configuration to get the max filesize values.
        $config = Configuration::getInstance();

        //check whether the filesize exceeds the max filesize values.
        $isValidFile = $image->size <= $config->IMAGE_MAX_FILESIZE * pow(1000, 2);
        $isValidStorage = $image->size <= $config->IMAGE_MAX_STORAGESIZE * pow(1000, 2);

        //return the state whether the Image Entity has a valid filesize.
        return $isValidFile && $isValidStorage;
    }
}