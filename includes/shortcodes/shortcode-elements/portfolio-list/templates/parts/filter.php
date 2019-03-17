<?php
if ($filter == "yes") { ?>
<div class='filter_outer <?php echo esc_attr($filter_align); ?>'>
    <div class='filter_holder  <?php echo esc_attr($portfolio_filter_class); ?>'>
        <ul>
            <?php if($disable_filter_title != "yes"){ ?>
                <li class='filter_title'><span><?php echo esc_html($filter_title); ?></span></li>
            <?php } ?>

            <?php if (in_array($type, array('standard','standard_no_space','hover_text','hover_text_no_space'))) { ?>
                <li class='filter' data-filter='all'><span><?php esc_html_e('All', 'qode') ?></span></li>
            <?php }else{ ?>
                <li class='filter' data-filter='*'><span><?php esc_html_e('All', 'qode') ?></span></li>
            <?php } ?>

            <?php if ($category == "") {
                    $args = array(
                            'parent' => 0,
                            'orderby' => $filter_order_by
                    );
                    $portfolio_categories = get_terms('portfolio_category', $args);
            } else {
                    $top_category = get_term_by('slug', $category, 'portfolio_category');
                    $term_id = '';
                    if (isset($top_category->term_id))
                            $term_id = $top_category->term_id;
                            $args = array(
                                    'parent' => $term_id,
                                    'orderby' => $filter_order_by
                            );
                            $portfolio_categories = get_terms('portfolio_category', $args);
            }
            foreach ($portfolio_categories as $portfolio_category) { ?>
                <li class='filter' data-filter='.portfolio_category_<?php echo esc_attr($portfolio_category->term_id); ?>'><span><?php echo esc_html($portfolio_category->name); ?></span>
                <?php $args = array(
                    'child_of' => $portfolio_category->term_id
                );
                ?>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php } ?>
