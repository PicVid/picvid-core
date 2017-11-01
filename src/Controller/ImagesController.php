<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
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

                if (UserImageTableMapper::build()->deleteByImage($image)) {
                    if (ImageMapper::build()->delete($image)) {
                        unlink($image->getImagePath());
                        $this->redirect(URL.'images');
                    }
                }
            }
        }

        //redirect to the image info.
        $this->redirect(URL.'images/info/'.$id);
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
        foreach($units as $unit)
        {
            //check if the current value is in the range of the unit and can be used for format.
            if($bytes >= $unit['value'])
            {
                return str_replace(".", "," , strval(round(($bytes / $unit['value']), 2)))." ".$unit['unit'];
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

                //check whether there are EXIF information on the Image Entity.
                if ($image->hasEXIF()) {
                    $cito->setValue('tab-exif-state', '');

                    //get the EXIF information of the image.
                    $exif = new EXIF($image->getImagePath());

                    //set the exif information of the image to the View.
                    $cito->setValue('exif-aperture-value', $exif->ApertureValue);
                    $cito->setValue('exif-brightness-value', $exif->BrightnessValue);
                    $cito->setValue('exif-components-configuration', $exif->ComponentsConfiguration);
                    $cito->setValue('exif-compressed-bits-per-pixel', $exif->CompressedBitsPerPixel);
                    $cito->setValue('exif-contrast', $exif->Contrast);
                    $cito->setValue('exif-custom-rendered', $exif->CustomRendered);
                    $cito->setValue('exif-date-time-digitized', $exif->DateTimeDigitized);
                    $cito->setValue('exif-date-time-original', $exif->DateTimeOriginal);
                    $cito->setValue('exif-digital-zoom-ratio', $exif->DigitalZoomRatio);
                    $cito->setValue('exif-version', $exif->ExifVersion);
                    $cito->setValue('exif-exposure-bias-value', $exif->ExposureBiasValue);
                    $cito->setValue('exif-exposure-index', $exif->ExposureIndex);
                    $cito->setValue('exif-exposure-mode', $exif->ExposureMode);
                    $cito->setValue('exif-exposure-program', $exif->ExposureProgram);
                    $cito->setValue('exif-exposure-time', $exif->ExposureTime);
                    $cito->setValue('exif-fnumber', $exif->FNumber);
                    $cito->setValue('exif-file-source', $exif->FileSource);
                    $cito->setValue('exif-flash', $exif->Flash);
                    $cito->setValue('exif-flash-pix-version', $exif->FlashPixVersion);
                    $cito->setValue('exif-focal-length', $exif->FocalLength);
                    $cito->setValue('exif-focal-length-in-35mm-film', $exif->FocalLengthIn35mmFilm);
                    $cito->setValue('exif-focal-plane-resolution-unit', $exif->FocalPlaneResolutionUnit);
                    $cito->setValue('exif-focal-plane-resolution-x', $exif->FocalPlaneXResolution);
                    $cito->setValue('exif-focal-plane-resolution-y', $exif->FocalPlaneYResolution);
                    $cito->setValue('exif-gain-control', $exif->GainControl);
                    $cito->setValue('exif-image-length', $exif->ImageLength);
                    $cito->setValue('exif-image-unique-id', $exif->ImageUniqueID);
                    $cito->setValue('exif-image-width', $exif->ImageWidth);
                    $cito->setValue('exif-iso-speed-ratings', $exif->ISOSpeedRatings);
                    $cito->setValue('exif-light-source', $exif->LightSource);
                    $cito->setValue('exif-maker-note', is_string($exif->MakerNote) ? $exif->MakerNote : '');
                    $cito->setValue('exif-max-aperture-value', $exif->MaxApertureValue);
                    $cito->setValue('exif-metering-mode', $exif->MeteringMode);
                    $cito->setValue('exif-related-sound-file', $exif->RelatedSoundFile);
                    $cito->setValue('exif-saturation', $exif->Saturation);
                    $cito->setValue('exif-scene-capture-type', $exif->SceneCaptureType);
                    $cito->setValue('exif-scene-type', $exif->SceneType);
                    $cito->setValue('exif-sensing-method', $exif->SensingMethod);
                    $cito->setValue('exif-sharpness', $exif->Sharpness);
                    $cito->setValue('exif-shutter-speed-value', $exif->ShutterSpeedValue);
                    $cito->setValue('exif-subject-distance-range', $exif->SubjectDistanceRange);
                    $cito->setValue('exif-subject-location', is_string($exif->SubjectLocation) ? $exif->SubjectLocation : '');
                    $cito->setValue('exif-subsec-time', $exif->SubsecTime);
                    $cito->setValue('exif-subsec-time-digitized', $exif->SubsecTimeDigitized);
                    $cito->setValue('exif-subsec-time-original', $exif->SubsecTimeOriginal);
                    $cito->setValue('exif-user-comment', $exif->UserComment);
                    $cito->setValue('exif-white-balance', $exif->WhiteBalance);
                } else {
                    $cito->setValue('tab-exif-state', 'disabled');
                }

                //set the informationen of the Image Entity to the View.
                $cito->setValue('image-id', $image->id);
                $cito->setValue('image-url', $image->getImageURL());
                $cito->setValue('image-title', $image->title);
                $cito->setValue('image-description', $image->description);
                $cito->setValue('image-width', $imageSize[0].'px');
                $cito->setValue('image-height', $imageSize[1].'px');
                $cito->setValue('image-size', $this->formatFileSize($image->size));
            }
        } else {
            $this->redirect(URL.'images');
        }

        //load the view.
        $view = new View('Images', 'Info');
        $view->load();
    }
}