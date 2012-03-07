<?php get_header(); 
global $q_config;
$date_fmt = 'F jS, Y';
if($q_config['language']!=='en'){
    $date_fmt = 'd/m/Y';
}
?>
<div id="main">		
    <div class="columns">
        <div class="narrowcolumn singlepage">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>							
                    <div class="post">            	
                        <div class="title">
                            <h2><?php the_title(); ?></h2>
                            <small><?php the_time($date_fmt) ?> | <?php _e('Posted by','nattywp'); ?> <span class="author"><?php natty_get_profile() ?></span> <?php _e('in','nattywp'); ?> <?php the_category(' | ');?> <?php edit_post_link(__('Edit','nattywp'), ' | ', ''); ?></small> 
                        </div> 
                        <div class="fb-like" data-href="http://www.xomena.com" data-send="true" data-width="600" data-show-faces="true" data-font="verdana"></div>
			<div class="entry">
                            <?php t_show_video($post->ID); ?>
                            <?php the_content(); ?> 
                            <?php
                            $args = array(
                                'post_type' => 'attachment',
                                'post_mime_type' => 'application/pdf',
                                'numberposts' => null,
                                'post_status' => null,
                                'post_parent' => $post->ID
                            );
                            $attachments = get_posts($args);
                            if ($attachments) {
                                echo "<ul class='attachments'>";
                                foreach($attachments as $attachment){
                                    echo "<li>";
                                    echo apply_filters('the_title', $attachment->post_title).": ";
                                    the_attachment_link($attachment->ID, false);
                                    echo "</li>";
                                }
                                echo "</ul>";
                            }
                            ?>
                            <div class="clear"></div>
                        </div>              
                
			<p class="postmetadata">	               
                            <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>        			
                            <span class="category"><?php the_tags('', ', ', ''); ?></span>	
			</p>
        
                        <p>
                            <small>
                                <?php _e('You can follow any responses to this entry through the','nattywp'); ?> <?php post_comments_feed_link('RSS 2.0'); ?>
				<?php if ( comments_open() && pings_open() ) {
                                    // Both Comments and Pings are open ?>
                                    <?php _e('You can <a href="#respond">leave a response</a>, or','nattywp'); ?> <a href="<?php trackback_url(); ?>" rel="trackback"><?php _e('trackback','nattywp'); ?></a>.
				<?php } elseif ( !comments_open() && pings_open() ) {
                                    // Only Pings are Open ?>
                                    <?php _e('Responses are currently closed, but you can','nattywp'); ?> <a href="<?php trackback_url(); ?> " rel="trackback"><?php _e('trackback','nattywp'); ?></a>.
				<?php } elseif ( comments_open() && !pings_open() ) {
                                    // Comments are open, Pings are not ?>							
                                    <?php _e('You can skip to the end and leave a response. Pinging is currently not allowed.','nattywp'); ?>
				<?php } elseif ( !comments_open() && !pings_open() ) {
                                    // Neither Comments, nor Pings are open ?>
                                    <?php _e('Both comments and pings are currently closed.','nattywp'); ?>							
				<?php }  ?>
                            </small>
                        </p>	
                    </div>	
                    <div class="post">
                        <?php comments_template(); ?>      	
                    </div>				
                <?php endwhile; ?>	
            <?php else : ?>
		<div class="post">
                    <h2><?php _e('Not Found','nattywp'); ?></h2>
                    <div class="entry">
                        <p><?php _e('Sorry, but you are looking for something that isn\'t here.','nattywp'); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                </div>
            <?php endif; ?>				
	</div> <!-- END Narrowcolumn -->
        <div id="sidebar" class="profile">
           <?php if (!function_exists('dynamic_sidebar') || (!is_active_sidebar(2))) {
                get_sidebar(); 
              } else {
                echo '<ul>';
                dynamic_sidebar('sidebar-2');
                echo '</ul>';
              } ?>
            <a href="http://webformyself.com/aff/chicharrero/4" target="_blank">
                <img src="http://webformystorage.s3.amazonaws.com/premium/kurs/cover1.png" width="187" height="182" />
            </a>
        </div>    
        <div class="clear"></div>

    <?php get_footer(); ?> 