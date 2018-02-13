<?php
/**
 * Namespace for all Controller of PicVid.
 */
namespace PicVid\Controller;

use PicVid\Core\API\ProjectHoneyPot;
use PicVid\Core\CitoEngine;
use PicVid\Core\Configuration;
use PicVid\Core\Encryption;
use PicVid\Core\Service\AuthenticationService;
use PicVid\Core\View;
use PicVid\Domain\Entity\User;
use PicVid\Domain\Specification\User\IsUniqueEmail;
use PicVid\Domain\Specification\User\IsUniqueUsername;
use PicVid\Domain\Specification\User\IsValidEmail;
use PicVid\Domain\Specification\User\IsValidPassword;
use PicVid\Domain\Specification\User\IsValidUsername;

/**
 * Class RegisterController
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Controller
 */
class RegisterController extends Controller
{
    /**
     * The default method / action of the Controller.
     */
    public function index()
    {
        //get the configuration.
        $config = Configuration::getInstance();

        //set the values for the template tags / placeholders on CitoEngine.
        $cito = CitoEngine::getInstance();
        $cito->setValue('BODY_ID', 'register-view');
        $cito->setValue('PAGE_TITLE', 'PicVid &raquo; Registrierung');
        $cito->setValue('LOGO_URL', $config->getUrl().'/resource/template/img/picvid-logo.png');
        $cito->setValue('token', $this->getFormToken('token-register'));
        $cito->setValue('URL', $config->getUrl());

        //load the view.
        $view = new View('Register');
        $view->load();
    }

    /**
     * The register method / action of the Controller.
     */
    public function register()
    {
        //get the configuration.
        $config = Configuration::getInstance();

        //check whether the token is the same.
        if (!$this->verifyFormToken('token-register')) {
            $this->jsonOutput('Es ist ein Fehler bei der Übermittlung aufgetreten!', '', 'error');
            return false;
        }

        //get the Encryption object to decrypt and encrypt the Project Honeypot API key.
        $encryption = new Encryption($config->ENCRYPTION_METHOD, $config->ENCRYPTION_SECURITY_KEY);
        $apiHoneypotKey = $encryption->decrypt($config->API_PROJECT_HONEYPOT_KEY);

        //check if the IP address is trusted (using Project Honey Pot).
        if ($apiHoneypotKey !== '') {
            if (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                if ((new ProjectHoneyPot($apiHoneypotKey))->check($_SERVER['REMOTE_ADDR'])) {
                    $this->jsonOutput('Die verwendete IP-Adresse ist nicht vertrauenswürdig (Project Honeypot)!', '', 'error');
                    return false;
                }
            }
        }

        //load the User Entity from register form.
        $user = new User();
        $user->loadFromPOST('register_');

        //check if the username of the User Entity is valid.
        if (!(new IsValidUsername())->isSatisfiedBy($user)) {
            $this->jsonOutput('Der Benutzername ist nicht gültig!', 'register_username', 'error');
            return false;
        }

        //check if the email of the User Entity is valid.
        if (!(new IsValidEmail())->isSatisfiedBy($user)) {
            $this->jsonOutput('Die E-Mail-Adresse ist nicht gültig!', 'register_email', 'error');
            return false;
        }

        //check if the password of the User Entity is valid.
        if (!(new IsValidPassword())->isSatisfiedBy($user)) {
            $this->jsonOutput('Das Passwort ist nicht gültig!', 'register_password', 'error');
            return false;
        }

        //check if the email of the User Entity already exists.
        if (!(new IsUniqueEmail())->isSatisfiedBy($user)) {
            $this->jsonOutput('Die E-Mail-Adresse wird bereits verwendet!', 'register_email', 'error');
            return false;
        }

        //check if the username of the User Entity already exists.
        if (!(new IsUniqueUsername())->isSatisfiedBy($user)) {
            $this->jsonOutput('Der Benutzername wird bereits verwendet!', 'register_username', 'error');
            return false;
        }

        //register the new User Entity.
        if ((new AuthenticationService())->register($user)) {
            $this->jsonOutput('Der Benutzer wurde erfolgreich registriert.', '', 'info', $config->getUrl().'login');
            return true;
        } else {
            $this->jsonOutput('Der Benutzer konnte nicht registriert werden!', '', 'error');
            return false;
        }
    }
}