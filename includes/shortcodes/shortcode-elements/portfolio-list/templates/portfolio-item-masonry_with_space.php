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


        if($pinterest_hover_type == "info_on_hover"){ ?>
            <div class='pinterest_info_hover_holder'>
            <div class='pinterest_info_hover_inner'>
            <div class='pinterest_info_hover_cell'>
        <?php }

            if($disable_link != "yes"){ ?>
                <a class='portfolio_link_class' href='<?php echo esc_url($params['portfolio_link']); ?>' target='<?php echo esc_attr($params['target']); ?>'></a>
            <?php } ?>

            <div class="portfolio_shader"></div>

            <?php echo qode_get_shortcode_template_part('templates/parts/icons', 'portfolio-list', '', $params); ?>

            <?php
            if($pinterest_hover_type == "info_on_hover"){
                echo qode_get_shortcode_template_part('templates/parts/title', 'portfolio-list', 'with-link', $params);

                echo qode_get_shortcode_template_part('templates/parts/subtitle', 'portfolio-list', '', $params);

                echo qode_get_shortcode_template_part('templates/parts/categories', 'portfolio-list', 'with-comma  ', $params);
            }

        if($pinterest_hover_type == "info_on_hover"){ ?>
            </div>
            </div>
            </div>
        <?php } ?>

    </div>
    <?php if ($pinterest_hover_type != "info_on_hover") { ?>
        <div class='portfolio_description <?php echo esc_html($portfolio_description_class); ?>' <?php echo esc_html($portfolio_box_style); ?>>
            <?php
			echo qode_get_shortcode_template_part('templates/parts/title', 'portfolio-list', 'with-link', $params);

			echo qode_get_shortcode_template_part('templates/parts/subtitle', 'portfolio-list', '', $params);

			echo qode_get_shortcode_template_part('templates/parts/categories', 'portfolio-list', 'with-comma  ', $params);
            ?>
        </div>
    <?php } ?>

</article>
<?php //this line is because of the space between items ?>