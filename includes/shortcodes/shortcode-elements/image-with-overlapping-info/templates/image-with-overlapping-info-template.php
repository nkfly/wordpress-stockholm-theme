<div class="qode-image-with-overlapping-info">
	<?php if($image_src != '') : ?>
	<div class="qode-iwoi-image-holder">
		<img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($title); ?>" />
	</div>
	<?php endif; ?>
	<div class="qode-iwoi-info-holder">
			<<?php echo esc_attr($title_tag); ?> class="qode-iwoi-title">
				<?php echo esc_attr($title); ?>
			</<?php echo esc_attr($title_tag); ?>>
			<?php if($text != '') : ?>
				<p class = "qode-iwoi-text"> <?php echo esc_attr($text); ?></p>
			<?php endif; ?>
			<?php
			if($link != '') {
				echo qode_get_button_html(
					array(
						'link'          => $link,
						'text'          => $link_text,
						'target'        => $link_target,
						'custom_class'  => $link_classes,
					)
				);
			}

			?>
	</div>
</div>