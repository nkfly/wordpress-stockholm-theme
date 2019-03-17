<?php
/* Progress bars icon shortcode */

if (!function_exists('progress_bar_icon')) {
	function progress_bar_icon($atts, $content = null) {

		$args =  array(
			"icons_number"              => "",
			"active_number"             => "",
			"type"                      => "",
			"icon_pack"                 => "",
			"fa_icon"                   => "",
			"fe_icon"                   => "",
			"linear_icon"               => "",
			"size"                      => "",
			"icon_color"                => "",
			"icon_active_color"         => "",
			"background_color"          => "",
			"background_active_color"   => "",
			"border_color"              => "",
			"border_active_color"       => ""
		);

		extract(shortcode_atts($args, $atts));
		$html =  "<div class='q_progress_bars_icons_holder'><div class='q_progress_bars_icons'><div class='q_progress_bars_icons_inner ".$type." ".$size;

		$html .= " clearfix' data-number='".$active_number."'>";

		$i = 0;
		while ($i < $icons_number) {
			$html .= "<div class='bar'><span class='bar_noactive fa-stack ";
			if($size != ""){
				if($size == "tiny"){
					$html .= "fa-lg";
				} else if($size == "small"){
					$html .= "fa-2x";
				} else if($size == "medium"){
					$html .= "fa-3x";
				} else if($size == "large"){
					$html .= "fa-4x";
				} else if($size == "very_large"){
					$html .= "fa-5x";
				}
			}
			$html .= "'";
			if($type == "circle" || $type == "square"){
				if($background_active_color != "" || $border_active_color != ""){
					$html .= " style='";
					if($background_active_color != ""){
						$html .= "background-color: ".$background_active_color.";";
					}
					if($border_active_color != ""){
						$html .= " border-color: ".$border_active_color.";";
					}
					$html .= "'";
				}
			}
			$html .= ">";

			if($icon_pack == 'font_awesome' && $fa_icon != ''){
				$html .= "<i class='fa fa-stack-1x ".$fa_icon."'";

				if($icon_active_color != ""){
					$html .= " style='color: ".$icon_active_color.";'";
				}

				$html .= "></i>";
			} elseif($icon_pack == 'font_elegant' && $fe_icon != ''){
				$html .= "<span class='q_font_elegant_icon ".$fe_icon."'";

				if($icon_active_color != ""){
					$html .= " style='color: ".$icon_active_color.";'";
				}

				$html .= "></span>";
			} elseif($icon_pack == 'linear_icons' && $linear_icon != ''){
				$html .= "<i class='lnr q_linear_icons_icon ".$linear_icon."'";

				if($icon_active_color != ""){
					$html .= " style='color: ".$icon_active_color.";'";
				}

				$html .= "></i>";
			}

			$html .= "</span><span class='bar_active fa-stack ";
			if($size != ""){
				if($size == "tiny"){
					$html .= "fa-lg";
				} else if($size == "small"){
					$html .= "fa-2x";
				} else if($size == "medium"){
					$html .= "fa-3x";
				} else if($size == "large"){
					$html .= "fa-4x";
				} else if($size == "very_large"){
					$html .= "fa-5x";
				}
			}
			$html .= "'";
			if($type == "circle" || $type == "square"){
				if($background_color != "" || $border_color != ""){
					$html .= " style='";
					if($background_color != ""){
						$html .= "background-color: ".$background_color.";";
					}
					if($border_color != ""){
						$html .= " border-color: ".$border_color.";";
					}
					$html .= "'";
				}
			}
			$html .= ">";

			if($icon_pack == 'font_awesome' && $fa_icon != ''){
				$html .= "<i class='fa ".$fa_icon." fa-stack-1x'";

				if($icon_color != ""){
					$html .= " style='color: ".$icon_color.";'";
				}

				$html .= "></i>";
			} elseif($icon_pack == 'font_elegant' && $fe_icon != ''){
				$html .= "<span class='q_font_elegant_icon ".$fe_icon."'";

				if($icon_color != ""){
					$html .= " style='color: ".$icon_color.";'";
				}

				$html .= "></span>";
			} elseif($icon_pack == 'linear_icons' && $linear_icon != ''){
				$html .= "<i class='lnr q_linear_icons_icon ".$linear_icon."'";

				if($icon_active_color != ""){
					$html .= " style='color: ".$icon_active_color.";'";
				}

				$html .= "></i>";
			}

			$html .= "</span></div>";


			$i++;
		}
		$html .= "</div></div></div>";
		return $html;
	}
	add_shortcode('progress_bar_icon', 'progress_bar_icon');
}
