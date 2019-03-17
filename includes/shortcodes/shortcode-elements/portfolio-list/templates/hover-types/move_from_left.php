<div class="holder-move">
	<div class="portfolio_shader"></div>

	<div class="text_holder">
		<?php
		echo qode_get_shortcode_template_part('templates/parts/title', 'portfolio-list', '', $params);
		echo qode_get_shortcode_template_part('templates/parts/subtitle', 'portfolio-list', '', $params);
		echo qode_get_shortcode_template_part('templates/parts/categories', 'portfolio-list', '', $params);
		?>
	</div>
	<?php echo qode_get_shortcode_template_part('templates/parts/icons', 'portfolio-list', '', $params); ?>
</div>
