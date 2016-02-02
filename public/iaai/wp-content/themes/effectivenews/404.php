<?php get_header(); ?>


            </div>
        <!--wrap-->
        
        <div class="page_wrap">
            <div class="page_inner error_page">
                
                <h2 class="errorMessage"><?php _e('404' , 'framework' ) ?></h2>
                <span class="errorMessage2"><?php _e("96 Down. com The page you are looking for doesn't seem to exist." , "framework" ) ?></span>
                
                <h3><?php _e("Why don't you try Search or back to " , 'framework' ) ?><a href="<?php echo home_url(); ?>">home page</a></h3>
                
                 <div class="mainsearch">
                    <form method="get" action="<?php echo home_url();?>">
                        <input type="text" name="s" id="search-form" value="<?php _e('Search ...' , 'framework' ) ?>" onfocus="if (this.value=='<?php _e('Search ...' , 'framework' ) ?>') this.value       = '';" onblur="if (this.value=='') this.value='<?php _e('Search ...' , 'framework' ) ?>';" />
                        <input type="submit" id="searchsubmit" class="btnMainColor" value="<?php _e('Search' , 'framework' ) ?>" />
                    </form>
                </div>
                
            </div>
        </div>
        
    </div>
    <!--Main-->
    
<div class="clear"></div>

<?php get_footer(); ?>