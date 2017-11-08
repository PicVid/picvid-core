<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\API\ProjectHoneyPot;
use PicVid\Core\CitoEngine;
use PicVid\Core\Service\AuthenticationService;
use PicVid\Core\View;
use PicVid\Domain\Entity\User;
use PicVid\Domain\Specification\User\IsUniqueEmail;
use PicVid\Domain\Specification\User\IsUniqueUsername;
use PicVid\Domain\Specification\User\IsValidEmail;
use PicVid\Domain\Specification\User\IsValidPassword;
use PicVid\Domain\Specification\User\IsValidUsername;

/**
 * Class RegisterController
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Controller
 */
class RegisterController extends Controller
{
    /**
     * The default method / action of the Controller.
     */
    public function index()
    {
        //set the values for the template tags / placeholders on CitoEngine.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'register-view');
        $cito->setValue('PAGE_TITLE', 'PicVid - Register');
        $cito->setValue('LOGO_URL', URL.'/resource/template/img/picvid-logo.png');
        $cito->setValue('token', $this->getFormToken('token-register'));

        //load the view.
        $view = new View('Register');
        $view->load();
    }

    /**
     * The register method / action of the Controller.
     */
    public function register()
    {
        //check whether the token is the same.
        if (!$this->verifyFormToken('token-register')) {
            $this->jsonOutput('The form state is not valid!', '', 'error');
            return false;
        }

        //check if the IP address is trusted (using Project Honey Pot).
        if (PROJECT_HONEYPOT_KEY !== '') {
            if (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                if ((new ProjectHoneyPot(PROJECT_HONEYPOT_KEY))->check($_SERVER['REMOTE_ADDR'])) {
                    $this->jsonOutput('The IP you are using is not trusted!', '', 'error');
                    return false;
                }
            }
        }

        //load the User Entity from register form.
        $user = new User();
        $user->loadFromPOST('register_');

        //check if the username of the User Entity is valid.
        if (!(new IsValidUsername())->isSatisfiedBy($user)) {
            $this->jsonOutput('The username is not valid!', 'register_username', 'error');
            return false;
        }

        //check if the email of the User Entity is valid.
        if (!(new IsValidEmail())->isSatisfiedBy($user)) {
            $this->jsonOutput('The email is not valid!', 'register_email', 'error');
            return false;
        }

        //check if the password of the User Entity is valid.
        if (!(new IsValidPassword())->isSatisfiedBy($user)) {
            $this->jsonOutput('The password is not valid!', 'register_password', 'error');
            return false;
        }

        //check if the email of the User Entity already exists.
        if (!(new IsUniqueEmail())->isSatisfiedBy($user)) {
            $this->jsonOutput('The email already exists!', 'register_email', 'error');
            return false;
        }

        //check if the username of the User Entity already exists.
        if (!(new IsUniqueUsername())->isSatisfiedBy($user)) {
            $this->jsonOutput('The username already exists!', 'register_username', 'error');
            return false;
        }

        //register the new User Entity.
        if ((new AuthenticationService())->register($user)) {
            $this->jsonOutput('The User was successfully registered!', '', 'info', URL.'login');
            return true;
        } else {
            $this->jsonOutput('The User could not be registered!', '', 'error');
            return false;
        }
    }
}