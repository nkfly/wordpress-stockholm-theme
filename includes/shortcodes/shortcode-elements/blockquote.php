<?php
/* Blockquote item shortcode */

if (!function_exists('blockquote')) {
	function blockquote($atts, $content = null) {
		$args = array(
			"text"              => "",
			"text_color"        => "",
			"title_tag"	        => "h3",
			"width"             => "",
			"line_height"       => "",
			"background_color"  => "",
			"border_color"      => "",
			"quote_icon_color"  => "",
			"show_quote_icon"   => "",
			"quote_icon_size"   => ""
		);

		extract(shortcode_atts($args, $atts));

		$headings_array = array('h2', 'h3', 'h4', 'h5', 'h6');

		//get correct heading value. If provided heading isn't valid get the default one
		$title_tag = (in_array($title_tag, $headings_array)) ? $title_tag : $args['title_tag'];

		//init variables
		$html               = "";
		$blockquote_styles  = "";
		$blockquote_classes = array();
		$heading_styles     = "";
		$quote_icon_styles  = array();

		if($show_quote_icon == 'yes') {
			$blockquote_classes[]= 'with_quote_icon';
		} else {
			$blockquote_classes[]= ' without_quote_icon';
		}

		if($width != "") {
			$blockquote_styles .= "width: ".$width."%;";
		}

		if($border_color != "") {
			$blockquote_styles .= "border-left-color: ".$border_color.";";
			$blockquote_classes[] = 'with_border';
		}

		if($background_color != "") {
			$blockquote_styles .= "background-color: ".$background_color.";";
			$blockquote_classes[] = 'with_background';
		}

		if($text_color != "") {
			$heading_styles .= "color: ".$text_color.";";
		}

		if($line_height != "") {
			$heading_styles .= " line-height: ".$line_height."px;";
		}

		if($quote_icon_color != "") {
			$quote_icon_styles[] = "color: ".$quote_icon_color;
		}

		if($quote_icon_size != '') {
			$quote_icon_styles[] = 'font-size: '.$quote_icon_size.'px';
		}

		$html .= "<blockquote class='".implode(' ', $blockquote_classes)."' style='".$blockquote_styles."'>"; //open blockquote
		if($show_quote_icon == 'yes') {
			$html .= "<span class='icon_quotations_holder'>";
			$html .= "<i class='q_font_elegant_icon icon_quotations' style='".implode(';', $quote_icon_styles)."'></i>";
			$html .= "</span>";
		}

		$html .= "<".$title_tag." class='blockquote_text' style='".$heading_styles."'>";
		$html .= "<span>".$text."</span>";
		$html .= "</".$title_tag.">";
		$html .= "</blockquote>"; //close blockquote
		return $html;
	}
	add_shortcode('blockquote', 'blockquote');
}
