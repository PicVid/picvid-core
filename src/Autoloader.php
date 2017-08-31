<?php
/**
 * Namespace for all classes of PicVid.
 */
namespace PicVid;

/**
 * Class Autoloader
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid
 */
class Autoloader
{
    /**
     * An associative array where the key is a namespace prefix and the value
     * is an array of base directories for classes in that namespace.
     * @var array
     */
    private $prefixes = [];

    /**
     * Register loader with SPL autoloader stack.
     */
    public function __construct()
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    /**
     * Adds a base directory for a namespace prefix.
     * @param string $prefix The namespace prefix.
     * @param string $directory A base directory for class files in the namespace.
     */
    public function addNamespace(string $prefix, string $directory)
    {
        //normalize the prefix and directory.
        $prefix = trim($prefix, '\\').'\\';
        $directory = rtrim($directory, '\\/').'/';

        //set the directory to the namespace prefix.
        $this->prefixes[$prefix][] = $directory;
    }

    /**
     * Loads the class file for a given class name.
     * @param string $class The fully-qualified class name.
     * @return bool|string The mapped file name on success, or boolean false on failure.
     */
    public function loadClass(string $class)
    {
        //the current namespace prefix.
        $prefix = $class;

        //work backwards through the namespace names of the fully-qualified class name to find a mapped file name.
        while (($pos = strrpos($prefix, '\\')) !== false) {

            //retain the trailing namespace separator in the prefix.
            $prefix = substr($class, 0, $pos + 1);

            //the rest is the relative class name.
            $relativeClass = substr($class, $pos + 1);

            //try to load a mapped file for the prefix and relative class.
            $file = $this->loadFile($prefix, $relativeClass);

            //check if the file could be loaded.
            if ($file !== false) {
                return $file;
            }

            //remove the trailing namespace separator for the next iteration of strrpos().
            $prefix = rtrim($prefix, '\\');
        }

        //never found a mapped file.
        return false;
    }

    /**
     * Load the mapped file for a namespace prefix and relative class.
     * @param string $prefix The namespace prefix.
     * @param string $class The relative class name.
     * @return bool|string Boolean false if no mapped file can be loaded, or the
     * name of the mapped file that was loaded.
     */
    public function loadFile(string $prefix, string $class)
    {
        //are there any base directories for this namespace prefix?
        if (isset($this->prefixes[$prefix]) === false) {
            return false;
        }

        //look through base directories for this namespace prefix.
        foreach ($this->prefixes[$prefix] as $directory) {

            //replace the namespace prefix with the base directory,
            //replace namespace separators with directory separators
            //in the relative class name, append with .php
            $file = $directory.str_replace('\\', '/', $class).'.php';

            //if the mapped file exists, require it.
            if ($this->requireFile($file)) {
                return $file;
            }
        }

        //never found it.
        return false;
    }

    /**
     * If a file exists, require it from the file system.
     * @param string $file The file to require.
     * @return bool True if the file exists, false if not.
     */
    protected function requireFile(string $file)
    {
        //check if the file exists.
        if (file_exists($file)) {
            require_once($file);
            return true;
        } else {
            return false;
        }
    }
}