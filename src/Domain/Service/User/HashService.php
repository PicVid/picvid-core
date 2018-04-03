<?php
/**
 * Namespace for all Services of User Entities.
 */
namespace PicVid\Domain\Service\User;

use PicVid\Domain\Entity\User;

/**
 * Class HashService
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Service\User
 */
class HashService
{
    /**
     * Method to hash the password information of an User Entity.
     * @param User $user The User Entity which should get hashed password information.
     * @return User The User Entity with the hashed password information.
     */
    public function hash(User $user) : User
    {
        $user->salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $user->password = hash('sha512', $user->password.$user->salt);
        return $user;
    }

    /**
     * Method to hash the password information of an User Entity.
     * @param User $user The User Entity which should get hashed password information.
     * @param string $salt The salt to create the hashed password information.
     * @return User The User Entity with the hashed password information.
     */
    public function hashWithSalt(User $user, string $salt) : User
    {
        $user->salt = $salt;
        $user->password = hash('sha512', $user->password.$user->salt);
        return $user;
    }
}
