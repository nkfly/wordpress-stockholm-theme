<?php
echo qode_get_shortcode_template_part('templates/parts/filter', 'portfolio-list', '', $params);
?>
<div class='projects_masonry_holder <?php echo esc_html($params['_loading_class']).' '.esc_attr($params['_portfolio_masonry_class']).' '.implode(' ',$filter_position_class); ?>' data-parallax_item_speed='<?php echo esc_attr($params['parallax_item_speed'])?>' data-parallax_item_offset='<?php esc_attr($params['parallax_item_offset']); ?>'>
    <?php
        if($query_results->have_posts()):
            while ( $query_results->have_posts() ) : $query_results->the_post();
				$params['masonry_item_classes'] = $thisObject->getMasonryItemClasses($params);
                echo qode_get_shortcode_template_part('templates/portfolio-item', 'portfolio-list', $type, $params);
            endwhile;
        else:
            echo qode_get_shortcode_template_part('templates/parts/posts-not-found', 'portfolio-list');
        endif;
        wp_reset_postdata();
    ?>
</div>
