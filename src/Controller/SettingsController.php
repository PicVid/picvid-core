<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\Configuration;
use PicVid\Core\View;
use PicVid\Domain\DataMapper\ImageMapper;
use PicVid\Domain\Entity\Image;
use PicVid\Domain\Repository\ImageRepository;
use PicVid\Domain\Repository\UserRepository;
use PicVid\Domain\TableMapper\UserImageTableMapper;

/**
 * Class SettingsController
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Controller
 */
class SettingsController extends Controller
{
    /**
     * The default method / action of the Controller.
     */
    public function index()
    {
        //a session is needed for this method / action.
        $this->needSession();

        //get the configuration.
        $config = Configuration::getInstance();

        //set the values for the template tags / placeholders on CitoEngine.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'settings-view');
        $cito->setValue('PAGE_TITLE', 'PicVid &raquo; Einstellungen');
        $cito->setValue('LOGO_URL', $config->getUrl().'/resource/template/img/picvid-logo.png');
        $cito->setValue('token', $this->getFormToken('token-settings'));
        $cito->setValue('username', $_SESSION['user_username']);
        $cito->setValue('URL', $config->getUrl());

        //load the view.
        $view = new View('Settings');
        $view->load(true);
    }

    /**
     * Method to cleanup the files on the database.
     */
    public function cleanupDatabase()
    {
        //a session is needed for this method / action.
        $this->needSession();

        //get the User ID from session.
        $userID = $_SESSION['user_id'];

        //get the User Entity.
        $users = UserRepository::build()->findByID($userID);

        //check if the User Entity is available.
        if (count($users) === 1) {
            $user = $users[0];

            //run through all Image Entities of the User.
            foreach (ImageRepository::build()->findByUser($user) as $image) {
                if ($image instanceof Image) {
                    if (!file_exists($image->getImagePath())) {
                        ImageMapper::build()->delete($image);
                        UserImageTableMapper::build()->deleteByImage($image);
                    }
                }
            }
        }

        //redirect back to the settings.
        $this->redirect(Configuration::getInstance()->getUrl().'settings');
    }

    /**
     * Method to cleanup the files on the filesystem.
     */
    public function cleanupFiles()
    {
        //a session is needed for this method / action.
        $this->needSession();

        //get the Configuration object.
        $config = Configuration::getInstance();

        //check if the images folder is available.
        if (!file_exists($config->getPathImage())) {
            mkdir($config->getPathImage(), 0755, true);
        }

        //get all files of the image directory.
        $files = scandir($config->getPathImage());

        //check if some files are available.
        if (is_array($files)) {
            $files = array_filter($files, function ($file) use ($config) {
                return !is_dir($config->getPathImage().$file);
            });

            //get all the filenames of the found Image Entities.
            $databaseFiles = array_map(function ($image) {
                return $image->filename;
            }, ImageRepository::build()->findAll());

            //get the difference between the two array (all unused files).
            $unusedFiles = array_diff($files, $databaseFiles);

            //run through all unused files to delete.
            foreach ($unusedFiles as $unusedFile) {
                if (file_exists($unusedFile)) {
                    unlink($unusedFile);
                }
            }
        }

        //redirect back to the settings.
        $this->redirect(Configuration::getInstance()->getUrl().'settings');
    }
}