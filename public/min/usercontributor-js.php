<?php 

set_include_path(realpath(dirname(__FILE__)) . '/lib' . PATH_SEPARATOR . get_include_path());
require 'Minify.php';
require 'Minify/Cache/File.php';
Minify::setCache(new Minify_Cache_File()); 

$jsFolder = '../scripts/javascripts/';

$srcjQuery = new Minify_Source(array(
    'filepath' => $jsFolder . 'jquery/jquery-1.6.2.min.js',
    'minifier' => '',
));

$srcjQueryUi = new Minify_Source(array(
    'filepath' => $jsFolder . 'jquery/jquery-ui.min.js',
    'minifier' => '',
));

$srcJsRating = new Minify_Source(array(
    'filepath' => $jsFolder . 'jquery/rate/jquery.raty.min.js',
    'minifier' => '',
));

$srcJsFancyBox = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/fancybox/jquery.fancybox-1.3.1.pack.js',
    'minifier' => '',
));

$srcjQueryAnchor = new Minify_Source(array(
    'filepath' => $jsFolder . 'jquery/jquery.anchor.js',
    'minifier' => '',
));

$srcJsValidate = new Minify_Source(array(
    'filepath' => $jsFolder . 'jquery/jquery.validate.min.js',
    'minifier' => '',
));

$sources[] = $srcjQuery;
$sources[] = $srcjQueryUi;
$sources[] = $srcJsRating;
$sources[] = $srcJsFancyBox;
$sources[] = $srcjQueryAnchor;
$sources[] = $srcJsValidate;
$sources[] = $jsFolder . 'usercontributor/global.js';
$sources[] = $jsFolder . 'usercontributor/general.js';
//$sources[] = $jsFolder . 'login.js';

$options = array(
    'files' => $sources,
    'maxAge' => 86400,
);

Minify::serve('Files', $options);