<?php
/* Countdown shortcode */

if (!function_exists('countdown')) {
	function countdown($atts, $content = null) {
		$args = array(
			'year' => '',
			'month' => '',
			'day' => '',
			'hour' => '',
			'minute' => '',
			'month_label' => 'Months',
			'day_label' => 'Days',
			'hour_label' => 'Hours',
			'minute_label' => 'Minutes',
			'second_label' => 'Seconds',
			'digit_font_size' => '',
			'label_font_size' => '',
			'digit_color' => ''
		);

		extract(shortcode_atts($args, $atts));

		$id = mt_rand(1000, 9999);

		//Get HTML from template
		$html = "";

		$html .= '<div class="qode-countdown" id="countdown' . esc_html($id) . '"';
		$html .= 'data-year="' . esc_attr($year) . '"';
		$html .= 'data-month="' . esc_attr($month) . '"';
		$html .= 'data-day="' . esc_attr($day) . '"';
		$html .= 'data-hour="' . esc_attr($hour) . '"';
		$html .= 'data-minute="' . esc_attr($minute) . '"';
		$html .= 'data-timezone="' . get_option('gmt_offset') . '"';
		$html .= 'data-month-label="' . esc_attr($month_label) . '"';
		$html .= 'data-day-label="' . esc_attr($day_label) . '"';
		$html .= 'data-hour-label="' . esc_attr($hour_label) . '"';
		$html .= 'data-minute-label="' . esc_attr($minute_label) . '"';
		$html .= 'data-second-label="' . esc_attr($second_label) . '"';
		$html .= 'data-digit-size="' . esc_attr($digit_font_size) . '"';
		$html .= 'data-digit-color="' . esc_attr($digit_color) . '"';
		$html .= 'data-label-size="' . esc_attr($label_font_size) . '"';
		$html .= '></div>';

		return $html;
	}
	add_shortcode('countdown', 'countdown');
}
