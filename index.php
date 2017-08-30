<?php
//include the configuration.
require_once('config.php');

//include the autoloader.
require_once(SRCPATH.'Autoloader.php');

//initialize the autoloader.
$autoloader = new \PicVid\Autoloader();
$autoloader->addNamespace('PicVid', 'src');