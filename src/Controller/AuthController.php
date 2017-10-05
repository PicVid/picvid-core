<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\Service\AuthenticationService;
use PicVid\Core\View;
use PicVid\Domain\Entity\User;
use PicVid\Domain\Specification\User\IsValidPassword;
use PicVid\Domain\Specification\User\IsValidUsername;

/**
 * Class AuthController
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Controller
 */
class AuthController extends Controller
{
    /**
     * The default method / action of the Controller.
     */
    public function index()
    {
        //set the values for the template tags / placeholders on CitoEngine.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'login-view');
        $cito->setValue('PAGE_TITLE', 'PicVid - Login');
        $cito->setValue('LOGO_URL', URL.'/resource/template/img/picvid-logo.png');
        $cito->setValue('token', $this->getFormToken('auth-index'));

        //load the view.
        $view = new View('Auth');
        $view->load();
    }

    /**
     * The login method / action of the Controller.
     */
    public function login()
    {
        //check whether the token is the same.
        if (!$this->verifyFormToken('auth-index')) {
            $this->jsonOutput('The form state is not valid!', '', 'error');
            return false;
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
            $this->jsonOutput('The User was successfully logged in!', '', 'info', URL.'profile');
            return true;
        } else {
            $this->jsonOutput('The User could not be logged in!', '', 'error');
            return false;
        }
    }

    /**
     * The logout method / action of the controller.
     */
    public function logout()
    {
        //we need a session to logout.
        $this->needSession();

        //logout the current User Entity / destroy the current session.
        (new AuthenticationService())->logout();

        //redirect to the index view.
        $this->redirect(URL);
    }
}