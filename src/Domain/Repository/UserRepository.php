<?php
/**
 * Namespace for all Repositories of PicVid.
 */
namespace PicVid\Domain\Repository;

use PicVid\Domain\DataMapper\UserMapper;

/**
 * Class UserRepository
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Repository
 */
class UserRepository extends Repository
{
    /**
     * Method to build a new object of UserRepository.
     * @return UserRepository The created object of UserRepository.
     */
    public static function build() : UserRepository
    {
        return new self(UserMapper::build());
    }

    /**
     * Method to find and get all User Entities.
     * @return array An array with all found User Entities.
     */
    public function findAll() : array
    {
        //check if an UserMapper is available.
        if (!($this->dataMapper instanceof UserMapper)) {
            return [];
        } else {
            return $this->findAllEntities(get_class($this->dataMapper));
        }
    }

    /**
     * Method to find and get User Entities by email.
     * @param string $email The email to find and get the User Entities.
     * @return array An array with all found User Entities.
     */
    public function findByEmail(string $email) : array
    {
        //check if an UserMapper is available.
        if (!($this->dataMapper instanceof UserMapper)) {
            return [];
        }

        //return the result of the UserMapper.
        return $this->dataMapper->find("email = '".$email."'");
    }

    /**
     * Method to find and get User Entities by ID.
     * @param int $id The ID to find and get the User Entities.
     * @return array An array with all found User Entities.
     */
    public function findByID(int $id) : array
    {
        //check if an UserMapper is available.
        if (!($this->dataMapper instanceof UserMapper)) {
            return [];
        } else {
            return $this->findEntityByID($id, get_class($this->dataMapper));
        }
    }

    /**
     * Method to find and get User Entities by username.
     * @param string $username The username to find and get the User Entities.
     * @return array An array with all found User Entities.
     */
    public function findByUsername(string $username) : array
    {
        //check if an UserMapper is available.
        if (!($this->dataMapper instanceof UserMapper)) {
            return [];
        }

        //return the result of the UserMapper.
        return $this->dataMapper->find("username = '".$username."'");
    }
}