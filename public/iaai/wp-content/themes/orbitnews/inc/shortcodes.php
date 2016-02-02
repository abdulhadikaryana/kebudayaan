<?php
/**
 * SHORTCODES
 */

// Allow shortcodes in widgets
add_filter('widget_text', 'do_shortcode');


// Insert line break
function orn_line($atts) {
    extract(shortcode_atts(array(), $atts));
    return '<div class="line"></div>';
}
add_shortcode('line', 'orn_line');

// Insert clear break
function orn_clear($atts) {
    extract(shortcode_atts(array(), $atts));
    return '<div class="clear"></div>';
}
add_shortcode('clear', 'orn_clear');

// Insert row
function orn_row($atts, $content = 'null') {
    extract(shortcode_atts(array(), $atts));
    return '<section class="row">' . do_shortcode($content) . '</section>';
}
add_shortcode('row', 'orn_row');

// Insert Ads468
function orn_ads($atts, $content = 'null') {
    extract(shortcode_atts(array(), $atts));
    return '<div class="ads-middle mb25">' . do_shortcode($content) . '</div>';
}
add_shortcode('ads', 'orn_ads');

// Insert Image
function orn_image($atts, $content = 'null') {
    extract(shortcode_atts(array(
		'link' => '',
        'src' => ''
	), $atts));
    return '<a href="'.$link.'" class="th"><img src="'.$src.'"></a>';
}
add_shortcode('image', 'orn_image');

// Dropcaps 1  Shortcodes
function orn_dropcaps($atts, $contents = null) {
    extract(shortcode_atts(array(
		'type' => '1',
        'title' => 'Your title',
        'larg_cap' => '1'
    ), $atts));
    return '<div class="dropcap'.$type.'">
                    <h6>' . $title . '</h6>
                    <span class="large-cap">' . $larg_cap . '</span>' . $contents . '
                </div>';
    
}
add_shortcode("dropcaps", "orn_dropcaps");

// Column Shortcodes
function orn_column($atts, $content = null) {
    extract(shortcode_atts(array(
        'width' => '1/2',
        'last' => 'no',
		'title' => ''
    ), $atts));
    
    switch ($width) {
        case "full":
            $w = "twelve column ";
            break;
        
        case "1/2":
            $w = "six column";
            break;
        
        case "1/3":
            $w = "four column";
            break;

        case "2/3":
            $w = "eight column";
            break;
        
        case "1/4":
            $w = "three column";
            break;
        
        case "1/6":
            $w = "two column";
            break;
        
        default:
            $w = 'column twelve';
    }
    $last !== 'no' ? $lasts = 'end' : $lasts = '';
	if (!empty($title)){$coltitle = '<h5>' . $title . '</h5>';} else { $coltitle='';}
    $column = '<div class="' . $w . ' ' . $lasts . '">' . $coltitle . 							  	do_shortcode($content) . '</div>';
    return $column;
}
add_shortcode('column', 'orn_column');

// Buton Shortcodes
function orn_button($atts, $content = null) {
    extract(shortcode_atts(array(
        "url" => '',
        "color" => 'color'
    ), $atts));
    $output = '<a class="button-' . $color . '" href="' . $url . '" ';
    $output .= '>';
    $output .= $content . '</a>';
    
    return $output;
}
add_shortcode('button', 'orn_button');

//List Shortcodes
function orn_list($atts, $content = null) {
    extract(shortcode_atts(array(
        "style" => ''
    ), $atts));
    
    $output     = '<ul class="' . $style . '-list">';
    $user_lists = do_shortcode(explode("|", $content));
    foreach ($user_lists as $new_list) {
        $output .= '<li class="bullet-item">' . $new_list . '</li>';
    }
    $output .= '</ul>';
    return $output;
}
add_shortcode('list', 'orn_list');

// Tab Shortcodes
function orn_tab_group($atts, $content) {
    $GLOBALS['tab_count'] = 0;
    do_shortcode($content);
    $count = 0;
	if (empty($tabs)) {$tabs="";}
	if (empty($panes)) {$panes="";}
    if (is_array($GLOBALS['tabs'])) {
        foreach ($GLOBALS['tabs'] as $tab) {
            $count++;
            $tabs[]  = '<dd class="' . ($tabs == 0 ? ' active' : '') . '"><a href="#simple' . $count . '">' . $tab['title'] . '</a></dd>';
            $panes[] = '<li id="simple' . $count . 'Tab" class="' . ($panes == 0 ? ' active' : '') . '">' . $tab['content'] . '</li>';
        }
        $return = "\n" . '<dl class="tabs">' . implode("\n", $tabs) . '</dl>' . "\n" . '<ul class="tabs-content">' . implode("\n", $panes) . '</ul>' . "\n";
    }
    return $return;
}
add_shortcode('tabgroup', 'orn_tab_group');

