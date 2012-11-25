<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$config = file_exists(APPLICATION_PATH . '/configs/local.xml') ? 'local.xml' : 'application.xml';
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/' . $config
);
$application->bootstrap()
            ->run();