<?php 

set_include_path(realpath(dirname(__FILE__)) . '/lib' . PATH_SEPARATOR . get_include_path());
require 'Minify.php';
//require 'Minify/Cache/File.php';
//Minify::setCache(new Minify_Cache_File()); 

$cssFolder = '../scripts/styles/';

$sources[] = $cssFolder . 'reset.css';
$sources[] = $cssFolder . 'jqueryui/smoothness/jquery-ui-1.8.1.custom.css';
$sources[] = '../scripts/javascripts/jquery/fancybox/jquery.fancybox-1.3.1.css';
$sources[] = $cssFolder . 'jquery.tweet.css';
$sources[] = $cssFolder . 'general.css';
$sources[] = $cssFolder . 'sprite.css';
$sources[] = $cssFolder . 'destination.css';
$sources[] = $cssFolder . 'form.css';
$sources[] = $cssFolder . 'login.css';
$sources[] = $cssFolder . 'map.css';
$sources[] = $cssFolder . 'gallery.css';
$sources[] = $cssFolder . 'activity.css';
$sources[] = $cssFolder . 'fullcalendar-1.5.1.css';
$sources[] = $cssFolder . 'rating/rating.css';
$sources[] = $cssFolder . 'cloud-zoom.css';
$sources[] = $cssFolder . 'photoessay.css';
$sources[] = $cssFolder . 'mini-calendar.css';
$sources[] = $cssFolder . 'jquery.jscrollpane.css';
$sources[] = $cssFolder . 'discover-indonesia.css';
$sources[] = $cssFolder . 'destination-new.css';
$sources[] = $cssFolder . 'jquery.autocomplete.css';

$options = array(
    'files' => $sources,
    //'maxAge' => 86400,
);

Minify::serve('Files', $options);