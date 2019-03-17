<div class='projects_holder_outer v<?php echo esc_html($columns).' '.esc_html($_portfolio_space_class).' '.esc_html($_portfolio_masonry_with_space_class).' '.implode(' ',$filter_position_class); ?>'>
<?php
echo qode_get_shortcode_template_part('templates/parts/filter', 'portfolio-list', '', $params);
?>

<div class='projects_holder clearfix v<?php echo esc_html($columns).esc_html($_type_class).' '.esc_html($thumb_size_class).' '.esc_html($_loading_class); ?>'>

<?php
    if($query_results->have_posts()):
        while ( $query_results->have_posts() ) : $query_results->the_post();
			$params['item_classes'] = $thisObject->getItemClasses($params);
            echo qode_get_shortcode_template_part('templates/portfolio-item', 'portfolio-list', $type, $params);
        endwhile;
		$i = 1;
		while ($i <= $columns) {
			$i++;
			if ($columns != 1) {?>
				<div class='filler'></div>
			<?php }
		}
    else:
        echo qode_get_shortcode_template_part('templates/parts/posts-not-found', 'portfolio-list');
    endif;
    wp_reset_postdata();
?>
</div>
    <?php echo qode_get_shortcode_template_part('templates/parts/show-more', 'portfolio-list', '', $params); ?>
</div>
