<?php 

set_include_path(realpath(dirname(__FILE__)) . '/lib' . PATH_SEPARATOR . get_include_path());
require 'Minify.php';
require 'Minify/Cache/File.php';
Minify::setCache(new Minify_Cache_File()); 

$jsFolder = '../scripts/javascripts/';

$datepicker = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/datepicker.js',
    'minifier' => '',
));

$ajaxmanager = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/jquery.ajaxmanager.js',
    'minifier' => '',
));

$ajaxQueue = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/jquery.ajaxQueue.js',
    'minifier' => '',
));

$autoComplete = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/jquery.autocomplete.min.js',
    'minifier' => '',
));

$curvycorners = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/jquery.curvycorners.min.js',
    'minifier' => '',
));

$epiclock = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/jquery.epiclock.min.js',
    'minifier' => '',
));

$form = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/jquery.form.js',
    'minifier' => '',
));

$lightbox = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/jquery.lightbox-0.5.js',
    'minifier' => '',
));

$treeview = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/jquery.treeview.min.js',
    'minifier' => '',
));

$utils = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/jquery.utils.js',
    'minifier' => '',
));

$validate = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/jquery.validate.min.js',
    'minifier' => '',
));

$jqueryui = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/jquery-ui.custom.min.js',
    'minifier' => '',
));

$jqueryuiall = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/jquery.ui.all.js',
    'minifier' => '',
));

$thickbox = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/thickbox-compressed.js',
    'minifier' => '',
));

$strings = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/jquery.strings.js',
    'minifier' => '',
));

$timepickr = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/ui.timepickr.js',
    'minifier' => '',
));

$datepickerui = new Minify_Source(array(
    'filepath' => $jsFolder . '/jqueryui/ui/ui.datepicker.js',
    'minifier' => '',
));

//general global scripts
$sources[] = $curvycorners;
$sources[] = $epiclock;
//for autocomplete
$sources[] = $ajaxmanager;
$sources[] = $ajaxQueue;
$sources[] = $autoComplete;
//for datepicker
$sources[] = $datepickerui;
$sources[] = $datepicker;
//other
$sources[] = $form;
$sources[] = $lightbox;
$sources[] = $treeview;
$sources[] = $utils;
$sources[] = $validate;
$sources[] = $thickbox;

$options = array(
    'files' => $sources,
    'maxAge' => 86400,
);

Minify::serve('Files', $options);