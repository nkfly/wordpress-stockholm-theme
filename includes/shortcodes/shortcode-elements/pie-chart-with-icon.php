<?php
/* Pie Chart With Icon shortcode */

if (!function_exists('pie_chart_with_icon')) {

	function pie_chart_with_icon($atts, $content = null) {

		global $qode_options;

		$args = array(
			"percent"         => "",
			"active_color"    => "",
			"noactive_color"  => "",
			"chart_width"	  => "",
			"line_width"      => "",
			"icon_pack"       => "",
			"fa_icon"         => "",
			"fe_icon"         => "",
			"linear_icon"     => "",
			"icon_color"      => "",
			"title"           => "",
			"title_color"     => "",
			"title_tag"       => "h5",
			"text"            => "",
			"text_color"      => ""
		);

		extract(shortcode_atts($args, $atts));

		$headings_array = array('h2', 'h3', 'h4', 'h5', 'h6');

		//get correct heading value. If provided heading isn't valid get the default one
		$title_tag = (in_array($title_tag, $headings_array)) ? $title_tag : $args['title_tag'];

		$html = '';

		$html .= '<div class="q_pie_chart_with_icon_holder"><div class="q_percentage_with_icon" data-percent="'.$percent.'" data-linewidth="'.$line_width.'" data-chartwidth="'.$chart_width.'" data-active="'.$active_color.'" data-noactive="'.$noactive_color.'">';

		if($icon_pack == 'font_awesome' && $fa_icon != ""){
			$html .= '<i class="fa '.$fa_icon.'"';


			if ($icon_color != "") {
				$html .= ' style="color: ' . $icon_color . ';"';
			}
			$html .= '></i>';
		}

		elseif($icon_pack == 'font_elegant' && $fe_icon != ""){
			$html .= '<span class="q_font_elegant_icon '.$fe_icon.'"';


			if ($icon_color != "") {
				$html .= ' style="color: ' . $icon_color . ';"';
			}
			$html .= '></span>';
		}

		elseif($icon_pack == 'linear_icons' && $linear_icon != ""){
			$html .= '<i class="lnr q_linear_icons_icon '.$linear_icon.'"';


			if ($icon_color != "") {
				$html .= ' style="color: ' . $icon_color . ';"';
			}
			$html .= '></i>';
		}

		$html .= '</div><div class="pie_chart_text">';
		if ($title != "") {
			$html .= '<'.$title_tag.' class="pie_title"';
			if ($title_color != "") {
				$html .= ' style="color: ' . $title_color . ';"';
			}
			$html .= '>' . $title . '</'.$title_tag.'>';
		}

		if ($text != "") {
			$html .= '<p ';
			if ($text_color != "") {
				$html .= ' style="color: ' . $text_color . ';"';
			}
			$html .= '>' . $text . '</p>';
		}
		$html .= "</div></div>";
		return $html;
	}
	add_shortcode('pie_chart_with_icon', 'pie_chart_with_icon');
}
