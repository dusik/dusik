<?php
/*
Plugin Name: Flexible Lightbox
Plugin URI: http://www.web-argument.com/flexible-lightbox
Description: Integrate Lightbox into your blogs. Open Images and Native Galleries on the popup overlay window without touching the html code. On the image setting panel you can select if you want to 'Open using Lightbox'.
Version: 1.0.4
Author: Alain Gonzalez
Author URI: http://www.web-argument.com
*/


/*****************************************************************************
                     Inserting class name to images
******************************************************************************/

function image_attachment_fields_flbox($form_fields, $post)
{
  if ( substr($post->post_mime_type, 0, 5) == 'image' ) {
  $form_fields['flbox'] = array(
			'label' => __('Open using LightBox'),
			'input' => 'html',
			'html'  => "
				<input type='radio' name='attachments[$post->ID][flbox]' id='flbox' value='yes'  checked='checked'/>
				<label for='flbox'>" . __('Yes') . "</label>
				<input type='radio' name='attachments[$post->ID][flbox]' id='flbox' value='no' />
				<label for='flbox'>" . __('No') . "</label>",
		);
   }      		
return $form_fields;
 
}

add_filter('attachment_fields_to_edit', 'image_attachment_fields_flbox', 10, 2);



function get_image_send_to_editor_flbox($id, $alt, $title, $align, $url='', $rel = false, $size, $flbox) {

	$html = get_image_tag($id, $alt, $title, $align, $size);

	if ( $url ){
	
	if ($flbox =='yes'){	
		
		$html = '<a class="lightbox"  title ="'.$title.'" href="' . clean_url($url) ."\">$html</a>";
		
	} else {
	
		$html = '<a href="' . clean_url($url) . "\"$rel>$html</a>";
		
	}
	}

	$html = apply_filters( 'image_send_to_editor', $html, $id, $alt, $title, $align, $url, $size );

	return media_send_to_editor($html);
}





function image_media_send_to_editor_flbox($html, $attachment_id, $attachment) {
	$post =& get_post($attachment_id);
	if ( substr($post->post_mime_type, 0, 5) == 'image' ) {
		$url = $attachment['url'];

		if ( isset($attachment['align']) )
			$align = $attachment['align'];
		else
			$align = 'none';

		if ( !empty($attachment['image-size']) )
			$size = $attachment['image-size'];
		else
			$size = 'medium';

		
		if (isset($attachment['flbox']))	$flbox = $attachment['flbox'];
			
		else $flbox = 'no';

			$rel = ( $url == get_attachment_link($attachment_id) );

		return get_image_send_to_editor_flbox($attachment_id, $attachment['post_excerpt'], $attachment['post_title'], $align, $url, $rel, $size, $flbox);
	}
	return $html;
}


add_filter('media_send_to_editor', 'image_media_send_to_editor_flbox', 10, 3);


	
function add_flexible_lightbox_css() {

    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/flexible-lightbox/css/flexible-lightbox.css" />';
}

add_action('admin_head', 'add_flexible_lightbox_css');



/*****************************************************************************
                     Inserting class name to galleries
******************************************************************************/

function gallery_shortcode_flbox($attr) {
	global $post;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'orderby'    => 'menu_order ASC, ID ASC',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
	), $attr));

	$id = intval($id);
	$attachments = get_children("post_parent=$id&post_type=attachment&post_mime_type=image&orderby={$orderby}");

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $id => $attachment )
			$output .= wp_get_attachment_link($id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	
	$output = apply_filters('gallery_style', "
		<style type='text/css'>
			.gallery {
				margin: auto;
			}
			.gallery-item {
				float: left;
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;			}
			.gallery img {
				border: 2px solid #cfcfcf;
			}
			.gallery-caption {
				margin-left: 0;
			}
		</style>
		<!-- see gallery_shortcode() in wp-includes/media.php -->
		<div class='gallery'>");

	foreach ( $attachments as $id => $attachment ) {
	//$link = wp_get_attachment_link($id);
		
		$a_img = wp_get_attachment_url($id);
	// Attachment page ID
		$att_page = get_attachment_link($id);
	// Returns array
		$img = wp_get_attachment_image_src($id, $size);
		$img = $img[0];
		
		$title= $attachment->post_title;
	
		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon'>
			
					<a href=\"$a_img\" title=\"$title\" rel=\"gallery-$post->ID\">
				
					<img src=\"$img\" alt=\"$title\" />
				
					</a>	
				
			</{$icontag}>";
		
		$output .= "</{$itemtag}>";
		if ( $columns == 0 )
			$output .= '<br style="clear: both" />';
	}

	$output .= "
			<br style='clear: both;' />
		</div>\n";

	return $output;
}

remove_shortcode('gallery');


add_shortcode('gallery', 'gallery_shortcode_flbox');



/*****************************************************************************
                     Inserting files on the header
******************************************************************************/

function flbox_head() {

    $flbox_header =  "\n<!-- Flexible Lightbox -->\n";		
   	$flbox_header .= "<script type=\"text/javascript\" src=\"".get_bloginfo('wpurl')."/wp-content/plugins/flexible-lightbox/js/jquery.lightbox-0.5.pack.js\"></script>\n";
	$flbox_header .= "<script type=\"text/javascript\">var path=\"".get_bloginfo('wpurl')."/wp-content/plugins/flexible-lightbox/images/\";</script>\n";	
	$flbox_header .= "<script type=\"text/javascript\" src=\"".get_bloginfo('wpurl')."/wp-content/plugins/flexible-lightbox/js/lightbox_call.js\"></script>\n";		
	$flbox_header .= "\t<link href=\"".get_bloginfo('wpurl')."/wp-content/plugins/flexible-lightbox/css/jquery.lightbox-0.5.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
            
print($flbox_header);
}

wp_enqueue_script('jquery'); 
add_action('wp_head', 'flbox_head');		


?>