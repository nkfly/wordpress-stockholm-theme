<?php

if (!function_exists('qode_shop_category_showcase')) {
	function qode_shop_category_showcase($atts, $content = null) {

		$args = array(
			'cat_slug' => '',
			'product_id' => '',
			'product_id_2' => '',
			'products_position' => ''
		);

		extract(shortcode_atts($args, $atts));

		$html = '';
		$cat1_html = $cat1_img = $cat1_href = '';
		$products_html = '';
		$classes = '';
		$cat1 = false;

		if($products_position != ''  && $products_position == 'left') {
			$classes .= 'cat_and_products_33_66';
		}
		else if($products_position != ''  && $products_position == 'right') {
			$classes .= 'cat_and_products_66_33';
		}

		if($cat_slug != '') {
			$cat1 = get_term_by('slug',$cat_slug,'product_cat');
		}

		if($cat1) {
			$category_thumbnail = get_woocommerce_term_meta($cat1->term_id, 'thumbnail_id', true);
			$cat1_img =  wp_get_attachment_image_src($category_thumbnail, 'full');
			$cat1_href = get_term_link( $cat1->term_id, 'product_cat' );

			$cat1_html .= '<div class="qode_category_showcase_category_holder">';
			$cat1_html .= '<div class="qode_category_showcase_category_image">';
			$cat1_html .= '</div>';
			$cat1_html .= '<a class="qode_category_showcase_category_info" target="_self" href="' . $cat1_href . '" style="background-image: url(' . $cat1_img[0] . ')">';
			$cat1_html .= '<div class="qode_category_showcase_category_name">';
			$cat1_html .= '<span>' . $cat1->name . '</span>';
			$cat1_html .= '</div>';
			$cat1_html .= '</a>';
			$cat1_html .= '</div>';
		}

		if($product_id != '') {
			$product = wc_get_product($product_id);
			if($product) {
				$image_id = $product->get_image_id();
				$products_html .= '<div class="qode_category_showcase_product_holder">'; 			// open product holder
				$products_html .= '<div class="qode_category_showcase_product_holder_inner">'; 		// open product holder inner
				$products_html .= '<div class="qode_category_showcase_product_image_holder">'; 		// open image holder
				$products_html .= '<div class="qode_category_showcase_product_shader"></div>'; 		// image shader
				$products_html .=  wp_get_attachment_image($image_id, 'full');
				$products_html .= '</div>';															// close image holder
				$products_html .= '<a class="qode_category_showcase_product_info_holder" ';			// open info holder
				$products_html .= 'target="_self" href="' . $product->get_permalink() . '">';
				$products_html .= '<div class="qode_category_showcase_product_info_holder_inner">';	// open info holder inner
				$products_html .= '<div class="qode_category_showcase_product_info_wrapper">';		// open info wrapper
				$products_html .= '<div class="qode_category_showcase_product_title">';				// open product title
				$products_html .= '<span>' . $product->get_title() . '</span>';
				$products_html .= '</div>';															// close product title
				$products_html .= '<div class="qode_category_showcase_product_price">';				// open product price
				$products_html .=  $product->get_price_html();
				$products_html .= '</div>';															// close product price
				$products_html .= '</div>';															// close info holder inner
				$products_html .= '</div>';															// close info wrapper
				$products_html .= '</a>'; 															// close info holder
				$products_html .= '</div>'; 														// close product holder inner
				$products_html .= '</div>';
			}
			if($product_id_2 == '') {
				$classes .= ' showcase_single_product';
			}
		}

		if($product_id_2 != '') {
			$product = wc_get_product($product_id_2);
			if($product) {
				$image_id = $product->get_image_id();
				$products_html .= '<div class="qode_category_showcase_product_holder">'; 			// open product holder
				$products_html .= '<div class="qode_category_showcase_product_holder_inner">'; 		// open product holder inner
				$products_html .= '<div class="qode_category_showcase_product_image_holder">'; 		// open image holder
				$products_html .= '<div class="qode_category_showcase_product_shader"></div>'; 		// image shader
				$products_html .=  wp_get_attachment_image($image_id, 'full');
				$products_html .= '</div>';															// close image holder
				$products_html .= '<a class="qode_category_showcase_product_info_holder" ';			// open info holder
				$products_html .= 'target="_self" href="' . $product->get_permalink() . '">';
				$products_html .= '<div class="qode_category_showcase_product_info_holder_inner">';	// open info holder inner
				$products_html .= '<div class="qode_category_showcase_product_info_wrapper">';		// open info wrapper
				$products_html .= '<div class="qode_category_showcase_product_title">';				// open product title
				$products_html .= '<span>' . $product->get_title() . '</span>';
				$products_html .= '</div>';															// close product title
				$products_html .= '<div class="qode_category_showcase_product_price">';				// open product price
				$products_html .=  $product->get_price_html();
				$products_html .= '</div>';															// close product price
				$products_html .= '</div>';															// close info holder inner
				$products_html .= '</div>';															// close info wrapper
				$products_html .= '</a>'; 															// close info holder
				$products_html .= '</div>'; 														// close product holder inner
				$products_html .= '</div>'; 														// close product holder
			}
			if($product_id == '') {
				$classes .= ' showcase_single_product';
			}
		}

		$html .= '<div class="qode_shop_category_showcase ' .$classes . ' ">';

		$html .= '<div class="qode_shop_category_showcase_element element_left">';

		if($products_position == 'right') {
			$html .= $cat1_html;
		}
		else {
			$html .= $products_html;
		}
		$html .= '</div>';

		$html .= '<div class="qode_shop_category_showcase_element element_right">';
		if($products_position == 'left') {
			$html .= $cat1_html;
		}
		else {
			$html .= $products_html;
		}
		$html .= '</div>';

		$html .=  '</div>'; /* close qode_shop_category_showcase */
		return $html;
	}

	add_shortcode('qode_shop_category_showcase', 'qode_shop_category_showcase');
}