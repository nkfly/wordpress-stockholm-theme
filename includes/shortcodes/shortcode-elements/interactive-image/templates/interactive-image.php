<div class="qode-interactive-image <?php echo esc_html($holderClasses) ?>">
	<?php if($image_src != '') : ?>
	<div class="qode-ii-image-holder">
		<img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($title); ?>" />
	</div>
	<?php endif; ?>
	<div class="qode-ii-info-holder">
        <div class="qode-ii-info-holder-inner">
			<<?php echo esc_attr($title_tag); ?> class="qode-ii-title">
				<?php echo esc_attr($title); ?>
			</<?php echo esc_attr($title_tag); ?>>
			<?php if($text != '') : ?>
				<p class = "qode-ii-text"> <?php echo esc_attr($text); ?></p>
			<?php endif; ?>
			<?php
			if($link != '' && $link_text !== '') {
				echo qode_get_button_html(
					array(
						'link'          => $link,
						'text'          => $link_text,
						'target'        => $link_target,
						'custom_class'  => 'qode-iwoi-link',
                        'style'         => $link_style,
                        'font_size'     => '14',
                        'font_weight'   => '600',

					)
				);
			}
			?>
	    </div>
	</div>
</div>