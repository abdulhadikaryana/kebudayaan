<style type="text/css">
    body {
        <?php if(eff_option('body_bg_img')) {?>
        background: url(<?php echo eff_option('body_bg_img'); ?>) repeat;
        <?php } ?>
        <?php if(eff_option('body_bg_cu')) {?>
        background: url(<?php echo eff_option('body_bg_cu'); ?>) repeat;
        <?php } ?>
        <?php if(eff_option('body_bg')) {?>
        background: <?php echo eff_option('body_bg'); ?>;
        <?php } ?>
        
        <?php
        $body_typo = eff_option('main_font');
        ?>
        <?php if ($body_typo != 'false') { ?>
        <?php if ($body_typo['color']) { ?>
        color:<?php echo $body_typo['color']; ?>;
        <?php } ?>
        <?php if ($body_typo['size']) { ?>
        font-size:<?php echo $body_typo['size']; ?>;
        <?php } ?>
        <?php if ($body_typo['face']) { ?>
        font-family:<?php echo $body_typo['face']; ?>;
        <?php } ?>
        <?php if ($body_typo['style']) { ?>
        font-weight: <?php echo $body_typo['style']; ?>;
        <?php } ?>
        <?php } ?>
    }
    .section_box p {
        <?php
        $body_typo = eff_option('main_font');
        ?>
        <?php if ($body_typo != 'false') { ?>
        <?php if ($body_typo['color']) { ?>
        color:<?php echo $body_typo['color']; ?>;
        <?php } ?>
        <?php if ($body_typo['size']) { ?>
        font-size:<?php echo $body_typo['size']; ?>;
        <?php } ?>
        <?php if ($body_typo['face']) { ?>
        font-family:<?php echo $body_typo['face']; ?>;
        <?php } ?>
        <?php if ($body_typo['style']) { ?>
        font-weight: <?php echo $body_typo['style']; ?>;
        <?php } ?>
        <?php } ?>
    }
    a {
        color: <?php echo eff_option('link_color'); ?>;
    }
    .entry-content a{
        color: <?php echo eff_option('link_color'); ?>;
    }
    a:hover {
        color: <?php echo eff_option('link_color_hover'); ?>;
    }
    .logo {
        margin-top: <?php echo eff_option('logo_margin'); ?>px;
    }
    h1#site_title {
        <?php
        $body_typo = eff_option('site_name');
        ?>
        <?php if ($body_typo != 'false') { ?>
        <?php if ($body_typo['color']) { ?>
        color:<?php echo $body_typo['color']; ?>;
        <?php } ?>
        <?php if ($body_typo['size']) { ?>
        font-size:<?php echo $body_typo['size']; ?>;
        <?php } ?>
        <?php if ($body_typo['face']) { ?>
        font-family:<?php echo $body_typo['face']; ?>;
        <?php } ?>
        <?php if ($body_typo['style']) { ?>
        font-weight: <?php echo $body_typo['style']; ?>;
        <?php } ?>
        <?php } ?>
    }
    h2#site_desc {
        <?php
        $body_typo = eff_option('site_desc');
        ?>
        <?php if ($body_typo != 'false') { ?>
        <?php if ($body_typo['color']) { ?>
        color:<?php echo $body_typo['color']; ?>;
        <?php } ?>
        <?php if ($body_typo['size']) { ?>
        font-size:<?php echo $body_typo['size']; ?>;
        <?php } ?>
        <?php if ($body_typo['face']) { ?>
        font-family:<?php echo $body_typo['face']; ?>;
        <?php } ?>
        <?php if ($body_typo['style']) { ?>
        font-weight: <?php echo $body_typo['style']; ?>;
        <?php } ?>
        <?php } ?>
    }
     .entry-content h1{
        <?php
        $h1_typo = eff_option('h1_font');
        ?>
        <?php if ($h1_typo != 'false') { ?>
        <?php if ($h1_typo['color']) { ?>
        color:<?php echo $h1_typo['color']; ?>;
        <?php } ?>
        <?php if ($h1_typo['size']) { ?>
        font-size:<?php echo $h1_typo['size']; ?>;
        <?php } ?>
        <?php if ($h1_typo['face']) { ?>
        font-family:<?php echo $h1_typo['face']; ?>;
        <?php } ?>
        <?php if ($h1_typo['style']) { ?>
        font-weight: <?php echo $h1_typo['style']; ?>;
        <?php } ?>
        <?php } ?>
    }
    .entry-content h2{
        <?php
        $h2_typo = eff_option('h2_font');
        ?>
        <?php if ($h2_typo != 'false') { ?>
        <?php if ($h2_typo['color']) { ?>
        color:<?php echo $h2_typo['color']; ?>;
        <?php } ?>
        <?php if ($h2_typo['size']) { ?>
        font-size:<?php echo $h2_typo['size']; ?>;
        <?php } ?>
        <?php if ($h2_typo['face']) { ?>
        font-family:<?php echo $h2_typo['face']; ?>;
        <?php } ?>
        <?php if ($h2_typo['style']) { ?>
        font-weight: <?php echo $h2_typo['style']; ?>;
        <?php } ?>
        <?php } ?>
    }
    .entry-content h3{
        <?php
        $h3_typo = eff_option('h3_font');
        ?>
        <?php if ($h3_typo != 'false') { ?>
        <?php if ($h3_typo['color']) { ?>
        color:<?php echo $h3_typo['color']; ?>;
        <?php } ?>
        <?php if ($h3_typo['size']) { ?>
        font-size:<?php echo $h3_typo['size']; ?>;
        <?php } ?>
        <?php if ($h3_typo['face']) { ?>
        font-family:<?php echo $h3_typo['face']; ?>;
        <?php } ?>
        <?php if ($h3_typo['style']) { ?>
        font-weight: <?php echo $h3_typo['style']; ?>;
        <?php } ?>
        <?php } ?>
    }
    .entry-content h4{
        <?php
        $h4_typo = eff_option('h4_font');
        ?>
        <?php if ($h4_typo != 'false') { ?>
        <?php if ($h4_typo['color']) { ?>
        color:<?php echo $h4_typo['color']; ?>;
        <?php } ?>
        <?php if ($h4_typo['size']) { ?>
        font-size:<?php echo $h4_typo['size']; ?>;
        <?php } ?>
        <?php if ($h4_typo['face']) { ?>
        font-family:<?php echo $h4_typo['face']; ?>;
        <?php } ?>
        <?php if ($h4_typo['style']) { ?>
        font-weight: <?php echo $h4_typo['style']; ?>;
        <?php } ?>
        <?php } ?>
    }
    .entry-content h5{
        <?php
        $h5_typo = eff_option('h5_font');
        ?>
        <?php if ($h5_typo != 'false') { ?>
        <?php if ($h5_typo['color']) { ?>
        color:<?php echo $h5_typo['color']; ?>;
        <?php } ?>
        <?php if ($h5_typo['size']) { ?>
        font-size:<?php echo $h5_typo['size']; ?>;
        <?php } ?>
        <?php if ($h5_typo['face']) { ?>
        font-family:<?php echo $h5_typo['face']; ?>;
        <?php } ?>
        <?php if ($h5_typo['style']) { ?>
        font-weight: <?php echo $h5_typo['style']; ?>;
        <?php } ?>
        <?php } ?>
    }
    .entry-content h6{
        <?php
        $h6_typo = eff_option('h6_font');
        ?>
        <?php if ($h6_typo != 'false') { ?>
        <?php if ($h6_typo['color']) { ?>
        color:<?php echo $h6_typo['color']; ?>;
        <?php } ?>
        <?php if ($h6_typo['size']) { ?>
        font-size:<?php echo $h6_typo['size']; ?>;
        <?php } ?>
        <?php if ($h6_typo['face']) { ?>
        font-family:<?php echo $h6_typo['face']; ?>;
        <?php } ?>
        <?php if ($h6_typo['style']) { ?>
        font-weight: <?php echo $h6_typo['style']; ?>;
        <?php } ?>
        <?php } ?>
    }
    .news_box1 .first_news h2 a,
    .news_box1 ul li h2 a,
    .news_box2 .first_news h2 a,
    .news_box2 ul li h2 a,
    .news_box3 .first_news h2 a,
    .news_box3 ul li h2 a,
    .news_box4 ul li h2 a,
    .news_box5 h2 a,
    .tabs_content ul li h2 a,
    .crousel_style2 h2 a,
    .crousel_style1 h2 a {
        <?php
        $hpt_typo = eff_option('hpt_font');
        ?>
        <?php if ($hpt_typo != 'false') { ?>
        <?php if ($hpt_typo['color']) { ?>
        color:<?php echo $hpt_typo['color']; ?>;
        <?php } ?>
        <?php if ($hpt_typo['size']) { ?>
        font-size:<?php echo $hpt_typo['size']; ?>;
        <?php } ?>
        <?php if ($hpt_typo['face']) { ?>
        font-family:<?php echo $hpt_typo['face']; ?>;
        <?php } ?>
        <?php if ($hpt_typo['style']) { ?>
        font-weight: <?php echo $hpt_typo['style']; ?>;
        <?php } ?>
        <?php } ?>
    }
    .sidebar .widget_title h2,
    .block_title h2 {
        <?php
        $nbh_typo = eff_option('nbh_font');
        ?>
        <?php if ($nbh_typo != 'false') { ?>
        <?php if ($nbh_typo['color']) { ?>
        color:<?php echo $nbh_typo['color']; ?>;
        <?php } ?>
        <?php if ($nbh_typo['size']) { ?>
        font-size:<?php echo $nbh_typo['size']; ?>;
        <?php } ?>
        <?php if ($nbh_typo['face']) { ?>
        font-family:<?php echo $nbh_typo['face']; ?>;
        <?php } ?>
        <?php if ($nbh_typo['style']) { ?>
        font-weight: <?php echo $nbh_typo['style']; ?>;
        <?php } ?>
        <?php } ?>
    }
    .t_menu ul li a{
        <?php
        $tmenu_typo = eff_option('tmenu_font');
        ?>
        <?php if ($tmenu_typo != 'false') { ?>
        <?php if ($tmenu_typo['color']) { ?>
        color:<?php echo $tmenu_typo['color']; ?>;
        <?php } ?>
        <?php if ($tmenu_typo['size']) { ?>
        font-size:<?php echo $tmenu_typo['size']; ?>;
        <?php } ?>
        <?php if ($tmenu_typo['face']) { ?>
        font-family:<?php echo $tmenu_typo['face']; ?>;
        <?php } ?>
        <?php if ($tmenu_typo['style']) { ?>
        font-weight: <?php echo $tmenu_typo['style']; ?>;
        <?php } ?>
        <?php } ?>
    }
    ul.main_menu li{
        <?php
        $mmenu_typo = eff_option('mmenu_font');
        ?>
        <?php if ($mmenu_typo != 'false') { ?>
        <?php if ($mmenu_typo['color']) { ?>
        color:<?php echo $mmenu_typo['color']; ?>;
        <?php } ?>
        <?php if ($mmenu_typo['size']) { ?>
        font-size:<?php echo $mmenu_typo['size']; ?>;
        <?php } ?>
        <?php if ($mmenu_typo['face']) { ?>
        font-family:<?php echo $mmenu_typo['face']; ?>;
        <?php } ?>
        <?php if ($mmenu_typo['style']) { ?>
        font-weight: <?php echo $mmenu_typo['style']; ?>;
        <?php } ?>
        <?php } ?>
    }   
    .top_bar{
        background: <?php echo eff_option('topbar_bg'); ?>;
    }
    .today_date {
        background: <?php echo eff_option('date_bg'); ?>;
    }
    .t_menu ul li a {
        color: <?php echo eff_option('top_menu_color'); ?>;
    }
    .t_menu ul li a:hover {
        color: <?php echo eff_option('top_menu_hover'); ?>;
    }
    .t_menu ul li ul {
        background: <?php echo eff_option('top_drop_bg'); ?>;
    }
    .t_menu ul li ul li:hover {
        background: <?php echo eff_option('top_drop_hover'); ?>;
    }
    .t_menu ul li ul li a {
        color: <?php echo eff_option('top_drop_color'); ?>;
    }
    .t_menu ul li ul li a:hover {
        color: <?php echo eff_option('top_drophover_color'); ?>;
    }
    .header_content {
        <?php if(eff_option('header_bg_img')) {?>
        background: url(<?php echo eff_option('header_bg_img'); ?>) repeat;
        <?php } ?>
        <?php if(eff_option('header_bg_cu')) {?>
        background: url(<?php echo eff_option('header_bg_cu'); ?>) repeat;
        <?php } ?>
        <?php if(eff_option('header_bg')) {?>
        background: <?php echo eff_option('header_bg'); ?>;
        <?php } ?> 
    }
    nav.navigation {
        background: <?php echo eff_option('nav_bg'); ?>;
        border-color: <?php echo eff_option('nav_border'); ?>;
    }
    ul.main_menu li {
        border-right-color: <?php echo eff_option('nav_border'); ?>;
    }
    ul.main_menu li:first-child {
        border-left-color: <?php echo eff_option('nav_border'); ?>;
    }
    ul.main_menu li.current-menu-item, ul.main_menu li:hover, ul.main_menu li.current-menu-ancestor {
        background-color: <?php echo eff_option('menu_hover_bg'); ?>;
        border-bottom-color: <?php echo eff_option('menu_hover_bottom'); ?>;
    }
    .menu-item-object-category .sub-mega-wrap {
        background: <?php echo eff_option('menu_hover_bg'); ?>;
    }
    ul.main_menu li a {
        color: <?php echo eff_option('menu_color'); ?>;
    }
    ul.main_menu li a:hover {
        color: <?php echo eff_option('menu_color_hover'); ?>;
    }
    ul.main_menu li ul li a {
        color: <?php echo eff_option('drop_menu_color'); ?>;
    }
    ul.main_menu li ul li a:hover {
        color: <?php echo eff_option('drop_menu_color_hover'); ?>;
    }
    .main_bar {
    background: <?php echo eff_option('mainbar_bg'); ?>;
    border-color: <?php echo eff_option('mainbar_border'); ?>;
    box-shadow: 0 3px <?php echo eff_option('mainbar_bborder'); ?>;
    -moz-box-shadow: 0 3px <?php echo eff_option('mainbar_bborder'); ?>;
    -webkit-box-shadow: 0 3px <?php echo eff_option('mainbar_bborder'); ?>;
    }
    .breaking_news span.ticker_title {
    background: <?php echo eff_option('breaking_bg'); ?>;
    border-color: <?php echo eff_option('breaking_bg_border'); ?>;
    color: <?php echo eff_option('breaking_color'); ?>;
    }
    .ticker_bg span.wrap_arrow {
    background-color: <?php echo eff_option('breaking_bg'); ?>;
    }
    .ticker_bg {
        background: <?php echo eff_option('breaking_wrap_bg'); ?>;
    }
    .breaking_news ul#ticker li a, .breaking_news ul#ticker li {
        color: <?php echo eff_option('breaking_items'); ?>;
    }
    .breaking_news ul#ticker li a:hover {
        color: <?php echo eff_option('breaking_items_hover'); ?>;
    }
    .bblock_title h2,
    .block_title h2 {
        <?php if(eff_option('section_span')) { ?>
        background: <?php echo eff_option('section_span'); ?> !important;
        <?php } ?>
    }
    .news_box5 .read_more:hover,
    .block_title h2:after {
        <?php if(eff_option('section_span')) { ?>
        background: <?php echo eff_option('section_span'); ?> !important;
        border-color: <?php echo eff_option('section_span'); ?> !important;
        <?php } ?>
    }
    footer {
        border-top-color: <?php echo eff_option('footer_border'); ?>;
        background: <?php echo eff_option('footer_bg'); ?>;
        color: <?php echo eff_option('footer_color'); ?>;
    }
    .copyright {
        background: <?php echo eff_option('copyright_bg'); ?>;
        color: <?php echo eff_option('copyright_color'); ?>;
    }
    .ondemand {
        background: <?php echo eff_option('nof_bg'); ?>;
        border-bottom-color: <?php echo eff_option('nof_border'); ?>;
        <?php
        $nof_typo = eff_option('nof_font');
        ?>
        <?php if ($nof_typo != 'false') { ?>
        <?php if ($nof_typo['color']) { ?>
        color:<?php echo $nof_typo['color']; ?>;
        <?php } ?>
        <?php if ($nof_typo['size']) { ?>
        font-size:<?php echo $nof_typo['size']; ?>;
        <?php } ?>
        <?php if ($nof_typo['face']) { ?>
        font-family:<?php echo $nof_typo['face']; ?>;
        <?php } ?>
        <?php if ($nof_typo['style']) { ?>
        font-weight: <?php echo $nof_typo['style']; ?>;
        <?php } ?>
        <?php } ?>
    }
    <?php if(eff_option('navshadow') == false) { ?>
    nav.navigation .inner:after {
        background: transparent;
    }
    <?php } ?>
    <?php if (eff_option('review_bg')!= false) { ?>
    .eff_review_wrap {
        background: <?php echo eff_option('review_bg'); ?>;
    }
    .eff_rt_cr_percent {
        background: none;
    }
    <?php } ?>
    <?php if (eff_option('review_bd')!= false) { ?>
    .eff_review_wrap {
        border-color: <?php echo eff_option('review_bd'); ?>;
    }
    <?php } ?>
    <?php if (eff_option('review_hf_bg')!= false) { ?>
    h3.eff_rt_head, .rt_footer, .eff_rt_cr_stars:hover, .eff_rt_cr_stars:hover .rt_stars_rate, .eff_rt_cr_percent:hover .rt_cr_per {
        background-color: <?php echo eff_option('review_hf_bg'); ?>;
    }
    <?php } ?>
    <?php if (eff_option('review_hf_tx')!= false) { ?>
    h3.eff_rt_head, .rt_footer, .eff_rt_cr_stars:hover .rt_cr_desc, .eff_rt_cr_percent:hover .rt_cr_per .rt_cr_desc {
        color: <?php echo eff_option('review_hf_tx'); ?>;
    }
    <?php } ?>
    
    <?php if (eff_option('review_cr_bg')!= false) { ?>
    .rt_cr_per, .eff_rt_cr_stars, .rt_stars_rate, .rt_score .score_title, .rt_score .rt_stars_rate {
        background-color: <?php echo eff_option('review_cr_bg'); ?>;
    }
    <?php } ?>
    <?php if (eff_option('review_cr_tx')!= false) { ?>
    .rt_cr_per, .eff_rt_cr_stars, .rt_cr_desc {
        color: <?php echo eff_option('review_cr_tx'); ?>;
    }
    <?php } ?>
    <?php if (eff_option('review_ss_bg')!= false) { ?>
    .summary_content, .rt_score {
        background-color: <?php echo eff_option('review_ss_bg'); ?>;
    }
    <?php } ?>
    <?php if (eff_option('review_ss_tx')!= false) { ?>
    .summary_content, .rt_score {
        color: <?php echo eff_option('review_ss_tx'); ?>;
    }
    <?php } ?>
    .to_top {
        background: url(<?php echo eff_option('totop_img'); ?>) no-repeat;
    }
    <?php echo eff_option('custom_css'); ?>
    @media only screen and (min-width: 768px) and (max-width: 959px) {
        <?php echo eff_option('custom_768_css'); ?>
    }
    @media only screen and (min-width: 480px) and (max-width: 767px) {
        <?php echo eff_option('custom_480_css'); ?>
    }
    @media only screen and (min-width: 320px) and (max-width: 479px) {
        <?php echo eff_option('custom_320_css'); ?>
    }
    <?php if(eff_option('header_style') == 'style2') { ?>
    .main_bar{border-top: none;position: relative;box-shadow:0 0;}
    nav.navigation .inner:after{background: none;}
    .main_bar:after {
        content: "";
        background: url(images/b-shadow.png) no-repeat;
        position: absolute;
        width: 100%;
        height: 19px;
        top: 43px;
        left: 0;
        }
    .main_content{margin-top: 30px;}
    <?php } ?>
    <?php global $post ;
    if( is_category() || is_single() ): 
    if( is_category() ) $cat_id = get_query_var('cat') ;
    if( is_single() ){ 
        $categories = get_the_category( $post->ID );
        $cat_id = $categories[0]->term_id ;
    }
    $cat_data = get_option("category_$cat_id");
    $cat_bg = $cat_data[bg];
    $cat_color = $cat_data[color];
    ?>
    .background {
        background-image: url('<?php echo $cat_bg; ?>');
        filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $cat_bg; ?>',sizingMethod='scale');<?php echo "\n"; ?>
	-ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $cat_bg; ?>',sizingMethod='scale')";<?php echo "\n"; ?>
    }
    <?php endif;
    if( eff_option('cat_'.$cat_id.'_color') ):
    ?>
    ul.main_menu li.current-menu-item, ul.main_menu li.current-menu-ancestor {
        border-bottom: 3px solid <?php echo $cat_color; ?>;
    }
    .ticker_bg span.wrap_arrow,
    .breaking_news span.ticker_title,
    .submit-container,
    .sidebar .tagcloud a:hover{
        background: <?php echo $cat_color; ?>;
        border-color: <?php echo $cat_color; ?>;
    }
    .tabs_widget_head li.ui-state-active, .tabs_widget_head li:hover {
        border-bottom-color: <?php echo $cat_color; ?> !important;
    }
    .newsletter .nsb,
    .pagination span.current,
    #calendar_wrap #wp-calendar #today, #calendar_wrap #wp-calendar #today{
        background: <?php echo $cat_color; ?>;
    }
    a.read_more:hover{
        color: <?php echo $cat_color; ?>;
    }
    <?php endif; ?>
    <?php
    if( is_home() && eff_option('hp_display') == 'nb' && eff_option('home_cats') == true) {
        $of_categories 		= array();  
        $of_categories_obj 	= get_categories('hide_empty=0');
        foreach ($of_categories_obj as $of_cat) {
            $of_categories = $of_cat->cat_ID;

        $cat_data2 = get_option("category_$of_categories");
        $cat_color = $cat_data2[color];
    
        if( get_option("category_$of_categories") ){ ?>
        .block.cat_<?php echo $of_categories ; ?> .block_title h2,
        .block.cat_<?php echo $of_categories ; ?> .block_title h2:after{
            background: <?php echo $cat_color ; ?> !important;
        }
        .block.cat_<?php echo $of_categories ; ?> a.read_more{
            color: <?php echo $cat_color ; ?>;
        }
        .block.cat_<?php echo $of_categories ; ?> .news_box5 a.read_more { color: #fff; }
        .block.cat_<?php echo $of_categories ; ?> .news_box5 .read_more:hover {
            background: <?php echo $cat_color ; ?>;
            border-color: <?php echo $cat_color ; ?>;
        }
        .block.cat_<?php echo $of_categories ; ?> .bblock_title h2 {
            background: <?php echo $cat_color ; ?>;
        }
        .block.bottom_box.cat_<?php echo $of_categories ; ?> ul li h2 a:hover{
             color: <?php echo $cat_color ; ?>;
        }
        <?php    
            }
        }
    }

    if(eff_option('logo_align') == 'center') { ?>
        .align_center.header_content { padding: 20px 0; }
        .align_center .logo {
            float: none;
            display: block;
            text-align: center;
        }
        .align_center .logo a img {
            display: inline-block;
            margin: 0;
        }
        .align_center .top_banner{
            margin-top: 15px;
            display: block;
            text-align: center;
            float: none;
        }
        .align_center .top_banner img {
            display: inline-block;
        }
        .align_center .top_banner_big {
            margin-top: 15px;
            display: block;
            text-align: center;
            float: none;
        }
        .align_center .top_banner_big img {
            display: inline-block;
        }
    <?php
    }
    ?>
    
</style>