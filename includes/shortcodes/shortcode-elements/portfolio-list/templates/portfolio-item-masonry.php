<article class="portfolio_masonry_item <?php echo implode(' ',$masonry_item_classes); ?>">
    <div class='image_holder <?php echo esc_html($hover_type); ?>'>
        <?php echo qode_get_shortcode_template_part('templates/parts/image', 'portfolio-list', 'masonry', $params); ?>
        <?php echo qode_get_shortcode_template_part('templates/hover-types/'.$hover_type, 'portfolio-list', '', $params); ?>
    </div>
</article>
<?php //this line is because of the space between items ?>