<?php
/**
 * Namespace for all Services of the Core of PicVid.
 */
namespace PicVid\Core\Service;

use PicVid\Domain\DataMapper\UserMapper;
use PicVid\Domain\Entity\User;
use PicVid\Domain\Repository\UserRepository;
use PicVid\Domain\Service\User\HashService;

/**
 * Class AuthenticationService
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Core\Service
 */
class AuthenticationService
{
    /**
     * Method to login an User Entity.
     * @param User $user The User Entity to be logged in.
     * @return bool The status of whether the User Entity could be logged in.
     */
    public function login(User $user) : bool
    {
        //load the User Entity from database.
        $users = UserRepository::build()->findByUsername($user->username);

        //check if an User Entity could be found.
        if (count($users) === 1) {
            $userDB = $users[0];

            //check if an User Entity is available.
            if ($userDB instanceof User) {

                //hash the input information to compare with the found User Entity.
                $hashService = new HashService();
                $user = $hashService->hashWithSalt($user, $userDB->salt);

                //check if the password match.
                if ($userDB->password === $user->password) {
                    (new SessionService())->create($userDB);
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Method to logout a User (current Session).
     * @return void
     */
    public function logout()
    {
        (new SessionService())->delete();
    }

    /**
     * Method to register an User Entity.
     * @param User $user The User Entity to be registered.
     * @return bool The status of whether the User Entity could be registered.
     */
    public function register(User $user) : bool
    {
        //get the User Entity with the hashed password information.
        $hashingService = new HashService();
        $user = $hashingService->hash($user);

        //save the User Entity and return the state.
        return UserMapper::build()->save($user);
    }
}