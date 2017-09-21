<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

/**
 * Interface IController
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Controller
 */
interface IController
{
    /**
     * The default method / action of the Controller.
     * @return void
     */
    public function index();
}