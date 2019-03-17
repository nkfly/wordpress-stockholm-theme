<?php

if(!function_exists('qode_add_parallax_holder_shortcode')) {
	function qode_add_parallax_holder_shortcode($shortcodes_class_name) {
		$shortcodes = array(
			'Stockholm\Shortcodes\ParallaxHolder\ParallaxHolder'
		);
		
		$shortcodes_class_name = array_merge($shortcodes_class_name, $shortcodes);
		
		return $shortcodes_class_name;
	}
	
	add_filter('qode_add_vc_shortcode', 'qode_add_parallax_holder_shortcode');
}

if(class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_Qode_Parallax_Holder extends WPBakeryShortCodesContainer {}
}