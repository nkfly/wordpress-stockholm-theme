<?php
/* Qode Slider shortcode */

if (!function_exists('qode_slider')) {
	function qode_slider( $atts, $content = null ) {
		global $qode_options;
		extract(shortcode_atts(array("slider"=>"", "height"=>"", "responsive_height"=>"", "background_color"=>"", "auto_start"=>"", "animation_type"=>"", "slide_animation"=>"6000", "anchor" => "", "show_navigation" => "yes", "show_control" => "yes", "control_position" => "center"), $atts));
		$html = "";

		if ($slider != "") {
			$args = array(
				'post_type'=> 'slides',
				'slides_category' => $slider,
				'orderby' => "menu_order",
				'order' => "ASC",
				'posts_per_page' => -1
			);

			$slider_id = get_term_by('slug',$slider,'slides_category')->term_id;
			$slider_meta = get_option( "taxonomy_term_".$slider_id );
			$slider_header_effect =  $slider_meta['header_effect'];
			if($slider_header_effect == 'yes'){
				$header_effect_class = 'header_effect';
			}else{
				$header_effect_class = '';
			}

			$slider_css_position_class = '';
			$slider_parallax = 'yes';
			if(isset($slider_meta['slider_parallax_effect'])){
				$slider_parallax = $slider_meta['slider_parallax_effect'];
			}
			if($slider_parallax == 'no' || (isset($qode_options['paspartu']) && $qode_options['paspartu'] == 'yes')){
				$data_parallax_effect = 'data-parallax="no"';
				$slider_css_position_class = 'relative_position';
			}else{
				$data_parallax_effect = 'data-parallax="yes"';
			}

			$slider_thumbs =  'no';
			if($slider_thumbs == 'yes'){
				$slider_thumbs_class = 'slider_thumbs';
			}else{
				$slider_thumbs_class = '';
			}

			if($height == "" || $height == "0"){
				$full_screen_class = "full_screen";
				$responsive_height_class = "";
				$slide_height = "";
				$data_height = "";
			}else{
				$full_screen_class = "";
				if($responsive_height == "yes"){
					$responsive_height_class = "responsive_height";
				}else{
					$responsive_height_class = "";
				}
				$slide_height = "height: ".$height."px;";
				$data_height = "data-height='".$height."'";
			}

			$anchor_data = '';
			if($anchor != "") {
				$anchor_data .= 'data-q_id = "#'.$anchor.'"';
			}

			$slider_transparency_class = "header_not_transparent";
			if(isset($qode_options['header_background_transparency_initial']) && $qode_options['header_background_transparency_initial'] != "1" && $qode_options['header_background_transparency_initial'] != ""){
				$slider_transparency_class = "";
			}

			if($background_color != ""){
				$background_color = 'background-color:'.$background_color.';';
			}

			$auto = "true";
			if($auto_start != ""){
				$auto = $auto_start;
			}

			if($auto == "true"){
				$auto_start_class = "q_auto_start";
			} else {
				$auto_start_class = "";
			}

			if($slide_animation != ""){
				$slide_animation = 'data-slide_animation="'.$slide_animation.'"';
			} else {
				$slide_animation = 'data-slide_animation=""';
			}

			if($animation_type == 'fade'){
				$animation_type_class = 'fade';
			}else{
				$animation_type_class = '';
			}

			/**************** Count positioning of navigation arrows and preloader depending on header transparency and layout - START ****************/

			global $wp_query;

			$page_id = $wp_query->get_queried_object_id();
			$header_height_padding = 0;
			if((get_post_meta($page_id, "qode_header_color_transparency_per_page", true) == "" || get_post_meta($page_id, "qode_header_color_transparency_per_page", true) == "1") && ($qode_options['header_background_transparency_initial'] == "" || $qode_options['header_background_transparency_initial'] == "1") && $qode_options['header_bottom_appearance'] != "regular" && ($qode_options['enable_content_top_margin'] != "yes" && get_post_meta($page_id, "qode_enable_content_top_margin", true) != "yes")){

				$header_bottom_appearance = "";
				if (isset($qode_options['header_bottom_appearance'])) {
					$header_bottom_appearance = $qode_options['header_bottom_appearance'];
				}

				$header_top = 0;
				if(isset($qode_options['header_top_area']) && $qode_options['header_top_area'] == "yes"){
					$header_top = 33;
				}

				if (!empty($qode_options['header_height']) && $header_bottom_appearance != "fixed_hiding") {
					$header_height = $qode_options['header_height'];
				} elseif(!empty($qode_options['header_height']) && $header_bottom_appearance == "fixed_hiding"){
					$header_height = $qode_options['header_height'] + 50; // 50 is logo height for fixed advanced header type
				} elseif((isset($qode_options['center_logo_image']) && $qode_options['center_logo_image'] == "yes" && $header_bottom_appearance != "stick") || $header_bottom_appearance == "fixed_hiding") {
					$header_height = 190;
				} else {
					$header_height = 100;
				}
				if (!empty($qode_options['header_bottom_border_color'])) {
					$header_height = $header_height + 1;
				}
				if($header_bottom_appearance == "stick menu_bottom") {
					$menu_bottom = 60; // border 1px
					if ($qode_options['center_logo_image'] == "yes") {
						if(is_active_sidebar('header_fixed_right')){
							$menu_bottom = $menu_bottom + 26; // 26 is for right widget in header bottom (line height of text)
						}
					}
				} else {
					$menu_bottom = 0;
				}

				$header_height_padding = $header_height + $menu_bottom + $header_top;

				if (isset($qode_options['center_logo_image']) && $qode_options['center_logo_image'] == "yes") {
					if(isset($qode_options['logo_image'])){
						$logo_width = 0;
						$logo_height = 0;
						if (!empty($qode_options['logo_image'])) {
							$logo_url_obj = parse_url($qode_options['logo_image']);
							list($logo_width, $logo_height, $logo_type, $logo_attr) = getimagesize($_SERVER['DOCUMENT_ROOT'].$logo_url_obj['path']);
						}
					}
					if($header_bottom_appearance == "stick menu_bottom") {
						$header_height_padding = $logo_height + $menu_bottom + $header_top + 20; // 20 is top and bottom margin of centered logo
					} else {
						$header_height_padding = $header_height + $logo_height + $header_top + 20; // 20 is top and bottom margin of centered logo
					}
				}
			}
			if($header_height_padding != 0){
				$navigation_margin_top = 'style="margin-top:'. ($header_height_padding/2 - 25).'px;"'; // 25 is half height of arrow
				$loader_margin_top = 'style="margin-top:'. ($header_height_padding/2).'px;"';
			}
			else {
				$navigation_margin_top = '';
				$loader_margin_top = '';
			}

			/**************** Count positioning of navigation arrows and preloader depending on header transparency and layout - END ****************/


			$html .= '<div id="qode-'.$slider.'" '.$anchor_data.' class="carousel slide '.$animation_type_class.' '.$full_screen_class.' '.$responsive_height_class.' '.$auto_start_class.' '.$header_effect_class.' '.$slider_thumbs_class.' '.$slider_transparency_class.'" '.$slide_animation.' '.$data_height.' '.$data_parallax_effect.' style="'.$slide_height.' '.$background_color.'"><div class="qode_slider_preloader"><div class="ajax_loader" '.$loader_margin_top.'><div class="ajax_loader_1">'.qode_loading_spinners(true).'</div></div></div>';
			$html .= '<div class="carousel-inner '.$slider_css_position_class.'" data-start="transform: translateY(0px);" data-1440="transform: translateY(-500px);">';
			query_posts( $args );


			$found_slides =  $wp_query->post_count;

			if ( have_posts() ) : $postCount = 0; while ( have_posts() ) : the_post();
				$active_class = '';
				if($postCount == 0){
					$active_class = 'active';
				}else{
					$active_class = 'inactive';
				}

				$slide_type = get_post_meta(get_the_ID(), "qode_slide-background-type", true);

				$image = get_post_meta(get_the_ID(), "qode_slide-image", true);
				$image_overlay_pattern = get_post_meta(get_the_ID(), "qode_slide-overlay-image", true);
				$thumbnail = get_post_meta(get_the_ID(), "qode_slide-thumbnail", true);
				$thumbnail_animation = get_post_meta(get_the_ID(), "qode_slide-thumbnail-animation", true);

				$thumbnail_link = "";
				if(get_post_meta(get_the_ID(), "qode_slide-thumbnail-link", true) != ""){
					$thumbnail_link = get_post_meta(get_the_ID(), "qode_slide-thumbnail-link", true);
				}

				$video_webm = get_post_meta(get_the_ID(), "qode_slide-video-webm", true);
				$video_mp4 = get_post_meta(get_the_ID(), "qode_slide-video-mp4", true);
				$video_ogv = get_post_meta(get_the_ID(), "qode_slide-video-ogv", true);
				$video_image = get_post_meta(get_the_ID(), "qode_slide-video-image", true);
				$video_overlay = get_post_meta(get_the_ID(), "qode_slide-video-overlay", true);
				$video_overlay_image = get_post_meta(get_the_ID(), "qode_slide-video-overlay-image", true);

				$content_animation = get_post_meta(get_the_ID(), "qode_slide-content-animation", true);
				$content_parallax_animation = get_post_meta(get_the_ID(), "qode_slide-contnet-fading-out", true);

				$slide_content_style = "";
				if(get_post_meta(get_the_ID(), "qode_slide-content-background-color", true) != ""){
					$slide_content_style .= "background-color: ". get_post_meta(get_the_ID(), "qode_slide-content-background-color", true) . ";";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-content-text-padding", true) != ""){
					$slide_content_style .= "padding: ". get_post_meta(get_the_ID(), "qode_slide-content-text-padding", true) . ";";
				}

				$slide_title_style = "";
				if(get_post_meta(get_the_ID(), "qode_slide-title-color", true) != ""){
					$slide_title_style .= "color: ". get_post_meta(get_the_ID(), "qode_slide-title-color", true) . ";";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-title-font-size", true) != ""){
					$slide_title_style .= "font-size: ". get_post_meta(get_the_ID(), "qode_slide-title-font-size", true) . "px;";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-title-line-height", true) != ""){
					$slide_title_style .= "line-height: ". get_post_meta(get_the_ID(), "qode_slide-title-line-height", true) . "px;";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-title-font-family", true) !== "" && get_post_meta(get_the_ID(), "qode_slide-title-font-family", true) !== "-1"){
					$slide_title_style .= "font-family: '". str_replace('+', ' ', get_post_meta(get_the_ID(), "qode_slide-title-font-family", true)) . "';";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-title-font-style", true) != ""){
					$slide_title_style .= "font-style: ". get_post_meta(get_the_ID(), "qode_slide-title-font-style", true) . ";";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-title-font-weight", true) != ""){
					$slide_title_style .= "font-weight: ". get_post_meta(get_the_ID(), "qode_slide-title-font-weight", true) . ";";
				}
				if(get_post_meta(get_the_ID(), 'qode_slide-title-letter-spacing', true) !== '') {
					$slide_title_style .= 'letter-spacing: '.get_post_meta(get_the_ID(), 'qode_slide-title-letter-spacing', true).'px;';
				}
				if(get_post_meta(get_the_ID(), 'qode_slide-title-text-transform', true) !== '') {
					$slide_title_style .= 'text-transform: '.get_post_meta(get_the_ID(), 'qode_slide-title-text-transform', true).';';
				}

				if(get_post_meta(get_the_ID(), 'qode_slide-hide-shadow', true) == 'yes'){
					$slide_title_style .= 'text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);';
				}

				if(get_post_meta(get_the_ID(), 'qode_slide-title-bottom-margin', true) !== '') {
					$slide_title_style .= 'margin-bottom: '.get_post_meta(get_the_ID(), 'qode_slide-title-bottom-margin', true).'px;';
				}

				if(get_post_meta(get_the_ID(), 'qode_slide-title-background-color', true) !== '') {
					$original_color = get_post_meta(get_the_ID(), 'qode_slide-title-background-color', true);
					$color = qode_hex2rgb($original_color);
					if(get_post_meta(get_the_ID(), 'qode_slide-title-background-opacity', true) !== '') {
						$opacity = get_post_meta(get_the_ID(), 'qode_slide-title-background-opacity', true);
						$slide_title_style .= 'background-color: rgba('. $color[0] . ',' . $color[1] . ',' . $color[2] . ',' . $opacity . ')';
					}
					else {
						$slide_title_style .= 'background-color: rgba('. $color[0] . ',' . $color[1] . ',' . $color[2] . ')';
					}
				}

				$slide_subtitle_style = "";
				if(get_post_meta(get_the_ID(), "qode_slide-subtitle-color", true) != ""){
					$slide_subtitle_style .= "color: ". get_post_meta(get_the_ID(), "qode_slide-subtitle-color", true) . ";";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-subtitle-font-size", true) != ""){
					$slide_subtitle_style .= "font-size: ". get_post_meta(get_the_ID(), "qode_slide-subtitle-font-size", true) . "px;";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-subtitle-line-height", true) != ""){
					$slide_subtitle_style .= "line-height: ". get_post_meta(get_the_ID(), "qode_slide-subtitle-line-height", true) . "px;";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-subtitle-font-family", true) !== "" && get_post_meta(get_the_ID(), "qode_slide-subtitle-font-family", true) !== "-1"){
					$slide_subtitle_style .= "font-family: '". str_replace('+', ' ', get_post_meta(get_the_ID(), "qode_slide-subtitle-font-family", true)) . "';";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-subtitle-font-style", true) != ""){
					$slide_subtitle_style .= "font-style: ". get_post_meta(get_the_ID(), "qode_slide-subtitle-font-style", true) . ";";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-subtitle-font-weight", true) != ""){
					$slide_subtitle_style .= "font-weight: ". get_post_meta(get_the_ID(), "qode_slide-subtitle-font-weight", true) . ";";
				}
				if(get_post_meta(get_the_ID(), 'qode_slide-subtitle-letter-spacing', true) !== '') {
					$slide_subtitle_style .= 'letter-spacing: '.get_post_meta(get_the_ID(), 'qode_slide-subtitle-letter-spacing', true).'px;';
				}
				if(get_post_meta(get_the_ID(), 'qode_slide-subtitle-text-transform', true) !== '') {
					$slide_subtitle_style .= 'text-transform: '.get_post_meta(get_the_ID(), 'qode_slide-subtitle-text-transform', true).';';
				}

				if(get_post_meta(get_the_ID(), 'qode_slide-hide-shadow', true) == 'yes'){
					$slide_subtitle_style .= 'text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);';
				}

				if(get_post_meta(get_the_ID(), 'qode_slide-subtile-bottom-margin', true) !== '') {
					$slide_subtitle_style .= 'margin-bottom: '.get_post_meta(get_the_ID(), 'qode_slide-subtile-bottom-margin', true).'px;';
				}

				$slide_text_style = "";
				$button_style = "";
				if(get_post_meta(get_the_ID(), "qode_slide-text-color", true) != ""){
					$slide_text_style .= "color: ". get_post_meta(get_the_ID(), "qode_slide-text-color", true) . ";";
					$button_style = " style='border-color:". get_post_meta(get_the_ID(), "qode_slide-text-color", true) . ";color:". get_post_meta(get_the_ID(), "qode_slide-text-color", true) . ";'";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-text-font-size", true) != ""){
					$slide_text_style .= "font-size: ". get_post_meta(get_the_ID(), "qode_slide-text-font-size", true) . "px;";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-text-line-height", true) != ""){
					$slide_text_style .= "line-height: ". get_post_meta(get_the_ID(), "qode_slide-text-line-height", true) . "px;";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-text-font-family", true) !== "" && get_post_meta(get_the_ID(), "qode_slide-text-font-family", true) !== "-1"){
					$slide_text_style .= "font-family: '". str_replace('+', ' ', get_post_meta(get_the_ID(), "qode_slide-text-font-family", true)) . "';";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-text-font-style", true) != ""){
					$slide_text_style .= "font-style: ". get_post_meta(get_the_ID(), "qode_slide-text-font-style", true) . ";";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-text-font-weight", true) != ""){
					$slide_text_style .= "font-weight: ". get_post_meta(get_the_ID(), "qode_slide-text-font-weight", true) . ";";
				}
				if(get_post_meta(get_the_ID(), 'qode_slide-text-letter-spacing', true) !== '') {
					$slide_text_style .= 'letter-spacing: '.get_post_meta(get_the_ID(), 'qode_slide-text-letter-spacing', true).'px;';
				}
				if(get_post_meta(get_the_ID(), 'qode_slide-text-text-transform', true) !== '') {
					$slide_text_style .= 'text-transform: '.get_post_meta(get_the_ID(), 'qode_slide-text-text-transform', true).';';
				}

				if(get_post_meta(get_the_ID(), 'qode_slide-hide-shadow', true) == 'yes'){
					$slide_text_style .= 'text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);';
				}

				if(get_post_meta(get_the_ID(), 'qode_slide-text-bottom-margin', true) !== '') {
					$slide_text_style .= 'margin-bottom: '.get_post_meta(get_the_ID(), 'qode_slide-text-bottom-margin', true).'px;';
				}

				$graphic_alignment = get_post_meta(get_the_ID(), "qode_slide-graphic-alignment", true);
				$content_alignment = get_post_meta(get_the_ID(), "qode_slide-content-alignment", true);

				$separate_text_graphic = get_post_meta(get_the_ID(), "qode_slide-separate-text-graphic", true);

				if(get_post_meta(get_the_ID(), "qode_slide-content-width", true) != ""){
					$content_width = "width:".get_post_meta(get_the_ID(), "qode_slide-content-width", true)."%;";
				}else{
					$content_width = "width:80%;";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-content-left", true) != ""){
					$content_xaxis= "left:".get_post_meta(get_the_ID(), "qode_slide-content-left", true)."%;";
				}else{
					if(get_post_meta(get_the_ID(), "qode_slide-content-right", true) != ""){
						$content_xaxis = "right:".get_post_meta(get_the_ID(), "qode_slide-content-right", true)."%;";
					}else{
						$content_xaxis = "left: 10%;";
					}
				}
				if(get_post_meta(get_the_ID(), "qode_slide-content-top", true) != ""){
					$content_yaxis_start = "top:".get_post_meta(get_the_ID(), "qode_slide-content-top", true)."%;";
					$content_yaxis_end = "top:".(get_post_meta(get_the_ID(), "qode_slide-content-top", true)-10)."%;";
				}else{
					if(get_post_meta(get_the_ID(), "qode_slide-content-bottom", true) != ""){
						$content_yaxis_start = "bottom:".get_post_meta(get_the_ID(), "qode_slide-content-bottom", true)."%;";
						$content_yaxis_end = "bottom:".(get_post_meta(get_the_ID(), "qode_slide-content-bottom", true)+10)."%;";
					}else{
						$content_yaxis_start = "top: 35%;";
						$content_yaxis_end = "top: 10%;";
					}
				}

				if(get_post_meta(get_the_ID(), "qode_slide-graphic-width", true) != ""){
					$graphic_width = "width:".get_post_meta(get_the_ID(), "qode_slide-graphic-width", true)."%;";
				}else{
					$graphic_width = "width:50%;";
				}
				if(get_post_meta(get_the_ID(), "qode_slide-graphic-left", true) != ""){
					$graphic_xaxis= "left:".get_post_meta(get_the_ID(), "qode_slide-graphic-left", true)."%;";
				}else{
					if(get_post_meta(get_the_ID(), "qode_slide-graphic-right", true) != ""){
						$graphic_xaxis = "right:".get_post_meta(get_the_ID(), "qode_slide-graphic-right", true)."%;";
					}else{
						$graphic_xaxis = "left: 25%;";
					}
				}
				if(get_post_meta(get_the_ID(), "qode_slide-graphic-top", true) != ""){
					$graphic_yaxis_start = "top:".get_post_meta(get_the_ID(), "qode_slide-graphic-top", true)."%;";
					$graphic_yaxis_end = "top:".(get_post_meta(get_the_ID(), "qode_slide-graphic-top", true)-10)."%;";
				}else{
					if(get_post_meta(get_the_ID(), "qode_slide-graphic-bottom", true) != ""){
						$graphic_yaxis_start = "bottom:".get_post_meta(get_the_ID(), "qode_slide-graphic-bottom", true)."%;";
						$graphic_yaxis_end = "bottom:".(get_post_meta(get_the_ID(), "qode_slide-graphic-bottom", true)+10)."%;";
					}else{
						$graphic_yaxis_start = "top: 30%;";
						$graphic_yaxis_end = "top: 10%;";
					}
				}

				$header_style = "";
				if(get_post_meta(get_the_ID(), "qode_slide-header-style", true) != ""){
					$header_style = get_post_meta(get_the_ID(), "qode_slide-header-style", true);
				}

				$vertical_alignment_class = '';
				if(get_post_meta(get_the_ID(), "qode_slide-vertical-alignment", true) == "yes"){
					$vertical_alignment_class = ' vertical_align_middle';
				}

				if($header_height_padding !== 0 && get_post_meta(get_the_ID(), "qode_slide-vertical-alignment", true) == "yes"){
					$vertical_alignment_top_padding_style = "padding-top:".$header_height_padding."px;";
				} else {
					$vertical_alignment_top_padding_style = "";
				}

				$content_bottom_right_alignment = '';
				if(get_post_meta(get_the_ID(), "qode_slide-bottom-right-alignment", true) == "yes"){
					$content_bottom_right_alignment = ' content_bottom_right_alignment';
				}

				$title = get_the_title();

				$html .= '<div class="item '.$header_style.$vertical_alignment_class.'" style="'.$slide_height.'">';
				if($slide_type == 'video'){

					$html .= '<div class="video"><div class="mobile-video-image" style="background-image: url('.$video_image.')"></div><div class="video-overlay';
					if($video_overlay == "yes"){
						$html .= ' active';
					}
					$html .= '"';
					if($video_overlay_image != ""){
						$html .= ' style="background-image:url('.$video_overlay_image.');"';
					}
					$html .= '>';
					if($video_overlay_image != ""){
						$html .= '<img src="'.$video_overlay_image.'" alt="" />';
					}else{
						$html .= '<img src="'.get_template_directory_uri().'/css/img/pixel-video.png" alt="" />';
					}
					$html .= '</div><div class="video-wrap">
									
									<video class="video" width="1920" height="800" poster="'.$video_image.'" controls="controls" preload="auto" loop autoplay muted>';
					if(!empty($video_webm)) { $html .= '<source type="video/webm" src="'.$video_webm.'">'; }
					if(!empty($video_mp4)) { $html .= '<source type="video/mp4" src="'.$video_mp4.'">'; }
					if(!empty($video_ogv)) { $html .= '<source type="video/ogg" src="'. $video_ogv.'">'; }
					$html .='<object width="320" height="240" type="application/x-shockwave-flash" data="'.get_template_directory_uri().'/js/flashmediaelement.swf">
													<param name="movie" value="'.get_template_directory_uri().'/js/flashmediaelement.swf" />
													<param name="flashvars" value="controls=true&file='.$video_mp4.'" />
													<img src="'.$video_image.'" width="1920" height="800" title="No video playback capabilities" alt="Video thumb" />
											</object>
									</video>		
							</div></div>';
				}else{
					$html .= '<div class="image" style="background-image:url('.$image.');">';
					if($slider_thumbs == 'no'){
						$html .= '<img src="'.$image.'" alt="'.$title.'">';
					}

					if($image_overlay_pattern !== ""){
						$html .= '<div class="image_pattern" style="background: url('.$image_overlay_pattern.') repeat 0 0;"></div>';
					}
					$html .= '</div>';
				}

				$html_thumb = "";
				if($thumbnail != ""){
					$html_thumb .= '<div class="thumb '.$thumbnail_animation.'">';
					if($thumbnail_link != ""){
						$html_thumb .= '<a href="'.$thumbnail_link.'" target="_self">';
					}

					$html_thumb .= '<img src="'.$thumbnail.'" alt="'.$title.'">';

					if($thumbnail_link != ""){
						$html_thumb .= '</a>';
					}
					$html_thumb .= '</div>';
				}
				$html_text = "";
				$title_class = "";
				if(get_post_meta(get_the_ID(), "qode_slide-title-background-color", true) != '') {
					$title_class .= ' with_bg_color';
				}
				$html_text .= '<div class="text '.$content_animation.'" style="'.$slide_content_style.'">';

				if(get_post_meta(get_the_ID(), "qode_slide-subtitle", true) != ""){
					$html_text .= '<h3 class="q_slide_subtitle" style="'.$slide_subtitle_style.'"><span>'.get_post_meta(get_the_ID(), 'qode_slide-subtitle', true).'</span></h3>';
				}

				if(get_post_meta(get_the_ID(), "qode_slide-hide-title", true) != true){
					$html_text .= '<h2 class="q_slide_title' . $title_class . '" style="'.$slide_title_style.'"><span>'.get_the_title().'</span></h2>';
				}

				if(get_post_meta(get_the_ID(), "qode_slide-text", true) != ""){
					$html_text .= '<h3 class="q_slide_text" style="'.$slide_text_style.'"><span>'.get_post_meta(get_the_ID(), "qode_slide-text", true).'</span></h3>';
				}

				//check if first button should be displayed
				$is_first_button_shown = get_post_meta(get_the_ID(), "qode_slide-button-label", true) != "" && get_post_meta(get_the_ID(), "qode_slide-button-link", true) != "";

				//check if second button should be displayed
				$is_second_button_shown = get_post_meta(get_the_ID(), "qode_slide-button-label2", true) != "" && get_post_meta(get_the_ID(), "qode_slide-button-link2", true) != "";

				//does any button should be displayed?
				$is_any_button_shown = $is_first_button_shown || $is_second_button_shown;

				if($is_any_button_shown) {
					$html_text .= '<div class="slide_buttons_holder">';
				}
				$slide_button_target = "_self";
				if(get_post_meta(get_the_ID(), "qode_slide-button-target", true) != ""){
					$slide_button_target = get_post_meta(get_the_ID(), "qode_slide-button-target", true);
				}

				$slide_button_target2 = "_self";
				if(get_post_meta(get_the_ID(), "qode_slide-button-target2", true) != ""){
					$slide_button_target2 = get_post_meta(get_the_ID(), "qode_slide-button-target2", true);
				}

				if($is_first_button_shown){
					$html_text .= '<a class="qbutton" href="'.get_post_meta(get_the_ID(), "qode_slide-button-link", true).'" target="'.$slide_button_target.'">'.get_post_meta(get_the_ID(), "qode_slide-button-label", true).'</a>';
				}
				if($is_second_button_shown){
					$html_text .= '<a class="qbutton white"' . $button_style . 'href="'.get_post_meta(get_the_ID(), "qode_slide-button-link2", true).'" target="'.$slide_button_target2.'">'.get_post_meta(get_the_ID(), "qode_slide-button-label2", true).'</a>';
				}

				if($is_any_button_shown) {
					$html_text .= '</div>'; //close div.slide_button_holder
				}

				if(get_post_meta(get_the_ID(), "qode_slide-anchor-button", true) !== '') {
					$slide_anchor_style = array();
					if(get_post_meta(get_the_ID(), "qode_slide-text-color", true) !== '') {
						$slide_anchor_style[] = "color: " . get_post_meta(get_the_ID(), "qode_slide-text-color", true);
					}

					if($slide_anchor_style !== '') {
						$slide_anchor_style = 'style="'. implode(';', $slide_anchor_style).'"';
					}

					$html_text .= '<div class="slide_anchor_holder"><a '.$slide_anchor_style.' class="slide_anchor_button anchor" href="'.get_post_meta(get_the_ID(), "qode_slide-anchor-button", true).'"><i class="fa fa-angle-down"></i></a></div>';
				}

				$html_text .= '</div>';
				$html .= '<div class="slider_content_outer '.$content_bottom_right_alignment.'">';

				if($separate_text_graphic != 'yes' || get_post_meta(get_the_ID(), "qode_slide-vertical-alignment", true) == "yes"){
					if($content_parallax_animation == "fading_out_off"){
						$html .= '<div class="slider_content '.$content_alignment.'" style="'.$content_width.$content_xaxis.$content_yaxis_start.$vertical_alignment_top_padding_style.'">';
					} else {
						$html .= '<div class="slider_content '.$content_alignment.'" style="'.$content_width.$content_xaxis.$content_yaxis_start.$vertical_alignment_top_padding_style.'" data-start="'.$content_width.' opacity:1; '.$content_xaxis.' '.$content_yaxis_start.'" data-300="opacity: 0; '.$content_xaxis.' '.$content_yaxis_end.'">';
					}
					$html .= $html_thumb;
					$html .= $html_text;
					$html .= '</div>';
				}else{
					if($content_parallax_animation == "fading_out_off"){
						$html .= '<div class="slider_content '.$graphic_alignment.'" style="'.$graphic_width.$graphic_xaxis.$graphic_yaxis_start.'">';
					} else {
						$html .= '<div class="slider_content '.$graphic_alignment.'" style="'.$graphic_width.$graphic_xaxis.$graphic_yaxis_start.'" data-start="'.$graphic_width.' opacity:1; '.$graphic_xaxis.' '.$graphic_yaxis_start.'" data-300="opacity: 0; '.$graphic_xaxis.' '.$graphic_yaxis_end.'">';
					}
					$html .= $html_thumb;
					$html .= '</div>';

					if($content_parallax_animation == "fading_out_off"){
						$html .= '<div class="slider_content '.$content_alignment.'" style="'.$content_width.$content_xaxis.$content_yaxis_start.'">';
					} else {
						$html .= '<div class="slider_content '.$content_alignment.'" style="'.$content_width.$content_xaxis.$content_yaxis_start.'" data-start="'.$content_width.' opacity:1; '.$content_xaxis.' '.$content_yaxis_start.'" data-300="opacity: 0; '.$content_xaxis.' '.$content_yaxis_end.'">';
					}
					$html .= $html_text;
					$html .= '</div>';
				}

				$html .= '</div>';
				$html .= '</div>';

				$postCount++;
			endwhile;
			else:
				$html .= __('Sorry, no slides matched your criteria.','qode');
			endif;
			wp_reset_query();

			$html .= '</div>';
			if($found_slides > 1){
				if($show_control == "yes"){
					if($content_parallax_animation == "fading_out_off"){
						$html .= '<ol class="carousel-indicators">';
					} else {
						$html .= '<ol class="carousel-indicators" data-start="opacity: 1;" data-300="opacity:0;">';
					}

					query_posts( $args );
					if ( have_posts() ) : $postCount = 0; while ( have_posts() ) : the_post();

						$html .= '<li data-target="#qode-'.$slider.'" data-slide-to="'.$postCount.'"';
						if($postCount == 0){
							$html .= ' class="active"';
						}
						$html .= '></li>';

						$postCount++;
					endwhile;
					else:
						$html .= __('Sorry, no posts matched your criteria.','qode');
					endif;

					wp_reset_query();
					$html .= '</ol>';
				}

				if($show_navigation == "yes"){
					if($content_parallax_animation == "fading_out_off"){
						$html .= '<a class="left carousel-control" href="#qode-'.$slider.'" data-slide="prev"><span class="prev_nav" '.$navigation_margin_top.'><span class="arrow_carrot-left"></span></span></a>';
						$html .= '<a class="right carousel-control" href="#qode-'.$slider.'" data-slide="next"><span class="next_nav" '.$navigation_margin_top.'><span class="arrow_carrot-right"></span></span></a>';
					} else {
						$html .= '<a class="left carousel-control" href="#qode-'.$slider.'" data-slide="prev" data-start="opacity: 1;" data-300="opacity:0;"><span class="prev_nav" '.$navigation_margin_top.'><span class="arrow_carrot-left"></span></span></a>';
						$html .= '<a class="right carousel-control" href="#qode-'.$slider.'" data-slide="next" data-start="opacity: 1;" data-300="opacity:0;"><span class="next_nav" '.$navigation_margin_top.'><span class="arrow_carrot-right"></span></span></a>';
					}
				}
			}
			$html .= '</div>';
		}
		return $html;
	}
	add_shortcode('qode_slider', 'qode_slider');
}
