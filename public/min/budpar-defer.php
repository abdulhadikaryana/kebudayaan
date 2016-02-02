<?php 

set_include_path(realpath(dirname(__FILE__)) . '/lib' . PATH_SEPARATOR . get_include_path());
require 'Minify.php';
require 'Minify/Cache/File.php';
Minify::setCache(new Minify_Cache_File()); 

$jsFolder = '../scripts/javascripts/';

$sources[] = $jsFolder . 'jquery/jquery.ifixpng.js';
$sources[] = $jsFolder . 'carouselgallery.1.1.js';
$sources[] = $jsFolder . 'mini-calendar-1.11.js';
$sources[] = $jsFolder . 'general.1.2.js';
$sources[] = $jsFolder . 'index.js';
$sources[] = $jsFolder . 'registration.js';
$sources[] = $jsFolder . 'login.js';
$sources[] = $jsFolder . 'contactus.js';
$sources[] = $jsFolder . 'review.js';
$sources[] = $jsFolder . 'destination-1.0.js';
$sources[] = $jsFolder . 'tabSwitch-1.0.js';
$sources[] = $jsFolder . 'search-1.1.js';
$sources[] = $jsFolder . 'slidedestination.1.7.js';

$options = array(
    'files' => $sources,
    //'maxAge' => 86400,
);

Minify::serve('Files', $options);