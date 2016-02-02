<?php 

set_include_path(realpath(dirname(__FILE__)) . '/lib' . PATH_SEPARATOR . get_include_path());
require 'Minify.php';
require 'Minify/Cache/File.php';
Minify::setCache(new Minify_Cache_File()); 

$jsFolder = '../scripts/javascripts/mice/';

$sources[] = $jsFolder . 'jquery-1.5.2.min.js';
$sources[] = $jsFolder . 'jquery.customselect.js';
$sources[] = $jsFolder . 'jquery.nivo.slider.pack.js';
$sources[] = $jsFolder . 'jquery.photoslider.js';
$sources[] = $jsFolder . 'jquery.stylish-select.js';
$sources[] = $jsFolder . 'common.js';

$options = array(
    'files' => $sources,
    'maxAge' => 86400,
);

Minify::serve('Files', $options);