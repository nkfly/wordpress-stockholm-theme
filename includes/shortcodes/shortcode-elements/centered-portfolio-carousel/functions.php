<?php

if(!function_exists('qode_add_centered_portfolio_carousel_shortcodes')) {
	function qode_add_centered_portfolio_carousel_shortcodes($shortcodes_class_name) {
		$shortcodes = array(
			'Stockholm\Shortcodes\CenteredPortfolioCarousel\CenteredPortfolioCarousel'
		);
		
		$shortcodes_class_name = array_merge($shortcodes_class_name, $shortcodes);
		
		return $shortcodes_class_name;
	}
	
	add_filter('qode_add_vc_shortcode', 'qode_add_centered_portfolio_carousel_shortcodes');
}