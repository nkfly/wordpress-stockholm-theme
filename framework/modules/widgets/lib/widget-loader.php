<?php

if (!function_exists('qode_register_widgets')) {
	function qode_register_widgets() {
		$widgets = apply_filters('qode_register_widgets', $widgets = array());

		foreach ($widgets as $widget) {
			register_widget($widget);
		}
	}
	
	add_action('widgets_init', 'qode_register_widgets');
}