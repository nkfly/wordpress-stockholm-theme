<?php
/* Social Icon shortcode */

if (!function_exists('social_icons')) {
	function social_icons($atts, $content = null) {
		$args = array(
			"type"                   => "",
			"icon_pack"              => "",
			"fa_icon"                => "",
			"fe_icon"                => "",
			"link"                   => "",
			"target"                 => "",
			"size"                   => "",
			"icon_color"             => "",
			"background_color"       => "",
			"border_color"           => "",
			"icon_hover_color"       => "",
			"background_hover_color" => "",
			"border_hover_color"     => ""
		);

		extract(shortcode_atts($args, $atts));

		$html            		= "";
		$fa_stack_styles 		= "";
		$icon_styles     		= "";
		$icon_holder_classes 	= array();
		$data_attr              = "";

		if($link != "") {
			$icon_holder_classes[] = "with_link";
		}

		if($type != "") {
			$icon_holder_classes[] = $type;
		}

		if($icon_color != ""){
			$icon_styles .= "color: ".$icon_color.";";
		}

		if($background_color != ""){
			$fa_stack_styles .= "background-color: {$background_color};";
		}

		if($border_color != ""){
			$fa_stack_styles .= "border: 1px solid {$border_color};";
		}

		if($background_hover_color != "") {
			$data_attr .= "data-hover-background-color=".$background_hover_color." ";
		}

		if($border_hover_color != "") {
			$data_attr .= "data-hover-border-color=".$border_hover_color." ";
		}

		if($icon_hover_color != "") {
			$data_attr .= "data-hover-color=".$icon_hover_color;
		}

		$html .= "<span class='q_social_icon_holder ".implode(' ', $icon_holder_classes)."' $data_attr>";

		if($link != ""){
			$html .= "<a href='".$link."' target='".$target."'>";
		}

		if($type == "normal_social"){

			if($icon_pack == 'font_awesome' && $fa_icon != ""){
				$html .= "<i class='social_icon fa ".$fa_icon." ".$size." simple_social' style='".$icon_styles."'></i>";
			}
			elseif($icon_pack == 'font_elegant' && $fe_icon != ""){
				$html .= "<span class='social_icon ".$fe_icon." ".$size." simple_social' style='".$icon_styles."'></span>";
			}

		} else {

			$html .= "<span class='fa-stack ".$size." ".$type."' style='".$icon_styles.$fa_stack_styles."'>";

			if($icon_pack == 'font_awesome' && $fa_icon != ""){
				$html .= "<i class='social_icon fa ".$fa_icon."'></i>";
			} elseif($icon_pack == 'font_elegant' && $fe_icon != ""){
				$html .= "<span class='social_icon ".$fe_icon."'></span>";
			}

			$html .= "</span>"; //close fa-stack
		}

		if($link != ""){
			$html .= "</a>";
		}

		$html .= "</span>"; //close q_social_icon_holder
		return $html;
	}
	add_shortcode('social_icons', 'social_icons');
}
