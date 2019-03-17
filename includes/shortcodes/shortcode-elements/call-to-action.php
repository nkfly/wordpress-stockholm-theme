<?php
/* Call To Action shortcode */

if (!function_exists('call_to_action')) {
	function call_to_action($atts, $content = null) {
		$args = array(
			"type"						        => "normal",
			"full_width"                        => "yes",
			"content_in_grid"                   => "yes",
			"icon_pack"                     	=> "",
			"fa_icon"                       	=> "",
			"fe_icon"                       	=> "",
			"linear_icon"                       => "",
			"icon_size"					        => "",
			"icon_color"				        => "",
			"custom_icon"				        => "",
			"background_color"                  => "",
			"border_color"                      => "",
			"box_padding"                       => "",
			"show_button"                       => "yes",
			"button_size"                       => "",
			"button_link"                       => "",
			"button_text"                       => "",
			"button_target"                     => "",
			"button_text_color"                 => "",
			"button_hover_text_color"           => "",
			"button_background_color"           => "",
			"button_hover_background_color"     => "",
			"button_border_color"               => "",
			"button_hover_border_color"         => "",
			"text_color"                        => "", //used only when shortcode is called from call to action widget
			"text_size"                         => ""
		);

		extract(shortcode_atts($args, $atts));

		$html                   = '';
		$action_classes         = '';
		$action_styles          = '';
		$text_wrapper_classes   = '';
		$button_styles          = '';
		$icon_styles			= '';
		$data_attr              = '';
		$content_styles         = '';

		if($show_button == 'yes') {
			$text_wrapper_classes   .= 'column1';
		}

		if($background_color != '') {
			$action_styles .= 'background-color: '.$background_color.';';
		}
		$action_classes .= $type;
		if($border_color != '') {
			$action_styles .= 'border-top: 1px solid '.$border_color.';';
		}
		if($box_padding != '') {
			$action_styles .= 'padding: '.$box_padding.';';
		}

		if($button_text_color != '') {
			$button_styles .= 'color:'.$button_text_color.';';
		}
		if($icon_color != "") {
			$icon_styles .= " color:".$icon_color . ";";
		}

		if($icon_size != '') {
			$icon_styles .= 'font-size:'.$icon_size.'px;';
		}

		if($button_border_color != '') {
			$button_styles .= 'border-color:'.$button_border_color.';';
		}

		if($button_background_color != '') {
			$button_styles .= "background-color: {$button_background_color};";

		}

		if($button_hover_background_color != "") {
			$data_attr .= " data-hover-background-color=".$button_hover_background_color." ";
		}

		if($button_hover_border_color != "") {
			$data_attr .= " data-hover-border-color=".$button_hover_border_color." ";
		}

		if($button_hover_text_color != "") {
			$data_attr .= " data-hover-color=".$button_hover_text_color;
		}

		if($full_width == "no") {
			$html .= '<div class="container_inner">';
		}

		$html.=  '<div class="call_to_action '.$action_classes.'" style="'.$action_styles.'">';

		if($content_in_grid == 'yes' && $full_width == 'yes') {
			$html .= '<div class="container_inner">';
		}

		if($show_button == 'yes') {
			$html .= '<div class="two_columns_75_25 clearfix">';
		}

		if($text_size != '') {
			$big_large .= 'font-size:'. $text_size.'px;';
		}

		if($text_color != '') {
			$content_styles .= 'color:'.$text_color.';';
		}

		$html .= '<div class="text_wrapper '.$text_wrapper_classes.'">';

		if($type == "with_icon"){
			$html .= '<div class="call_to_action_icon_holder">';
			$html .= '<div class="call_to_action_icon">';
			$html .= '<div class="call_to_action_icon_inner">';
			if($custom_icon != "") {
				if(is_numeric($custom_icon)) {
					$custom_icon_src = wp_get_attachment_url( $custom_icon );
				} else {
					$custom_icon_src = $custom_icon;
				}

				$html .= '<img src="' . $custom_icon_src . '" alt="">';
			} elseif($icon_pack == 'font_awesome' && $fa_icon != '') {
				$html .= '<i class="call_to_action_icon fa '.$fa_icon.'" style="'.$icon_styles.'"></i>';
			} elseif($icon_pack == 'font_elegant' && $fe_icon != '') {
				$html .= '<span class="call_to_action_icon q_font_elegant_icon '.$fe_icon.'" aria-hidden="true" style="'.$icon_styles.'"></span>';
			} elseif($icon_pack == 'linear_icons' && $linear_icon != '') {
				$html .= '<i class="call_to_action_icon q_linear_icons_icon lnr '.$linear_icon.'"  style="'.$icon_styles.'"></i>';
			}

			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
		}

		$html .= '<div class="call_to_action_text" style="'.$content_styles.'">'.do_shortcode($content).'</div>';
		$html .= '</div>'; //close text_wrapper

		if($show_button == 'yes') {
			$button_link = ($button_link != '') ? $button_link : 'javascript: void(0)';
			if($button_target == ""){
				$button_target = "_self";
			}

			$html .= '<div class="button_wrapper column2">';
			$html .= '<a href="'.$button_link.'" class="qbutton '. $button_size . '" target="'.$button_target.'" style="'.$button_styles.'"'. $data_attr . '>'.$button_text.'</a>';
			$html .= '</div>';//close button_wrapper
		}

		if($show_button == 'yes') {
			$html .= '</div>'; //close two_columns_75_25 if opened
		}

		if($content_in_grid == 'yes' && $full_width == 'yes') {
			$html .= '</div>'; // close .container_inner if oppened
		}

		$html .= '</div>';//close .call_to_action

		if($full_width == 'no') {
			$html .= '</div>'; // close .container_inner if oppened
		}

		return $html;
	}
	add_shortcode('call_to_action', 'call_to_action');
}