<?php
/* Testimonials shortcode */

if (!function_exists('testimonials')) {

	function testimonials($atts, $content = null) {
		$deafult_args = array(
			"type"						=> "",
			"number"					=> "-1",
			"category"					=> "",
			"show_author_image"			=> "",
			"show_title"				=> "",
			"text_color"				=> "",
			"text_font_size"			=> "",
			"author_text_color"			=> "",
			"show_author_job_position"	=> "",
			"text_align"                => "left_align",
			"show_navigation"			=> "",
			"navigation_style"			=> "",
			"auto_rotate_slides"		=> "",
			"animation_type"			=> "",
			"animation_speed"			=> ""
		);

		extract(shortcode_atts($deafult_args, $atts));

		$html                           = "";
		$testimonial_p_style			= "";
		$navigation_button_radius		= "";
		$testimonial_name_styles        = "";

		if($text_font_size != "" || $text_color != ""){
			$testimonial_p_style = " style='";
			if($text_font_size != ""){
				$testimonial_p_style .= "font-size:". $text_font_size . "px;";
			}
			if($text_color != ""){
				$testimonial_p_style .= "color:". $text_color . ";";
			}
			$testimonial_p_style .= "'";
		}

		if($author_text_color != "") {
			$testimonial_name_styles .= "color: ".$author_text_color.";";
		}

		$args = array(
			'post_type' => 'testimonials',
			'orderby' => "date",
			'order' => "DESC",
			'posts_per_page' => $number
		);

		if ($category != "") {
			$args['testimonials_category'] = $category;
		}

		$html .= "<div class='testimonials_holder clearfix " . $navigation_style . " " . $type . "'>";
		$html .= '<div class="testimonials testimonials_carousel" data-show-navigation="'.$show_navigation.'" data-animation-type="'.$animation_type.'" data-animation-speed="'.$animation_speed.'" data-auto-rotate-slides="'.$auto_rotate_slides.'">';
		$html .= '<ul class="slides">';
		$i = 0;
		$opened = false;
		query_posts($args);
		if (have_posts()) :
			while (have_posts()) : the_post();
				$author = get_post_meta(get_the_ID(), "qode_testimonial-author", true);
				$text = get_post_meta(get_the_ID(), "qode_testimonial-text", true);
				$job = get_post_meta(get_the_ID(), "qode_testimonial-job", true);
				if($type == 'grouped') {
					$i++;
					if($i%3 == 1){
						$html .= '<li id="testimonials' . get_the_ID() . '" class="testimonial_content">';
						$opened = true;
					}
					$html .= '<div class="testimonial_content_grouped_item">';
					$html .= '<div class="testimonial_content_inner">';
					$html .= '<div class="testimonial_text_holder '.$text_align.'">';
					$html .= '<div class="testimonial_text_inner">';
					if($show_author_image == 'yes') {
						$html .= '<div class="testimonial_image_holder">';
						$html .= get_the_post_thumbnail(get_the_ID());
						$html .= '</div>';
					}
					$html .= '<p'. $testimonial_p_style .'>' . trim($text) . '</p>';

					$html .= '<p class="testimonial_author" style="'.$testimonial_name_styles.'">- ' . $author;
					if($show_author_job_position == 'yes') {
						$html .= '<span class="testimonial_author_job">' . $job . '</span>';
					}
					$html .= '</p>';
					$html .= '</div>'; //close testimonial_text_inner
					$html .= '</div>'; //close testimonial_text_holder

					$html .= '</div>'; //close testimonial_content_inner
					$html .= '</div>'; //close testimonial_content_grouped_item

					if($i%3 == 0) {
						$html .= '</li>';
						$opened = false;
					}

				}
				else {
					$html .= '<li id="testimonials' . get_the_ID() . '" class="testimonial_content">';
					$html .= '<div class="testimonial_content_inner">';
					$html .= '<div class="testimonial_text_holder '.$text_align.'">';
					$html .= '<div class="testimonial_text_inner">';
					if($show_author_image == 'yes') {
						$html .= '<div class="testimonial_image_holder">';
						$html .= get_the_post_thumbnail(get_the_ID());
						$html .= '</div>';
					}
					if($show_title == 'yes') {
						$html .= '<p class="testimonial_title">' . get_the_title(get_the_ID()) . '</p>';
					}
					$html .= '<p'. $testimonial_p_style .'>' . trim($text) . '</p>';

					$html .= '<p class="testimonial_author" style="'.$testimonial_name_styles.'">- ' . $author;
					if($show_author_job_position == 'yes') {
						$html .= '<span class="testimonial_author_job">' . $job . '</span>';
					}
					$html .= '</p>';
					$html .= '</div>'; //close testimonial_text_inner
					$html .= '</div>'; //close testimonial_text_holder

					$html .= '</div>'; //close testimonial_content_inner
					$html .= '</li>'; //close testimonials
				}

			endwhile;
		else:
			$html .= __('Sorry, no posts matched your criteria.', 'qode');
		endif;

		wp_reset_query();
		if($type == 'grouped' && $opened) {
			$html .= '</li>';
		}
		$html .= '</ul>';//close slides
		$html .= '</div>';
		$html .= '</div>';
		return $html;
	}
	add_shortcode('testimonials', 'testimonials');
}
