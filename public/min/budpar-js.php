<?php 

set_include_path(realpath(dirname(__FILE__)) . '/lib' . PATH_SEPARATOR . get_include_path());
require 'Minify.php';
require 'Minify/Cache/File.php';
Minify::setCache(new Minify_Cache_File()); 

$jsFolder = '../scripts/javascripts/';

$srcJsRating = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/rating/jquery.ui.stars.min.js',
    'minifier' => '',
));

$srcJsFancyBox = new Minify_Source(array(
    'filepath' => $jsFolder . '/jquery/fancybox/jquery.fancybox-1.3.1.pack.js',
    'minifier' => '',
));

$srcJsCarousel = new Minify_Source(array(
    'filepath' => $jsFolder . 'jquery/jcarousel/jquery.jcarousel.pack.js',
    'minifier' => '',
));

$srcJsValidate = new Minify_Source(array(
    'filepath' => $jsFolder . 'jquery/jquery.validate.min.js',
    'minifier' => '',
));

$srcJsCarousell = new Minify_Source(array(
    'filepath' => $jsFolder . 'jquery/jquery.carouFredSel-3.1.0-packed.js',
    'minifier' => '',
));

$srcJsTranslate = new Minify_Source(array(
    'filepath' => $jsFolder . 'jquery/jquery.translate.min.js',
    'minifier' => '',
));

$srcJsBlockUI = new Minify_Source(array(
    'filepath' => $jsFolder . 'jquery/jquery.blockUI.min.js',
    'minifier' => '',
));

$srcJsShadow = new Minify_Source(array(
    'filepath' => $jsFolder . 'jquery/jquery.shadow.min.js',
    'minifier' => '',
)); 

$srcjQuery = new Minify_Source(array(
    'filepath' => $jsFolder . 'jquery/jquery-1.6.2.min.js',
    'minifier' => '',
));

$srcjQueryUi = new Minify_Source(array(
    'filepath' => $jsFolder . 'jquery/jquery-ui-1.8.14.custom.min.js',
    //'filepath' => $jsFolder . 'jquery/jquery-ui.min.js',
    'minifier' => '',
));

$srcFullCalendar = new Minify_Source(array(
	'filepath' => $jsFolder . 'jquery/fullcalendar/fullcalendar-1.5.1.min.js'
));

        $srcQtip = new Minify_Source(array(
	'filepath' => $jsFolder . 'jquery/jquery.qtip-1.0.0-rc3.min.js'
));

$srcScrollPane = new Minify_Source(array(
	'filepath' => $jsFolder . 'jquery/jquery.jscrollpane.min.js'
)); 

$srcMousewheel = new Minify_Source(array(
	'filepath' => $jsFolder . 'jquery/jquery.mousewheel.min.js'
));

$srcMousewheel = new Minify_Source(array(
	'filepath' => $jsFolder . 'jquery/jquery.nivo.slider.pack.js'
));

$srcAutocomplete = new Minify_Source(array(
	'filepath' => $jsFolder . 'jquery.autocomplete.js'
));

$sources[] = $srcjQuery;
$sources[] = $srcjQueryUi;
$sources[] = $srcJsBlockUI;
$sources[] = $srcJsRating;
$sources[] = $srcJsFancyBox;
$sources[] = $srcJsCarousel;
$sources[] = $srcJsValidate;
$sources[] = $srcJsCarousell;
$sources[] = $srcJsTranslate;
$sources[] = $srcJsShadow;
$sources[] = $srcAutocomplete;
$sources[] = $jsFolder . 'async-load.js';

//jQuery full calendar
$sources[] = $srcFullCalendar;
$sources[] = $srcQtip;

//jQuery scroll pane
$sources[] = $srcMousewheel;
$sources[] = $srcScrollPane;

$options = array(
    'files' => $sources,
    'maxAge' => 86400,
);

Minify::serve('Files', $options);