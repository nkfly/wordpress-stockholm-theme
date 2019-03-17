<?php
/* Pie Chart shortcode */

if (!function_exists('pie_chart')) {

	function pie_chart($atts, $content = null) {
		$args = array(
			"title"                 => "",
			"title_color"           => "",
			"title_tag"             => "h5",
			"percent"               => "",
			"show_percent_mark"     => "with_mark",
			"percentage_color"      => "",
			"percent_font_size"     => "",
			"percent_font_weight"   => "",
			"active_color"          => "",
			"noactive_color"        => "",
			"chart_width"	        => "",
			"line_width"            => "",
			"text"                  => "",
			"text_color"            => ""
		);

		extract(shortcode_atts($args, $atts));

		$headings_array = array('h2', 'h3', 'h4', 'h5', 'h6');

		//get correct heading value. If provided heading isn't valid get the default one
		$title_tag = (in_array($title_tag, $headings_array)) ? $title_tag : $args['title_tag'];
		$percent_style = '';
		$html = '';
		$html .= '<div class="q_pie_chart_holder"><div class="q_percentage" data-percent="' . $percent . '" data-linewidth="' . $line_width . '" data-chartwidth="' . $chart_width . '" data-active="' . $active_color . '" data-noactive="' . $noactive_color . '"';
		if ($percentage_color != "" || $percent_font_size != "" || $percent_font_weight != "") {
			$percent_style .= ' style="';

			if($percentage_color != ""){
				$percent_style .= 'color:'.$percentage_color.';';
			}
			if($percent_font_size != ""){
				$percent_style .= 'font-size:'.$percent_font_size.'px;';
			}
			if($percent_font_weight != ""){
				$percent_style .= 'font-weight:'.$percent_font_weight.';';
			}
			$percent_style .= '"';
		}
		$html .= '><span class="tocounter '.$show_percent_mark.'" ' .$percent_style . '>' . $percent . '</span>';
		$html .= '</div><div class="pie_chart_text">';
		if ($title != "") {
			$html .= '<'.$title_tag.' class="pie_title"';
			if ($title_color != "") {
				$html .= ' style="color: ' . $title_color . ';"';
			}
			$html .= '>' . $title . '</'.$title_tag.'>';
		}

		if ($text != "") {
			$html .= '<p';
			if($text_color != ""){
				$html .= ' style="color: '.$text_color.';"';
			}
			$html .= '>' . $text . '</p>';
		}
		$html .= "</div></div>";
		return $html;
	}
	add_shortcode('pie_chart', 'pie_chart');
}
