<?php
function eff_review ($top=null) { ?>
<?php
	global $post;
//meta
$rt_enable = get_post_meta($post->ID, 'eff_enable_review', true);
$rt_style = get_post_meta($post->ID, 'eff_review_style', true);
$rt_position = get_post_meta($post->ID, 'eff_review_position', true);
$rt_head = get_post_meta($post->ID, 'eff_review_head', true);
$rt_foot = get_post_meta($post->ID, 'eff_review_foot', true);
$rt_summary = get_post_meta($post->ID, 'eff_review_summary', true);

// Criteria Names
$rt_cr1 = get_post_meta($post->ID, 'eff_rt_cr1_desc', true);
$rt_cr2 = get_post_meta($post->ID, 'eff_rt_cr2_desc', true);
$rt_cr3 = get_post_meta($post->ID, 'eff_rt_cr3_desc', true);
$rt_cr4 = get_post_meta($post->ID, 'eff_rt_cr4_desc', true);
$rt_cr5 = get_post_meta($post->ID, 'eff_rt_cr5_desc', true);
$rt_cr6 = get_post_meta($post->ID, 'eff_rt_cr6_desc', true);
$rt_cr7 = get_post_meta($post->ID, 'eff_rt_cr7_desc', true);
$rt_cr8 = get_post_meta($post->ID, 'eff_rt_cr8_desc', true);
$rt_cr9 = get_post_meta($post->ID, 'eff_rt_cr9_desc', true);
$rt_cr10 = get_post_meta($post->ID, 'eff_rt_cr10_desc', true);

// Criteria rates
$rt_cr1_rate = get_post_meta($post->ID, 'eff_rt_cr1_rate', true);
$rt_cr2_rate = get_post_meta($post->ID, 'eff_rt_cr2_rate', true);
$rt_cr3_rate = get_post_meta($post->ID, 'eff_rt_cr3_rate', true);
$rt_cr4_rate = get_post_meta($post->ID, 'eff_rt_cr4_rate', true);
$rt_cr5_rate = get_post_meta($post->ID, 'eff_rt_cr5_rate', true);
$rt_cr6_rate = get_post_meta($post->ID, 'eff_rt_cr6_rate', true);
$rt_cr7_rate = get_post_meta($post->ID, 'eff_rt_cr7_rate', true);
$rt_cr8_rate = get_post_meta($post->ID, 'eff_rt_cr8_rate', true);
$rt_cr9_rate = get_post_meta($post->ID, 'eff_rt_cr9_rate', true);
$rt_cr10_rate = get_post_meta($post->ID, 'eff_rt_cr10_rate', true);

//points
$rt_cr1_rate_po = $rt_cr1_rate/10;
$rt_cr2_rate_po = $rt_cr2_rate/10;
$rt_cr3_rate_po = $rt_cr3_rate/10;
$rt_cr4_rate_po = $rt_cr4_rate/10;
$rt_cr5_rate_po = $rt_cr5_rate/10;
$rt_cr6_rate_po = $rt_cr6_rate/10;
$rt_cr7_rate_po = $rt_cr7_rate/10;
$rt_cr8_rate_po = $rt_cr8_rate/10;
$rt_cr9_rate_po = $rt_cr9_rate/10;
$rt_cr10_rate_po = $rt_cr10_rate/10;

//Scores
$percent_score = get_post_meta($post->ID, 'eff_rt_final_score', true);
$points_score = get_post_meta($post->ID, 'eff_rt_final_score_po', true);
$stars_score = get_post_meta($post->ID, 'eff_rt_final_score_stars', true);
$score_title = get_post_meta($post->ID, 'eff_rt_score_title', true);
?>
<?php if ($rt_enable == true) { ?>
<?php if ($rt_style == 'stars') { ?>
	<div class="eff_review_wrap <?php echo $top; ?>">
	    <?php if($rt_head) { ?> 
            <h3 class="eff_rt_head"><?php echo $rt_head; ?></h3>
            <?php } ?>
	    <div class="rt_results">
	    <?php if($rt_cr1) { ?> 
		<div class="eff_rt_cr_stars">
		    <div class="rt_cr_stars">
			    <span class="rt_cr_desc"><?php echo $rt_cr1; ?></span>
                            <div class="rt_stars">
                                <span class="rt_stars_rate" style="width:<?php echo $rt_cr1_rate; ?>%;"></span>
                            </div>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr2) { ?> 
		<div class="eff_rt_cr_stars">
		    <div class="rt_cr_stars">
			    <span class="rt_cr_desc"><?php echo $rt_cr2; ?></span>
                            <div class="rt_stars">
                                <span class="rt_stars_rate" style="width:<?php echo $rt_cr2_rate; ?>%;"></span>
                            </div>
    		    </div>
		</div>
            <?php } ?>
	    <?php if($rt_cr3) { ?> 
		<div class="eff_rt_cr_stars">
		    <div class="rt_cr_stars">
			    <span class="rt_cr_desc"><?php echo $rt_cr3; ?></span>
                            <div class="rt_stars">
                                <span class="rt_stars_rate" style="width:<?php echo $rt_cr3_rate; ?>%;"></span>
                            </div>
    		    </div>
		</div>
            <?php } ?>
	    <?php if($rt_cr4) { ?> 
		<div class="eff_rt_cr_stars">
		    <div class="rt_cr_stars">
			    <span class="rt_cr_desc"><?php echo $rt_cr4; ?></span>
                            <div class="rt_stars">
                                <span class="rt_stars_rate" style="width:<?php echo $rt_cr4_rate; ?>%;"></span>
                            </div>
    		    </div>
		</div>
            <?php } ?>
	    <?php if($rt_cr5) { ?> 
		<div class="eff_rt_cr_stars">
		    <div class="rt_cr_stars">
			    <span class="rt_cr_desc"><?php echo $rt_cr5; ?></span>
                            <div class="rt_stars">
                                <span class="rt_stars_rate" style="width:<?php echo $rt_cr5_rate; ?>%;"></span>
                            </div>
    		    </div>
		</div>
            <?php } ?>
	    <?php if($rt_cr6) { ?> 
		<div class="eff_rt_cr_stars">
		    <div class="rt_cr_stars">
			    <span class="rt_cr_desc"><?php echo $rt_cr6; ?></span>
                            <div class="rt_stars">
                                <span class="rt_stars_rate" style="width:<?php echo $rt_cr6_rate; ?>%;"></span>
                            </div>
    		    </div>
		</div>
            <?php } ?>
	    <?php if($rt_cr7) { ?> 
		<div class="eff_rt_cr_stars">
		    <div class="rt_cr_stars">
			    <span class="rt_cr_desc"><?php echo $rt_cr7; ?></span>
                            <div class="rt_stars">
                                <span class="rt_stars_rate" style="width:<?php echo $rt_cr7_rate; ?>%;"></span>
                            </div>
    		    </div>
		</div>
            <?php } ?>
	    <?php if($rt_cr8) { ?> 
		<div class="eff_rt_cr_stars">
		    <div class="rt_cr_stars">
			    <span class="rt_cr_desc"><?php echo $rt_cr8; ?></span>
                            <div class="rt_stars">
                                <span class="rt_stars_rate" style="width:<?php echo $rt_cr8_rate; ?>%;"></span>
                            </div>
    		    </div>
		</div>
            <?php } ?>
	    <?php if($rt_cr9) { ?> 
		<div class="eff_rt_cr_stars">
		    <div class="rt_cr_stars">
			    <span class="rt_cr_desc"><?php echo $rt_cr9; ?></span>
                            <div class="rt_stars">
                                <span class="rt_stars_rate" style="width:<?php echo $rt_cr9_rate; ?>%;"></span>
                            </div>
    		    </div>
		</div>
            <?php } ?>
	    <?php if($rt_cr10) { ?> 
		<div class="eff_rt_cr_stars">
		    <div class="rt_cr_stars">
			    <span class="rt_cr_desc"><?php echo $rt_cr10; ?></span>
                            <div class="rt_stars">
                                <span class="rt_stars_rate" style="width:<?php echo $rt_cr10_rate; ?>%;"></span>
                            </div>
    		    </div>
		</div>
            <?php } ?>
	    </div> <!--Review Result-->
	    <div class="rt_summary" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating">
		<meta itemprop="worstRating" content = "1" />
		<meta itemprop="bestRating" content = "100" />
		<div class="rt_score">
		    <div class="star_score" itemprop="ratingValue"><?php echo $stars_score; ?></div>
		    <div class="star_score_title"><?php echo $score_title; ?></div>
		    <div class="score_title">
                        <div class="rt_stars">
                                <span class="rt_stars_rate" style="width:<?php echo $percent_score; ?>%;"></span>
                         </div>
                    </div>
		</div>
		<div class="summary_content" itemprop="description">
		    <p><?php echo $rt_summary; ?></p>
		</div>
		<span style="display:none" itemprop="reviewRating"><?php echo $points_score; ?></span>
	    </div> <!--Review Summary-->
            <?php if($rt_foot) { ?>
	    <div class="rt_footer"><?php echo $rt_foot; ?></div>
            <?php } ?>
	</div> <!--eff review wrap-->
        
        <?php } //end stars
            elseif ($rt_style == 'percent') {
        ?>
	<div class="eff_review_wrap <?php echo $top; ?>">
	    <?php if($rt_head) { ?> 
            <h3 class="eff_rt_head"><?php echo $rt_head; ?></h3>
            <?php } ?>
	    <div class="rt_results">
	    <?php if($rt_cr1) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr1_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr1; ?> - <?php echo $rt_cr1_rate; ?>%</span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr2) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr2_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr2; ?> - <?php echo $rt_cr2_rate; ?>%</span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr3) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr3_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr3; ?> - <?php echo $rt_cr3_rate; ?>%</span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr4) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr4_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr4; ?> - <?php echo $rt_cr4_rate; ?>%</span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr5) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr5_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr5; ?> - <?php echo $rt_cr5_rate; ?>%</span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr6) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr6_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr6; ?> - <?php echo $rt_cr6_rate; ?>%</span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr7) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr7_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr7; ?> - <?php echo $rt_cr7_rate; ?>%</span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr8) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr8_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr8; ?> - <?php echo $rt_cr8_rate; ?>%</span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr9) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr9_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr9; ?> - <?php echo $rt_cr9_rate; ?>%</span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr10) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr10_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr10; ?> - <?php echo $rt_cr10_rate; ?>%</span>
    		    </div>
		</div>
            <?php } ?>

	    </div> <!--Review Result-->
	    <div class="rt_summary" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating">
		<meta itemprop="worstRating" content = "1" />
		<meta itemprop="bestRating" content = "100" />
		<div class="rt_score">
		    <div class="score" itemprop="ratingValue"><?php echo $percent_score; ?>%</div>
		    <div class="score_title"><?php echo $score_title; ?></div>
		</div>
		<div class="summary_content" itemprop="description">
		    <p><?php echo $rt_summary; ?></p>
		</div>
		<span style="display:none" itemprop="reviewRating"><?php echo $points_score; ?></span>
	    </div> <!--Review Summary-->
            <?php if($rt_foot) { ?>
	    <div class="rt_footer"><?php echo $rt_foot; ?></div>
            <?php } ?>
	</div> <!--eff review wrap-->
        <?php } //end percent
         elseif ($rt_style == 'points') {
        ?>
	<div class="eff_review_wrap <?php echo $top; ?>">
	    <?php if($rt_head) { ?> 
            <h3 class="eff_rt_head"><?php echo $rt_head; ?></h3>
            <?php } ?>
	    <div class="rt_results">
	    <?php if($rt_cr1) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr1_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr1; ?> - <?php echo $rt_cr1_rate_po; ?></span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr2) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr2_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr2; ?> - <?php echo $rt_cr2_rate_po; ?></span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr3) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr3_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr3; ?> - <?php echo $rt_cr3_rate_po; ?></span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr4) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr4_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr4; ?> - <?php echo $rt_cr4_rate_po; ?></span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr5) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr5_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr5; ?> - <?php echo $rt_cr5_rate_po; ?></span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr6) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr6_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr6; ?> - <?php echo $rt_cr6_rate_po; ?></span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr7) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr7_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr7; ?> - <?php echo $rt_cr7_rate_po; ?></span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr8) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr8_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr8; ?> - <?php echo $rt_cr8_rate_po; ?></span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_c9) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_c9_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_c9; ?> - <?php echo $rt_c9_rate_po; ?></span>
    		    </div>
		</div>
            <?php } ?>

	    <?php if($rt_cr10) { ?> 
		<div class="eff_rt_cr_percent">
		    <div class="rt_cr_per" style="width:<?php echo $rt_cr10_rate; ?>%;">
			    <span class="rt_cr_desc"><?php echo $rt_cr10; ?> - <?php echo $rt_cr10_rate_po; ?></span>
    		    </div>
		</div>
            <?php } ?>


	    </div> <!--Review Result-->
	    <div class="rt_summary" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating">
		<meta itemprop="worstRating" content = "1" />
		<meta itemprop="bestRating" content = "100" />
		<div class="rt_score">
		    <div class="score" itemprop="ratingValue"><?php echo $points_score; ?></div>
		    <div class="score_title"><?php echo $score_title; ?></div>
		</div>
		<div class="summary_content" itemprop="description">
		    <p><?php echo $rt_summary; ?></p>
		</div>
		<span style="display:none" itemprop="reviewRating"><?php echo $points_score; ?></span>
	    </div> <!--Review Summary-->
            <?php if($rt_foot) { ?>
	    <div class="rt_footer"><?php echo $rt_foot; ?></div>
            <?php } ?>
	</div> <!--eff review wrap-->
        <?php } ?>
<?php } ?>
<?php
}

function eff_review_sc ($atts, $content) {
	extract(shortcode_atts(array(
	), $atts));
       	ob_start();
            echo eff_review();
      	$content = ob_get_contents();
	ob_end_clean();

	return $content;
	
	}

add_shortcode('review', 'eff_review_sc');

