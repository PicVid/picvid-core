<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\Configuration;
use PicVid\Core\View;
use PicVid\Domain\DataMapper\ImageMapper;
use PicVid\Domain\DataMapper\UserMapper;
use PicVid\Domain\Entity\Image;
use PicVid\Domain\Entity\User;
use PicVid\Domain\Repository\ImageRepository;
use PicVid\Domain\Repository\UserRepository;
use PicVid\Domain\Service\User\HashService;
use PicVid\Domain\Specification\User\IsUniqueEmail;
use PicVid\Domain\Specification\User\IsUniqueUsername;
use PicVid\Domain\Specification\User\IsValidEmail;
use PicVid\Domain\Specification\User\IsValidFirstname;
use PicVid\Domain\Specification\User\IsValidLastname;
use PicVid\Domain\Specification\User\IsValidPassword;
use PicVid\Domain\Specification\User\IsValidUsername;
use PicVid\Domain\TableMapper\UserImageTableMapper;

/**
 * Class ProfileController
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Controller
 */
class ProfileController extends Controller
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

        //get the User from database by Session information.
        $users = UserRepository::build()->findByID($_SESSION['user_id']);

        //check if an User Entity could be found.
        if (count($users) === 1) {
            $user = $users[0];

            //set all the values for the placeholders on template.
            $cito = CitoEngine::getInstance();
            $cito->setValue('BODY_ID', 'profile-index');
            $cito->setValue('LOGO_URL', $config->getUrl().'/resource/template/img/picvid-logo.png');
            $cito->setValue('PAGE_TITLE', 'PicVid &raquo; Profil');
            $cito->setValue('user_username', $user->username);
            $cito->setValue('user_email', $user->email);
            $cito->setValue('user_firstname', $user->firstname);
            $cito->setValue('user_lastname', $user->lastname);
            $cito->setValue('user_id', $user->id);
            $cito->setValue('user_password', '');
            $cito->setValue('username', $user->username);
            $cito->setValue('token', $this->getFormToken('profile-index'));

            //get all Image Entities of the User Entity.
            $images = ImageRepository::build()->findByUser($user);

            //set the count of all Image Entities to the profile.
            $cito->setValue('count-images', count($images));
            $cito->setValue('count-unused-files', count($this->getUnusedImageFiles()));

            //load the view.
            $view = new View('Profile');
            $view->load(true);
        } else {
            $this->redirect($config->getUrl().'logout');
        }
    }

    /**
     * The clean images method / action of the Controller.
     * @param string $mode The mode which will be used to clean the unused images.
     */
    public function cleanImages(string $mode = 'backup')
    {
        //a Session is needed for this method / action.
        $this->needSession();

        //get the Configuration object.
        $config = Configuration::getInstance();

        //only two modes are available (backup and delete).
        if (!in_array($mode, ['delete', 'backup'])) {
            $this->redirect($config->getUrl().'profile');
            return;
        }

        //get the name if the backup directory.
        $backupPath = $config->getPathImage().'backup-'.(new \DateTime())->format('Y-m-d-H-i-s').DIRECTORY_SEPARATOR;

        //get all the unused files on the image directory.
        $unusedFiles = $this->getUnusedImageFiles();

        //run through all files to delete or backup these files.
        foreach ($unusedFiles as $unusedFile) {

            //chech if a backup should be created or the files should be deleted.
            if ($mode !== 'delete') {

                //create the backup directory if it doesn't exist.
                if (!file_exists($backupPath)) {
                    mkdir($backupPath);
                }

                //move the unused file from the image directory to the backup directory.
                rename($config->getPathImage().$unusedFile, $backupPath.$unusedFile);
            } else {

                //delete the unused file on the image directory.
                unlink($config->getPathImage().$unusedFile);
            }
        }

        //at the end redirect to the profile page (refresh the page).
        $this->redirect($config->getUrl().'profile');
    }

    /**
     * The remove images method / action of the Controller.
     */
    public function removeImages()
    {
        //a Session is needed for this method / action.
        $this->needSession();

        //get the configuration.
        $config = Configuration::getInstance();

        //get the User from database by Session information.
        $users = UserRepository::build()->findByID($_SESSION['user_id']);

        //check if an User Entity could be found.
        if (count($users) === 1) {
            $user = $users[0];

            //find all Image Entities of the User Entity.
            $images = ImageRepository::build()->findByUser($user);

            //set the UserImageTableMapper and ImageMapper to remove the connections and Image Entities.
            $userImageTableMapper = UserImageTableMapper::build();
            $imageMapper = ImageMapper::build();

            //run through all Image Entities to remove.
            foreach ($images as $image) {

                //check whether a Image Entity is available.
                if ($image instanceof Image) {

                    //delete the connection to the User Entity and the Image Entity itself.
                    if ($userImageTableMapper->delete($user, $image) && $imageMapper->delete($image)) {
                        unlink($image->getImagePath());
                    }
                }
            }
        }

        //redirect back to the profile.
        $this->redirect($config->getUrl().'profile');
    }

    /**
     * The save method / action of the Controller.
     */
    public function save()
    {
        //a Session is needed for this method / action.
        $this->needSession();

        //check whether the token is the same.
        if (!$this->verifyFormToken('profile-index')) {
            $this->jsonOutput('The form state is not valid!', '', 'error');
            return false;
        }

        //get the information of the User Entity to save.
        $user = new User();
        $user->loadFromPOST('profile_');

        //check if the username of the User Entity is valid.
        if (!(new IsValidUsername())->isSatisfiedBy($user)) {
            $this->jsonOutput('The username is not valid!', 'profile_username', 'error');
            return false;
        }

        //check if the email of the User Entity is valid.
        if (!(new IsValidEmail())->isSatisfiedBy($user)) {
            $this->jsonOutput('The email is not valid!', 'profile_email', 'error');
            return false;
        }

        //check if the firstname of the User Entity is valid.
        if (!(new IsValidFirstname())->isSatisfiedBy($user)) {
            $this->jsonOutput('The firstname is not valid!', 'profile_firstname', 'error');
            return false;
        }

        //check if the lastname of the User Entity is valid.
        if (!(new IsValidLastname())->isSatisfiedBy($user)) {
            $this->jsonOutput('The lastname is not valid!', 'profile_lastname', 'error');
            return false;
        }

        //check whether a password is available.
        if (trim($user->password) !== '') {

            //check if the password of the User Entity is valid.
            if (!(new IsValidPassword())->isSatisfiedBy($user)) {
                $this->jsonOutput('The password is not valid!', 'profile_password', 'error');
                return false;
            }

            //hash the new password on the User Entity.
            $hash_service = new HashService();
            $hash_service->hash($user);
        } else {

            //get the User Entity from database to set password information.
            $userDB = UserRepository::build()->findByID($user->id);

            //check if the User Entity was found.
            if (count($userDB) === 1) {
                $userDB = $userDB[0];

                //check if the ID is the same.
                if ($user->id == $userDB->id) {

                    //check if the email was changed on the User Entity.
                    if ($userDB->email !== $user->email) {

                        //check if the email of the User Entity already exists.
                        if (!(new IsUniqueEmail())->isSatisfiedBy($user)) {
                            $this->jsonOutput('The email already exists!', 'profile_email', 'error');
                            return false;
                        }
                    }

                    //check if the username was changed on the User Entity.
                    if ($userDB->username !== $user->username) {

                        //check if the username of the User Entity already exists.
                        if (!(new IsUniqueUsername())->isSatisfiedBy($user)) {
                            $this->jsonOutput('The username already exists!', 'profile_username', 'error');
                            return false;
                        }
                    }

                    //set the password information from database.
                    $user->password = $userDB->password;
                    $user->salt = $userDB->salt;
                }
            }
        }

        //create the User Mapper and save the User Entity to database.
        $user_mapper = UserMapper::build();

        //check if the User Entity was saved successfully.
        if ($user_mapper->save($user)) {
            $this->jsonOutput('The Profile was successfully saved!', '', 'success');
            return true;
        } else {
            $this->jsonOutput('The Profile could not be saved!', '', 'error');
            return false;
        }
    }

    /**
     * Method to get all unsued files of the image directory.
     * @return array The array with all unused files of the image directory.
     */
    private function getUnusedImageFiles() : array
    {
        //get the Configuration object.
        $config = Configuration::getInstance();

        //get all files of the image directory.
        $files = scandir($config->getPathImage());

        //check if some files are available.
        if (is_array($files)) {

            //filter all directories from the found files.
            $files = array_filter($files, function ($file) use ($config) {
                return !is_dir($config->getPathImage().$file);
            });

            //get all the filenames of the found Image Entities.
            $databaseFiles = array_map(function($image) { return $image->filename; }, ImageRepository::build()->findAll());

            //return the difference between the two array (all unused files).
            return array_diff($files, $databaseFiles);
        }

        //there is no unused file.
        return [];
    }
}