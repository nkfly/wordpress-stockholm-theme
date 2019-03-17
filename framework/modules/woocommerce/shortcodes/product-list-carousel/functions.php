<?php
if(!function_exists('qode_add_product_list_carousel_shortcode')) {
	function qode_add_product_list_carousel_shortcode($shortcodes_class_name) {
		$shortcodes = array(
			'Stockholm\Shortcodes\ProductListElegantCarousel\ProductListElegantCarousel',
		);

		$shortcodes_class_name = array_merge($shortcodes_class_name, $shortcodes);

		return $shortcodes_class_name;
	}

	add_filter('qode_add_vc_shortcode', 'qode_add_product_list_carousel_shortcode');
}