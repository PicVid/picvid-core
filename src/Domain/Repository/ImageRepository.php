<?php
/**
 * Namespace for all Repositories of PicVid.
 */
namespace PicVid\Domain\Repository;

use PicVid\Domain\DataMapper\ImageMapper;
use PicVid\Domain\Entity\User;

/**
 * Class ImageRepository
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Repository
 */
class ImageRepository extends Repository
{
    /**
     * Method to build a new object of ImageRepository.
     * @return ImageRepository The created object of ImageRepository.
     */
    public static function build() : ImageRepository
    {
        return new self(ImageMapper::build());
    }

    /**
     * Method to find and get all Image Entities.
     * @return array An array with all found Image Entities.
     */
    public function findAll() : array
    {
        //check if an ImageMapper is available.
        if (!($this->dataMapper instanceof ImageMapper)) {
            return [];
        } else {
            return $this->findAllEntities(get_class($this->dataMapper));
        }
    }

    /**
     * Method to find and get Image Entities by ID.
     * @param int $id The ID to find and get the Image Entities.
     * @return array An array with all found Image Entities.
     */
    public function findByID(int $id) : array
    {
        //check if an ImageMapper is available.
        if (!($this->dataMapper instanceof ImageMapper)) {
            return [];
        } else {
            return $this->findEntityByID($id, get_class($this->dataMapper));
        }
    }

    /**
     * Method to find and get Image Entities by a User Entity.
     * @param User $user The User Entity to find and get the Image Entities.
     * @return array An array with all found Image Entities.
     */
    public function findByUser(User $user) : array
    {
        //check if a specific DataMapper is available.
        if (!($this->dataMapper instanceof ImageMapper)) {
            return [];
        }

        //create the condition and return the result.
        $condition = 'id IN (SELECT image_id FROM user_image WHERE user_id = '.$user->id.')';
        return $this->dataMapper->find($condition);
    }
}
