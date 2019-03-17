<?php
$title_style = '';
if($title_font_size != ""){
	$title_style = 'style="font-size: '.$title_font_size.'px;"';
}
?>
<<?php echo esc_attr($title_tag); ?> class="portfolio_title" <?php echo wp_kses_post($title_style); ?>> <?php echo get_the_title() ?></<?php echo esc_attr($title_tag); ?>>