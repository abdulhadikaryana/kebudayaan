<?php 

set_include_path(realpath(dirname(__FILE__)) . '/lib' . PATH_SEPARATOR . get_include_path());
require 'Minify.php';
//require 'Minify/Cache/File.php';
//Minify::setCache(new Minify_Cache_File()); 

$cssFolder = '../scripts/styles/mice/';

$sources[] = $cssFolder . 'style.css';
$sources[] = $cssFolder . 'detail.css';
$sources[] = $cssFolder . 'search.css';
$sources[] = $cssFolder . 'jquery.customselect.css';
$sources[] = $cssFolder . 'nivo-slider.css';
$sources[] = $cssFolder . 'nivo-slider-customize.css';
$sources[] = $cssFolder . 'jquery.stylish-select.css';

$options = array(
    'files' => $sources,
    //'maxAge' => 86400,
);

Minify::serve('Files', $options);