<?php

if(!function_exists('qode_add_content_slider_shortcodes')) {
	function qode_add_content_slider_shortcodes($shortcodes_class_name) {
		$shortcodes = array(
			'Stockholm\Shortcodes\ContentSlider\ContentSlider',
			'Stockholm\Shortcodes\ContentSlide\ContentSlide'
		);
		
		$shortcodes_class_name = array_merge($shortcodes_class_name, $shortcodes);
		
		return $shortcodes_class_name;
	}
	
	add_filter('qode_add_vc_shortcode', 'qode_add_content_slider_shortcodes');
}

if(class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_Qode_Content_Slider extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Qode_Content_Slide extends WPBakeryShortCodesContainer {}
}