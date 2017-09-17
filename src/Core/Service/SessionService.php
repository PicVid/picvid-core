<?php
/**
 * Namespace for all services of the core of PicVid.
 */
namespace PicVid\Core\Service;

use PicVid\Core\Database;
use PicVid\Core\Session;
use PicVid\Domain\Entity\User;

/**
 * Class SessionService
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Core\Service
 */
class SessionService
{
    /**
     * Method to create a session.
     * @param User $user The User entity for which the Session is to be created.
     * @return void
     */
    public function create(User $user)
    {
        //create the session.
        $session = new Session();
        $session->create(Database::getInstance()->getConnection());

        //set the information to the session.
        $_SESSION['user_username'] = $user->username;
    }

    /**
     * Method to delete a session.
     * @return void
     */
    public function delete()
    {
        session_destroy();
    }
}