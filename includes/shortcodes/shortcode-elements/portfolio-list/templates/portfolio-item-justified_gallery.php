<?php
        $custom_portfolio_link = get_post_meta(get_the_ID(), 'qode_portfolio-external-link', true);
        $portfolio_link = $custom_portfolio_link != "" ? $custom_portfolio_link : get_permalink();

        if(get_post_meta(get_the_ID(), 'qode_portfolio-external-link-target', true) != ""){
			$custom_portfolio_link_target = get_post_meta(get_the_ID(), 'qode_portfolio-external-link-target', true);
		} else {
			$custom_portfolio_link_target = '_blank';
		}
		$target = $custom_portfolio_link != "" ? $custom_portfolio_link_target : '_self';
?>
<article class="<?php echo implode(' ',$item_classes); ?>">
	<?php echo qode_get_shortcode_template_part('templates/parts/image', 'portfolio-list', 'justified_gallery', $params); ?>
    <?php if($disable_link != "yes"){ ?>
        <a class='portfolio_shader'  href='<?php echo esc_url($portfolio_link); ?>' target='<?php echo esc_html($target); ?>'></a>
    <?php } else { ?>
        <div class="portfolio_shader"></div>'
	<?php } ?>
	<?php echo qode_get_shortcode_template_part('templates/parts/icons', 'portfolio-list', '', $params); ?>
</article>
<?php //this line is because of the space between items ?>