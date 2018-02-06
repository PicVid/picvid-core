<?php
/**
 * Namespace for all core classes of PicVid.
 */
namespace PicVid\Core;

/**
 * Class PicVid
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Core
 */
class PicVid
{
    /**
     * The controller to be used.
     * @var string
     */
    protected $controller = 'Index';

    /**
     * The method of the controller to be used.
     * @var string
     */
    protected $method = 'index';

    /**
     * The parameters to be used in the method of the controller.
     * @var array
     */
    protected $params = [];

    /**
     * PicVid constructor.
     */
    public function __construct()
    {
        //get the configuration.
        $config = Configuration::getInstance();

        //parse URL to get the controller, method and parameters.
        $url = $this->parseUrl();

        //check if the controller is present.
        if (isset($url[0]) && file_exists($config->getPathSource().'Controller/'.$this->normalize($url[0], false).'Controller.php')) {
            $this->controller = $this->normalize($url[0], false);
            unset($url[0]);
        }

        //determine the full name of the controller and initialize the controller.
        $controller = 'PicVid\\Controller\\'.$this->controller.'Controller';
        $this->controller = new $controller;

        //check whether the method exists in the controller.
        if (isset($url[1]) && method_exists($this->controller, $this->normalize($url[1], true))) {
            $this->method = $this->normalize($url[1], true);
            unset($url[1]);
        }

        //read parameters from the URL and call method of controller.
        $this->params = (count($url) > 0) ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Method to normalize a valoe to use as a controller or method name.
     * @param string $value The value to be normalized.
     * @param bool $isMethod The status whether it is a method.
     * @return string The normalized value.
     */
    private function normalize(string $value, bool $isMethod)
    {
        $normalized = implode(array_map('ucfirst', explode('_', strtolower($value))));
        $normalized = implode(array_map('ucfirst', explode('-', strtolower($normalized))));
        return ($isMethod) ? lcfirst($normalized) : $normalized;
    }

    /**
     * Method to read and determine the parts of the URL (for controller, method and parameters).
     * @return array The parts of the URL.
     */
    private function parseUrl()
    {
        $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
        return ($url !== null && $url !== false) ? explode('/', trim($url, '/')) : [];
    }
}