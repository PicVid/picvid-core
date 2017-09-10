<?php
/**
 * Namespace for all core classes of PicVid.
 */
namespace PicVid\Core;

/**
 * Class View
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Core
 */
class View
{
    /**
     * The controller to be used.
     * @var string
     */
    private $controller = '';

    /**
     * The method to be used.
     * @var string
     */
    private $method = '';

    /**
     * An array with all variables of the view.
     * @var array
     */
    private $viewVars = [];

    /**
     * View constructor.
     * @param string $controller The name of the controller.
     * @param string $method The name of the method.
     */
    public function __construct(string $controller, string $method = 'Index')
    {
        $this->controller = $controller;
        $this->method = $method;
    }

    /**
     * Method to determine the value of a variable in the view.
     * @param string $name The name of the variable.
     * @param null $default The default value of the variable.
     * @return mixed|null The value of the variable or default vaoue.
     */
    public function getVar(string $name, $default = null)
    {
        return (isset($this->viewVars[$name])) ? $this->viewVars[$name] : $default;
    }

    /**
     * Method to include the file of the View.
     */
    private function includeView()
    {
        $viewFile = VIEWDIR.$this->controller.DIRECTORY_SEPARATOR.$this->method.'View.php';

        //check whether the file of the view exists.
        if (file_exists($viewFile)) {
            require_once($viewFile);
        }
    }

    /**
     * Method to load the view.
     */
    public function load()
    {
        //get the paths to the header and footer files.
        $headerFile = RESPATH.'template'.DIRECTORY_SEPARATOR.'header.php';
        $footerFile = RESPATH.'template'.DIRECTORY_SEPARATOR.'footer.php';

        //check whether the header file exists.
        if (file_exists($headerFile)) {
            require_once(RESPATH.'template'.DIRECTORY_SEPARATOR.'header.php');
        }

        $this->includeView();

        //check whether the footer file exists.
        if (file_exists($footerFile)) {
            require_once(RESPATH.'template'.DIRECTORY_SEPARATOR.'footer.php');
        }
    }

    /**
     * Method to set the value of a variable in the view.
     * @param string $name The name of the variable.
     * @param string $value The value of the variable.
     */
    public function setVar(string $name, string $value)
    {
        $this->viewVars[$name] = $value;
    }
}