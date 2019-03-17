<?php
/* Select Image Slider with no space shortcode */

if (!function_exists('image_slider_no_space')) {
	function image_slider_no_space($atts, $content = null) {
		global $qode_options;
		$args = array(
			"images"    				=> "",
			"height"    				=> "",
			"on_click"  				=> "",
			"custom_links" 				=> "",
			"custom_links_target" 		=> "",
			"navigation_style"			=> "",
			"highlight_active_image" 	=> "",
			"link_all_items"			=> ""
		);

		extract(shortcode_atts($args, $atts));

		//init variables
		$html = "";
		$image_gallery_holder_styles 	= '';
		$image_gallery_holder_classes 	= '';
		$image_gallery_item_styles   	= '';
		$custom_links_array			 	= array();
		$using_custom_links			 	= false;

		//is height for the slider set?
		if($height !== '') {
			$image_gallery_holder_styles .= 'height: '.$height.'px;';
			$image_gallery_item_styles .= 'height: '.$height.'px;';
		}

		//are we using custom links and is custom links field filled?
		if($on_click == 'use_custom_links' && $custom_links !== '') {
			//create custom links array
			$custom_links_array = explode(',', strip_tags($custom_links));
		}

		if($navigation_style !== '') {
			$image_gallery_holder_classes = $navigation_style;
		}

		if($highlight_active_image == 'yes') {
			$image_gallery_holder_classes .= ' highlight_active';
		}

		if($link_all_items == 'yes') {
			$image_gallery_holder_classes .= ' link_all';
		}

		$html .= "<div class='qode_image_gallery_no_space ".$image_gallery_holder_classes."'><div class='qode_image_gallery_holder' style='".$image_gallery_holder_styles."'><ul>";



		if($images != '' ) {
			$images_gallery_array = explode(',',$images);
		}

		//are we using prettyphoto?
		if($on_click == 'prettyphoto') {
			//generate random rel attribute
			$pretty_photo_rel = 'prettyPhoto[rel-'.rand().']';
		}


		//are we using custom links and is target for those elements chosen?
		if($on_click == 'use_custom_links' && in_array($custom_links_target, array('_self', '_blank'))) {
			//generate target attribute
			$custom_links_target = 'target="'.$custom_links_target.'"';
		}

		if(isset($images_gallery_array) && count($images_gallery_array) != 0) {
			$i = 0;
			foreach($images_gallery_array as $gimg_id) {
				$current_item_custom_link = '';

				$gimage_src = wp_get_attachment_image_src($gimg_id,'full',true);
				$gimage_alt = get_post_meta($gimg_id, '_wp_attachment_image_alt', true);

				$image_src    = $gimage_src[0];
				$image_width  = $gimage_src[1];
				$image_height = $gimage_src[2];

				//is height set for the slider?
				if($height !== '') {
					//get image proportion that will be used to calculate image width
					$proportion = $height / $image_height;

					//get proper image widht based on slider height and proportion
					$image_width = ceil($image_width * $proportion);
				}

				$html .= '<li><div style="'.$image_gallery_item_styles.' width:'.$image_width.'px;">';

				//is on click event chosen?
				if($on_click !== '') {
					switch($on_click) {
						case 'prettyphoto':
							$html .= '<a class="prettyphoto" rel="'.$pretty_photo_rel.'" href="'.$image_src.'">';
							break;
						case 'use_custom_links':
							//does current image has custom link set?
							if(isset($custom_links_array[$i])) {
								//get custom link for current image
								$current_item_custom_link = $custom_links_array[$i];

								if($current_item_custom_link !== '') {
									$html .= '<a '.$custom_links_target.' href="'.$current_item_custom_link.'">';
								}
							}
							break;
						case 'new_tab':
							$html .= '<a href="'.$image_src.'" target="_blank">';
							break;
						default:
							break;
					}
				}

				$html .= '<img src="'.$image_src.'" alt="'.$gimage_alt.'" />';

				//are we using prettyphoto or new tab click event or is custom link for current image set?
				if(in_array($on_click, array('prettyphoto', 'new_tab')) || ($on_click == 'use_custom_links' && $current_item_custom_link !== '')) {
					//if so close opened link
					$html .= '</a>';
				}

				$html .= '</div></li>';

				$i++;
			}
		}

		$html .= "</ul>";
		$html .= '</div>';
		$html .= '<div class="controls">';
		$html .= '<a class="prev-slide" href="#"><span class="arrow_carrot-left"></span></a>';
		$html .= '<a class="next-slide" href="#"><span class="arrow_carrot-right"></span></a>';
		$html .= '</div></div>';

		return $html;
	}

	add_shortcode('image_slider_no_space', 'image_slider_no_space');
}