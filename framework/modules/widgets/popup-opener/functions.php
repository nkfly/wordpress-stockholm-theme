<?php

if(!function_exists('qode_register_popup_opener_widget')) {
	/**
	 * Function that register search opener widget
	 */
	function qode_register_popup_opener_widget($widgets) {
		$widgets[] = 'QodePopupOpener';

		return $widgets;
	}

	add_filter('qode_register_widgets', 'qode_register_popup_opener_widget');
}