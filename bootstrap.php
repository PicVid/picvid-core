<?php
//define the source directory of the project.
define('PROJECT_SRC', __DIR__);

//include the autoloader.
require_once(PROJECT_SRC.'/src/Autoloader.php');

//initialize the autoloader for the project source.
$autoloader = new \PicVid\Autoloader();
$autoloader->addNamespace('\PicVid', PROJECT_SRC.'/src');
$autoloader->addNamespace('\PicVid\Test', PROJECT_SRC.'/test');