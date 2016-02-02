<?php 

set_include_path(realpath(dirname(__FILE__)) . '/lib' . PATH_SEPARATOR . get_include_path());
require 'Minify.php';

$cssFolder = '../scripts/styles/';

$sources[] = $cssFolder . 'jqueryui/smoothness/jquery-ui-1.8.1.custom.css';
$sources[] = '../scripts/javascripts/jquery/fancybox/jquery.fancybox-1.3.1.css';
$sources[] = $cssFolder . 'usercontributor-general.css';
$sources[] = $cssFolder . 'login.css';

$options = array(
    'files' => $sources,
    //'maxAge' => 86400,
);

Minify::serve('Files', $options);