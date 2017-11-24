<?php
/**
 * Namespace for all test classes of the Entities.
 */
namespace PicVid\Test\Domain\Entity;

use PHPUnit\Framework\TestCase;
use PicVid\Domain\Entity\User;

/**
 * Class UserTest
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Test\Domain\Entity
 */
class UserTest extends TestCase
{
    /**
     * Method to test the User::getFullName method.
     * @test
     */
    public function testGetFullname()
    {
        //set a User Entity with firstname and lastname.
        $user = new User();
        $user->firstname = 'John';
        $user->lastname = 'Doe';

        //the the User Entity.
        $this->assertEquals('John Doe', $user->getFullname());
    }

    /**
     * Method to test the User::hasID method.
     * @test
     */
    public function testHasID()
    {
        //create a new User Entity.
        $user = new User();

        //test the User Entity (not changed).
        $this->assertEquals(0, $user->id);
        $this->assertFalse($user->hasID());

        //set a new ID to the User Entity.
        $user->id = 1;

        //test the User Entity (with changed ID).
        $this->assertTrue($user->hasID());
    }

    /**
     * Method to test the User::loadFromArray method.
     * @test
     */
    public function testLoadFromArray()
    {
        //create a new User Entity.
        $user = new User();

        //create an array with the user information.
        $arr = [
            'id' => 1,
            'email' => 'tmoxon0@buzzfeed.com',
            'firstname' => 'Tim',
            'lastname' => 'Moxon',
            'password' => 'NLIhCkx5MOEb',
            'salt' => '373cbfd073baa5d2777a27513f23fd8247d68d2b3e86c0233067df41de17ebf77fb62a30d37f22c7624ac191cea514db',
            'username' => 'tmoxon0'
        ];

        //load the array with user information to the User Entity.
        $user->loadFromArray($arr);

        //test the User Entity.
        $this->assertEquals(1, $user->id);
        $this->assertTrue($user->hasID());
        $this->assertEquals('tmoxon0@buzzfeed.com', $user->email);
        $this->assertEquals('Tim', $user->firstname);
        $this->assertEquals('Moxon', $user->lastname);
        $this->assertEquals('NLIhCkx5MOEb', $user->password);
        $this->assertEquals('373cbfd073baa5d2777a27513f23fd8247d68d2b3e86c0233067df41de17ebf77fb62a30d37f22c7624ac191cea514db', $user->salt);
        $this->assertEquals('tmoxon0', $user->username);
        $this->assertEquals('Tim Moxon', $user->getFullname());

        //create a new User Entity.
        $user = new User();

        //create an array with the user information (with prefixes).
        $arr = [
            'test_id' => 2,
            'test_email' => 'ftrayes1@answers.com',
            'test_firstname' => 'Fleurette',
            'test_lastname' => 'Trayes',
            'test_password' => 'tyFS02Plm',
            'test_salt' => 'b2c4002ed2e7ac1fad33df395eabb2e8660f83081bee89b2717b099301523d790661f75ac1fd4d3499f929fc0328681a',
            'test_username' => 'ftrayes1'
        ];

        //load the array with user information to the User Entity (with prefixes).
        $user->loadFromArray($arr, 'test_');

        //test the User Entity.
        $this->assertEquals(2, $user->id);
        $this->assertTrue($user->hasID());
        $this->assertEquals('ftrayes1@answers.com', $user->email);
        $this->assertEquals('Fleurette', $user->firstname);
        $this->assertEquals('Trayes', $user->lastname);
        $this->assertEquals('tyFS02Plm', $user->password);
        $this->assertEquals('b2c4002ed2e7ac1fad33df395eabb2e8660f83081bee89b2717b099301523d790661f75ac1fd4d3499f929fc0328681a', $user->salt);
        $this->assertEquals('ftrayes1', $user->username);
        $this->assertEquals('Fleurette Trayes', $user->getFullname());
    }

    /**
     * Method to test the User::loadFromObject method.
     * @test
     */
    public function testLoadFromObject()
    {
        //create a new User Entity.
        $user = new User();

        //create an object with the user information.
        $obj = new \stdClass();
        $obj->id = 3;
        $obj->email = 'eknappett2@prnewswire.com';
        $obj->firstname = 'Elsworth';
        $obj->lastname = 'Knappett';
        $obj->password = 'xlykqW2jW';
        $obj->salt = '88368e51e0da86381c2633fa9482230ac96bb1162f314913cec312cb8c6fd0c041fb770a6d3a3937202f76f206e41806';
        $obj->username = 'eknappett2';

        //load the object with user information to the User Entity.
        $user->loadFromObject($obj);

        //test the User Entity.
        $this->assertEquals(3, $user->id);
        $this->assertTrue($user->hasID());
        $this->assertEquals('eknappett2@prnewswire.com', $user->email);
        $this->assertEquals('Elsworth', $user->firstname);
        $this->assertEquals('Knappett', $user->lastname);
        $this->assertEquals('xlykqW2jW', $user->password);
        $this->assertEquals('88368e51e0da86381c2633fa9482230ac96bb1162f314913cec312cb8c6fd0c041fb770a6d3a3937202f76f206e41806', $user->salt);
        $this->assertEquals('eknappett2', $user->username);
        $this->assertEquals('Elsworth Knappett', $user->getFullname());

        //create a new User Entity.
        $user = new User();

        //create an object with the user information (with prefixes).
        $obj = new \stdClass();
        $obj->test_id = 4;
        $obj->test_email = 'teyrl3@github.io';
        $obj->test_firstname = 'Theodore';
        $obj->test_lastname = 'Eyrl';
        $obj->test_password = '4NoReUEFAuy';
        $obj->test_salt = '44ec9f5f54b4beef2d235e87323a3ef1a556d8f39197e86f05dd4dfd7d572046a4e8cd7b081f4989d93b1250d5bb8229';
        $obj->test_username = 'teyrl3';

        //load the object with user information to the User Entity (with prefixes).
        $user->loadFromObject($obj, 'test_');

        //test the User Entity.
        $this->assertEquals(4, $user->id);
        $this->assertTrue($user->hasID());
        $this->assertEquals('teyrl3@github.io', $user->email);
        $this->assertEquals('Theodore', $user->firstname);
        $this->assertEquals('Eyrl', $user->lastname);
        $this->assertEquals('4NoReUEFAuy', $user->password);
        $this->assertEquals('44ec9f5f54b4beef2d235e87323a3ef1a556d8f39197e86f05dd4dfd7d572046a4e8cd7b081f4989d93b1250d5bb8229', $user->salt);
        $this->assertEquals('teyrl3', $user->username);
        $this->assertEquals('Theodore Eyrl', $user->getFullname());
    }
}