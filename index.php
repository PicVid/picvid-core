<?php
//include the autoloader.
require_once('./src/Autoloader.php');

//initialize the autoloader.
$autoloader = new \PicVid\Autoloader();
$autoloader->addNamespace('PicVid', 'src');

//include the configuration (if exists).
$config = \PicVid\Core\Configuration::getInstance();

//check if the configuration is available (outside install).
if ($config->exists()) {
    $config->load();
} elseif (strpos($_SERVER['REQUEST_URI'], 'install') === false) {
    header('Location: install');
    exit;
}

//initialize the CitoEngine (template engine).
$cito = \PicVid\Core\CitoEngine::getInstance();
$cito->init();

//initialize the application.
$picvid = new \PicVid\Core\PicVid();

//render the output.
$cito->render();