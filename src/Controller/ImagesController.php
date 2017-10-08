<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\View;
use PicVid\Domain\DataMapper\ImageMapper;
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
        $cito->setValue('BODY_ID', 'images-index');
        $cito->setValue('PAGE_TITLE', 'PicVid - Bilder');
        $cito->setValue('LOGO_URL', URL.'/resource/template/img/picvid-logo.png');
        $cito->setValue('username', $_SESSION['user_username']);

        //load the view.
        $view = new View('Images');
        $view->load();
    }

    /**
     * The delete method / action of the Controller.
     * @param int $id The ID of the image to delete.
     */
    public function delete(int $id)
    {
        //a session is needed to delete the images.
        $this->needSession();

        //get the Image Entity from database.
        $images = ImageRepository::build()->findByID($id);

        //check whether the Image Entity could be found.
        if (count($images) === 1) {
            $image = $images[0];

            //check whether an Image Entity is available.
            if ($image instanceof Image) {
                if (ImageMapper::build()->delete($image)) {
                    $this->redirect(URL.'images');
                } else {
                    $this->redirect(URL.'images/info/'.$id);
                }
            }
        }
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

    /**
     * The info method / action of the Controller.
     * @param int $id The ID if the image to show the information.
     */
    public function info(int $id)
    {
        //a session is needed to see the images.
        $this->needSession();

        //set the values for the template tags / placeholders on CitoEngine.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'images-info');
        $cito->setValue('PAGE_TITLE', 'PicVid - Bilder');
        $cito->setValue('LOGO_URL', URL.'/resource/template/img/picvid-logo.png');
        $cito->setValue('username', $_SESSION['user_username']);

        //get the Image Entity from database.
        $images = ImageRepository::build()->findByID($id);

        //check whether the Image Entity could be found.
        if (count($images) === 1) {
            $image = $images[0];

            //check whether an Image Entity is available.
            if ($image instanceof Image) {

                //get some information about the Image Entity.
                $imageInfo = [];
                $imageSize = getimagesize($image->getImagePath(), $imageInfo);

                //set the informationen of the Image Entity to the View.
                $cito->setValue('image-id', $image->id);
                $cito->setValue('image-url', $image->getImageURL());
                $cito->setValue('image-title', $image->title);
                $cito->setValue('image-description', $image->description);
                $cito->setValue('image-width', $imageSize[0].'px');
                $cito->setValue('image-height', $imageSize[1].'px');
            }
        } else {
            $this->redirect(URL.'images');
        }

        //load the view.
        $view = new View('Images', 'Info');
        $view->load();
    }
}