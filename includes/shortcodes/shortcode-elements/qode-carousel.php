<?php
/* Qode Carousel shortcode */

if (!function_exists('qode_carousel')) {
	function qode_carousel( $atts, $content = null ) {
		$args = array(
			"carousel" 					=> "",
			"items_visible" 			=> "5",
			"order_by"  				=> "date",
			"order"    					=> "ASC",
			"show_navigation"			=> "",
			"show_draggable_navigation"	=> "",
			"show_in_two_rows" 			=> "",
			"space_between" 			=> "no",
			"hover_effect" 				=> "second_image",
			"on_click" 					=> "open_link",
			"carousel_type"				=> ""
		);

		extract(shortcode_atts($args, $atts));

		$html = "";
		$data = "";


		if ($carousel != "") {
			$carousel_holder_classes = array();
			$carousel_type_classes = "";

			if ($carousel_type == "carousel_owl") {
				$carousel_type_classes = 'carousel_owl';
			}

			if ($show_in_two_rows == 'yes') {
				$carousel_holder_classes[] = 'two_rows';
			}

			if ($items_visible != "") {
				$data .= 'data-number_of_items = ' . $items_visible;
			}

			if ($space_between == 'yes') {
				$carousel_holder_classes[] = 'with_space';
			}

			if ($hover_effect == 'second_image') {
				$carousel_holder_classes[] = 'hover_second_image';
			} else if ($hover_effect == 'overlay') {
				$carousel_holder_classes[] = 'hover_overlay';
			}



			if ($carousel_type == "carousel_owl") {
				$draggable_data = array();
				if(!empty($show_draggable_navigation)) {
					$draggable_data['data-enable-navigation'] = $show_draggable_navigation;
				}
				$html .= "<div class='qode_carousels_holder clearfix ".implode(' ', $carousel_holder_classes)."'><div class='qode_carousels " .$carousel_type_classes. "'". qode_get_inline_attrs($draggable_data) ."><div class='slides'>";

				$q = array('post_type'=> 'carousels', 'carousels_category' => $carousel, 'orderby' => $order_by, 'order' => $order, 'posts_per_page' => '-1');

				$pretty_rel_random = ' data-rel="prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']"';

				query_posts($q);
				$have_posts = false;

				if ( have_posts() ) : $post_count = 1; $have_posts = true; while ( have_posts() ) : the_post();

					if(get_post_meta(get_the_ID(), "qode_carousel-image", true) != "") {
						$image = get_post_meta(get_the_ID(), "qode_carousel-image", true);
					} else {
						$image = "";
					}

					if(get_post_meta(get_the_ID(), "qode_carousel-hover-image", true) != ""){
						$hover_image = get_post_meta(get_the_ID(), "qode_carousel-hover-image", true);
						$has_hover_image = "has_hover_image";
					} else {
						$hover_image = "";
						$has_hover_image = "";
					}

					if(get_post_meta(get_the_ID(), "qode_carousel-item-link", true) != ""){
						$link = get_post_meta(get_the_ID(), "qode_carousel-item-link", true);
					} else {
						$link = "";
					}

					if(get_post_meta(get_the_ID(), "qode_carousel-item-target", true) != ""){
						$target = get_post_meta(get_the_ID(), "qode_carousel-item-target", true);
					} else {
						$target = "_self";
					}

					$title = get_the_title();

					//is current item not on even position in array and two rows option is chosen?
					if($post_count % 2 !== 0 && $show_in_two_rows == 'yes') {
						$html .= "<div class='item'>";
					} elseif($show_in_two_rows == '') {
						$html .= "<div class='item'>";
					}

					$html .= '<div class="carousel_item_holder">';

					if($link != "" && $on_click == 'open_link'){
						$html .= "<a href='".$link."' target='".$target."'>";
					}
					else if ($on_click == 'prettyphoto') {
						$html .= "<a class='prettyphoto' href='" . $image . "'" . $pretty_rel_random . ">";
					}

					if($image != ""){
						$html .= "<span class='first_image_holder ".$has_hover_image."'><img src='".$image."' alt='".$title."'></span>";
					}

					if($hover_image != "" && $hover_effect == 'second_image'){
						$html .= "<span class='second_image_holder ".$has_hover_image."'><img src='".$hover_image."' alt='".$title."'></span>";
					}

					else if($hover_effect == 'overlay') {
						$html .= "<span class='carousel_image_overlay'></span>";
					}

					if($link != "" || $on_click == 'prettyphoto'){
						$html .= "</a>";
					}

					$html .= '</div>';

					//is current item on even position in array and two rows option is chosen?
					if($post_count % 2 == 0 && $show_in_two_rows == 'yes') {
						$html .= "</div>";
					} elseif($show_in_two_rows == '') {
						$html .= "</div>";
					}

					$post_count++;

				endwhile;

				else:
					$html .= __('Sorry, no posts matched your criteria.','qode');
				endif;

				wp_reset_query();

				$html .= "</div>";

				$html .= "</div></div>";

			} else {

				$html .= "<div class='qode_carousels_holder clearfix " . implode(' ', $carousel_holder_classes) . "'><div class='qode_carousels " . $carousel_type_classes . "' " . $data . "><ul class='slides'>";

				$q = array('post_type' => 'carousels', 'carousels_category' => $carousel, 'orderby' => $order_by, 'order' => $order, 'posts_per_page' => '-1');

				$pretty_rel_random = ' data-rel="prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']"';

				query_posts($q);
				$have_posts = false;

				if (have_posts()) : $post_count = 1;
					$have_posts = true;
					while (have_posts()) : the_post();

						if (get_post_meta(get_the_ID(), "qode_carousel-image", true) != "") {
							$image = get_post_meta(get_the_ID(), "qode_carousel-image", true);
						} else {
							$image = "";
						}

						if (get_post_meta(get_the_ID(), "qode_carousel-hover-image", true) != "") {
							$hover_image = get_post_meta(get_the_ID(), "qode_carousel-hover-image", true);
							$has_hover_image = "has_hover_image";
						} else {
							$hover_image = "";
							$has_hover_image = "";
						}

						if (get_post_meta(get_the_ID(), "qode_carousel-item-link", true) != "") {
							$link = get_post_meta(get_the_ID(), "qode_carousel-item-link", true);
						} else {
							$link = "";
						}

						if (get_post_meta(get_the_ID(), "qode_carousel-item-target", true) != "") {
							$target = get_post_meta(get_the_ID(), "qode_carousel-item-target", true);
						} else {
							$target = "_self";
						}

						$title = get_the_title();

						//is current item not on even position in array and two rows option is chosen?
						if ($post_count % 2 !== 0 && $show_in_two_rows == 'yes') {
							$html .= "<li class='item'>";
						} elseif ($show_in_two_rows == '') {
							$html .= "<li class='item'>";
						}

						$html .= '<div class="carousel_item_holder">';

						if ($link != "" && $on_click == 'open_link') {
							$html .= "<a href='" . $link . "' target='" . $target . "'>";
						} else if ($on_click == 'prettyphoto') {
							$html .= "<a class='prettyphoto' href='" . $image . "'" . $pretty_rel_random . ">";
						}

						if ($image != "") {
							$html .= "<span class='first_image_holder " . $has_hover_image . "'><img src='" . $image . "' alt='" . $title . "'></span>";
						}

						if ($hover_image != "" && $hover_effect == 'second_image') {
							$html .= "<span class='second_image_holder " . $has_hover_image . "'><img src='" . $hover_image . "' alt='" . $title . "'></span>";
						} else if ($hover_effect == 'overlay') {
							$html .= "<span class='carousel_image_overlay'></span>";
						}

						if ($link != "" || $on_click == 'prettyphoto') {
							$html .= "</a>";
						}

						$html .= '</div>';

						//is current item on even position in array and two rows option is chosen?
						if ($post_count % 2 == 0 && $show_in_two_rows == 'yes') {
							$html .= "</li>";
						} elseif ($show_in_two_rows == '') {
							$html .= "</li>";
						}

						$post_count++;

					endwhile;

				else:
					$html .= __('Sorry, no posts matched your criteria.', 'qode');
				endif;

				wp_reset_query();

				$html .= "</ul>";

				if ($show_navigation != 'no' && $have_posts) {
					//generate navigation html
					$html .= '<ul class="caroufredsel-direction-nav">';

					$html .= '<li class="caroufredsel-prev-holder">';

					$html .= '<a id="caroufredsel-prev" class="qode_carousel_prev caroufredsel-navigation-item caroufredsel-prev" href="javascript: void(0)">';

					$html .= '<span class="arrow_carrot-left"></span>';

					$html .= '</a>';

					$html .= '</li>'; //close li.caroufredsel-prev-holder

					$html .= '<li class="caroufredsel-next-holder">';
					$html .= '<a class="qode_carousel_next caroufredsel-next caroufredsel-navigation-item" id="caroufredsel-next" href="javascript: void(0)">';

					$html .= '<span class="arrow_carrot-right"></span>';

					$html .= '</a>';

					$html .= '</li>'; //close li.caroufredsel-next-holder

					$html .= '</ul>'; //close ul.caroufredsel-direction-nav
				}
				$html .= "</div></div>";

			}
		}

		return $html;
	}
	add_shortcode('qode_carousel', 'qode_carousel');
}
