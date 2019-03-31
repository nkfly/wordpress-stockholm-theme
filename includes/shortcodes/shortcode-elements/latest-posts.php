<?php
/* Latest posts shortcode */

if (!function_exists('latest_post')) {
	function latest_post($atts, $content = null) {
		$blog_hide_comments = "";
		if (isset($qode_options['blog_hide_comments'])) {
			$blog_hide_comments = $qode_options['blog_hide_comments'];
		}

		$qode_like = "on";
		if (isset($qode_options['qode_like'])) {
			$qode_like = $qode_options['qode_like'];
		}

		$args = array(
			"type"       			=> "boxes",
			"number_of_posts"       => "",
			"number_of_columns"     => "",
			"number_of_rows"        => "1",
			"rows"                  => "",
			"order_by"              => "",
			"order"                 => "",
			"category"              => "",
			"text_length"           => "",
			"title_tag"             => "h4",
			"display_category"    	=> "1",
			"display_date"          => "1",
			"display_author"		=> "1",
			"background_color"      => ""
		);

		extract(shortcode_atts($args, $atts));

		$headings_array = array('h2', 'h3', 'h4', 'h5', 'h6');

		//get correct heading value. If provided heading isn't valid get the default one
		$title_tag = (in_array($title_tag, $headings_array)) ? $title_tag : $args['title_tag'];

		//get proper number of posts based on type param
		$posts_number =$type != 'boxes' ? $number_of_posts : $number_of_columns*$number_of_rows;

		$current_page = get_query_var( 'page' ) ? (int) get_query_var( 'page' ) : 1;

		//run query to get posts
		$q = new WP_Query(array(
			'orderby' => $order_by,
			'order' => $order,
			'posts_per_page' => $posts_number,
			'category_name' => $category,
			'page' => $current_page,
			'offset' => ($current_page - 1) * $posts_number
		));

		//get number of columns class for boxes type
		$columns_number = "";
		if($type == 'boxes') {
			switch($number_of_columns) {
				case 1:
					$columns_number = 'one_column';
					break;
				case 2:
					$columns_number = 'two_columns';
					break;
				case 3:
					$columns_number = 'three_columns';
					break;
				case 4:
					$columns_number = 'four_columns';
					break;
				default:
					break;
			}
		}

		//get number of rows class for boxes type
		$rows_number = "";
		if($type == 'boxes') {
			switch($number_of_rows) {
				case 1:
					$rows_number = 'one_row';
					break;
				case 2:
					$rows_number = 'two_rows';
					break;
				case 3:
					$rows_number = 'three_rows';
					break;
				case 4:
					$rows_number = 'four_rows';
					break;
				case 5:
					$rows_number = 'five_rows';
					break;
				default:
					break;
			}
		}

		$html = "";
		$html .= "<div class='latest_post_holder $type $columns_number $rows_number'>";
		$html .= "<ul>";

		while ($q->have_posts()) : $q->the_post();
			$li_classes = "";
			$box_style  = "";

			if($background_color != "" && $type == "boxes"){
				if($background_color == "transparent" || $background_color == "rgba(0,0,0,0.01)"){
					$box_style = "style='background-color: transparent; padding-right: 0; padding-left: 0;'";
				} else{
					$box_style = "style='background-color: ".$background_color.";'";
				}
			}

			$cat = get_the_category();

			$html .= '<li class="clearfix">';

			if($type == "boxes") {
				$html .= '<div class="boxes_image">';
				$html .= '<a href="'.get_permalink().'">'.get_the_post_thumbnail(get_the_ID(), 'portfolio-default').'<span class="latest_post_overlay"><i class="icon_plus" aria-hidden="true"></i></span></a>';
				$html .= '</div>';
			}

			$html .= '<div class="latest_post" '.$box_style.'>';

			if($type == "image_in_box") {
				$html .= '<div class="latest_post_image clearfix">';
				$html .= '<a href="'.get_permalink().'">'.get_the_post_thumbnail(get_the_ID(), 'latest_post_small_image').'</a>';
				$html .= '</div>';
			}

			$html .= '<div class="latest_post_text">';
			if($type == "boxes") {
				if($display_date == '1'){
					$html .= '<span class="date_holder post_info_section">';
					$html .= '<span class="date">' . get_the_time(get_option('date_format')) . '</span>';
					$html .= '</span>';//close date_hour_holder
				}


				if($display_category == '1'){
					$html .= '<div class="latest_post_categories post_info_section">';
					foreach ($cat as $categ) {
						$html .= '<a href="' . get_category_link($categ->term_id) . '">' . $categ->cat_name . ' </a> ';
					}
					$html .= '</div>'; //close span.latest_post_categories
				}

				if($display_author == '1'){
					$html .= '<div class="latest_post_author post_info_section">';
					$html .= '<span>'. __("By", "qode").'</span> <a class="post_author_link" href="'.get_author_posts_url( get_the_author_meta("ID") ).'"><span>'.get_the_author_meta("display_name").'</span></a>';
					$html .= '</div>'; //close span.latest_post_categories
				}
			}
			$html .= '<'.$title_tag.' class="latest_post_title "><a href="' . get_permalink() . '">' . get_the_title() . '</a></'.$title_tag.'>';

			if($type == "image_in_box") {
				$html .= '<div class="post_info_section_holder">';
				if($display_date == '1'){
					$html .= '<span class="date_holder post_info_section">';
					$html .= '<span class="date">' . get_the_time(get_option('date_format')) . '</span>';
					$html .= '</span>';//close date_hour_holder
				}


				if($display_category == '1'){
					$html .= '<div class="latest_post_categories post_info_section">';
					foreach ($cat as $categ) {
						$html .= '<a href="' . get_category_link($categ->term_id) . '">' . $categ->cat_name . ' </a> ';
					}
					$html .= '</div>'; //close span.latest_post_categories
				}

				if($display_author == '1'){
					$html .= '<div class="latest_post_author post_info_section">';
					$html .= '<span>'. __("By", "qode").'</span> <a class="post_author_link" href="'.get_author_posts_url( get_the_author_meta("ID") ).'"><span>'.get_the_author_meta("display_name").'</span></a>';
					$html .= '</div>'; //close span.latest_post_categories
				}
				$html .= '</div>';
			}

			if($text_length != '0' & $type == "boxes") {
				$excerpt = ($text_length > 0) ? substr(get_the_excerpt(), 0, intval($text_length)) : get_the_excerpt();

				$html .= '<p class="excerpt">'.$excerpt.'...</p>';
			}

			if($display_author == '1' && $type == "boxes"){
				$html .= '<div class="post_author_holder">';
				$html .= '<div class="post_author">';
				$html .= '<span>'. __("By", "qode").'</span> <a class="post_author_link" href="'.get_author_posts_url( get_the_author_meta("ID") ).'"><span>'.get_the_author_meta("display_name").'</span></a>';
				$html .= '</div>';
				$html .= '</div>'; //close post_author_holder
			}
			$html .= '</div>'; //close latest_post_text
			$html .= '</div>'; //close latest_post
			$html .= '</li>';
		endwhile;
		wp_reset_query();

		$prev_page = $current_page - 1 >= 1 ? $current_page - 1 : 1;
		$next_page = $current_page + 1 <= $q->max_num_pages ? $current_page + 1 : $q->max_num_pages;
		$radius = 2;
		$index = $current_page - $radius;
		$html .= "</ul>";
		$html .= '<div class="pagination"><ul>';
		$html .= '<li class="previous"><a href="'.home_url( add_query_arg( array('page' => $prev_page), null )) . '"><span class="arrow_carrot-left"></span></a></li>';
		while ($index <= $current_page + $radius) {
			if ($index < 1 || $index > $q->max_num_pages) {
				$index++;
				continue;
			}

			if ($index == $current_page) {
				$html .= '<li><a style="color: black;" href="'.home_url( add_query_arg( array('page' => $index), null )) . '">'.$index.'</a></li>';
			} else {
				$html .= '<li><a href="'.home_url( add_query_arg( array('page' => $index), null )) . '">'.$index.'</a></li>';
			}

			$index++;
		}
		$html .= '<li style="position: initial;" class="next"><a href="'.home_url( add_query_arg( array('page' => $next_page), null )) . '"><span class="arrow_carrot-right"></span></a></li>';
	  $html .= '</ul></div></div>';

		return $html;
	}

	add_shortcode('latest_post', 'latest_post');
}
