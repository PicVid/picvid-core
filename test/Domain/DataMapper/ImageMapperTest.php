<?php
/**
 * Namespace for all test classes of the DataMapper.
 */
namespace PicVid\Test\Domain\DataMapper;

use PHPUnit\DbUnit\DataSet\XmlDataSet;
use PicVid\Domain\DataMapper\ImageMapper;
use PicVid\Domain\Entity\Image;
use PicVid\Domain\Entity\User;
use PicVid\Test\DatabaseTestCase;

/**
 * Class ImageMapperTest
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Test\Domain\DataMapper
 */
class ImageMapperTest extends DatabaseTestCase
{
    /**
     * Method to get the initial state of the database for test.
     * @return XmlDataSet
     */
    public function getDataset() : XmlDataSet
    {
        return $this->createXMLDataSet(__DIR__ . '/DataSets/Image/images.xml');
    }

    /**
     * Method to test the ImageMapper:create method.
     * @test
     */
    public function testCreate()
    {
        //The Image Entity which will be created on database.
        $imageCreate = new Image();
        $imageCreate->description = 'Suspendisse accumsan tortor quis turpis.';
        $imageCreate->filename = 'penatibus_et.tiff';
        $imageCreate->size = 358;
        $imageCreate->title = 'Nullam porttitor lacus at turpis.';
        $imageCreate->type = 'image/tiff';

        //The Image Entity which will be updated on database.
        $imageUpdate = new Image();
        $imageUpdate->id = 2;

        //The ImageMapper to create the Image Entity on database.
        $imageMapper = new ImageMapper($this->getConnection()->getConnection());

        //The first Image Entity should be created; the second Image Entity should fail.
        $this->assertTrue($imageMapper->create($imageCreate));
        $this->assertFalse($imageMapper->create($imageUpdate));

        //Another Entity than Image Entity is not valid on the ImageMapper and should fail.
        $this->assertFalse($imageMapper->create(new User()));

        //The ID of the created Image Entity should be 3.
        $this->assertEquals(3, $imageMapper->getInsertID());

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('images', 'SELECT * FROM images');
        $expectedDataset = __DIR__.'/DataSets/Image/images-create.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('images');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $actualTable);
    }

    /**
     * Method to test the ImageMapper:delete method.
     * @test
     */
    public function testDelete()
    {
        //The Image Entity which will be deleted on database.
        $imageDelete = new Image();
        $imageDelete->id = 2;

        //The Image Entity which will be created on database.
        $imageCreate = new Image();

        //The ImageMapper to delete the Image Entity on database.
        $imageMapper = new ImageMapper($this->getConnection()->getConnection());

        //The first Image Entity should be deleted; the second Image Entity should fail.
        $this->assertTrue($imageMapper->delete($imageDelete));
        $this->assertFalse($imageMapper->delete($imageCreate));

        //Another Entity than Image Entity is not valid on the ImageMapper.
        $this->assertFalse($imageMapper->delete(new User()));

        //No Image Entity was created so the ID should be 0.
        $this->assertEquals(0, $imageMapper->getInsertID());

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('images', 'SELECT * FROM images');
        $expectedDataset = __DIR__.'/DataSets/Image/images-delete.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('images');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $actualTable);
    }

