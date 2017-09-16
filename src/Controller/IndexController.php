<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\View;

/**
 * Class IndexController
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Controller
 */
class IndexController
{
    /**
     * The default method / action of the Controller.
     */
    public function index()
    {
        //set the values for the template tags / placeholders on CitoEngine.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'index-view');
        $cito->setValue('PAGE_TITLE', 'PicVid - Willkommen');
        $cito->setValue('LOGO_URL', URL.'/resource/template/img/picvid-logo.png');

        //load the view.
        $view = new View('Index');
        $view->load();
    }
}