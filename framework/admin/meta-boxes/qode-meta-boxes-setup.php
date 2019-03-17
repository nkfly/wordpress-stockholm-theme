<?php

add_action('init', 'qode_meta_boxes_map_init');
function qode_meta_boxes_map_init() {

	do_action('qode_before_meta_boxes_map');

	require_once(QODE_ROOT_DIR.'/framework/admin/meta-boxes/page/map.php');
	require_once(QODE_ROOT_DIR.'/framework/admin/meta-boxes/portfolio/map.php');
	require_once(QODE_ROOT_DIR.'/framework/admin/meta-boxes/slides/map.php');
	require_once(QODE_ROOT_DIR.'/framework/admin/meta-boxes/post/map.php');
	require_once(QODE_ROOT_DIR.'/framework/admin/meta-boxes/testimonials/map.php');
	require_once(QODE_ROOT_DIR.'/framework/admin/meta-boxes/carousels/map.php');

	do_action('qode_meta_boxes_map');
}