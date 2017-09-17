<?php
//include the configuration.
require_once('config.php');

//include the autoloader.
require_once(SRCPATH.'Autoloader.php');

//initialize the autoloader.
$autoloader = new \PicVid\Autoloader();
$autoloader->addNamespace('PicVid', 'src');

//initialize the CitoEngine (template engine).
$cito = \PicVid\Core\CitoEngine::getInstance();
$cito->init();

//initialize the application.
$picvid = new \PicVid\Core\PicVid();

//render the output.
$cito->render();