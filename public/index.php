<?php

// Define application environment (development, testing, production)
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', 'production');

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Abbreviate default directory separator constant
define('DS', DIRECTORY_SEPARATOR);

// Define path to public directory
define('PUBLIC_PATH', realpath(dirname(__FILE__)));

define('IMAGE_FOLDER', PUBLIC_PATH . DS . "media" . DS . "images" . DS);
define('UPLOAD_FOLDER', IMAGE_FOLDER . "upload" . DS);

define('NAMA_UPLOAD_FOLDER', UPLOAD_FOLDER);

defined('DISPLAY_ERROR')
    || define('DISPLAY_ERROR',true);
    
defined('USE_ALIAS')
    || define('USE_ALIAS','no');
    //|| define('USE_ALIAS','yes');
    
date_default_timezone_set('Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");

// START
define('ROOT_URL', 'http://'.$_SERVER['HTTP_HOST']);


define('ROOT_DOCUMENT', $_SERVER['DOCUMENT_ROOT'].'/');
define('SMTP_USERNAME', '');
define('SMTP_PASSWORD', '');
define('SMTP_HOST', '');
define('FACEBOOK_PAGE_URL', 'http://www.facebook.com/pages/Kebudayaan-Indonesia/127999584019830');

define("PARTNER_LOGO_URL", ROOT_URL);

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(    
    realpath(APPLICATION_PATH . '/../library'),        
    get_include_path(),
)));

//echo get_include_path();
include_once('Fb/facebook.php');

Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;

/** Zend_Application */
require_once 'Zend/Application.php';  

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV, 
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();
