<?php
if (!function_exists('qode_sidearea_opener_icon')) {
	function qode_sidearea_opener_icon(){

		$icon = qode_options()->getOptionValue('sidearea_open_icon_type');
		$html = '';

		if($icon != '') {
			switch ($icon):

				case 'font-elegant':

					$html = '<span class="icon_menu"></span>';
					break;
				default:
					$html = '<i class="fa fa-bars"></i>';
					break;
				endswitch;
		}

		echo wp_kses_post($html);
	}
}