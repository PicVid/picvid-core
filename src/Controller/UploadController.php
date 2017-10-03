<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\Service\SessionService;
use PicVid\Core\View;
use PicVid\Domain\DataMapper\ImageMapper;
use PicVid\Domain\Entity\Image;
use PicVid\Domain\Entity\User;
use PicVid\Domain\Repository\ImageRepository;
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

        //load the view.
        $view = new View('Upload');
        $view->load();

        //set all the values for the placeholders on template.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'upload-index');
        $cito->setValue('PAGE_TITLE', 'PicVid - Upload');
        $cito->setValue('LOGO_URL', URL.'/resource/template/img/picvid-logo.png');
        $cito->setValue('username', $_SESSION['user_username']);
    }

    /**
     * The upload method / action of the Controller.
     */
    public function upload()
    {
        //a Session is needed for this method / action.
        $this->needSession();

        var_dump($_FILES);
        foreach ($_FILES["image_upload"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                // basename() may prevent filesystem traversal attacks;
                // further validation/sanitation of the filename may be appropriate
                $filename = str_replace('.', '', uniqid('', true)).'-'.basename($_FILES["image_upload"]["name"][$key]);
                $uploadfile = IMAGEDIR.$filename;
                $tempfile = $_FILES['image_upload']['tmp_name'][$key];
                if (move_uploaded_file($tempfile, $uploadfile)) {
                    $session = new SessionService();
                    $user = $session->getUser();

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

                        $image->id = $imageMapper->getInsertID();

                        UserImageTableMapper::build()->create($user, $image);

                        echo "<pre>";
                        var_dump(ImageRepository::build()->findByUser($user));
                        echo "</pre>";
                    }
                }
            }
        }
        //redirect to the upload.
        //$this->redirect(URL.'upload');
    }
}