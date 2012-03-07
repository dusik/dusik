<?php 
$t_timeout = t_get_option('t_timeout');  
$t_slide_speed = t_get_option('t_slide_speed'); 
$t_slide_effect = t_get_option('t_slide_effect'); 
?>

<div id="footer">
<div class="lt"><?php _e('Copyright &copy; 2011-2012 ','xomena'); ?></div>
<div class="rt">Powered by <a href="http://www.xomena.com" title="Xomena"><img src="<?php echo get_template_directory_uri(); ?>/images/xomena-icon.png" width="12" height="12" valign="3px" class="png" alt="Xomena" align="middle" /> Andriy Khomenko</a></div>		
<div class="clear"></div>			
</div>
    </div> <!-- END Columns --> 
    
   
</div><!-- END main -->
</div>  
<div class="clear"></div>

<?php $t_tracking = t_get_option( "t_tracking" );
if ($t_tracking != ""){
	echo stripslashes(stripslashes($t_tracking));
	}
?>

<?php wp_footer(); ?>  
<script type="text/javascript" charset="utf-8">
<?php if (t_get_option('t_cufon_replace') == 'yes') { ?>	Cufon.now(); <?php } ?>	
	jQuery(document).ready(function() {
			$j('.slideshow').cycle({
				fx: '<?php if(!isset($t_slide_effect) || $t_slide_effect == 'no') {echo 'fade';} else {echo $t_slide_effect;} ?>',
				timeout: <?php if(!isset($t_timeout) || $t_timeout == 'no') {echo '5000';} else {echo $t_timeout;} ?>,
				pager: '#slideshow-nav',
				speed: <?php if(!isset($t_slide_speed) || $t_slide_speed == 'no') {echo '1000';} else {echo $t_slide_speed;} ?>,
				//prev: '#left-arrow',
        //next: '#right-arrow',
				pagerEvent: 'click',
    		pauseOnPagerHover: true,
				cleartypeNoBg: true });						
	  });		
	</script>     
</body>
</html>