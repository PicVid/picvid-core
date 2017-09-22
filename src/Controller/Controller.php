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
     * Method to create and output a JSON output for AJAX.
     * @param string $message The message to display on the alert.
     * @param string $field The field to focus (e.g. for invalid field values).
     * @param string $level The message level to display (used for alert color).
     * @param string $redirect The redirect URL to redirect after successfull AJAX call.
     * @return void
     */
    protected function jsonOutput(string $message, string $field, string $level, string $redirect = '')
    {
        echo json_encode([
            'message' => $message,
            'field' => $field,
            'state' => $level,
            'redirect' => $redirect
        ]);
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
}