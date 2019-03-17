<?php
/* Icon List Item shortcode */

if (!function_exists('icon_list_item')) {
	function icon_list_item($atts, $content = null) {
		$args = array(
			"icon_pack"                => "",
			"fa_icon"                  => "",
			"fe_icon"                  => "",
			"linear_icon"              => "",
			"icon_type"                => "",
			"icon_color"               => "",
			"border_type"              => "",
			"border_color"             => "",
			"title"                    => "",
			"title_color"              => "",
			"title_size"               => ""
		);

		extract(shortcode_atts($args, $atts));

		$html           = '';
		$icon_style     = "";
		$icon_classes   = "";
		$title_style    = "";

		$icon_classes .= $icon_type." ";

		if($icon_color != "") {
			$icon_style .= "color:".$icon_color.";";
		}

		if($border_color != "" && $border_type != "") {
			$icon_style .= "border-color: ".$border_color.";";
		}

		if($title_color != "") {
			$title_style .= "color:".$title_color.";";
		}

		if($title_size != "") {
			$title_style .= "font-size: ".$title_size."px;";
		}

		$html .= '<div class="q_icon_list">';
		if($icon_pack == 'font_awesome' && $fa_icon != ''){

			$html .= '<i class="fa '.$fa_icon.' '.$icon_classes.' '.$border_type.'" style="'.$icon_style.'"></i>';

		} elseif($icon_pack == 'font_elegant' && $fe_icon != ''){

			$html .= '<span class="q_font_elegant_icon '.$fe_icon.' '.$icon_classes.' '.$border_type.'" aria-hidden="true" style="'.$icon_style.'"></span>';

		} elseif($icon_pack == 'linear_icons' && $linear_icon != ''){

			$html .= '<i class="lnr q_linear_icons_icon '.$linear_icon.' '.$icon_classes.' '.$border_type.'" aria-hidden="true" style="'.$icon_style.'"></i>';
		}

		$html .= '<p class="'.$icon_classes.'" style="'.$title_style.'">'.$title.'</p>';
		$html .= '</div>';
		return $html;
	}
	add_shortcode('icon_list_item', 'icon_list_item');
}
