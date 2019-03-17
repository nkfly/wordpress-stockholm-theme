<div class='projects_holder_outer portfolio_justified_gallery <?php echo implode(' ',$filter_position_class); ?>'>
    <?php
    echo qode_get_shortcode_template_part('templates/parts/filter', 'portfolio-list', '', $params);
    ?>
    <div class='projects_holder clearfix' data-spacing='10'
        <?php if($row_height != ''){echo "data-row-height=".$row_height;} ?>
        <?php if($justify_last_row != ""){ echo "data-last-row=".$justify_last_row;} ?>
        <?php if($justify_threshold != ''){ echo "data-justify-threshold=".$justify_threshold;} ?>>
    <?php
    if($query_results->have_posts()):
        while ( $query_results->have_posts() ) : $query_results->the_post();
			$params['item_classes'] = $thisObject->getItemClasses($params);
            echo qode_get_shortcode_template_part('templates/portfolio-item', 'portfolio-list', $type, $params);
        endwhile;
    else:
        echo qode_get_shortcode_template_part('templates/parts/posts-not-found', 'portfolio-list');
    endif;
    wp_reset_postdata();
    ?>
    </div>
	<?php echo qode_get_shortcode_template_part('templates/parts/show-more', 'portfolio-list', '', $params); ?>
</div>
