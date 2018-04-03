<?php
/**
 * Namespace for all Entities of PicVid.
 */
namespace PicVid\Domain\Entity;

use PicVid\Core\Configuration;

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
        //get the configuration.
        $config = Configuration::getInstance();

        //set the full image path.
        $imagePath = preg_replace('/\/\\\/', DIRECTORY_SEPARATOR, $config->getPathImage()).$this->filename;

        //return the image path if file exists.
        return (file_exists($imagePath)) ? $imagePath : '';
    }

    /**
     * Method to get the full image URL if file exists.
     * @return string The image URL if the file exists or a empty string.
     */
    public function getImageURL() : string
    {
        //get the configuration.
        $config = Configuration::getInstance();

        //set the full image URL.
        $imageURL = preg_replace("/\/|\\\/", '/', $config->getUrlImage()).$this->filename;

        //return the image URL if file exists.
        return (file_exists($this->getImagePath())) ? $imageURL : '';
    }

    /**
     * Method to determine the state of whether EXIF data exists.
     * @return bool The state whether EXIF data exists.
     */
    public function hasEXIF() : bool
    {
        //get the image path of the Image Entity.
        $filePath = $this->getImagePath();

        //check whether the file is a supported EXIF format.
        if (in_array(exif_imagetype($filePath), [IMAGETYPE_JPEG, IMAGETYPE_TIFF_II, IMAGETYPE_TIFF_MM]) === false) {
            return false;
        }

        //check whether a path is available.
        if (trim($filePath) !== '') {
            return is_array(@exif_read_data($filePath, 'EXIF'));
        } else {
            return false;
        }
    }
}
