<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\Configuration;
use PicVid\Core\View;

/**
 * Class InfoController
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Controller
 */
class InfoController extends Controller
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
        $cito->setValue('BODY_ID', 'info-view');
        $cito->setValue('PAGE_TITLE', 'PicVid - Info');
        $cito->setValue('LOGO_URL', $config->URL.'/resource/template/img/picvid-logo.png');
        $cito->setValue('URL', $config->URL);

        //load the view.
        $view = new View('Info');
        $view->load();
    }
}