function orn_tab($atts, $content) {
    extract(shortcode_atts(array(
        'title' => 'Tab %d'
    ), $atts));
    
    $x                   = $GLOBALS['tab_count'];
    $GLOBALS['tabs'][$x] = array(
        'title' => sprintf($title, $GLOBALS['tab_count']),
        'content' => do_shortcode($content)
    );
    $GLOBALS['tab_count']++;
}
add_shortcode('tab', 'orn_tab');

// Accordion Shortcodes
function orn_accordiongroup($atts, $content = null) {
    extract(shortcode_atts(array(), $atts));
    return '<ul class="accordion">' . do_shortcode($content) . '</ul>';
}
add_shortcode('accordiongroup', 'orn_accordiongroup');

function orn_accordion($atts, $content) {
    extract(shortcode_atts(array(
        'title' => 'Tab'
    ), $atts));
    return '<li class=""><div class="title"><h5>' . $title . '</h5></div><div class="content">' . do_shortcode($content) . '</div></li>';
}
add_shortcode('accordion', 'orn_accordion');

// Box Shortcodes
function orn_box($atts, $content = null) {
    extract(shortcode_atts(array(
        "type" => ''
    ), $atts));
    return '<div class="alert-box ' . $type . '">' . do_shortcode($content) . '<a href="#" class="close">&times;</a></div>';
}
add_shortcode('box', 'orn_box');

// Pricing Table Shortcodes
function orn_pricing_table($atts, $content) {
    extract(shortcode_atts(array(
        "table_size" => 'four',
        "title" => '',
        "price" => '',
        "description" => '',
        "button_text" => 'Buy it Now',
        "button_link" => ''
    ), $atts));
    
    $output = '<div class="' . $table_size . ' column">';
    $output .= '<ul class="pricing-table">';
    $output .= '<li class="title">' . $title . '</li>';
    $output .= '<li class="price">' . $price . '</li>';
    $output .= '<li class="description">' . $description . '</li>';
    $user_text = do_shortcode(explode("|", $content));
    foreach ($user_text as $new_item) {
        $output .= '<li class="bullet-item">' . $new_item . '</li>';
    }
    $output .= '<li class="cta-button"><a class="button" href="' . $button_link . '">' . $button_text . '</a></li>';
    $output .= '</ul></div>';
    return $output;
}
add_shortcode('pricing_table', 'orn_pricing_table');

// Pricing Table Shortcodes
function orn_simple_table( $atts ) {
    extract( shortcode_atts( array(
        'cols' => 'none',
        'data' => 'none',
		'width' => 'twelve'
    ), $atts ) );
    $cols = explode(',',$cols);
    $data = explode(',',$data);
    $total = count($cols);
    $output = '<table class="'.$width.'"><thead><tr>';
    foreach($cols as $col):
        $output .= '<th>'.$col.'</th>';
    endforeach;
    $output .= '</tr></thead><tr>';
    $counter = 1;
    foreach($data as $datum):
        $output .= '<td>'.$datum.'</td>';
        if($counter%$total==0):
            $output .= '</tr>';
        endif;
        $counter++;
    endforeach;
        $output .= '</table>';
    return $output;
}
add_shortcode( 'table', 'orn_simple_table' );

// Add Tiny Mce Dropdown For Shortcodes
function register_customcode_dropdown($buttons) {
    array_push($buttons, "Shortcodes");
    return $buttons;
}

function add_customcode_dropdown($plugin_array) {
    $plugin_array['Shortcodes'] = get_template_directory_uri() . '/backend/js/TinyMCE_js.js';
    return $plugin_array;
}

function customcode_dropdown() {
    
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
        return;
    }
    
    if (get_user_option('rich_editing') == 'true') {
        add_filter('mce_external_plugins', 'add_customcode_dropdown');
        add_filter('mce_buttons', 'register_customcode_dropdown');
    }
    
}

add_action('init', 'customcode_dropdown');
