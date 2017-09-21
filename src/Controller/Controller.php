<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\Database;
use PicVid\Core\Session;

/**
 * Class Controller
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Controller
 */
abstract class Controller implements IController
{
    /**
     * Method to redirect to an URL.
     * @param string $url The target URL to redirect.
     * @return void
     */
    protected function redirect(string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            header('Location: '.$url);
        }
    }

    /**
     * Method to redirect to a URL if no session exists.
     * @param string $redirectURL The target URL to redirect.
     * @return void
     */
    protected function needSession(string $redirectURL = URL)
    {
        //create the Session.
        $session = new Session();
        $session->create(Database::getInstance()->getConnection());

        //check if the Session is available.
        if (isset($_SESSION['user_username']) === false) {
            $this->redirect($redirectURL);
        }
    }
}