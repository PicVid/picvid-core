<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\View;
use PicVid\Domain\DataMapper\ImageMapper;
use PicVid\Domain\Entity\Image;

/**
 * Class UploadController
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Controller
 */
class UploadController extends Controller
{
    /**
     * The default method / action of the Controller.
     */
    public function index()
    {
        //load the view.
        $view = new View('Upload');
        $view->load();

        //set all the values for the placeholders on template.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'profile-index');
        $cito->setValue('PAGE_TITLE', 'PicVid - Upload');
        $cito->setValue('LOGO_URL', URL.'/resource/template/img/picvid-logo.png');
    }

    /**
     * The upload method / action of the Controller.
     */
    public function upload()
    {
        //create the filename and file with full path.
        $filename = str_replace('.', '', uniqid('', true)).'-'.basename($_FILES['image_upload']['name']);
        $uploadfile = IMAGEDIR.'username'.DIRECTORY_SEPARATOR.$filename;
        $tempfile = $_FILES['image_upload']['tmp_name'];

        //try to move the file from temp directory to data directory.
        if (move_uploaded_file($tempfile, $uploadfile)) {

            //load the Image Entity from POST.
            $image = new Image();
            $image->loadFromPOST('image_');

            //get the information from upload and set to the Image Entity.
            $image->filename = $filename;
            $image->size = $_FILES['image_upload']['size'];
            $image->type = $_FILES['image_upload']['type'];

            //get the Image Mapper and save the Image Entity to the database.
            $imageMapper = ImageMapper::build();
            $imageMapper->save($image);
        }

        //redirect to the upload.
        $this->redirect(URL.'upload');
    }
}