<?php
//database configuration.
define('DB_HOST', 'hostname');
define('DB_PORT', 3306);
define('DB_NAME', 'database_name');
define('DB_USER', 'username');
define('DB_PASS', 'password');

//path and url configuration.
define('URL', 'http://example.com/');
define('ABSPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('RESPATH', ABSPATH.'resource'.DIRECTORY_SEPARATOR);
define('SRCPATH', ABSPATH.'src'.DIRECTORY_SEPARATOR);
define('VIEWDIR', SRCPATH.'View'.DIRECTORY_SEPARATOR);
define('DATADIR', ABSPATH.'data'.DIRECTORY_SEPARATOR);
define('DATAURL', URL.'data'.DIRECTORY_SEPARATOR);
define('UPLOADDIR', DATADIR.'upload'.DIRECTORY_SEPARATOR);
define('IMAGEDIR', DATADIR.'images'.DIRECTORY_SEPARATOR);
define('IMAGEURL', DATAURL.'images'.DIRECTORY_SEPARATOR);

//the project honeypot key.
define('PROJECT_HONEYPOT_KEY', '');