<?php
/**
 * Namespace for all controller of PicVid.
 */
namespace PicVid\Controller;

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
     * The default method / action of the controller.
     */
    public function index()
    {
        $view = new View('Index');
        $view->load();
    }
}