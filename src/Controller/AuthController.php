<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\Service\AuthenticationService;

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
        $this->redirect(URL.'login');
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