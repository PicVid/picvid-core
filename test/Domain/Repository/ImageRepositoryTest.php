<?php
/**
 * Namespace for all test classes of the DataMapper.
 */
namespace PicVid\Test\Domain\DataMapper;

use PHPUnit\DbUnit\DataSet\XmlDataSet;
use PicVid\Domain\DataMapper\ImageMapper;
use PicVid\Domain\Entity\Image;
use PicVid\Domain\Repository\ImageRepository;
use PicVid\Test\DatabaseTestCase;

/**
 * Class ImageRepositoryTest
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Test\Domain\DataMapper
 */
class ImageRepositoryTest extends DatabaseTestCase
{
    /**
     * Method to get the initial state of the database for test.
     * @return XmlDataSet
     */
    public function getDataset() : XmlDataSet
    {
        return $this->createXMLDataSet(__DIR__ . '/DataSets/images.xml');
    }

    /**
     * Method to test the ImageRepository:findAll method.
     * @test
     */
    public function testFindAll()
    {
        //get the ImageMapper and ImageRepository to get the Image Entities.
        $imageMapper = new ImageMapper($this->getConnection()->getConnection());
        $imageRepository = new ImageRepository($imageMapper);

        //get all the Image Entities from database.
        $arrImages = $imageRepository->findAll();

        //The first Image Entity which will be found on database.
        $firstImage = new Image();
        $firstImage->id = 1;
        $firstImage->description = 'Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo.';
        $firstImage->filename = 'eleifend_luctus.jpeg';
        $firstImage->size = 442;
        $firstImage->title = 'Cras in purus eu magna vulputate luctus.';
        $firstImage->type = 'image/jpeg';

        //The second Image Entitiy which will be found on database.
        $secondImage = new Image();
        $secondImage->id = 2;
        $secondImage->description = 'Duis mattis egestas metus.';
        $secondImage->filename = 'suscipit_nulla.jpeg';
        $secondImage->size = 375;
        $secondImage->title = 'In hac habitasse platea dictumst.';
        $secondImage->type = 'image/pjpeg';

        //The first and second Image Entity should be found on database.
        $this->assertEquals($firstImage, $arrImages[0]);
        $this->assertEquals($secondImage, $arrImages[1]);
    }

    /**
     * Method to test the ImageRepository:findByID method.
     * @test
     */
    public function testFindByID()
    {
        //get the ImageMapper and ImageRepository to get the Image Entities.
        $imageMapper = new ImageMapper($this->getConnection()->getConnection());
        $imageRepository = new ImageRepository($imageMapper);

        //get the first and second Image Entity from database.
        $arrFirstImage = $imageRepository->findByID(1);
        $arrSecondImage = $imageRepository->findByID(2);

        //The first Image Entity which will be found on database.
        $firstImage = new Image();
        $firstImage->id = 1;
        $firstImage->description = 'Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo.';
        $firstImage->filename = 'eleifend_luctus.jpeg';
        $firstImage->size = 442;
        $firstImage->title = 'Cras in purus eu magna vulputate luctus.';
        $firstImage->type = 'image/jpeg';

        //The second Image Entity which will be found on database.
        $secondImage = new Image();
        $secondImage->id = 2;
        $secondImage->description = 'Duis mattis egestas metus.';
        $secondImage->filename = 'suscipit_nulla.jpeg';
        $secondImage->size = 375;
        $secondImage->title = 'In hac habitasse platea dictumst.';
        $secondImage->type = 'image/pjpeg';

        //The first and second Image Entity should be found on database.
        $this->assertEquals($arrFirstImage[0], $firstImage);
        $this->assertEquals($arrSecondImage[0], $secondImage);
    }
}