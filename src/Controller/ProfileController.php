<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\CitoEngine;
use PicVid\Core\View;
use PicVid\Domain\DataMapper\UserMapper;
use PicVid\Domain\Entity\User;
use PicVid\Domain\Repository\UserRepository;
use PicVid\Domain\Service\User\HashService;

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

        //get the User from database by Session information.
        $users = UserRepository::build()->findByID($_SESSION['user_id']);

        //check if a user could be found.
        if (count($users) === 1) {
            $user = $users[0];

            //set all the values for the placeholders on template.
            $cito = CitoEngine::getInstance();
            $cito->setValue('BODY_ID', 'profile-index');
            $cito->setValue('LOGO_URL', URL.'/resource/template/img/picvid-logo.png');
            $cito->setValue('user_username', $user->username);
            $cito->setValue('user_email', $user->email);
            $cito->setValue('user_firstname', $user->firstname);
            $cito->setValue('user_lastname', $user->lastname);
            $cito->setValue('user_id', $user->id);
            $cito->setValue('user_password', '');

            //load the view.
            $view = new View('Profile');
            $view->load();
        } else {

            //user is unknown, so logout.
            $this->redirect(URL.'logout');
        }
    }

    /**
     * The save method / action of the Controller.
     */
    public function save()
    {
        //a Session is needed for this method / action.
        $this->needSession();

        //get the information of the User Entity to save.
        $user = new User();
        $user->loadFromPOST('profile_');

        //check whether a password is available.
        if ($user->password !== '') {
            $hash_service = new HashService();
            $hash_service->hash($user);
        } else {
            $userDB = UserRepository::build()->findByID($user->id);

            //check if the User Entity was found.
            if (count($userDB) === 1) {
                $userDB = $userDB[0];

                //check if the ID is the same.
                if ($user->id == $userDB->id) {
                    $user->password = $userDB->password;
                    $user->salt = $userDB->salt;
                }
            }
        }

        //create the User Mapper and save the User Entity to database.
        $user_mapper = UserMapper::build();
        $user_mapper->save($user);

        //redirect to the profile page.
        $this->redirect(URL.'profile');
    }
}