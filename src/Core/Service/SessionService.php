<?php
/**
 * Namespace for all Services of the Core of PicVid.
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
     * Method to create a Session.
     * @param User $user The User Entity for which the Session is to be created.
     * @return void
     */
    public function create(User $user)
    {
        //create the Session.
        $session = new Session();
        $session->create(Database::getInstance()->getConnection());

        //set the information to the Session.
        $_SESSION['user_username'] = $user->username;
        $_SESSION['user_id'] = $user->id;
    }

    /**
     * Method to delete a Session.
     * @return void
     */
    public function delete()
    {
        session_destroy();
    }
}