<?php
/**
 * Namespace for all test classes of the DataMapper.
 */
namespace PicVid\Test\Domain\DataMapper;

use PHPUnit\DbUnit\DataSet\XmlDataSet;
use PicVid\Domain\DataMapper\UserMapper;
use PicVid\Domain\Entity\User;
use PicVid\Domain\Entity\Image;
use PicVid\Test\DatabaseTestCase;

/**
 * Class UserMapperTest
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Test\Domain\DataMapper
 */
class UserMapperTest extends DatabaseTestCase
{
    /**
     * Method to get the initial state of the database for test.
     * @return XmlDataSet
     */
    public function getDataset() : XmlDataSet
    {
        return $this->createXMLDataSet(__DIR__ . '/DataSets/User/user.xml');
    }

    /**
     * Method to test the UserMapper:create method.
     * @test
     */
    public function testCreate()
    {
        //The User Entity which will be created on database.
        $userCreate = new User();
        $userCreate->email = 'eknappett2@prnewswire.com';
        $userCreate->firstname = 'Elsworth';
        $userCreate->lastname = 'Knappett';
        $userCreate->username = 'eknappett2';

        //The User Entity which will be updated on database.
        $userUpdate = new User();
        $userUpdate->id = 2;

        //The UserMapper to create the User Entity on database.
        $userMapper = new UserMapper($this->getConnection()->getConnection());

        //The first User Entity should be created; the second User Entity should fail.
        $this->assertTrue($userMapper->create($userCreate));
        $this->assertFalse($userMapper->create($userUpdate));

        //Another Entity than User Entity is not valid on the UserMapper and should fail.
        $this->assertFalse($userMapper->create(new Image()));

        //The ID of the created User Entity should be 3.
        $this->assertEquals(3, $userMapper->getInsertID());

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('user', 'SELECT id, email, firstname, lastname, username FROM user');
        $expectedDataset = __DIR__.'/DataSets/User/user-create.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('user');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $actualTable);
    }

    /**
     * Method to test the UserMapper:delete method.
     * @test
     */
    public function testDelete()
    {
        //The User Entity which will be deleted on database.
        $userDelete = new User();
        $userDelete->id = 2;

        //The User Entity which will be created on database.
        $userCreate = new User();

        //The UserMapper to delete the User Entity on database.
        $userMapper = new UserMapper($this->getConnection()->getConnection());

        //The first User Entity should be deleted; the second User Entity should fail.
        $this->assertTrue($userMapper->delete($userDelete));
        $this->assertFalse($userMapper->delete($userCreate));

        //Another Entity than User Entity is not valid on the UserMapper.
        $this->assertFalse($userMapper->delete(new Image()));

        //No User Entity was created so the ID should be 0.
        $this->assertEquals(0, $userMapper->getInsertID());

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('user', 'SELECT id, email, firstname, lastname, username FROM user');
        $expectedDataset = __DIR__.'/DataSets/User/user-delete.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('user');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $actualTable);
    }

    /**
     * Method to test the UserMapper:find method.
     * @test
     */
    public function testFind()
    {
        //The UserMapper to find the User Entities on database.
        $userMapper = new UserMapper($this->getConnection()->getConnection());

        //Find the User Entity with ID = 1 on database.
        $arrUser = $userMapper->find("id = 1");

        //The UserMapper should find one User Entity.
        $this->assertEquals(1, count($arrUser));

        //Create the first User Entity as object to compare with the found User Entities.
        $firstUser = new User();
        $firstUser->id = 1;
        $firstUser->email = 'tmoxon0@buzzfeed.com';
        $firstUser->firstname = 'Tim';
        $firstUser->lastname = 'Moxon';
        $firstUser->username = 'tmoxon0';

        //Create the second User Entity as object to compare with the found User Entities.
        $secondUser = new User();
        $secondUser->id = 2;
        $secondUser->email = 'ftrayes1@answers.com';
        $secondUser->firstname = 'Fleurette';
        $secondUser->lastname = 'Trayes';
        $secondUser->username = 'ftrayes1';

        //The found User Entity (database) should be the same User Entity (object).
        $this->assertEquals($arrUser[0], $firstUser);

        //Find all User Entities on database.
        $arrUser = $userMapper->find();

        //The UserMapper should find two User Entities.
        $this->assertEquals(2, count($arrUser));

        //The found User Entities (database) should be the same User Entities (objects).
        $this->assertEquals($arrUser[0], $firstUser);
        $this->assertEquals($arrUser[1], $secondUser);

        //Find no User Entities on database.
        $arrUser = $userMapper->find('1 = 2');

        //The User Mapper should not find a User Entity.
        $this->assertEquals(0, count($arrUser));
    }

    /**
     * Method to test the UserMapper:save method.
     * @test
     */
    public function testSave()
    {
        //The User Entity which will be updated on database.
        $userUpdate = new User();
        $userUpdate->id = 2;
        $userUpdate->email = 'ygerrard4@spotify.com';
        $userUpdate->firstname = 'Yard';
        $userUpdate->lastname = 'Gerrard';
        $userUpdate->username = 'ygerrard4';

        //The User Entity which will be created on database.
        $userCreate = new User();
        $userCreate->email = 'ostannislawski5@bizjournals.com';
        $userCreate->firstname = 'Orelle';
        $userCreate->lastname = 'Stannislawski';
        $userCreate->username = 'ostannislawski5';

        //The UserMapper to save the User Entities on database.
        $userMapper = new UserMapper($this->getConnection()->getConnection());

        //The first and second User Entity should be saved on database.
        $this->assertTrue($userMapper->save($userUpdate));
        $this->assertTrue($userMapper->save($userCreate));

        //Another Entity than User Entity is not valid on the UserMapper.
        $this->assertFalse($userMapper->save(new Image()));

        //The ID of the created User Entity should be 3.
        $this->assertEquals(3, $userMapper->getInsertID());

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('user', 'SELECT id, email, firstname, lastname, username FROM user');
        $expectedDataset = __DIR__.'/DataSets/User/user-save.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('user');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $actualTable);
    }

    /**
     * Method to test the UserMapper:update method.
     * @test
     */
    public function testUpdate()
    {
        //The User Entity which will be updated on database.
        $userUpdate = new User();
        $userUpdate->id = 2;
        $userUpdate->email = 'teyrl3@github.io';
        $userUpdate->firstname = 'Theodore';
        $userUpdate->lastname = 'Eyrl';
        $userUpdate->username = 'teyrl3';

        //The User Entity which will be created on database.
        $userCreate = new User();

        //The UserMapper to update the User Entity on database.
        $userMapper = new UserMapper($this->getConnection()->getConnection());

        //The first User Entity should be updated; the second User Entity should fail.
        $this->assertTrue($userMapper->update($userUpdate));
        $this->assertFalse($userMapper->update($userCreate));

        //Another Entity than User Entity is not valid on the UserMapper.
        $this->assertFalse($userMapper->update(new Image()));

        //No User Entity was created so the ID should be 0.
        $this->assertEquals(0, $userMapper->getInsertID());

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('user', 'SELECT id, email, firstname, lastname, username FROM user');
        $expectedDataset = __DIR__.'/DataSets/User/user-update.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('user');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $actualTable);
    }
}