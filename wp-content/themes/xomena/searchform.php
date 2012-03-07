<form method="get" id="searchforma" class="search" action="<?php echo home_url(); ?>/">	
    <input type="text" class="search-input png_crop" title="<?php _e('Search'); ?>" value="<?php _e('Search'); ?>" onblur="if (!value)value='<?php _e('Search'); ?>'" onclick="value=''" id="edit-search-theme-form-keys" name="s" />
    <input type="image" alt="<?php _e('Search'); ?>" title="<?php _e('Search'); ?>" class="search-submit png_crop" name="op" value="" src="<?php echo get_template_directory_uri();?>/images/<?php global $q_config; echo $q_config['language'];?>/submit.png"/>
</form>						
<div style="clear:both;"></div>