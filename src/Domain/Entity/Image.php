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
}