<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\Configuration;
use PicVid\Core\Service\AuthenticationService;
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

        //check if the images folder is available.
        if (!file_exists($config->getPathImage())) {
            mkdir($config->getPathImage(), 0755, true);
        }

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

            //load the view.
            $view = new View('Profile');
            $view->load(true);
        } else {
            $this->redirect($config->getUrl().'logout');
        }
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
                if ($image instanceof Image) {
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
            $this->jsonOutput('Es ist ein Fehler beim Speichern der Daten aufgetreten!', '', 'error');
            return false;
        }

        //get the user information from Session.
        $username = filter_var($_SESSION['user_username'], FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'profile_confirm_password', FILTER_SANITIZE_STRING);

        //check if the username is available.
        if ($username === false) {
            $this->jsonOutput('Der Benutzername ist nicht verfügbar!', '', 'error');
            return false;
        }

        //check if the password is available.
        if ($password === false || $password === null) {
            $this->jsonOutput('Das Passwort zur Bestätigung ist nicht gültig!', 'profile_confirm_password', 'error');
            return false;
        }

        //confirm the user information is allowed to change the profile information.
        if (!(new AuthenticationService())->confirm($username, $password)) {
            $this->jsonOutput('Das Passwort zur Bestätigung ist nicht korrekt!', 'profile_confirm_password', 'error');
            return false;
        }

        //get the information of the User Entity to save.
        $user = new User();
        $user->loadFromPOST('profile_');

        //check if the username of the User Entity is valid.
        if (!(new IsValidUsername())->isSatisfiedBy($user)) {
            $this->jsonOutput('Der Benutzername ist nicht gültig!', 'profile_username', 'error');
            return false;
        }

        //check if the email of the User Entity is valid.
        if (!(new IsValidEmail())->isSatisfiedBy($user)) {
            $this->jsonOutput('Die E-Mail ist nicht gültig!', 'profile_email', 'error');
            return false;
        }

        //check if the firstname of the User Entity is valid.
        if (!(new IsValidFirstname())->isSatisfiedBy($user)) {
            $this->jsonOutput('Der Vorname ist nicht gültig!', 'profile_firstname', 'error');
            return false;
        }

        //check if the lastname of the User Entity is valid.
        if (!(new IsValidLastname())->isSatisfiedBy($user)) {
            $this->jsonOutput('Der Nachname ist nicht gültig!', 'profile_lastname', 'error');
            return false;
        }

        //check whether a password is available.
        if (trim($user->password) !== '') {
            if (!(new IsValidPassword())->isSatisfiedBy($user)) {
                $this->jsonOutput('Das Passwort ist nicht gültig!', 'profile_password', 'error');
                return false;
            }

            //hash the new password on the User Entity.
            $hash_service = new HashService();
            $hash_service->hash($user);
        } else {
            $userDB = UserRepository::build()->findByID($user->id);

            //check if the User Entity was found.
            if (count($userDB) === 1) {
                $userDB = $userDB[0];

                //check if the ID is the same.
                if ($user->id == $userDB->id) {
                    if ($userDB->email !== $user->email) {
                        if (!(new IsUniqueEmail())->isSatisfiedBy($user)) {
                            $this->jsonOutput('Die E-Mail ist bereits vorhanden!', 'profile_email', 'error');
                            return false;
                        }
                    }

                    //check if the username was changed on the User Entity.
                    if ($userDB->username !== $user->username) {
                        if (!(new IsUniqueUsername())->isSatisfiedBy($user)) {
                            $this->jsonOutput('Der Benutzername ist bereits vorhanden!', 'profile_username', 'error');
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
            $_SESSION['user_username'] = $user->username;

            //output the JSON information and return the state.
            $this->jsonOutput('Das Profil wurde erfolgreich gespeichert.', '', 'success');
            return true;
        } else {
            $this->jsonOutput('Das Profil konnte nicht gespeichert werden!', '', 'error');
            return false;
        }
    }
}
