<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\Configuration;
use PicVid\Core\EXIF;
use PicVid\Core\View;
use PicVid\Domain\DataMapper\ImageMapper;
use PicVid\Domain\Entity\Image;
use PicVid\Domain\Repository\ImageRepository;
use PicVid\Domain\TableMapper\UserImageTableMapper;

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

        //get the configuration.
        $config = Configuration::getInstance();

        //set the values for the template tags / placeholders on CitoEngine.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'images-index');
        $cito->setValue('PAGE_TITLE', 'PicVid &raquo; Bilder');
        $cito->setValue('LOGO_URL', $config->getUrl().'/resource/template/img/picvid-logo.png');
        $cito->setValue('username', $_SESSION['user_username']);
        $cito->setValue('URL', $config->getUrl());

        //load the view.
        $view = new View('Images');
        $view->load(true);
    }

    /**
     * The delete method / action of the Controller.
     * @param int $id The ID of the image to delete.
     */
    public function delete(int $id)
    {
        //a session is needed to delete the images.
        $this->needSession();

        //get the configuration.
        $config = Configuration::getInstance();

        //get the Image Entity from database.
        $images = ImageRepository::build()->findByID($id);

        //check whether the Image Entity could be found.
        if (count($images) === 1) {
            $image = $images[0];

            //check whether an Image Entity is available.
            if ($image instanceof Image) {
                if (UserImageTableMapper::build()->deleteByImage($image)) {
                    if (ImageMapper::build()->delete($image)) {
                        unlink($image->getImagePath());
                        $this->redirect($config->getUrl().'images');
                    }
                }
            }
        }

        //redirect to the image info.
        $this->redirect($config->getUrl().'images/info/'.$id);
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
     * Method to format the file size.
     * @param int $bytes The file size to be formatted.
     * @return string The formatted file size.
     * @see https://secure.php.net/manual/en/function.filesize.php#112996
     */
    private function formatFileSize(int $bytes) : string
    {
        //convert the file size to a float value.
        $bytes = floatval($bytes);

        //set an array with all information of the units.
        $units = [
            0 => ['unit' => 'TB', 'value' => pow(1024, 4)],
            1 => ['unit' => 'GB', 'value' => pow(1024, 3)],
            2 => ['unit' => 'MB', 'value' => pow(1024, 2)],
            3 => ['unit' => 'KB', 'value' => 1024],
            4 => ['unit' => 'B', 'value' => 1]
        ];

        //iterate through all units to find the matching unit of the file size.
        foreach ($units as $unit) {
            if ($bytes >= $unit['value']) {
                return str_replace('.', ',', strval(round(($bytes / $unit['value']), 2))).' '.$unit['unit'];
            }
        }

        //the unit could not be found.
        return $bytes;
    }

    /**
     * The info method / action of the Controller.
     * @param int $id The ID if the image to show the information.
     */
    public function info(int $id)
    {
        //a session is needed to see the images.
        $this->needSession();

        //get the configuration.
        $config = Configuration::getInstance();

        //set the values for the template tags / placeholders on CitoEngine.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'images-info');
        $cito->setValue('PAGE_TITLE', 'PicVid &raquo; Bilder');
        $cito->setValue('LOGO_URL', $config->getUrl().'/resource/template/img/picvid-logo.png');
        $cito->setValue('username', $_SESSION['user_username']);
        $cito->setValue('URL', $config->getUrl());

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

                //check whether there are EXIF information on the Image Entity.
                if ($image->hasEXIF()) {
                    $cito->setValue('tab-exif-state', '');

                    //get the EXIF information of the image.
                    $exif = new EXIF($image->getImagePath());

                    //run through all available properties of the EXIF object.
                    foreach ($exif->getKeyValueArray() as $property => $value) {
                        $row = '<tr><td>'.$property.'</td><td>'.$value.'</td></tr>';
                        $cito->setValue('exif-table-rows', $row);
                    }
                } else {
                    $cito->setValue('tab-exif-state', 'disabled');
                }

                //set the informationen of the Image Entity to the View.
                $cito->setValue('image-id', $image->id);
                $cito->setValue('image-url', $image->getImageURL());
                $cito->setValue('image-width', $imageSize[0].'px');
                $cito->setValue('image-height', $imageSize[1].'px');
                $cito->setValue('image-size', $this->formatFileSize($image->size));
                $cito->setValue('image-type', $image->type);

                //show the image title if available or a placeholder.
                if (trim($image->title) === '') {
                    $cito->setValue('image-title', '<i>kein Titel</i>');
                } else {
                    $cito->setValue('image-title', $image->title);
                }

                //show the image description if available or a placeholder.
                if (trim($image->description) === '') {
                    $cito->setValue('image-description', '<i>keine Beschreibung</i>');
                } else {
                    $cito->setValue('image-description', $image->description);
                }
            }
        } else {
            $this->redirect($config->getUrl().'images');
        }

        //load the view.
        $view = new View('Images', 'Info');
        $view->load(true);
    }
}