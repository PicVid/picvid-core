<?php
/**
 * Namespace for all core classes of PicVid.
 */
namespace PicVid\Core;

/**
 * Class EXIF
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Core
 */
class EXIF
{
    /**
     * The lens aperture. The unit is the APEX value.
     * @var string
     */
    public $ApertureValue = '';

    /**
     * The value of brightness. The unit is the APEX value. Ordinarily it is given in the range of -99.99 to 99.99.
     * @var string
     */
    public $BrightnessValue = '';

    /**
     * The color space information tag (ColorSpace) is always recorded as the color space specifier.
     * @var int
     */
    public $ColorSpace = 0;

    /**
     * Information specific to compressed data. The channels of each component
     * are arranged in order from the 1st component to the 4th.
     * @var string
     */
    public $ComponentsConfiguration = '';

    /**
     * Information specific to compressed data. The compression mode
     * used for a compressed image is indicated in unit bits per pixel.
     * @var string
     */
    public $CompressedBitsPerPixel = '';

    /**
     * This tag indicates the direction of contrast processing applied by the camera when the image was shot.
     * @var int
     */
    public $Contrast = 0;

    /**
     * This tag indicates the use of special processing on image data, such as rendering
     * geared to output. When special processing is performed, the reader is expected
     * to disable or minimize any further processing.
     * @var int
     */
    public $CustomRendered = 0;

    /**
     * The date and time when the image was stored as digital data. If, for example, an image
     * was captured by DSC and at the same time the file was recorded, then the
     * DateTimeOriginal and DateTimeDigitized will have the same contents.
     * @var string
     */
    public $DateTimeDigitized = '';

    /**
     * The date and time when the original image data was generated.
     * For a DSC the date and time the picture was taken are recorded.
     * @var string
     */
    public $DateTimeOriginal = '';

    /**
     * This tag indicates the digital zoom ratio when the image was shot. If the numerator of the
     * recorded value is 0, this indicates that digital zoom was not used.
     * @var string
     */
    public $DigitalZoomRatio = '';

    /**
     * The version of this standard supported. Nonexistence of this field is taken to mean nonconformance
     * to the standard. Conformance to this standard is indicated by recording "0220" as 4-byte ASCII.
     * @var string
     */
    public $ExifVersion = '0220';

    /**
     * The exposure bias. The unit is the APEX value. Ordinarily it is given in the range of –99.99 to 99.99.
     * @var string
     */
    public $ExposureBiasValue = '';

    /**
     * Indicates the exposure index selected on the camera or input device at the time the image is captured.
     * @var string
     */
    public $ExposureIndex = '';

    /**
     * This tag indicates the exposure mode set when the image was shot. In auto-bracketing mode,
     * the camera shoots a series of frames of the same scene at different exposure settings.
     * @var int
     */
    public $ExposureMode = 0;

    /**
     * The class of the program used by the camera to set exposure when the picture is taken.
     * @var int
     */
    public $ExposureProgram = 0;

    /**
     * Exposure time, given in seconds (sec).
     * @var string
     */
    public $ExposureTime = '';

    /**
     * The F number.
     * @var string
     */
    public $FNumber = '';

    /**
     * Indicates the image source. If a DSC recorded the image, this tag value of this tag
     * always be set to 3, indicating that the image was recorded on a DSC.
     * @var string
     */
    public $FileSource = '3';

    /**
     * This tag indicates the status of flash when the image was shot. Bit 0 indicates the flash
     * firing status, bits 1 and 2 indicate the flash return status, bits 3 and 4 indicate the flash
     * mode, bit 5 indicates whether the flash function is present, and bit 6 indicates "red eye" mode.
     * @var int
     */
    public $Flash = 0;

    /**
     * The Flashpix format version supported by a FPXR file. If the FPXR function supports Flashpix format
     * Ver. 1.0, this is indicated similarly to ExifVersion by recording "0100" as 4-byte ASCII.
     * @var string
     */
    public $FlashPixVersion = '0100';

    /**
     * The actual focal length of the lens, in mm. Conversion is not made to the focal length of a 35 mm film camera.
     * @var string
     */
    public $FocalLength = '';

    /**
     * This tag indicates the equivalent focal length assuming a 35mm film camera, in mm. A value of 0
     * means the focal length is unknown. Note that this tag differs from the FocalLength tag.
     * @var int
     */
    public $FocalLengthIn35mmFilm = 0;

    /**
     * Indicates the unit for measuring FocalPlaneXResolution and FocalPlaneYResolution.
     * This value is the same as the ResolutionUnit.
     * @var int
     */
    public $FocalPlaneResolutionUnit = 2;

    /**
     * Indicates the number of pixels in the image width (X) direction per
     * FocalPlaneResolutionUnit on the camera focal plane.
     * @var string
     */
    public $FocalPlaneXResolution = '';

