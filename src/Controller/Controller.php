<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\Configuration;
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
     * Method to create a token for a form to protect it against CSRF attacks.
     * @param string $formName The name of the form used for the session.
     * @return string The token of the form to protect it against CSRF attacks.
     */
    protected function getFormToken(string $formName) : string
    {
        //create the Session.
        $session = new Session();
        $session->create(Database::getInstance()->getConnection());

        //create a form token and set the token to the session.
        $token = md5(uniqid(microtime(), true));
        $_SESSION[$formName.'_token'] = $token;

        //return the form token.
        return $token;
    }

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
    protected function needSession(string $redirectURL = '')
    {
        //create the Session.
        $session = new Session();
        $session->create(Database::getInstance()->getConnection());

        //check if the Session is available.
        if (isset($_SESSION['user_username']) === false) {
            $config = Configuration::getInstance();
            $this->redirect(($redirectURL === '') ? $config->URL : $redirectURL);
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

    /**
     * Method to set a response code.
     * @param int $code The status code which will be set as response code.
     * @return void
     */
    protected function setResponseCode(int $code)
    {
        //TODO - create a full list of all valid codes: http://php.net/manual/en/function.http-response-code.php#107261
        header($_SERVER["SERVER_PROTOCOL"].' '.$code.' See Other');
    }

    /**
     * Method to check the token of the form.
     * @param string $formName The name of the form used for the session.
     * @return bool The status whether the token is valid.
     */
    function verifyFormToken(string $formName) : bool
    {
        //create the Session.
        $session = new Session();
        $session->create(Database::getInstance()->getConnection());

        //check if there is a session with the token.
        if (!isset($_SESSION[$formName.'_token'])) {
            return false;
        }

        //check if there is a token of the form.
        if (!isset($_POST['token'])) {
            return false;
        }

        //check whether the token of the form is identical to the token of the session.
        if ($_SESSION[$formName.'_token'] !== $_POST['token']) {
            return false;
        }

        //the tokens are valid.
        return true;
    }
}