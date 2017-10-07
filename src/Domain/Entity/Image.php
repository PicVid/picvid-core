<?php
/**
 * Namespace for all Entities of PicVid.
 */
namespace PicVid\Domain\Entity;

/**
 * Class Image
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Entity
 */
class Image extends Entity
{
    /**
     * The description of the Image.
     * @var string
     */
    public $description = '';

    /**
     * The filename of the Image.
     * @var string
     */
    public $filename = '';

    /**
     * The size of the image (in Bytes).
     * @var int
     */
    public $size = 0;

    /**
     * The title of the Image.
     * @var string
     */
    public $title = '';

    /**
     * The filetype of the Image (MIME-Type).
     * @var string
     */
    public $type = '';

    /**
     * Method to get the full image path if file exists.
     * @return string The image path if the file exists or a empty string.
     */
    public function getImagePath() : string
    {
        //set the full image path.
        $imagePath = IMAGEDIR.$this->filename;

        //return the image path if file exists.
        return (file_exists($imagePath)) ? $imagePath : '';
    }

    /**
     * Method to get the full image URL if file exists.
     * @return string The image URL if the file exists or a empty string.
     */
    public function getImageURL() : string
    {
        //set the full image path and URL.
        $imagePath = IMAGEDIR.$this->filename;
        $imageURL = IMAGEURL.$this->filename;

        //return the image URL if file exists.
        return (file_exists($imagePath)) ? $imageURL : '';
    }
}