    /**
     * Indicates the number of pixels in the image height (Y) direction per
     * FocalPlaneResolutionUnit on the camera focal plane.
     * @var string
     */
    public $FocalPlaneYResolution = '';

    /**
     * This tag indicates the degree of overall image gain adjustment.
     * @var int
     */
    public $GainControl = 0;

    /**
     * The number of rows of image data. In JPEG compressed data a JPEG marker is used instead of this tag.
     * @var int
     */
    public $ImageLength = 0;

    /**
     * This tag indicates an identifier assigned uniquely to each image. It is recorded as an ASCII string equivalent
     * to hexadecimal notation and 128-bit fixed length.
     * @var string
     */
    public $ImageUniqueID = '';

    /**
     * The number of columns of image data, equal to the number of pixels per row. In JPEG compressed
     * data a JPEG marker is used instead of this tag.
     * @var int
     */
    public $ImageWidth = 0;

    /**
     * Indicates the ISO Speed and ISO Latitude of the camera or input device as specified in ISO 12232.
     * @var int
     */
    public $ISOSpeedRatings = 0;

    /**
     * The kind of light source.
     * @var int
     */
    public $LightSource = 0;

    /**
     * A tag for manufacturers of Exif writers to record any desired information. The contents are up to the
     * manufacturer, but this tag should not be used for any other than its intended purpose.
     * @var string
     */
    public $MakerNote = '';

    /**
     * The smallest F number of the lens. The unit is the APEX value. Ordinarily it is given
     * in the range of 00.00 to 99.99, but it is not limited to this range.
     * @var string
     */
    public $MaxApertureValue = '';

    /**
     * The metering mode.
     * @var int
     */
    public $MeteringMode = 0;

    /**
     * This tag is used to record the name of an audio file related to the image data. The only
     * relational information recorded here is the Exif audio file name and extension.
     * @var string
     */
    public $RelatedSoundFile = '';

    /**
     * This tag indicates the direction of saturation processing applied by the camera when the image was shot.
     * @var int
     */
    public $Saturation = 0;

    /**
     * This tag indicates the type of scene that was shot. It can also be used to record the mode in
     * which the image was shot. Note that this differs from the scene type (SceneType) tag.
     * @var int
     */
    public $SceneCaptureType = 0;

    /**
     * Indicates the type of scene. If a DSC recorded the image, this tag value shall always be
     * set to 1, indicating that the image was directly photographed.
     * @var string
     */
    public $SceneType = '1';

    /**
     * Indicates the image sensor type on the camera or input device.
     * @var int
     */
    public $SensingMethod = 0;

    /**
     * This tag indicates the direction of sharpness processing applied by the camera when the image was shot.
     * @var int
     */
    public $Sharpness = 0;

    /**
     * Shutter speed. The unit is the APEX (Additive System of Photographic Exposure) setting.
     * @var string
     */
    public $ShutterSpeedValue = '';

    /**
     * This tag indicates the distance to the subject.
     * @var int
     */
    public $SubjectDistanceRange = 0;

    /**
     * Indicates the location of the main subject in the scene. The value of this tag represents the pixel at the
     * center of the main subject relative to the left edge, prior to rotation processing as per the Rotation tag.
     * The first value indicates the X column number and second indicates the Y row number.
     * @var int
     */
    public $SubjectLocation = 0;

    /**
     * A tag used to record fractions of seconds for the DateTime tag.
     * @var string
     */
    public $SubsecTime = '';

    /**
     * A tag used to record fractions of seconds for the DateTimeDigitized tag.
     * @var string
     */
    public $SubsecTimeDigitized = '';

    /**
     * A tag used to record fractions of seconds for the DateTimeOriginal tag.
     * @var string
     */
    public $SubsecTimeOriginal = '';

    /**
     * A tag for Exif users to write keywords or comments on the image besides those in ImageDescription,
     * and without the character code limitations of the ImageDescription tag.
     * @var string
     */
    public $UserComment = '';

    /**
     * This tag indicates the white balance mode set when the image was shot.
     * @var int
     */
    public $WhiteBalance = 0;

    /**
     * EXIF constructor.
     * @param string $filePath The path of the image for which the EXIF information is to be determined.
     */
    public function __construct(string $filePath)
    {
        //check whether the file exists.
        if (file_exists($filePath)) {
            $result = exif_read_data($filePath, 'EXIF');

            //check whether the EXIF data is available.
            if ($result !== false) {
                $this->loadFromArray($result);
            }
        }
    }

    /**
     * Method to load an array to the EXIF class.
     * @param array $array The array to load into the EXIF class.
     * @return void
     */
    public function loadFromArray(array $array)
    {
        foreach (array_keys(get_class_vars(get_class($this))) as $property) {
            if (array_key_exists($property, $array) === true) {
                $this->$property = $array[$property];
            }
        }
    }
}