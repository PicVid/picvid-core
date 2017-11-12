<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\Configuration;
use PicVid\Core\Service\SessionService;
use PicVid\Core\View;
use PicVid\Domain\DataMapper\ImageMapper;
use PicVid\Domain\Entity\Image;
use PicVid\Domain\Entity\User;
use PicVid\Domain\TableMapper\UserImageTableMapper;

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
        //a Session is needed for this method / action.
        $this->needSession();

        //get the configuration.
        $config = Configuration::getInstance();

        //load the view.
        $view = new View('Upload');
        $view->load();

        //set all the values for the placeholders on template.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'upload-index');
        $cito->setValue('PAGE_TITLE', 'PicVid - Upload');
        $cito->setValue('LOGO_URL', $config->URL.'/resource/template/img/picvid-logo.png');
        $cito->setValue('username', $_SESSION['user_username']);
        $cito->setValue('token', $this->getFormToken('upload-index'));
        $cito->setValue('URL', $config->URL);
    }

    /**
     * The upload method / action of the Controller.
     */
    public function upload()
    {
        //a Session is needed for this method / action.
        $this->needSession();

        //get the configuration.
        $config = Configuration::getInstance();

        //check whether the token is the same.
        if (!$this->verifyFormToken('upload-index')) {
            $this->jsonOutput('The form state is not valid!', '', 'error');
            return false;
        }

        //run through all images of the upload.
        foreach ($_FILES['image_upload']['error'] as $key => $error) {

            //check if the upload was successful for this image.
            if ($error == UPLOAD_ERR_OK) {

                //get the filename of the image to save on database and filesystem.
                $filename = basename($_FILES["image_upload"]["name"][$key]);
                $filename = preg_replace('/[^0-9a-zA-Z \-\_\.]/', '', $filename);
                $filename = str_replace(' ', '', $filename);
                $filename = 'img-'.str_replace('.', '', uniqid('', true)).'-'.$filename;

                //move the file to the image directory.
                if (move_uploaded_file($_FILES['image_upload']['tmp_name'][$key], $config->IMGDIR.$filename)) {

                    //get the User Entity from Session.
                    $user = (new SessionService())->getUser();

                    //check whether the User Entity could be determined.
                    if ($user instanceof User) {

                        //load the Image Entity from POST.
                        $image = new Image();
                        $image->loadFromPOST('image_');

                        //get the information from upload and set to the Image Entity.
                        $image->filename = $filename;
                        $image->size = $_FILES['image_upload']['size'][$key];
                        $image->type = $_FILES['image_upload']['type'][$key];

                        //get the Image Mapper and save the Image Entity to the database.
                        $imageMapper = ImageMapper::build();
                        $imageMapper->save($image);

                        //set the ID of the Image Entity.
                        $image->id = $imageMapper->getInsertID();

                        //create the association between the User Entity and Image Entity.
                        UserImageTableMapper::build()->create($user, $image);
                    }
                }
            }
        }

        //redirect to the upload.
        $this->redirect($config->URL.'upload');
        return true;
    }
}