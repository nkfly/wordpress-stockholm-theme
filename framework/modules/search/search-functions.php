<?php
if (!function_exists('qode_search_opener_icon')) {
	function qode_search_opener_icon()
	{

		$icon = qode_options()->getOptionValue('search_icon_type');

		switch ($icon):
			case 'font-elegant':
				$html = '<i class="icon_search"></i>';
				break;
			case 'font-linear':
				$html = '<i class="lnr lnr-magnifier"></i>';
				break;
			default:
				$html = '<i class="fa fa-search"></i>';
				break;
		endswitch;

		echo wp_kses_post($html);
	}
}