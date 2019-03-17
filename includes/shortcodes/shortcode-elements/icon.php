<?php
//Icon shortcode
if(!function_exists('icons')) {
	function icons($atts, $content = null) {
		$default_atts = array(
			"icon_pack"            		=> "",
			"fa_size"              		=> "",
			"custom_size"          		=> "",
			"fa_icon"              		=> "",
			"fe_icon"              		=> "",
			"linear_icon"          		=> "",
			"type"                 		=> "",
			"position"             		=> "",
			"border_color"         		=> "",
			"border_hover_color"   		=> "",
			"border_width"         		=> "",
			"border_radius"				=> "",
			"icon_color"           		=> "",
			"icon_hover_color"     		=> "",
			"background_color"     		=> "",
			"background_hover_color"    => "",
			"margin"               		=> "",
			"icon_animation"       		=> "",
			"icon_animation_delay" 		=> "",
			"link"                 		=> "",
			"target"               		=> ""
		);

		extract(shortcode_atts($default_atts, $atts));

		$html = "";
		if($fa_icon != "" || $fe_icon != "" || $linear_icon != "") {

			if ($icon_pack == 'font_awesome' && $fa_icon != '')
				$size = $fa_size;

			//generate inline icon styles
			$icon_stack_classes    = '';
			$animation_delay_style = '';
			$icon_link_style       = '';

			//generate icon stack styles
			$icon_stack_style         = '';
			$icon_stack_circle_styles = '';
			$icon_stack_square_styles = '';
			$icon_stack_normal_style  = '';
			$icon_stack_font_size     = '';
			$data_attr              = "";

			if($background_hover_color != "") {
				$data_attr .= "data-hover-background-color=".$background_hover_color." ";
			}

			if($border_hover_color != "") {
				$data_attr .= "data-hover-border-color=".$border_hover_color." ";
			}

			if($icon_hover_color != "") {
				$data_attr .= "data-hover-color=".$icon_hover_color." ";
			}

			if($custom_size != "") {
				$icon_stack_normal_style .= 'font-size: '.$custom_size;

				if(($fe_icon != "" && $icon_pack == 'font_elegant') || ($linear_icon != "" && $icon_pack == 'linear_icons')){
					$icon_stack_circle_styles .= 'padding: 1.5em;';
					$icon_stack_square_styles .= 'padding: 1.5em;';
				} else {
					$icon_stack_circle_styles .= 'font-size: '.$custom_size;
					$icon_stack_square_styles .= 'font-size: '.$custom_size;
				}

				if(!strstr($custom_size, 'px') && $icon_pack != 'font_elegant' && $icon_pack != 'linear_icons') {
					$icon_stack_normal_style .= 'px;';
					$icon_stack_circle_styles .= 'px;';
					$icon_stack_square_styles .= 'px;';
				}

				if(!strstr($custom_size, 'px') && $icon_stack_normal_style != '') {
					$icon_stack_normal_style .= 'px;';
				}

				//generate inline icon styles
				if(($fe_icon != "" && $icon_pack == 'font_elegant') || ($linear_icon != "" && $icon_pack == 'linear_icons')) {
					$icon_stack_font_size	.= 'font-size: '.$custom_size.'px;';
				}
			}
			if($icon_color != "") {
				$icon_stack_normal_style .= 'color: '.$icon_color.';';
				$icon_stack_style .= 'color: '.$icon_color.';';
			}

			if($position != "") {
				$icon_stack_classes .= 'pull-'.$position;
			}

			if($background_color != "") {
				$icon_stack_style .= 'background-color: '.$background_color.';';
			}

			if($border_color != "") {
				$icon_stack_style .= 'border-color: '.$border_color.';';
			}

			if($border_width != "") {
				$icon_stack_style .= 'border-width: '.$border_width.'px;';
			}

			if($border_radius != "") {
				$icon_stack_square_styles .= 'border-radius: '.$border_radius.'px;';
			}

			if($icon_animation_delay != ""){
				$animation_delay_style .= 'transition-delay: '.$icon_animation_delay.'ms; -webkit-transition-delay: '.$icon_animation_delay.'ms; -moz-transition-delay: '.$icon_animation_delay.'ms; -o-transition-delay: '.$icon_animation_delay.'ms;';
			}

			if($margin != "") {
				$icon_stack_style .= 'margin: '.$margin.';';
				$icon_stack_normal_style .= 'margin: '.$margin.';';
			}

			switch ($type) {
				case 'circle':
					if($icon_pack == 'font_awesome' && $fa_icon != ''){

						$html = '<span class="fa-stack q_icon_shortcode circle q_font_awsome_icon_holder q_font_awsome_icon_circle '.$size.' '.$icon_stack_classes.' '.$icon_animation.'" style="'.$icon_stack_style.$icon_stack_circle_styles.' '.$animation_delay_style.'"'. $data_attr . '>';
						if($link != ""){
							$html .= '<a href="'.$link.'" target="'.$target.'">';
						}
						$html .= '<i class="fa '.$fa_icon.'"></i>';

					} elseif($icon_pack == 'font_elegant' && $fe_icon != ''){

						$html = '<span class="q_font_elegant_holder q_icon_shortcode '.$type.' '.$icon_stack_classes.' '.$icon_animation.'" style="'.$icon_stack_style.$icon_stack_circle_styles.' '.$animation_delay_style.'"'. $data_attr . '>';
						if($link != ""){
							$html .= '<a href="'.$link.'" target="'.$target.'">';
						}
						$html .= '<span class="q_font_elegant_icon '.$fe_icon.'" aria-hidden="true" style="'.$icon_stack_font_size.'"></span>';

					} elseif($icon_pack == 'linear_icons' && $linear_icon != ''){

						$html = '<span class="q_icon_shortcode q_linear_icons_holder '.$type.' '.$icon_stack_classes.' '.$icon_animation.'" style="'.$icon_stack_style.$icon_stack_circle_styles.' '.$animation_delay_style.'"'. $data_attr . '>';
						if($link != ""){
							$html .= '<a href="'.$link.'" target="'.$target.'">';
						}
						$html .= '<i class="lnr q_linear_icons_icon '.$linear_icon.'" style="'.$icon_stack_font_size.'"></i>';

					}
					break;
				case 'square':
					if($icon_pack == 'font_awesome' && $fa_icon != ''){

						$html = '<span class="fa-stack q_font_awsome_icon_holder q_icon_shortcode square q_font_awsome_icon_square '.$size.' '.$icon_stack_classes.' '.$icon_animation.'" style="'.$icon_stack_style.$icon_stack_square_styles.' '.$animation_delay_style.'"'. $data_attr . '>';
						if($link != ""){
							$html .= '<a href="'.$link.'" target="'.$target.'">';
						}
						$html .= '<i class="fa '.$fa_icon.'"></i>';

					} elseif($icon_pack == 'font_elegant' && $fe_icon != ''){

						$html = '<span class="q_font_elegant_holder q_icon_shortcode '.$type.' '.$icon_stack_classes.' '.$icon_animation.'" style="'.$icon_stack_style.$icon_stack_square_styles.' '.$animation_delay_style.'"'. $data_attr . '>';
						if($link != ""){
							$html .= '<a href="'.$link.'" target="'.$target.'">';
						}
						$html .= '<span class="q_font_elegant_icon '.$fe_icon.'" aria-hidden="true" style="'.$icon_stack_font_size.'"></span>';

					} elseif($icon_pack == 'linear_icons' && $linear_icon != ''){

						$html = '<span class="q_linear_icons_holder q_icon_shortcode '.$type.' '.$icon_stack_classes.' '.$icon_animation.'" style="'.$icon_stack_style.$icon_stack_square_styles.' '.$animation_delay_style.'"'. $data_attr . '>';
						if($link != ""){
							$html .= '<a href="'.$link.'" target="'.$target.'">';
						}
						$html .= '<i class="lnr q_linear_icons_icon '.$linear_icon.'"  style="'.$icon_stack_font_size.'"></i>';

					}
					break;
				default:
					if($icon_pack == 'font_awesome' && $fa_icon != ''){

						$html = '<span class="q_font_awsome_icon q_icon_shortcode normal q_font_awsome_icon_holder '.$size.' '.$icon_stack_classes.' '.$icon_animation.'" style="'.$icon_stack_normal_style.' '.$animation_delay_style.'"'. $data_attr . '>';
						if($link != ""){
							$html .= '<a href="'.$link.'" target="'.$target.'">';
						}
						$html .= '<i class="fa '.$fa_icon.'"></i>';

					} elseif($icon_pack == 'font_elegant' && $fe_icon != ''){

						$html = '<span class="q_font_elegant_holder q_icon_shortcode '.$type.' '.$icon_stack_classes.' '.$icon_animation.'" style="'.$icon_stack_normal_style.' '.$animation_delay_style.'"'. $data_attr . '>';
						if($link != ""){
							$html .= '<a href="'.$link.'" target="'.$target.'">';
						}
						$html .= '<span class="q_font_elegant_icon '.$fe_icon.'" aria-hidden="true" style="'.$icon_stack_font_size.'"></span>';

					} elseif($icon_pack == 'linear_icons' && $linear_icon != ''){

						$html = '<span class="q_font_elegant_holder q_icon_shortcode '.$type.' '.$icon_stack_classes.' '.$icon_animation.'" style="'.$icon_stack_normal_style.' '.$animation_delay_style.'"'. $data_attr . '>';
						if($link != ""){
							$html .= '<a href="'.$link.'" target="'.$target.'">';
						}
						$html .= '<i class="lnr q_linear_icons_icon '.$linear_icon.'"  style="'.$icon_stack_font_size.'"></i>';

					}
					break;
			}

			if($link != ""){
				$html .= '</a>';
			}

			$html.= '</span>';
		}
		return $html;
	}
	add_shortcode('icons', 'icons');
}