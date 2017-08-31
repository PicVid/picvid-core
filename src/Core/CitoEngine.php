<?php
/**
 * Namespace for all core classes of PicVid.
 */
namespace PicVid\Core;

/**
 * Class CitoEngine
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Core
 */
class CitoEngine
{
    /**
     * The status of whether the buffer could be initialized.
     * @var bool
     */
    private $bufferState = false;

    /**
     * The instance of the CitoEngine.
     * @var null|CitoEngine
     */
    private static $instance = null;

    /**
     * The buffer containing the page content.
     * @var string
     */
    private $siteBuffer = '';

    /**
     * The array with all tags and their values.
     * @var array
     */
    private $tagValues = [];

    /**
     * The status which compression is used.
     * @var string
     */
    private $usedCompression = '';

    /**
     * Private constructor to prevent a new instance.
     */
    private function __construct()
    {
    }

    /**
     * Private clone method to prevent a new instance.
     */
    private function __clone()
    {
    }

    /**
     * Method to execute the CitoEngine.
     */
    public function execute()
    {
        //check whether output buffering has been started.
        if ($this->bufferState === true) {
            $this->siteBuffer = ob_get_contents();

            //check whether the output buffering was successful.
            if ($this->siteBuffer !== false) {
                ob_end_clean();
                $this->render();
            }
        }
    }

    /**
     * Method to execute the deflate compression.
     */
    private function executeDeflate()
    {
        $this->siteBuffer = gzdeflate($this->siteBuffer, 9);
        header('Content-Encoding: deflate');
    }

    /**
     * Method to execute the gzip compression.
     */
    private function executeGzip()
    {
        $contentSize = strlen($this->siteBuffer);
        $contentChecksum = crc32($this->siteBuffer);

        //compress the site buffer.
        $this->siteBuffer = gzcompress($this->siteBuffer);
        $this->siteBuffer = substr($this->siteBuffer, 0, strlen($this->siteBuffer) - 4);

        //set header and output content.
        header('Content-Encoding: gzip');
        $this->siteBuffer = "\x1f\x8b\x08\x00\x00\x00\x00\x00";
        $this->siteBuffer .= $this->siteBuffer.pack('V', $contentChecksum).pack('V', $contentSize);
    }

    /**
     * Method to get an instance of the CitoEngine.
     * @return null|CitoEngine An instance of the CitoEngine.
     */
    public static function getInstance()
    {
        //create an instance if none exists.
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Method to initialize the CitoEngine.
     */
    public function init()
    {
        $this->initCompression();
        $this->bufferState = ob_start();
    }

    /**
     * Method to initialize the compression.
     */
    private function initCompression()
    {
        //check if gzip compression is available.
        if (intval(ini_get('zlib.output_compression')) !== 1) {
            $encoding = filter_input(INPUT_SERVER, 'HTTP_ACCEPT_ENCODING');

            //check if a gecko browser is used.
            if (strpos(filter_input(INPUT_SERVER, 'HTTP_USER_AGENT'), 'Gecko') !== false) {

                //check which compression is available.
                if (strpos($encoding, 'deflate') !== false) {
                    $this->usedCompression = 'deflate';
                } elseif (strpos($encoding, 'gzip') !== false) {
                    $this->usedCompression = 'gzip';
                }
            } elseif ((version_compare(phpversion(), '4.0.5') >= 0) && (strpos($encoding, 'gzip') !== false)) {

                //check if the zlib extension exists.
                if (extension_loaded('zlib') === true) {
                    ob_start('ob_gzhandler');
                }
            }
        }
    }

    /**
     * Method to render the output.
     */
    public function render()
    {
        //check whether the output buffering was successful.
        if ($this->bufferState === true) {
            $this->siteBuffer = ob_get_contents();

            //check if the page content is available.
            if ($this->siteBuffer !== false) {
                ob_end_clean();

                //render and output buffer.
                $this->replaceTags();

                //compress the page content.
                if ($this->usedCompression === 'deflate') {
                    $this->executeDeflate();
                } elseif ($this->usedCompression === 'gzip') {
                    $this->executeGzip();
                }

                //output page content.
                echo $this->siteBuffer;
            }
        }
    }

    /**
     * Method to reset the tags in the template.
     */
    private function replaceTags()
    {
        $tagContent = '';

        //determine all tags from the template.
        preg_match_all("/{{(.*)}}/", $this->siteBuffer, $tags);

        for ($i = 0; $i < count($tags[1]); $i++) {
            $tag = $tags[1][$i];

            //check if there is any content for the tag.
            if (isset($this->tagValues[$tag])) {

                //create the full tag content.
                foreach ($this->tagValues[$tag] as $content) {
                    $tagContent .= $content.(($content === '') ? '' : "\n");
                }

                //check if there is any content for the tag in tag content.
                preg_match_all("/{{(.*)}}/", $tagContent, $tagsContent);
                $tags[1] = array_merge($tags[1], $tagsContent[1]);
            }

            //replace the tag with the tag content.
            $this->siteBuffer = str_replace('{{'.$tag.'}}', $tagContent, $this->siteBuffer);
            $tagContent = '';
        }
    }

    /**
     * Method to place content in a tag.
     * @param string $tag The name of the tag.
     * @param string $value The content of the tag.
     */
    public function setValue(string $tag, string $value)
    {
        $this->tagValues[$tag][] = $value;
    }
}