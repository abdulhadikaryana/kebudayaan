						
<div class="mainsearch">
    <form method="get" action="<?php echo home_url();?>">
	<input type="text" name="s" id="search-form" value="<?php _e('Search ...', 'framework'); ?>" name="s" onfocus="if(this.value == '<?php _e('Search ...', 'framework'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search ...', 'framework'); ?>';}" />
	<input type="submit" id="searchsubmit" class="btnMainColor" value="<?php _e('Search' , 'framework' ) ?>" />
    </form>
</div>             
                