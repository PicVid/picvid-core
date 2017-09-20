<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\Service\AuthenticationService;
use PicVid\Core\View;
use PicVid\Domain\Entity\User;

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
     * The default method / action of the controller.
     */
    public function index()
    {
        //set the values for the template tags / placeholders on CitoEngine.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'login-view');
        $cito->setValue('PAGE_TITLE', 'PicVid - Login');
        $cito->setValue('LOGO_URL', URL.'/resource/template/img/picvid-logo.png');

        //load the view.
        $view = new View('Auth');
        $view->load();
    }

    /**
     * The login method / action of the controller.
     */
    public function login()
    {
        //load the User Entity from login form.
        $user = new User();
        $user->loadFromPOST('login_');

        //login the User Entity and redirect to the profile page.
        if ((new AuthenticationService())->login($user)) {
            $this->redirect(URL.'profile');
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