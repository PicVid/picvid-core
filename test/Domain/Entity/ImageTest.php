<?php
/**
 * Namespace for all test classes of the Entities.
 */
namespace PicVid\Test\Domain\Entity;

use PHPUnit\Framework\TestCase;
use PicVid\Domain\Entity\Image;

/**
 * Class ImageTest
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Test\Domain\Entity
 */
class ImageTest extends TestCase
{
    /**
     * Method to test the Image::hasID method.
     * @test
     */
    public function testHasID()
    {
        //create a new Image Entity.
        $image = new Image();

        //test the Image Entity (expected default ID = 0).
        $this->assertEquals(0, $image->id);
        $this->assertFalse($image->hasID());

        //set a new ID to the Image Entity.
        $image->id = 1;

        //test the Image Entity (expected ID > 0).
        $this->assertEquals(1, $image->id);
        $this->assertTrue($image->hasID());
    }

    /**
     * Method to test the Image::loadFromArray method.
     * @test
     */
    public function testLoadFromArray()
    {
        //create a new Image Entity.
        $image = new Image();

        //test the Image Entity (expected default ID = 0).
        $this->assertEquals(0, $image->id);
        $this->assertFalse($image->hasID());

        //create an array with the image information.
        $arr = [
            'id' => 1,
            'description' => 'Integer ac neque.',
            'filename' => 'quis_justo.png',
            'size' => 498,
            'title' => 'Nam congue.',
            'type' => 'image/png'
        ];

        //load the array with image information to the Image Entity.
        $image->loadFromArray($arr);

        //test the Image Entity.
        $this->assertTrue($image->hasID());
        $this->assertEquals(1, $image->id);
        $this->assertEquals('Integer ac neque.', $image->description);
        $this->assertEquals('quis_justo.png', $image->filename);
        $this->assertEquals(498, $image->size);
        $this->assertEquals('Nam congue.', $image->title);
        $this->assertEquals('image/png', $image->type);

        //create a new Image Entity.
        $image = new Image();

        //test the Image Entity (expected default ID = 0).
        $this->assertEquals(0, $image->id);
        $this->assertFalse($image->hasID());

        //create an array with the image information (with prefixes).
        $arr = [
            'test_id' => 2,
            'test_description' => 'Proin leo odio, porttitor id, consequat in, consequat ut, nulla.',
            'test_filename' => 'odio_in_hac.tiff',
            'test_size' => 833,
            'test_title' => 'In tempor sem.',
            'test_type' => 'image/tiff'
        ];

        //load the array with image information to the Image Entity (with prefixes).
        $image->loadFromArray($arr, 'test_');

        //test the Image Entity.
        $this->assertTrue($image->hasID());
        $this->assertEquals(2, $image->id);
        $this->assertEquals('Proin leo odio, porttitor id, consequat in, consequat ut, nulla.', $image->description);
        $this->assertEquals('odio_in_hac.tiff', $image->filename);
        $this->assertEquals(833, $image->size);
        $this->assertEquals('In tempor sem.', $image->title);
        $this->assertEquals('image/tiff', $image->type);
    }

    /**
     * Method to test the Image::loadFromObject method.
     * @test
     */
    public function testLoadFromObject()
    {
        //create a new Image Entity.
        $image = new Image();

        //test the Image Entity (expected default ID = 0).
        $this->assertEquals(0, $image->id);
        $this->assertFalse($image->hasID());

        //create an object with the image information.
        $obj = new \stdClass();
        $obj->id = 3;
        $obj->description = 'Maecenas tincidunt lacus at velit.';
        $obj->filename = 'bibendum_imperdiet_nullam.gif';
        $obj->size = 602;
        $obj->title = 'Donec ut convallis.';
        $obj->type = 'image/gif';

        //load the object with image information to the Image Entity.
        $image->loadFromObject($obj);

        //test the Image Entity.
        $this->assertTrue($image->hasID());
        $this->assertEquals(3, $image->id);
        $this->assertEquals('Maecenas tincidunt lacus at velit.', $image->description);
        $this->assertEquals('bibendum_imperdiet_nullam.gif', $image->filename);
        $this->assertEquals(602, $image->size);
        $this->assertEquals('Donec ut convallis.', $image->title);
        $this->assertEquals('image/gif', $image->type);

        //create a new Image Entity.
        $image = new Image();

        //test the Image Entity (expected default ID = 0).
        $this->assertEquals(0, $image->id);
        $this->assertFalse($image->hasID());

        //create an array with the image information (with prefixes).
        $obj = new \stdClass();
        $obj->test_id = 4;
        $obj->test_description = 'Proin risus.';
        $obj->test_filename = 'justo.tiff';
        $obj->test_size = 863;
        $obj->test_title = 'Fusce posuere felis sed lacus.';
        $obj->test_type = 'image/x-tiff';

        //load the object with image information to the Image Entity (with prefixes).
        $image->loadFromObject($obj, 'test_');

        //test the Image Entity.
        $this->assertTrue($image->hasID());
        $this->assertEquals(4, $image->id);
        $this->assertEquals('Proin risus.', $image->description);
        $this->assertEquals('justo.tiff', $image->filename);
        $this->assertEquals(863, $image->size);
        $this->assertEquals('Fusce posuere felis sed lacus.', $image->title);
        $this->assertEquals('image/x-tiff', $image->type);
    }
}