    /**
     * Method to test the ImageMapper:find method.
     * @test
     */
    public function testFind()
    {
        //The ImageMapper to find the Image Entities on database.
        $imageMapper = new ImageMapper($this->getConnection()->getConnection());

        //Find the Image Entity with ID = 1 on database.
        $arrImage = $imageMapper->find("id = 1");

        //The ImageMapper should find one Image Entity.
        $this->assertEquals(1, count($arrImage));

        //Create the first Image Entity as object to compare with the found Image Entities.
        $firstImage = new Image();
        $firstImage->id = 1;
        $firstImage->description = 'Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo.';
        $firstImage->filename = 'eleifend_luctus.jpeg';
        $firstImage->size = 442;
        $firstImage->title = 'Cras in purus eu magna vulputate luctus.';
        $firstImage->type = 'image/jpeg';

        //Create the second Image Entity as object to compare with the found Image Entities.
        $secondImage = new Image();
        $secondImage->id = 2;
        $secondImage->description = 'Duis mattis egestas metus.';
        $secondImage->filename = 'suscipit_nulla.jpeg';
        $secondImage->size = 375;
        $secondImage->title = 'In hac habitasse platea dictumst.';
        $secondImage->type = 'image/pjpeg';

        //The found Image Entity (database) should be the same Image Entity (object).
        $this->assertEquals($arrImage[0], $firstImage);

        //Find all Image Entities on database.
        $arrImage = $imageMapper->find();

        //The ImageMapper should find two Image Entities.
        $this->assertEquals(2, count($arrImage));

        //The found Image Entities (database) should be the same Image Entities (objects).
        $this->assertEquals($arrImage[0], $firstImage);
        $this->assertEquals($arrImage[1], $secondImage);

        //Find no Image Entities on database.
        $arrImage = $imageMapper->find('1 = 2');

        //The Image Mapper should not find a Image Entity.
        $this->assertEquals(0, count($arrImage));
    }

    /**
     * Method to test the ImageMapper:save method.
     * @test
     */
    public function testSave()
    {
        //The Image Entity which will be updated on database.
        $imageUpdate = new Image();
        $imageUpdate->id = 2;
        $imageUpdate->description = 'Mauris lacinia sapien quis libero.';
        $imageUpdate->filename = 'sapien_placerat.jpeg';
        $imageUpdate->size = 449;
        $imageUpdate->title = 'Nulla ut erat id mauris vulputate elementum.';
        $imageUpdate->type = 'image/jpeg';

        //The Image Entity which will be created on database.
        $imageCreate = new Image();
        $imageCreate->description = 'Cras in purus eu magna vulputate luctus.';
        $imageCreate->filename = 'ullamcorper.tiff';
        $imageCreate->size = 556;
        $imageCreate->title = 'Morbi porttitor lorem id ligula.';
        $imageCreate->type = 'image/tiff';

        //The ImageMapper to save the Image Entities on database.
        $imageMapper = new ImageMapper($this->getConnection()->getConnection());

        //The first and second Image Entity should be saved on database.
        $this->assertTrue($imageMapper->save($imageUpdate));
        $this->assertTrue($imageMapper->save($imageCreate));

        //Another Entity than Image Entity is not valid on the ImageMapper.
        $this->assertFalse($imageMapper->save(new User()));

        //The ID of the created Image Entity should be 3.
        $this->assertEquals(3, $imageMapper->getInsertID());

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('images', 'SELECT * FROM images');
        $expectedDataset = __DIR__.'/DataSets/Image/images-save.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('images');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $actualTable);
    }

    /**
     * Method to test the ImageMapper:update method.
     * @test
     */
    public function testUpdate()
    {
        //The Image Entity which will be updated on database.
        $imageUpdate = new Image();
        $imageUpdate->id = 2;
        $imageUpdate->description = 'Duis bibendum.';
        $imageUpdate->filename = 'tempor.jpeg';
        $imageUpdate->size = 578;
        $imageUpdate->title = 'Sed sagittis.';
        $imageUpdate->type = 'image/jpeg';

        //The Image Entity which will be created on database.
        $imageCreate = new Image();

        //The ImageMapper to update the Image Entity on database.
        $imageMapper = new ImageMapper($this->getConnection()->getConnection());

        //The first Image Entity should be updated; the second Image Entity should fail.
        $this->assertTrue($imageMapper->update($imageUpdate));
        $this->assertFalse($imageMapper->update($imageCreate));

        //Another Entity than Image Entity is not valid on the ImageMapper.
        $this->assertFalse($imageMapper->update(new User()));

        //No Image Entity was created so the ID should be 0.
        $this->assertEquals(0, $imageMapper->getInsertID());

        //get the actual and expected table.
        $actualTable = $this->getConnection()->createQueryTable('images', 'SELECT * FROM images');
        $expectedDataset = __DIR__.'/DataSets/Image/images-update.xml';
        $expectedTable = $this->createXMLDataSet($expectedDataset)->getTable('images');

        //check whether the tables are equal.
        $this->assertTablesEqual($expectedTable, $actualTable);
    }
}