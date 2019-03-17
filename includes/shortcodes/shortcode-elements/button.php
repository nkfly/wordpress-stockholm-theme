<?php
/* Button shortcode */

if (!function_exists('button')) {
	function qbutton($atts, $content = null) {
		global $qode_options;

		$args = array(
			"size"                      => "",
			"style"                     => "",
			"text"                      => "",
			"icon_pack"              	=> "",
			"fa_icon"                	=> "",
			"fe_icon"                	=> "",
			"linear_icon"               => "",
			"icon_color"                => "",
			"icon_size"                 => "",
			"link"                      => "",
			"target"                    => "_self",
			"color"                     => "",
			"hover_color"               => "",
			"background_color"			=> "",
			"hover_background_color"    => "",
			"border_color"              => "",
			"hover_border_color"        => "",
			"font_size"                 => "",
			"font_style"                => "",
			"font_weight"               => "",
			"text_align"                => "",
			"margin"					=> "",
			"border_radius"				=> "",
			'hover_animation'			=> "",
			'custom_class'				=> ""
		);

		extract(shortcode_atts($args, $atts));

		if($target == ""){
			$target = "_self";
		}

		//init variables
		$html  = "";
		$button_classes 	= "qbutton ";
		$icon_classes 		= "";
		$button_styles  	= "";
		$add_icon       	= "";
		$additional_html	= "";
		$data_attr      	= "";

		if($size != "") {
			$button_classes .= " {$size}";
		}

		if($text_align != "") {
			$button_classes .= " {$text_align}";
		}

		if($hover_animation != "") {
			$button_classes .= " {$hover_animation}";
		}

		if($custom_class != "") {
			$button_classes .= " {$custom_class}";
		}

		if($style != "") {
			$button_classes .= " {$style}";
		}
		if($color != ""){
			$button_styles .= 'color: '.$color.'; ';
		}

		if($border_color != ""){
			$button_styles .= 'border-color: '.$border_color.'; ';
		}

		if($font_style != ""){
			$button_styles .= 'font-style: '.$font_style.'; ';
		}

		if($font_weight != ""){
			$button_styles .= 'font-weight: '.$font_weight.'; ';
		}

		if($font_size != ""){
			$button_styles .= 'font-size: '.$font_size.'px; ';
		}

		if($icon_pack != ""){
			$icon_style = "";
			$button_classes .= " qbutton_with_icon";
			if($icon_color != ""){
				$icon_style .= 'color: '.$icon_color.';';
			}

			if($icon_size != ""){
				$icon_style .= 'font-size: '.$icon_size.'px;';
				$icon_classes .= " custom_icon_size";
			}

			if($icon_pack == 'font_awesome' && $fa_icon != '')
				$add_icon .= '<i class="button_icon ' . $icon_classes . ' fa '.$fa_icon.'" style="'.$icon_style.'"></i>';
			elseif ($icon_pack == 'font_elegant' && $fe_icon != ''){
				$add_icon .= '<span class="button_icon ' . $icon_classes . ' q_font_elegant_icon '.$fe_icon.'" aria-hidden="true" style="'.$icon_style.'"></span>';
			}
			else if($icon_pack == 'linear_icons' && $linear_icon != '') {
				$add_icon .= '<i class="button_icon ' . $icon_classes . ' q_linear_icons_icon lnr '.$linear_icon.'" style="'.$icon_style.'"></i>';
			}
		}

		if($margin != ""){
			$button_styles .= 'margin: '.$margin.'; ';
		}

		if($border_radius != ""){
			$button_styles .= 'border-radius: '.$border_radius.'px;-moz-border-radius: '.$border_radius.'px;-webkit-border-radius: '.$border_radius.'px; ';
		}

		if($background_color != "" ) {
			$button_styles .= "background-color: {$background_color};";
		}

		if($hover_background_color != "") {
			$data_attr .= "data-hover-background-color=".$hover_background_color." ";
		}

		if($hover_border_color != "") {
			$data_attr .= "data-hover-border-color=".$hover_border_color." ";
		}

		if($hover_color != "") {
			$data_attr .= "data-hover-color=".$hover_color;
		}

		if($style == "underlined") {
			$additional_html_style = '';
			if($hover_border_color != "") {
				$additional_html_style = "background-color:".$hover_border_color.";";
			}
			$additional_html = '<span class="qode-underlined-button-span" style="'.$additional_html_style.'"></span>';
		}


		$html .=  '<a href="'.$link.'" target="'.$target.'" '.$data_attr.' class="'.$button_classes.'" style="'.$button_styles.'">'.$text.$add_icon.$additional_html.'</a>';

		return $html;
	}
	add_shortcode('qbutton', 'qbutton');
}

if ( ! function_exists( 'qode_get_button_html' ) ) {
	/**
	 * Calls button shortcode with given parameters and returns it's output
	 *
	 * @param $params
	 *
	 * @return mixed|string
	 */
	function qode_get_button_html( $params ) {
		$button_html = qode_execute_shortcode( 'qbutton', $params );
		$button_html = str_replace( "\n", '', $button_html );

		return $button_html;
	}
}