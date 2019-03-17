<?php
/* Image with text over shortcode */

if (!function_exists('interactive_banners')) {

	function interactive_banners($atts, $content = null) {
		$args = array(
			"layout_width"           => "",
			"image"                  => "",
			"icon_pack"              => "",
			"fa_icon"                => "",
			"fe_icon"                => "",
			"linear_icon"            => "",
			"icon_custom_size"       => "45",
			"icon_color"             => "",
			"title"                  => "",
			"title_color"            => "",
			"title_size"             => "21",
			"title_tag"              => "h4",
			"subtitle"               => "",
			"subtitle_color"         => "",
			"subtitle_size"          => "17",
			"subtitle_tag"           => "h3",
			"link"                   => "",
			"link_text"              => "SEE MORE",
			"target"                 => "_self",
			"link_color"             => "",
			"link_border_color"      => "",
			"link_background_color"  => ""
		);

		extract(shortcode_atts($args, $atts));

		$headings_array = array('h2', 'h3', 'h4', 'h5', 'h6');

		//get correct heading value. If provided heading isn't valid get the default one
		$title_tag = (in_array($title_tag, $headings_array)) ? $title_tag : $args['title_tag'];

		//init variables
		$html            = "";
		$title_styles    = "";
		$subtitle_styles = "";
		$icon_styles     = "";
		$link_style      = "";
		$icon_font_style = "";
		$image_alt       = "";

		//generate styles
		if($title_color != "") {
			$title_styles .= "color: ".$title_color.";";
		}

		if($title_size != "") {
			$valid_title_size = (strstr($title_size, 'px', true)) ? $title_size : $title_size.'px';
			$title_styles .= "font-size: ".$valid_title_size.";";
		}

		if($subtitle_color != "") {
			$subtitle_styles .= "color: ".$subtitle_color.";";
		}

		if($subtitle_size != "") {
			$valid_title_size = (strstr($subtitle_size, 'px', true)) ? $subtitle_size : $subtitle_size.'px';
			$subtitle_styles .= "font-size: ".$valid_title_size.";";
		}

		$icon_styles .= "style='";

		if($icon_color != "") {
			$icon_styles .= "color: ".$icon_color.";";
		}

		if($icon_custom_size != "") {
			$icon_font_style .= ' font-size: '.$icon_custom_size;
			if(!strstr($icon_custom_size, 'px')) {
				$icon_font_style .= 'px;';
			}
			$icon_styles .= $icon_font_style;
		}

		$icon_styles .= "'";

		if (is_numeric($image)) {
			$image_src = wp_get_attachment_url($image);
			$image_alt = get_post_meta($image, '_wp_attachment_image_alt', true);
		} else {
			$image_src = $image;
			$image_alt = $title;
		}

		if($link_color != ""){
			$link_style .= "color: ".$link_color.";";
		}

		if($link_border_color != ""){
			$link_style .= "border-color: ".$link_border_color.";";
		}

		if($link_background_color != ""){
			$link_style .= "background-color: ".$link_background_color.";";
		}

		//generate output
		$html .= '<div class="q_image_with_text_over '.$layout_width.'">';
		$html .= '<div class="shader"></div>';

		$html .= '<img src="' . $image_src . '" alt="' . $image_alt . '" />';


		//title and subtitle html
		$html .= '<div class="front_holder"><div class="front_holder_inner"><div class="front_holder_inner2">';
		if($icon_pack == 'font_awesome' && $fa_icon != ""){
			$html .= '<i class="icon_holder fa '.$fa_icon.'" '.$icon_styles .'></i>';
		}elseif($icon_pack == 'font_elegant' && $fe_icon != ""){
			$html .= '<span class="icon_holder q_font_elegant_icon '.$fe_icon.'" aria-hidden="true" '.$icon_styles .'></span>';
		}elseif($icon_pack == 'linear_icons' && $linear_icon != ""){
			$html .= '<i class="icon_holder lnr q_linear_icons_icon '.$linear_icon.'" '.$icon_styles .'></i>';
		}
		$html .= '<'.$subtitle_tag.' class="front_subtitle" style="'.$subtitle_styles.'">'.$subtitle.'</'.$subtitle_tag.'>';
		$html .= '<'.$title_tag.' class="front_title" style="'.$title_styles.'">'.$title.'</'.$title_tag.'>';
		$html .= '</div></div></div>';

		//image description html which appears on mouse hover
		$html .= '<div class="back_holder"><div class="back_holder_inner"><div class="back_holder_inner2">';
		$html .= do_shortcode($content);

		if($link != ""){
			$html .= '<a class="qbutton medium" htef="'.$link.'" target="'.$target.'" style="'.$link_style.'">'.$link_text.'</a>';
		}
		$html .= '</div></div></div>';


		$html .= '</div>'; //close image_with_text_over

		return $html;
	}

	add_shortcode('interactive_banners', 'interactive_banners');
}