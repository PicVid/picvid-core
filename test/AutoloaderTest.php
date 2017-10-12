<?php
/**
 * Namespace for all test classes of PicVid.
 */
namespace PicVid\Test;

use \PicVid\Autoloader;
use \PHPUnit\Framework\TestCase;

/**
 * Class MockAutoloaderTest
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Test
 */
class MockAutoloaderTest extends Autoloader
{
    /**
     * An array with all files to test the autoloader.
     * @var array
     */
    protected $files = [];

    /**
     * Method to set an array of file paths to test the autoloader.
     * @param array $files An array of file paths.
     */
    public function setFiles(array $files)
    {
        $this->files = $files;
    }

    /**
     * Method to check if the required file is available (simulate successful require function).
     * @param string $file The file path to check against the array of file paths.
     * @return bool The state if the file is required successfully.
     */
    protected function requireFile(string $file)
    {
        return in_array($file, $this->files);
    }
}

/**
 * Class AutoloaderTest
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Test
 */
class AutoloaderTest extends TestCase
{
    /**
     * The autoloader to test.
     * @var null|MockAutoloaderTest
     */
    protected $loader = null;

    /**
     * Method to setup the test environment.
     */
    protected function setUp()
    {
        //set the autoloader instance for test.
        $this->loader = new MockAutoloaderTest();

        //set the files to the loader for test.
        $this->loader->setFiles([
            '/vendor/foo.bar/src/ClassName.php',
            '/vendor/foo.bar/src/DoomClassName.php',
            '/vendor/foo.bar/tests/ClassNameTest.php',
            '/vendor/foo.bardoom/src/ClassName.php',
            '/vendor/foo.bar.baz.dib/src/ClassName.php',
            '/vendor/foo.bar.baz.dib.zim.gir/src/ClassName.php'
        ]);

        //add the namespaces for test.
        $this->loader->addNamespace('Foo\Bar', '/vendor/foo.bar/src');
        $this->loader->addNamespace('Foo\Bar', '/vendor/foo.bar/tests');
        $this->loader->addNamespace('Foo\BarDoom', '/vendor/foo.bardoom/src');
        $this->loader->addNamespace('Foo\Bar\Baz\Dib', '/vendor/foo.bar.baz.dib/src');
        $this->loader->addNamespace('Foo\Bar\Baz\Dib\Zim\Gir', '/vendor/foo.bar.baz.dib.zim.gir/src');
    }

    /**
     * Method to test for existing file.
     * @test
     */
    public function testExistingFile()
    {
        $actual = $this->loader->loadClass('Foo\Bar\ClassName');
        $expect = '/vendor/foo.bar/src/ClassName.php';
        $this->assertSame($expect, $actual);

        $actual = $this->loader->loadClass('Foo\Bar\ClassNameTest');
        $expect = '/vendor/foo.bar/tests/ClassNameTest.php';
        $this->assertSame($expect, $actual);
    }

    /**
     * Method to test for missing file.
     * @test
     */
    public function testMissingFile()
    {
        $actual = $this->loader->loadClass('No_Vendor\No_Package\NoClass');
        $this->assertFalse($actual);
    }

    /**
     * Method to test for a deep file.
     * @test
     */
    public function testDeepFile()
    {
        $actual = $this->loader->loadClass('Foo\Bar\Baz\Dib\Zim\Gir\ClassName');
        $expect = '/vendor/foo.bar.baz.dib.zim.gir/src/ClassName.php';
        $this->assertSame($expect, $actual);
    }

    /**
     * Method to test for confusing namespaces.
     * @test
     */
    public function testConfusion()
    {
        $actual = $this->loader->loadClass('Foo\Bar\DoomClassName');
        $expect = '/vendor/foo.bar/src/DoomClassName.php';
        $this->assertSame($expect, $actual);

        $actual = $this->loader->loadClass('Foo\BarDoom\ClassName');
        $expect = '/vendor/foo.bardoom/src/ClassName.php';
        $this->assertSame($expect, $actual);
    }
}