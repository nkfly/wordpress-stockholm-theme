<article class="mix <?php echo implode(' ',$item_classes); ?>">
    <div class='image_holder <?php echo esc_html($hover_type); ?>'>
        <?php echo qode_get_shortcode_template_part('templates/parts/image', 'portfolio-list', '', $params); ?>

        <?php
		$custom_portfolio_link = get_post_meta(get_the_ID(), 'qode_portfolio-external-link', true);
		$params['portfolio_link'] = $custom_portfolio_link != "" ? $custom_portfolio_link : get_permalink();

		if(get_post_meta(get_the_ID(), 'qode_portfolio-external-link-target', true) != ""){
			$custom_portfolio_link_target = get_post_meta(get_the_ID(), 'qode_portfolio-external-link-target', true);
		} else {
			$custom_portfolio_link_target = '_blank';
		}
		$params['target'] = $custom_portfolio_link != "" ? $custom_portfolio_link_target : '_self';

        if($disable_link != "yes"){ ?>
            <a class='portfolio_link_class' href='<?php echo esc_url($params['portfolio_link']); ?>' target='<?php echo esc_attr($params['target']); ?>'></a>
		<?php } ?>

        <?php echo qode_get_shortcode_template_part('templates/hover-types/'.$hover_type, 'portfolio-list', '', $params); ?>


    </div>
</article>
<?php //this line is because of the space between items ?>