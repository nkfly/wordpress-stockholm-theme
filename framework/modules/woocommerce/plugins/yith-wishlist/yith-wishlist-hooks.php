<?php

if(!function_exists('qode_woocommerce_wishlist_position')) {
	function qode_woocommerce_wishlist_position() {
		$order =  array(
			'add-to-cart' => array( 'hook' => 'woocommerce_single_product_summary', 'priority' => 29 ),
			'thumbnails'  => array( 'hook' => 'woocommerce_product_thumbnails', 'priority' => 21 ),
			'summary'     => array( 'hook' => 'woocommerce_after_single_product_summary', 'priority' => 11 )
		);

		return $order;
	}
}