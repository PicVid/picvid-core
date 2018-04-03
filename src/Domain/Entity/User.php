<?php
/**
 * Namespace for all Entities of PicVid.
 */
namespace PicVid\Domain\Entity;

/**
 * Class User
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Entity
 */
class User extends Entity
{
    /**
     * The email address of the User.
     * @var string
     */
    public $email = '';

    /**
     * The firstname of the User.
     * @var string
     */
    public $firstname = '';

    /**
     * The lastname of the User.
     * @var string
     */
    public $lastname = '';

    /**
     * The password of the User.
     * @var string
     */
    public $password = '';

    /**
     * The salt for the password of the User.
     * @var string
     */
    public $salt = '';

    /**
     * The username of the User.
     * @var string
     */
    public $username = '';

    /**
     * Method to get the fullname of the User.
     * @return string The fullname of the User.
     */
    public function getFullname()
    {
        return $this->firstname.' '.$this->lastname;
    }
}
