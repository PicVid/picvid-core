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
        //set the values for the template tags / placeholders on CitoEngine.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'login-view');
        $cito->setValue('PAGE_TITLE', 'PicVid - Login');
        $cito->setValue('LOGO_URL', URL.'/resource/template/img/picvid-logo.png');

        //load the view.
        $view = new View('Login');
        $view->load();
    }

    /**
     * The login method / action of the Controller.
     */
    public function login()
    {
        //load the user from register form.
        $user = new User();
        $user->loadFromPOST('login_');

        //login the User Entity.
        (new AuthenticationService())->login($user);
    }
}