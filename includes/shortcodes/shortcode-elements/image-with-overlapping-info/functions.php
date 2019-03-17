<?php

if(!function_exists('qode_add_image_with_overlapping_info_shortcodes')) {
	function qode_add_image_with_overlapping_info_shortcodes($shortcodes_class_name) {
		$shortcodes = array(
			'Stockholm\Shortcodes\ImageWithOverlappingInfo\ImageWithOverlappingInfo'
		);
		
		$shortcodes_class_name = array_merge($shortcodes_class_name, $shortcodes);
		
		return $shortcodes_class_name;
	}
	
	add_filter('qode_add_vc_shortcode', 'qode_add_image_with_overlapping_info_shortcodes');
}