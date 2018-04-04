<?php
/**
 * Namespace for all test classes of the DataMapper.
 */
namespace PicVid\Test\Domain\DataMapper;

use PHPUnit\DbUnit\DataSet\XmlDataSet;
use PicVid\Domain\DataMapper\ImageMapper;
use PicVid\Domain\DataMapper\UserMapper;
use PicVid\Domain\Entity\User;
use PicVid\Domain\Repository\UserRepository;
use PicVid\Test\DatabaseTestCase;

/**
 * Class UserRepositoryTest
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Test\Domain\DataMapper
 */
class UserRepositoryTest extends DatabaseTestCase
{
    /**
     * Method to get the initial state of the database for test.
     * @return XmlDataSet
     */
    public function getDataset() : XmlDataSet
    {
        return $this->createXMLDataSet(__DIR__ . '/DataSets/users.xml');
    }

    /**
     * Method to test the UserRepository:findAll method.
     * @test
     */
    public function testFindAll()
    {
        //try to use another DataMapper on UserRepository then UserMapper.
        $imageMapper = new ImageMapper($this->getConnection()->getConnection());
        $failedUserRepository = new UserRepository($imageMapper);

        //try to find a User Entity with the wrong DataMapper.
        $arrUsers = $failedUserRepository->findAll();

        //there should be no User Entity.
        $this->assertEquals(0, count($arrUsers));

        //get the UserMapper and UserRepository to get the User Entities.
        $userMapper = new UserMapper($this->getConnection()->getConnection());
        $userRepository = new UserRepository($userMapper);

        //get all the User Entities from database.
        $arrUsers = $userRepository->findAll();

        //The first User Entity which will be found on database.
        $firstUser = new User();
        $firstUser->id = 1;
        $firstUser->email = 'tmoxon0@buzzfeed.com';
        $firstUser->firstname = 'Tim';
        $firstUser->lastname = 'Moxon';
        $firstUser->username = 'tmoxon0';

        //The second User Entitiy which will be found on database.
        $secondUser = new User();
        $secondUser->id = 2;
        $secondUser->email = 'ftrayes1@answers.com';
        $secondUser->firstname = 'Fleurette';
        $secondUser->lastname = 'Trayes';
        $secondUser->username = 'ftrayes1';

        //The first and second User Entity should be found on database.
        $this->assertEquals(2, count($arrUsers));
        $this->assertEquals($firstUser, $arrUsers[0]);
        $this->assertEquals($secondUser, $arrUsers[1]);
    }

    /**
     * Method to test the UserRepository:findByEmail method.
     * @test
     */
    public function testFindByEmail()
    {
        //try to use another DataMapper on UserRepository then UserMapper.
        $imageMapper = new ImageMapper($this->getConnection()->getConnection());
        $failedUserRepository = new UserRepository($imageMapper);

        //try to find a User Entity with the wrong DataMapper.
        $arrUsers = $failedUserRepository->findByEmail('tmoxon0@buzzfeed.com');

        //there should be no User Entity.
        $this->assertEquals(0, count($arrUsers));

        //get the UserMapper and UserRepository to get the User Entities.
        $userMapper = new UserMapper($this->getConnection()->getConnection());
        $userRepository = new UserRepository($userMapper);

        //get the first and second User Entity from database.
        $arrFirstUser = $userRepository->findByEmail('tmoxon0@buzzfeed.com');
        $arrSecondUser = $userRepository->findByEmail('ftrayes1@answers.com');

        //The first User Entity which will be found on database.
        $firstUser = new User();
        $firstUser->id = 1;
        $firstUser->email = 'tmoxon0@buzzfeed.com';
        $firstUser->firstname = 'Tim';
        $firstUser->lastname = 'Moxon';
        $firstUser->username = 'tmoxon0';

        //The second User Entity which will be found on database.
        $secondUser = new User();
        $secondUser->id = 2;
        $secondUser->email = 'ftrayes1@answers.com';
        $secondUser->firstname = 'Fleurette';
        $secondUser->lastname = 'Trayes';
        $secondUser->username = 'ftrayes1';

        //The first and second User Entity should be found on database.
        $this->assertEquals(1, count($arrFirstUser));
        $this->assertEquals($firstUser, $arrFirstUser[0]);
        $this->assertEquals(1, count($arrSecondUser));
        $this->assertEquals($secondUser, $arrSecondUser[0]);

        //try to find a not available User Entity.
        $arrNotFoundUser = $userRepository->findByEmail('notavailable@example.com');

        //the User Entity should not be found on database.
        $this->assertEquals(0, count($arrNotFoundUser));
        $this->assertEquals([], $arrNotFoundUser);
    }

