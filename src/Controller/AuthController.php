<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\Service\AuthenticationService;
use PicVid\Core\View;

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
        $cito->setValue('BODY_ID', 'auth-view');
        $cito->setValue('PAGE_TITLE', 'PicVid - Login');
        $cito->setValue('LOGO_URL', URL.'/resource/template/img/picvid-logo.png');
        $cito->setValue('token_login', $this->getFormToken('token-login'));
        $cito->setValue('token_register', $this->getFormToken('token-register'));

        //load the view.
        $view = new View('Auth');
        $view->load();
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