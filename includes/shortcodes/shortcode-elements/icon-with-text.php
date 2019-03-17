<?php
/* Icon with text shortcode */

if(!function_exists('icon_text')) {
	function icon_text($atts, $content = null) {
		$default_atts = array(
			"icon_size"             		=> "",
			"custom_icon_size"      		=> "20",
			"text_left_padding"     		=> "86",
			"icon_pack"             		=> "",
			"fa_icon"               		=> "",
			"fe_icon"               		=> "",
			"linear_icon"              		=> "",
			"custom_icon_image"             => "",
			"icon_animation"        		=> "",
			"icon_animation_delay"  	 	=> "",
			"icon_type"             	 	=> "",
			"icon_border_width"       	 	=> "",
			"without_double_border_icon" 	=> "",
			"icon_position"         		=> "",
			"icon_border_color"     		=> "",
			"icon_margin"           		=> "",
			"icon_color"            		=> "",
			"icon_background_color" 		=> "",
			"box_type"              		=> "",
			"box_border"            		=> "",
			"box_border_color"      		=> "",
			"box_background_color"  		=> "",
			"title"                 		=> "",
			"title_tag"             		=> "h4",
			"title_color"           		=> "",
			"title_padding"         		=> "",
			"text"                  		=> "",
			"text_color"            		=> "",
			"link"                  		=> "",
			"link_text"             		=> "",
			"link_color"            		=> "",
			"target"                		=> ""
		);

		extract(shortcode_atts($default_atts, $atts));

		$headings_array = array('h2', 'h3', 'h4', 'h5', 'h6');

		//get correct heading value. If provided heading isn't valid get the default one
		$title_tag = (in_array($title_tag, $headings_array)) ? $title_tag : $args['title_tag'];

		//init icon styles
		$style = '';
		$icon_stack_classes = '';

		//init icon stack styles
		$icon_margin_style       	= '';
		$icon_stack_square_style 	= '';
		$icon_stack_base_style   	= '';
		$icon_stack_style        	= '';
		$icon_stack_font_size       = '';
		$icon_holder_style          = '';
		$animation_delay_style   	= '';

		//generate inline icon styles
		if($custom_icon_size != "" && (($fe_icon != "" && $icon_pack == 'font_elegant') || ($linear_icon != "" && $icon_pack == 'linear_icons'))) {
			$icon_stack_style		.= 'font-size: '.$custom_icon_size.'px;';
			$icon_stack_font_size	.= 'font-size: '.$custom_icon_size.'px;';
		}

		if($icon_color != "") {
			$style .= 'color: '.$icon_color.';';
			$icon_stack_style .= 'color: '.$icon_color.';';
		}

		//generate icon stack styles
		if($icon_background_color != "") {
			$icon_stack_base_style .= 'background-color: '.$icon_background_color.';';
			$icon_stack_square_style .= 'background-color: '.$icon_background_color.';';
		}

		if($icon_border_width !== '') {
			$icon_stack_base_style .= 'border-width: '.$icon_border_width.'px;';
			$icon_holder_style .= 'border-width: '.$icon_border_width.'px;';
			$icon_stack_square_style .= 'border-width: '.$icon_border_width.'px;';
		}

		if($icon_border_color != "") {
			$icon_stack_style .= 'border-color: '.$icon_border_color.';';
			$icon_holder_style .= 'border-color: '.$icon_border_color.';';
		}

		if($icon_margin != "") {
			$icon_margin_style .= "margin: ".$icon_margin.";";
		}

		if($icon_animation_delay != "" && $icon_animation == "q_icon_animation"){
			$animation_delay_style .= 'transition-delay: '.$icon_animation_delay.'ms; -webkit-transition-delay: '.$icon_animation_delay.'ms; -moz-transition-delay: '.$icon_animation_delay.'ms; -o-transition-delay: '.$icon_animation_delay.'ms;';
		}

		$box_size = '';
		//generate icon text holder styles and classes

		//map value of the field to the actual class value

		if($icon_pack == 'font_awesome' && $fa_icon != ''){

			switch ($icon_size) {
				case 'large': //smallest icon size
					$box_size = 'tiny';
					break;
				case 'fa-2x':
					$box_size = 'small';
					break;
				case 'fa-3x':
					$box_size = 'medium';
					break;
				case 'fa-4x':
					$box_size = 'large';
					break;
				case 'fa-5x':
					$box_size = 'very_large';
					break;
				default:
					$box_size = 'tiny';
			}
		}

		$box_icon_type = '';
		switch ($icon_type) {
			case 'normal':
				$box_icon_type = 'normal_icon';
				break;
			case 'square':
				$box_icon_type = 'square';
				break;
			case 'circle':
				$box_icon_type = 'circle';
				break;
		}

		$html = "";
		$html_icon = "";
		$html_custom_icon = "";

		//genererate icon html
		switch ($icon_type) {
			case 'circle':
				//if custom icon size is set and if it is larger than large icon size
				if($custom_icon_size != "") {
					//add custom font class that has smaller inner icon font
					$icon_stack_classes .= ' custom-font';
				}

				if($icon_pack == 'font_awesome' && $fa_icon != ''){
					$html_icon .= '<span class="fa-stack '.$icon_size.' '.$icon_stack_classes.'" style="'.$icon_stack_style . $icon_stack_base_style .'">';
					$html_icon .= '<i class="icon_text_icon fa '.$fa_icon.' fa-stack-1x"></i>';
					$html_icon .= '</span>';
				}elseif($icon_pack == 'font_elegant' && $fe_icon != ''){
					$html_icon .= '<span class="q_font_elegant_holder '.$icon_type.' '.$icon_stack_classes.'" style="'.$icon_stack_style.$icon_stack_base_style.'">';
					$html_icon .= '<span class="icon_text_icon q_font_elegant_icon '.$fe_icon.'" aria-hidden="true" style="'.$icon_stack_font_size.'"></span>';
					$html_icon .= '</span>';
				}elseif($icon_pack == 'linear_icons' && $linear_icon != ''){
					$html_icon .= '<span class="q_linear_icons_holder '.$icon_type.' '.$icon_stack_classes.'" style="'.$icon_stack_style.$icon_stack_base_style.'">';
					$html_icon .= '<i class="icon_text_icon q_linear_icons_icon lnr '.$linear_icon.'" style="'.$icon_stack_font_size.'"></i>';
					$html_icon .= '</span>';
				}

				break;
			case 'square':
				//if custom icon size is set and if it is larget than large icon size
				if($custom_icon_size != "") {
					//add custom font class that has smaller inner icon font
					$icon_stack_classes .= ' custom-font';
				}

				if($icon_pack == 'font_awesome' && $fa_icon != ''){
					$html_icon .= '<span class="fa-stack '.$icon_size.' '.$icon_stack_classes.'" style="'.$icon_stack_style.$icon_stack_square_style.'">';
					$html_icon .= '<i class="icon_text_icon fa '.$fa_icon.' fa-stack-1x"></i>';
					$html_icon .= '</span>';
				}elseif($icon_pack == 'font_elegant' && $fe_icon != ''){
					$html_icon .= '<span class="q_font_elegant_holder '.$icon_type.' '.$icon_stack_classes.'" style="'.$icon_stack_style.$icon_stack_square_style.'">';
					$html_icon .= '<span class="icon_text_icon q_font_elegant_icon '.$fe_icon.'" aria-hidden="true" style="'.$icon_stack_font_size.'" ></span>';
					$html_icon .= '</span>';
				}elseif($icon_pack == 'linear_icons' && $linear_icon != ''){
					$html_icon .= '<span class="q_linear_icons_holder '.$icon_type.' '.$icon_stack_classes.'" style="'.$icon_stack_style.$icon_stack_square_style.'">';
					$html_icon .= '<span class="icon_text_icon lnr q_linear_icons_icon '.$linear_icon.'" style="'.$icon_stack_font_size.'" ></span>';
					$html_icon .= '</span>';
				}

				break;
			default:

				if($icon_pack == 'font_awesome' && $fa_icon != ''){
					$html_icon .= '<span style="'.$icon_stack_style.'" class="q_font_awsome_icon '.$icon_size.' '.$icon_stack_classes.'">';
					$html_icon .= '<i class="icon_text_icon fa '.$fa_icon.'"></i>';
					$html_icon .= '</span>';
				}elseif($icon_pack == 'font_elegant' && $fe_icon != ''){
					$html_icon .= '<span class="q_font_elegant_holder '.$icon_type.' '.$icon_stack_classes.'" style="'.$icon_stack_style.'">';
					$html_icon .= '<span class="icon_text_icon q_font_elegant_icon '.$fe_icon.'" aria-hidden="true" style="'.$icon_stack_font_size.'"></span>';
					$html_icon .= '</span>';
				}elseif($icon_pack == 'linear_icons' && $linear_icon != ''){
					$html_icon .= '<span class="q_linear_icons_holder '.$icon_type.' '.$icon_stack_classes.'" style="'.$icon_stack_style.'">';
					$html_icon .= '<i class="icon_text_icon lnr q_linear_icons_icon '.$linear_icon.'" aria-hidden="true" style="'.$icon_stack_font_size.'"></i>';
					$html_icon .= '</span>';
				}elseif($icon_pack == 'custom_icon' && $custom_icon_image != '') {
					$html_icon .= wp_get_attachment_image($custom_icon_image, 'full');
				}

				break;
		}

		$title_style = "";
		if($title_color != "") {
			$title_style .= "color: ".$title_color;
		}

		$text_style = "";
		if($text_color != "") {
			$text_style .= "color: ".$text_color;
		}

		$link_style = "";

		if($link_color != "") {
			$link_style .= "color: ".$link_color.";";
		}

		//generate normal type of a box html
		if($box_type == "normal") {

			//init icon text wrapper styles
			$icon_with_text_clasess = '';
			$icon_with_text_style   = '';
			$icon_text_inner_style  = '';
			$icon_text_holder_style = '';

			$icon_with_text_clasess .= $box_size;
			$icon_with_text_clasess .= ' '.$box_icon_type;

			if($box_border == "yes") {
				$icon_with_text_clasess .= ' with_border_line';
			}

			if($without_double_border_icon == 'yes') {
				$icon_with_text_clasess .= ' without_double_border';
			}

			if($text_left_padding != "" && ($icon_pack == 'font_elegant' || $icon_pack == 'linear_icons') && $icon_position == "left"){
				$icon_text_holder_style .= 'padding-left: '.$text_left_padding.'px';
			}

			if($box_border == "yes" && $box_border_color != "") {
				$icon_text_inner_style .= 'border-color: '.$box_border_color;
			}

			if($icon_position == "" || $icon_position == "top") {
				$icon_with_text_clasess .= " center";
			}
			if($icon_position == "left_from_title"){
				$icon_with_text_clasess .= " left_from_title";
			}
			if($icon_pack == 'custom_icon') {
				$icon_with_text_clasess .= " with_custom_icon";
			}

			$html .= "<div class='q_icon_with_title ".$icon_with_text_clasess."'>";
			if($icon_position != "left_from_title") {
				//generate icon holder html part with icon
				$html .= '<div class="icon_holder '.$icon_animation.'" style="'.$icon_margin_style.' '.$animation_delay_style.'">';
				$html .= '<div class="icon_holder_inner">';
				$html .= $html_icon;
				$html .= '</div>'; // close icon_holder_inner
				$html .= '</div>'; //close icon_holder
			}

			//generate text html
			$html .= '<div class="icon_text_holder" style="'.$icon_text_holder_style.'">';
			$html .= '<div class="icon_text_inner" style="'.$icon_text_inner_style.'">';
			if($icon_position == "left_from_title") {
				$html .= '<div class="icon_title_holder">'; //generate icon_title holder for icon from title
				//generate icon holder html part with icon
				$html .= '<div class="icon_holder '.$icon_animation.'" style="'.$icon_margin_style.' '.$animation_delay_style.'">';
				$html .= '<div class="icon_holder_inner">';
				$html .= $html_icon;
				$html .= '</div>'; //close icon_holder_inner
				$html .= '</div>'; //close icon_holder
			}
			$html .= '<'.$title_tag.' class="icon_title" style="'.$title_style.'">'.$title.'</'.$title_tag.'>';
			if($icon_position == "left_from_title") {
				$html .= '</div>'; //close icon_title holder for icon from title
			}
			$html .= "<p style='".$text_style."'>".$text."</p>";
			if($link != ""){
				if($target == ""){
					$target = "_self";
				}

				if($link_text == ""){
					$link_text = "READ MORE";
				}

				$html .= "<a class='icon_with_title_link' href='".$link."' target='".$target."' style='".$link_style."'>".$link_text."</a>";
			}
			$html .= '</div>';  //close icon_text_inner
			$html .= '</div>'; //close icon_text_holder

			$html.= '</div>'; //close icon_with_title
		} else {
			//init icon text wrapper styles
			$icon_with_text_clasess = '';
			$box_holder_styles = '';

			if($box_border_color != "") {
				$box_holder_styles .= 'border-color: '.$box_border_color.';';
			}

			if($box_background_color != "") {
				$box_holder_styles .= 'background-color: '.$box_background_color.';';
			}

			if($title_padding != ""){
				$valid_title_padding = (strstr($title_padding, 'px', true)) ? $title_padding : $title_padding.'px';
				$title_style .= 'padding-top: '.$valid_title_padding.';';
			}

			$icon_with_text_clasess .= $box_size;
			$icon_with_text_clasess .= ' '.$box_icon_type;

			if($without_double_border_icon == 'yes') {
				$icon_with_text_clasess .= ' without_double_border';
			}

			if($icon_pack == 'custom_icon') {
				$icon_with_text_clasess .= " with_custom_icon";
			}

			$html .= '<div class="q_box_holder with_icon" style="'.$box_holder_styles.'">';

			$html .= '<div class="box_holder_icon">';
			$html .= '<div class="box_holder_icon_inner '.$icon_with_text_clasess.' '.$icon_animation.'" style="'.$animation_delay_style.'">';
			$html .= '<div class="icon_holder_inner">';
			$html .= $html_icon;
			$html .= '</div>'; //close icon_holder_inner
			$html .= '</div>'; //close box_holder_icon_inner
			$html .= '</div>'; //close box_holder_icon

			//generate text html
			$html .= '<div class="box_holder_inner '.$box_size.' center">';
			$html .= '<'.$title_tag.' class="icon_title" style="'.$title_style.'">'.$title.'</'.$title_tag.'>';
			$html .= '<p style="'.$text_style.'">'.$text.'</p>';
			$html .= '</div>'; //close box_holder_inner

			$html .= '</div>'; //close box_holder
		}

		return $html;

	}
	add_shortcode('icon_text', 'icon_text');
}
