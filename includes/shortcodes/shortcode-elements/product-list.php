<?php
/* Product list shortcode */
if (!function_exists('qode_product_list')) {
	function qode_product_list($atts, $content = null)
	{
		global $qode_options;
		$args = array(
			'type' => 'standard',
			'columns' => '4',
			'items_number' => '-1',
			'order_by' => 'date',
			'sort_order' => 'desc',
			'taxonomy_to_display' => 'category',
			'taxonomy_values' => '',
			'display_categories' => 'yes'
		);

		extract(shortcode_atts($args, $atts));
		$params = array();
		$params['display_categories'] = $display_categories;
		if($type == 'standard') {
			do_action('qode_pl_standard_initial_setup', $params);
		}
		else if($type == 'simple') {
			do_action('qode_pl_simple_initial_setup');
		}

		$html = '';

		/* Get query args */
		$args = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1,
			'orderby' => $order_by,
			'order' => $sort_order,
			'posts_per_page' => $items_number,
			'meta_query' => WC()->query->get_meta_query()
		);

		if ($taxonomy_to_display != '' && $taxonomy_to_display == 'category') {
			$args['product_cat'] = $taxonomy_values;
		}

		if ($taxonomy_values != '' && $taxonomy_values == 'tag') {
			$args['product_tag'] = $taxonomy_values;
		}

		if ($taxonomy_to_display != '' && $taxonomy_to_display == 'id') {
			$idArray = $taxonomy_values;
			$ids = explode(',', $idArray);
			$args['post__in'] = $ids;
		}

		$products = new \WP_Query($args);
		$html .= '<div class="qodef-product-list-holder">';
		$html .= '<div class="woocommerce columns-' . $columns . '">';
		$html .= '<ul class="products ' . $type . '">';
		ob_start();
		if ($products->have_posts()) :
			while ($products->have_posts()) : $products->the_post();
				$html .= get_template_part('templates/product-list/'.$type.'-loop');
			endwhile;
		endif;
		$output = ob_get_contents();
		ob_end_clean();
		$html .= $output;

		woocommerce_reset_loop();
		wp_reset_postdata();

		$html .= '</ul>';
		$html .= '</div>';
		$html .= '</div>';

		return $html;

	}
	add_shortcode('qode_product_list', 'qode_product_list');
}