<?php
if(!function_exists('qode_add_product_list_shortcode')) {
	function qode_add_product_list_shortcode($shortcodes_class_name) {
		$shortcodes = array(
			'Stockholm\Shortcodes\ProductListElegant\ProductListElegant',
		);

		$shortcodes_class_name = array_merge($shortcodes_class_name, $shortcodes);

		return $shortcodes_class_name;
	}

	add_filter('qode_add_vc_shortcode', 'qode_add_product_list_shortcode');
}

if(!function_exists('qode_if_quicklook_or_wishlist_are_installed_class')) {
	function qode_if_quicklook_or_wishlist_are_installed_class(){
		if(qode_is_yith_wcqv_install() || qode_is_yith_wcwl_install()) {
			echo 'qode-has-additional-info';
		}
	}
}