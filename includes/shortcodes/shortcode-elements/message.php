<?php
/* Message shortcode */

if (!function_exists('message')) {
	function message($atts, $content = null) {
		global $qode_options;

		$args = array(
			"type"                  => "",
			"background_color"      => "",
			"border_color"          => "",
			"border_width"          => "",
			"icon_pack"             => "",
			"fa_icon"               => "",
			"fe_icon"               => "",
			"linear_icon"           => "",
			"icon_size"            	=> "fa-2x",
			"icon_custom_size"      => "",
			"icon_color"            => "",
			"icon_background_color" => "",
			"custom_icon"           => "",
			"close_button_color"    => ""
		);
		extract(shortcode_atts($args, $atts));

		//init variables
		$html               = "";
		$icon_html          = "";
		$message_classes    = "";
		$message_styles     = "";
		$icon_styles        = "";
		$close_button_style = "";

		if($type == "with_icon"){
			$message_classes .= " with_icon";
		}

		if($background_color != "") {
			$message_styles .= "background-color: ".$background_color.";";
		}

		if($border_color != "") {
			if($border_width != ""){
				$message_styles .= "border: ".$border_width."px solid ".$border_color.";";
			} else {
				$message_styles .= "border: 2px solid ".$border_color.";";
			}
		}

		if($icon_color != "") {
			$icon_styles .= "color: ".$icon_color . ";";
		}

		if($icon_background_color != "") {
			$icon_styles .= " background-color: ".$icon_background_color . ";";
		}

		if($icon_custom_size != "") {
			$icon_font_style = ' font-size: '.$icon_custom_size;
			if(!strstr($icon_custom_size, 'px')) {
				$icon_font_style .= 'px';
			}
			$icon_font_style .= ';';
			$icon_styles .= $icon_font_style;
		}

		if($close_button_color != "") {
			$close_button_style .= "color: ".$close_button_color . ";";
		}

		$html .= "<div class='q_message ".$message_classes."' style='".$message_styles."'>";
		$html .= "<div class='q_message_inner'>";
		if($type == "with_icon"){
			$icon_html .= '<div class="q_message_icon_holder"><div class="q_message_icon"><div class="q_message_icon_inner">';
			if($custom_icon != "") {
				if(is_numeric($custom_icon)) {
					$custom_icon_src = wp_get_attachment_url( $custom_icon );
				} else {
					$custom_icon_src = $custom_icon;
				}

				$icon_html .= '<img src="' . $custom_icon_src . '" alt="">';
			} elseif($icon_pack == 'font_awesome' && $fa_icon != "") {
				$icon_html .= "<i class='fa ".$fa_icon." ". $icon_size . "' style='".$icon_styles."'></i>";
			} elseif($icon_pack == 'font_elegant' && $fe_icon != ""){
				$icon_html .= "<span class='q_font_elegant_icon ".$fe_icon."' aria-hidden='true' style='".$icon_styles ."'></span>";
			} elseif($icon_pack == 'linear_icons' && $linear_icon != ""){
				$icon_html .= "<i class='lnr q_linear_icons_icon ".$linear_icon."' style='".$icon_styles ."'></i>";
			}
			$icon_html .= '</div></div></div>';
		}

		$html .= $icon_html;

		$html .= "<a href='#' class='close'>";
		$html .= "<i class='q_font_elegant_icon icon_close' style='".$close_button_style."'></i>";
		$html .= "</a>"; //close a.close

		$html .= "<div class='message_text_holder'><div class='message_text'><div class='message_text_inner'>".do_shortcode($content)."</div></div></div>";

		$html .= "</div></div>"; //close message text div
		return $html;
	}
	add_shortcode('message', 'message');
}
