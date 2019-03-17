<?php
/* Portfolio Slider shortcode */

if (!function_exists('portfolio_slider')) {
	function portfolio_slider( $atts, $content = null ) {

		global $qode_options;
		$portfolio_qode_like = "on";
		if (isset($qode_options['portfolio_qode_like'])) {
			$portfolio_qode_like = $qode_options['portfolio_qode_like'];
		}

		$args = array(
			"order_by"          =>  "menu_order",
			"order"             =>  "ASC",
			"number"            =>  "-1",
			"category"          =>  "",
			"selected_projects" =>  "",
			"disable_link"      => "no",
			"lightbox"          => "yes",
			"show_like"         => "yes",
			"title_tag"         =>  "h5",
			"image_size"        =>  "portfolio-square",
			"enable_navigation" =>  ""
		);
		extract(shortcode_atts($args, $atts));

		$headings_array = array('h2', 'h3', 'h4', 'h5', 'h6');

		//get correct heading value. If provided heading isn't valid get the default one
		$title_tag = (in_array($title_tag, $headings_array)) ? $title_tag : $args['title_tag'];

		$portfolio_list_hide_category = false;
		if (isset($qode_options['portfolio_list_hide_category']) && $qode_options['portfolio_list_hide_category'] == "yes") {
			$portfolio_list_hide_category = true;
		}



		$html = "";
		$lightbox_slug = 'portfolio_slider_'.rand();


		$html .= "<div class='portfolio_slider_holder clearfix'><div class='portfolio_slider'><ul class='portfolio_slides'>";

		if ($category == "") {
			$q = array(
				'post_type' => 'portfolio_page',
				'orderby' => $order_by,
				'order' => $order,
				'posts_per_page' => $number
			);
		} else {
			$q = array(
				'post_type' => 'portfolio_page',
				'portfolio_category' => $category,
				'orderby' => $order_by,
				'order' => $order,
				'posts_per_page' => $number
			);
		}

		$project_ids = null;
		if ($selected_projects != "") {
			$project_ids = explode(",", $selected_projects);
			$q['post__in'] = $project_ids;
		}

		query_posts($q);

		if ( have_posts() ) : $postCount = 0; while ( have_posts() ) : the_post();

			$title = get_the_title();
			$terms = wp_get_post_terms(get_the_ID(), 'portfolio_category');

			//get proper image size
			switch($image_size) {
				case 'landscape':
					$thumb_size = 'portfolio-landscape';
					break;
				case 'portrait':
					$thumb_size = 'portfolio-portrait';
					break;
				case 'square':
					$thumb_size = 'portfolio-square';
					break;
				case 'full':
					$thumb_size = 'full';
					break;
				default:
					$thumb_size = 'portfolio-default';
					break;
			}

			$featured_image_array = wp_get_attachment_image_src(get_post_thumbnail_id(), $thumb_size);

			if(get_post_meta(get_the_ID(), 'qode_portfolio-lightbox-link', true) != ""){
				$large_image = get_post_meta(get_the_ID(), 'qode_portfolio-lightbox-link', true);
			} else {
				$large_image = $featured_image_array[0];
			}

			$custom_portfolio_link = get_post_meta(get_the_ID(), 'qode_portfolio-external-link', true);
			$portfolio_link = $custom_portfolio_link != "" ? $custom_portfolio_link : get_permalink();
			if(get_post_meta(get_the_ID(), 'qode_portfolio-external-link-target', true) != ""){
				$custom_portfolio_link_target = get_post_meta(get_the_ID(), 'qode_portfolio-external-link-target', true);
			} else {
				$custom_portfolio_link_target = '_blank';
			}

			$target = $custom_portfolio_link != "" ? $custom_portfolio_link_target : '_self';

			$html .= "<li class='item'>";
			$html .= "<div class='image_holder'>";
			$html .= "<span class='image'>";
			$html .= get_the_post_thumbnail(get_the_ID(), $thumb_size);
			$html .= "</span>"; /* close span.image */

			if($disable_link != "yes"){
				$html .= "<a class='portfolio_link_class' href='" . $portfolio_link . "' target='".$target."'></a>";
			}

			$html .= '<div class="portfolio_shader"></div>';

			$html .= '<div class="text_holder">';
			if(!$portfolio_list_hide_category){
				$html .= '<span class="project_category">';
				$html .= '<span>'. __('In ', 'qode') .'</span>';
				$k = 1;
				foreach ($terms as $term) {
					$html .= "$term->name";
					if (count($terms) != $k) {
						$html .= '/ ';
					}
					$k++;
				}
				$html .= '</span>';
			}

			$html .= '<'.$title_tag.' class="portfolio_title">' . get_the_title() . '</'.$title_tag.'>';

			$html .= "</div>";

			$html .= '<div class="icons_holder"><div class="icons_holder_inner">';
			if ($lightbox == "yes") {
				$html .= "<a class='portfolio_lightbox' title='" . $title . "' href='" . $large_image . "' data-rel='prettyPhoto[" . $lightbox_slug . "]'></a>";
			}

			if ($portfolio_qode_like == "on" && $show_like == "yes") {
				if (function_exists('qode_like_portfolio_list')) {
					$html .= qode_like_portfolio_list(get_the_ID());
				}
			}
			$html .= "</div></div>";
			$html .= "</div>"; /* close div.image_holder */
			$html .= "</li>";

			$postCount++;

		endwhile;

		else:
			$html .= __('Sorry, no posts matched your criteria.','qode');
		endif;

		wp_reset_query();

		$html .= "</ul>";
		if($enable_navigation){
			$html .= '<ul class="caroufredsel-direction-nav"><li><a id="caroufredsel-prev" class="caroufredsel-prev" href="#"><span class="arrow_carrot-left"></span></a></li><li><a class="caroufredsel-next" id="caroufredsel-next" href="#"><span class="arrow_carrot-right"></span></a></li></ul>';
		}
		$html .= "</div></div>";

		return $html;
	}
	add_shortcode('portfolio_slider', 'portfolio_slider');
}