<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\View;
use PicVid\Domain\Entity\Image;
use PicVid\Domain\Repository\ImageRepository;

/**
 * Class ImagesController
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Controller
 */
class ImagesController extends Controller
{
    /**
     * The default method / action of the Controller.
     */
    public function index()
    {
        //a session is needed to see the images.
        $this->needSession();

        //set the values for the template tags / placeholders on CitoEngine.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'images-view');
        $cito->setValue('PAGE_TITLE', 'PicVid - Bilder');
        $cito->setValue('LOGO_URL', URL.'/resource/template/img/picvid-logo.png');
        $cito->setValue('username', $_SESSION['user_username']);

        //load the view.
        $view = new View('Images');
        $view->load();
    }

    /**
     * The download method / action of the Controller.
     * @param int $id The ID of the image to download.
     */
    public function download(int $id)
    {
        //a session is needed to download the images.
        $this->needSession();

        //get the Image from database.
        $images = ImageRepository::build()->findByID($id);

        //check whether the Image Entity could be found.
        if (count($images) === 1) {
            $image = $images[0];

            //check whether the found Entity is an Image Entity.
            if ($image instanceof Image) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.basename($image->filename));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                ob_clean();
                flush();
                readfile($image->getImageURL());
                exit;
            }
        }
    }
}