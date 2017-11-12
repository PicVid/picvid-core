<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\API\ProjectHoneyPot;
use PicVid\Core\CitoEngine;
use PicVid\Core\Configuration;
use PicVid\Core\Service\AuthenticationService;
use PicVid\Core\View;
use PicVid\Domain\Entity\User;
use PicVid\Domain\Specification\User\IsValidPassword;
use PicVid\Domain\Specification\User\IsValidUsername;

/**
 * Class LoginController
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Controller
 */
class LoginController extends Controller
{
    /**
     * The default method / action of the Controller.
     */
    public function index()
    {
        //get the configuration.
        $config = Configuration::getInstance();

        //set the values for the template tags / placeholders on CitoEngine.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'login-view');
        $cito->setValue('PAGE_TITLE', 'PicVid - Login');
        $cito->setValue('LOGO_URL', $config->URL.'/resource/template/img/picvid-logo.png');
        $cito->setValue('token', $this->getFormToken('token-login'));

        //load the view.
        (new View('Login'))->load();
    }

    /**
     * The login method / action of the Controller.
     */
    public function login()
    {
        //get the configuration.
        $config = Configuration::getInstance();

        //check whether the token is the same.
        if (!$this->verifyFormToken('token-login')) {
            $this->jsonOutput('The form state is not valid!', '', 'error');
            return false;
        }

        //check if the IP address is trusted (using Project Honey Pot).
        if ($config->PROJECT_HONEYPOT_KEY !== '') {
            if (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                if ((new ProjectHoneyPot($config->PROJECT_HONEYPOT_KEY))->check($_SERVER['REMOTE_ADDR'])) {
                    $this->jsonOutput('The IP you are using is not trusted!', '', 'error');
                    return false;
                }
            }
        }

        //load the User Entity from login form.
        $user = new User();
        $user->loadFromPOST('login_');

        //check if the username of the User Entity is valid.
        if ((new IsValidUsername())->isSatisfiedBy($user) === false) {
            $this->jsonOutput('The username is not valid!', 'login_username', 'error');
            return false;
        }

        //check if the password of the User Entity is valid.
        if ((new IsValidPassword())->isSatisfiedBy($user) === false) {
            $this->jsonOutput('The password is not valid!', 'login_email', 'error');
            return false;
        }

        //login the User Entity.
        if ((new AuthenticationService())->login($user)) {
            $this->jsonOutput('The User was successfully logged in!', '', 'info', $config->URL.'profile');
            return true;
        } else {
            $this->jsonOutput('The User could not be logged in!', '', 'error');
            return false;
        }
    }
}