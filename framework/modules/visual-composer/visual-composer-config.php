<?php
/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
if(function_exists('vc_set_as_theme')) vc_set_as_theme(true);

// Initialising Shortcodes
if (class_exists('WPBakeryVisualComposerAbstract')) {
	function qode_require_vc_extend(){
		require_once locate_template('/extendvc/extend-vc.php');

		do_action('qode_vc_map');
	}
	add_action('init', 'qode_require_vc_extend', 11);
}