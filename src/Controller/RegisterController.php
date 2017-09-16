<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\View;

/**
 * Class RegisterController
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Controller
 */
class RegisterController
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

        //load the view.
        $view = new View('Register');
        $view->load();
    }
}