<?php

if (!function_exists('qode_woocommerce_single_number_of_thumbs')) {
	/**
	 * Function for overriding product number of thumbs
	 */
	function qode_woocommerce_single_number_of_thumbs() {
		$number_of_thumbs = qode_options()->getOptionValue('woo_product_single_thumb_number');
		return $number_of_thumbs;
	}
	add_filter('woocommerce_product_thumbnails_columns','qode_woocommerce_single_number_of_thumbs');
}

if (!function_exists('qode_elegant_woocommerce_template_loop_product_title')) {
	/**
	 * Function for overriding product title template in Product List Loop
	 */
	function qode_elegant_woocommerce_template_loop_product_title() {
		the_title('<h6 class="qode-product-list-title"><a href="'.get_the_permalink().'">', '</a></h6>');
	}
}

if (!function_exists('qode_elegant_woocommerce_sale_flash')) {
	/**
	 * Function for overriding Sale Flash Template
	 *
	 * @return string
	 */
	function qode_elegant_woocommerce_sale_flash() {
		global $product;

		if ( version_compare( WOOCOMMERCE_VERSION, '3.0' ) >= 0 ) {
			$product_regular_price = $product->get_regular_price();
			$product_sale_price = $product->get_sale_price();
		} else {
			$product_regular_price = $product->regular_price;
			$product_sale_price = $product->sale_price;
		}

		if ($product->is_in_stock() && !$product->has_child()) { //second condition is for variable products that has variations with different prices
			return '<span class="qode-onsale">' . qode_woocommerce_sale_percentage(intval($product_regular_price), intval($product_sale_price)) . '</span>';
		}
	}
}

if (!function_exists('qode_elegant_woocommerce_product_out_of_stock')) {
	/**
	 * Function for adding Out Of Stock Template
	 *
	 * @return string
	 */
	function qode_elegant_woocommerce_product_out_of_stock() {

		global $product;

		if (!$product->is_in_stock()) {
			print '<span class="qode-out-of-stock">' . esc_html__('SOLD', 'depot') . '</span>';
		}
	}
}

if (!function_exists('qode_elegant_woocommerce_new_product_mark')) {
	/**
	 * Function for adding New Product Template
	 *
	 * @return string
	 */
	function qode_elegant_woocommerce_new_product_mark() {
		global $product;

		if ( version_compare( WOOCOMMERCE_VERSION, '3.0' ) >= 0 ) {
			$product_id = $product->get_id();
		} else {
			$product_id = $product->id;
		}

		if (get_post_meta($product_id, 'qode_single_product_new_meta', true) === 'yes') {
			print '<span class="qode-new-product">' . esc_html__('NEW', 'depot') . '</span>';
		}

	}
}

if (!function_exists('qode_elegant_woocommerce_template_loop_add_to_cart')) {
	/**
	 * Function for adding woo button to list
	 *
	 * @return string
	 */
	function qode_elegant_woocommerce_template_loop_add_to_cart() {
		global $product;

		if ( version_compare( WOOCOMMERCE_VERSION, '3.0' ) >= 0 ) {
			$product_id = $product->get_id();
			$product_type = $product->get_type();
		} else {
			$product_id = $product->id;
			$product_type = $product->product_type;
		}

		if (!$product->is_in_stock()) {
			$button_classes = 'ajax_add_to_cart qode-button qode-read-more-button';
		} else if ($product_type === 'variable') {
			$button_classes = 'product_type_variable add_to_cart_button qode-variable qode-button';
		} else if ($product_type === 'external') {
			$button_classes = 'product_type_external qode-external qode-button';
		} else if ($product_type === 'grouped') {
			$button_classes = 'add_to_cart_button ajax_add_to_cart qode-grouped qode-button';
		}else {
			$button_classes = 'add_to_cart_button ajax_add_to_cart qode-add-to-cart qode-button';
		}

		echo '<div class="qode-pl-add-to-cart">';
		echo apply_filters( 'woocommerce_loop_add_to_cart_link',
			sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
				esc_url( $product->add_to_cart_url() ),
				esc_attr( isset( $quantity ) ? $quantity : 1 ),
				esc_attr( $product_id ),
				esc_attr( $product->get_sku() ),
				esc_attr( $button_classes ),
				esc_html( $product->add_to_cart_text() )
			),
			$product );
		echo '</div>';
	}
}

if (!function_exists('qode_elegant_pl_holder_additional_tag_before')) {
	function qode_elegant_pl_holder_additional_tag_before() {

		print '<div class="qode-elegant-pl-main-holder">';
	}
}

if (!function_exists('qode_elegant_pl_holder_additional_tag_after')) {
	function qode_elegant_pl_holder_additional_tag_after() {

		print '</div>';
	}
}

if (!function_exists('qode_elegant_pl_inner_additional_tag_before')) {
	function qode_elegant_pl_inner_additional_tag_before() {

		print '<div class="qode-pl-inner">';
	}
}

if (!function_exists('qode_elegant_pl_inner_additional_tag_after')) {
	function qode_elegant_pl_inner_additional_tag_after() {

		print '</div>';
	}
}

if (!function_exists('qode_elegant_pl_image_additional_tag_before')) {
	function qode_elegant_pl_image_additional_tag_before() {

		print '<div class="qode-pl-image">';
	}
}

if (!function_exists('qode_elegant_pl_image_additional_tag_after')) {
	function qode_elegant_pl_image_additional_tag_after() {

		print '</div>';
	}
}

if (!function_exists('qode_elegant_pl_inner_text_additional_tag_before')) {
	function qode_elegant_pl_inner_text_additional_tag_before() {

		print '<div class="qode-pl-text"><div class="qode-pl-text-outer"><div class="qode-pl-text-inner">';
	}
}

if (!function_exists('qode_elegant_pl_inner_text_additional_tag_after')) {
	function qode_elegant_pl_inner_text_additional_tag_after() {

		print '</div></div></div>';
	}
}

if (!function_exists('qode_elegant_pl_text_wrapper_additional_tag_before')) {
	function qode_elegant_pl_text_wrapper_additional_tag_before() {

		print '<div class="qode-pl-text-wrapper">';
	}
}

if (!function_exists('qode_elegant_pl_text_wrapper_additional_tag_after')) {
	function qode_elegant_pl_text_wrapper_additional_tag_after() {

		print '</div>';
	}
}

if (!function_exists('qode_elegant_pl_categories')) {
	function qode_elegant_pl_categories() {
		$product = qode_return_woocommerce_global_variable();
		$categories_html = '';

		if ( version_compare( WOOCOMMERCE_VERSION, '3.0' ) >= 0 ) {
			$product_categories = wc_get_product_category_list( $product->get_id(), ', ' );
		} else {
			$product_categories = $product->get_categories(', ');
		}

		if (!empty($product_categories)) {
			$categories_html = '<p class="qode-product-list-category">'.$product_categories.'</p>';
		}

		print $categories_html;
	}
}

if (!function_exists('qode_elegant_pl_additional_info_before')) {
	function qode_elegant_pl_additional_info_before(){
		print '<div class="qode-pl-text"><div class="qode-pl-text-outer"><div class="qode-pl-text-inner"><div class="qode-pl-additional-info">';
	}
}

if (!function_exists('qode_elegant_pl_additional_info')) {
	function qode_elegant_pl_additional_info() {
		echo do_action('qode_woocommerce_additional_info');
	}
}

if (!function_exists('qode_elegant_pl_additional_info_after')) {
	function qode_elegant_pl_additional_info_after(){
		print '</div></div></div></div>';
	}
}


