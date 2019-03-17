<?php
	$featured_image_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); //original size

	if(get_post_meta(get_the_ID(), 'qode_portfolio-lightbox-link', true) != ""){
		$large_image = get_post_meta(get_the_ID(), 'qode_portfolio-lightbox-link', true);
	} else {
		$large_image = $featured_image_array[0];
	}
?>
<div class="icons_holder">
	<div class="icons_holder_inner">
		<?php if ($lightbox == "yes") { ?>
			<a class='portfolio_lightbox' title='<?php echo esc_html($title); ?>' href='<?php echo esc_url($large_image); ?>' data-rel='prettyPhoto[<?php echo esc_html($slug_list_); ?>]'></a>
		<?php } ?>

		<?php if ($portfolio_qode_like == "on" && $show_like == "yes") {

			if (function_exists('qode_like_portfolio_list')) {
				echo qode_like_portfolio_list(get_the_ID());
			}
		} ?>
	</div>
</div>