<?php
if($query_results->max_num_pages > 1) {
	if ($show_load_more == "yes" || $show_load_more == "") { ?>
		<div class="portfolio_paging"><span rel="<?php echo $query_results->max_num_pages; ?>" class="load_more"><?php echo get_next_posts_link(__('Show more', 'qode'), $query_results->max_num_pages); ?></span></div>
		<div class="portfolio_paging_loading"><a href="javascript: void(0)" class="qbutton"><?php esc_html_e('Loading...', 'qode') ?></a></div>
	<?php }
}
?>