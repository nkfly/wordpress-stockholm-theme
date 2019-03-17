<?php
if(!function_exists('qode_add_widget_menu_closed_level_option')) {
	function qode_add_widget_menu_closed_level_option($widget, $return, $instance)
	{

		if ('nav_menu' == $widget->id_base) {

			$closed_sub_levels = isset($instance['closed_sub_levels']) ? $instance['closed_sub_levels'] : '';
			?>
			<p>
				<input class="checkbox" type="checkbox"
					   id="<?php echo esc_attr($widget->get_field_id('closed_sub_levels')); ?>"
					   name="<?php echo esc_attr($widget->get_field_name('closed_sub_levels')); ?>" <?php checked(true, $closed_sub_levels); ?> />
				<label for="<?php echo esc_attr($widget->get_field_id('closed_sub_levels')); ?>">
					<?php esc_html_e('Initially closed sub-levels', 'qode'); ?>
				</label>
			</p>
			<?php
		}
	}

	add_filter('in_widget_form', 'qode_add_widget_menu_closed_level_option', 10, 3);
}
if(!function_exists('qode_save_menu_closed_level_option')) {
	function qode_save_menu_closed_level_option($instance, $new_instance)
	{

		if (isset($new_instance['nav_menu']) && !empty($new_instance['closed_sub_levels'])) {
			$new_instance['closed_sub_levels'] = 1;
		}

		return $new_instance;
	}

	add_filter('widget_update_callback', 'qode_save_menu_closed_level_option', 10, 2);
}
if(!function_exists('qode_add_menu_closed_level_class')) {
	function qode_add_menu_closed_level_class($params)
	{

		$widget_settings = get_option('widget_nav_menu');

		if (!empty($widget_settings[$params[1]['number']]['closed_sub_levels'])) {
			add_filter('nav_menu_submenu_css_class', 'qode_menu_closed_level_class', 10, 3);
		} else {
			remove_filter('nav_menu_submenu_css_class', 'qode_menu_closed_level_class', 10, 3);
		}
		return $params;
	}

	add_filter('dynamic_sidebar_params', 'qode_add_menu_closed_level_class');
}
if(!function_exists('qode_menu_closed_level_class')) {
	function qode_menu_closed_level_class($classes, $args, $depth)
	{
		$classes[] = 'qode-sub-menu-closed';
		return $classes;
	}
}


