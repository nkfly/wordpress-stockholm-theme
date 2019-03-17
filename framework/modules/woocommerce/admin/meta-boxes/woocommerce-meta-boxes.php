<?php

if(!function_exists('qode_map_woocommerce_meta')) {
    function qode_map_woocommerce_meta() {
        $woocommerce_meta_box = qode_add_meta_box(
            array(
                'scope' => array('product'),
                'title' => esc_html__('Product Meta', 'qode'),
                'name' => 'woo_product_meta'
            )
        );

		qode_add_meta_box_field(array(
			'name'        => 'qode_single_product_new_meta',
			'type'        => 'select',
			'label'       => esc_html__('Enable New Product Mark', 'qode'),
			'description' => esc_html__('Enabling this option will show new product mark on your product elegant lists', 'qode'),
			'parent'      => $woocommerce_meta_box,
			'options'     => array(
				'no'  => esc_html__('No', 'qode'),
				'yes' => esc_html__('Yes', 'qode')
			)
		));
    }
	
    add_action('qode_meta_boxes_map', 'qode_map_woocommerce_meta', 99);
}