    /**
     * Method to test the UserRepository:findByID method.
     * @test
     */
    public function testFindByID()
    {
        //try to use another DataMapper on UserRepository then UserMapper.
        $imageMapper = new ImageMapper($this->getConnection()->getConnection());
        $failedUserRepository = new UserRepository($imageMapper);

        //try to find a User Entity with the wrong DataMapper.
        $arrUsers = $failedUserRepository->findByID(1);

        //there should be no User Entity.
        $this->assertEquals(0, count($arrUsers));

        //get the UserMapper and UserRepository to get the User Entities.
        $userMapper = new UserMapper($this->getConnection()->getConnection());
        $userRepository = new UserRepository($userMapper);

        //get the first and second User Entity from database.
        $arrFirstUser = $userRepository->findByID(1);
        $arrSecondUser = $userRepository->findByID(2);

        //The first User Entity which will be found on database.
        $firstUser = new User();
        $firstUser->id = 1;
        $firstUser->email = 'tmoxon0@buzzfeed.com';
        $firstUser->firstname = 'Tim';
        $firstUser->lastname = 'Moxon';
        $firstUser->username = 'tmoxon0';

        //The second User Entitiy which will be found on database.
        $secondUser = new User();
        $secondUser->id = 2;
        $secondUser->email = 'ftrayes1@answers.com';
        $secondUser->firstname = 'Fleurette';
        $secondUser->lastname = 'Trayes';
        $secondUser->username = 'ftrayes1';

        //The first and second User Entity should be found on database.
        $this->assertEquals(1, count($arrFirstUser));
        $this->assertEquals($arrFirstUser[0], $firstUser);
        $this->assertEquals(1, count($arrSecondUser));
        $this->assertEquals($arrSecondUser[0], $secondUser);

        //try to find a not available User Entity.
        $arrNotFoundUser = $userRepository->findByID(3);

        //the User Entity should not be found on database.
        $this->assertEquals(0, count($arrNotFoundUser));
        $this->assertEquals([], $arrNotFoundUser);
    }

    /**
     * Method to test the UserRepository:findByUsername method.
     * @test
     */
    public function testFindByUsername()
    {
        //try to use another DataMapper on UserRepository then UserMapper.
        $imageMapper = new ImageMapper($this->getConnection()->getConnection());
        $failedUserRepository = new UserRepository($imageMapper);

        //try to find a User Entity with the wrong DataMapper.
        $arrUsers = $failedUserRepository->findByUsername('tmoxon0');

        //there should be no User Entity.
        $this->assertEquals(0, count($arrUsers));

        //get the UserMapper and UserRepository to get the User Entities.
        $userMapper = new UserMapper($this->getConnection()->getConnection());
        $userRepository = new UserRepository($userMapper);

        //get the first and second User Entity from database.
        $arrFirstUser = $userRepository->findByUsername('tmoxon0');
        $arrSecondUser = $userRepository->findByUsername('ftrayes1');

        //The first User Entity which will be found on database.
        $firstUser = new User();
        $firstUser->id = 1;
        $firstUser->email = 'tmoxon0@buzzfeed.com';
        $firstUser->firstname = 'Tim';
        $firstUser->lastname = 'Moxon';
        $firstUser->username = 'tmoxon0';

        //The second User Entity which will be found on database.
        $secondUser = new User();
        $secondUser->id = 2;
        $secondUser->email = 'ftrayes1@answers.com';
        $secondUser->firstname = 'Fleurette';
        $secondUser->lastname = 'Trayes';
        $secondUser->username = 'ftrayes1';

        //The User Entity should be found on database.
        $this->assertEquals(1, count($arrFirstUser));
        $this->assertEquals($firstUser, $arrFirstUser[0]);
        $this->assertEquals(1, count($arrSecondUser));
        $this->assertEquals($secondUser, $arrSecondUser[0]);

        //try to find a not available User Entity.
        $arrNotFoundUser = $userRepository->findByUsername('notavailable');

        //the User Entity should not be found on database.
        $this->assertEquals(0, count($arrNotFoundUser));
        $this->assertEquals([], $arrNotFoundUser);
    }
}