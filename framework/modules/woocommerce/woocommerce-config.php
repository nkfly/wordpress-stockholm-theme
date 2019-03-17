<?php

//Disable the default WooCommerce stylesheet.
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

if(!function_exists('qode_woo_related_products_args')) {
    /**
     * Function that sets number of displayed related products. Hooks to woocommerce_output_related_products_args filter
     * @param $args array array of args for the query
     * @return mixed array of changed args
     */
    function qode_woo_related_products_args( $args ) {
        $args['posts_per_page'] = 4;
        
        return $args;
    }

    add_filter( 'woocommerce_output_related_products_args', 'qode_woo_related_products_args' );
}

if(!function_exists('qode_woo_upsell_products_args')) {
	function qode_woo_upsell_products_args( $args ) {
		$args['posts_per_page'] = 4;
		
		return $args;
	}
	
	add_filter( 'woocommerce_upsell_display_args', 'qode_woo_upsell_products_args' );
}

// Define number of products per page.
if(!function_exists('qode_woo_product_per_page')) {
    /**
     * Function that sets number of products per page. Default is 12
     * @return int number of products to be shown per page
     */
    function qode_woo_product_per_page() {
        global $qode_options;

        $products_per_page = 12;
        if(isset($qode_options['woo_products_per_page']) && $qode_options['woo_products_per_page']) {
            $products_per_page = $qode_options['woo_products_per_page'];
        }

        return $products_per_page;
    }

    add_filter('loop_shop_per_page', 'qode_woo_product_per_page', 20);
}

// Hook in
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');

/**
 * Remove add to cart function from woocommerce_after_shop_loop_item_title hook
 * and hook it in qode_woocommerce_after_product_image
 */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action('qode_woocommerce_after_product_image', 'woocommerce_template_loop_add_to_cart', 10);

/**
 * Overrides placeholder values for checkout fields
 * @param array all checkout fields
 * @return array checkout fields with overriden values
 */
function custom_override_checkout_fields($fields) {
    //billing fields
    $args_billing = array(
        'first_name' => __('First name','qode'),
        'last_name'  => __('Last name','qode'),
        'company'    => __('Company name','qode'),
        'address_1'  => __('Address','qode'),
        'email'      => __('Email','qode'),
        'phone'      => __('Phone','qode'),
        'postcode'   => __('Postcode / ZIP','qode'),
        'city'       => __('Town / City','qode'),
        'state'      => __('State / County','qode')
    );
    
    //shipping fields
    $args_shipping = array(
        'first_name' => __('First name','qode'),
        'last_name'  => __('Last name','qode'),
        'company'    => __('Company name','qode'),
        'address_1'  => __('Address','qode'),
        'postcode'   => __('Postcode / ZIP','qode')
    );
    
    //override billing placeholder values
    foreach ($args_billing as $key => $value) {
        $fields["billing"]["billing_{$key}"]["placeholder"] = $value;
    }
    
    //override shipping placeholder values
    foreach ($args_shipping as $key => $value) {
        $fields["shipping"]["shipping_{$key}"]["placeholder"] = $value;
    }

    return $fields;
}

// Adds theme support for woocommerce 
add_theme_support('woocommerce');

if (!function_exists('woocommerce_content')){

    /**
     * Output WooCommerce content.
     *
     * This function is only used in the optional 'woocommerce.php' template
     * which people can add to their themes to add basic woocommerce support
     * without hooks or modifying core templates.
     *
     * @access public
     * @return void
     */
    function woocommerce_content() {

        if ( is_singular( 'product' ) ) {

            while ( have_posts() ) : the_post();
	
	            wc_get_template_part( 'content', 'single-product' );

            endwhile;

        } else {

            ?>

            <?php do_action( 'woocommerce_archive_description' ); ?>

            <?php if ( have_posts() ) : ?>

                <?php do_action('woocommerce_before_shop_loop'); ?>

                <?php woocommerce_product_loop_start(); ?>

                    <?php woocommerce_product_subcategories(); ?>

                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php wc_get_template_part( 'content', 'product' ); ?>

                    <?php endwhile; // end of the loop. ?>

                <?php woocommerce_product_loop_end(); ?>

                <?php do_action('woocommerce_after_shop_loop'); ?>

            <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

                <?php wc_get_template_part( 'loop/no-products-found.php' ); ?>

            <?php endif;

        }
    }
}
if ( ! function_exists( 'woocommerce_output_product_data_tabs' ) ) {

	/**
	 * Output the product tabs.
	 *
	 * @access public
	 * @subpackage	Product/Tabs
	 * @return void
	 */
	function woocommerce_output_product_data_tabs() {
		wc_get_template( 'single-product/tabs/tabs.php' );
                echo '</div>';
	}
}


if(!function_exists('woocommerce_change_actions_priorities')) {
    /**
     * Function that changes woocommerce actions priorities.
     * Used in product listing to put product rating bellow product price
     */
    function woocommerce_change_actions_priorities() {
        $actions = array(
            array(
                'tag' => 'woocommerce_after_shop_loop_item_title',
                'action' => 'woocommerce_template_loop_price',
                'priority' => 10,
                'priority_to_set' => 10
            ),
            array(
                'tag' => 'woocommerce_after_shop_loop_item_title',
                'action' => 'woocommerce_template_loop_rating',
                'priority' => 5,
                'priority_to_set' => 11
            )
        );
        
        foreach($actions as $action) {
            //actions which priorities needs to be changed
            remove_action($action['tag'], $action['action'], $action['priority']);
            
            //new priorities
            add_action($action['tag'], $action['action'], $action['priority_to_set']);
        }
    }
    
    add_action('woocommerce_change_priorities', 'woocommerce_change_actions_priorities');
    do_action('woocommerce_change_priorities');
}

if(!function_exists('qode_woocommerce_share')) {
    function qode_woocommerce_share() {
        global $qode_options;
        //check social share style
        $social_type = 'circle';
        if(isset($qode_options['woo_product_single_single_social_share_type'])  && $qode_options['woo_product_single_single_social_share_type'] != "") {
            $social_type = $qode_options['woo_product_single_single_social_share_type'];
        }
        if(do_shortcode('[social_share_list]') != ""){
            echo '<span class="social_share_title">'.  __( "Share:", "qode" ) .' </span>';
            echo do_shortcode('[social_share_list list_type=' . $social_type . ']');
        }
    }

    add_action('woocommerce_product_meta_end', 'qode_woocommerce_share');
}

//Remove open and close link position
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );


if(qode_options()->getOptionValue('woo_products_list_type') == 'elegant') {


	/*************** GENERAL FILTERS - begin ***************/

	//Sale flash template override
	add_filter('woocommerce_sale_flash', 'qode_elegant_woocommerce_sale_flash');

	//Out of stock template
	add_filter('woocommerce_product_thumbnails', 'qode_elegant_woocommerce_product_out_of_stock');
	add_action('woocommerce_before_shop_loop_item_title', 'qode_elegant_woocommerce_product_out_of_stock', 10);

	//New product template
	add_action('woocommerce_before_shop_loop_item_title', 'qode_elegant_woocommerce_new_product_mark', 10);

	/*************** GENERAL FILTERS - end ***************/

	/*************** PRODUCT SINGLE FILTERS - begin ***************/

	//add sale flash on image
	remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash');
	add_action('woocommerce_product_thumbnails', 'woocommerce_show_product_sale_flash');
	add_action('woocommerce_product_thumbnails', 'qode_elegant_woocommerce_new_product_mark');

	/*************** PRODUCT SINGLE FILTERS - end ***************/


	/*************** PRODUCT LISTS FILTERS - begin ***************/

        //Add additional html tags around product lists
        add_action('woocommerce_before_shop_loop', 'qode_elegant_pl_holder_additional_tag_before', 35);
        add_action('woocommerce_after_shop_loop', 'qode_elegant_pl_holder_additional_tag_after', 5);

        //Add additional html tag around product elements
        add_action('woocommerce_before_shop_loop_item', 'qode_elegant_pl_inner_additional_tag_before', 5);

        //Remove open and close link position
        remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

        //Add additional html tags around image and marks
        add_action('woocommerce_before_shop_loop_item_title', 'qode_elegant_pl_image_additional_tag_before', 5);
        add_action('qode_action_shop_elegant_woo_pl_info_below_image', 'qode_elegant_pl_image_additional_tag_after', 6);
        add_action('qode_action_shop_elegant_woo_pl_info_on_image_hover', 'qode_elegant_pl_image_additional_tag_after', 1);


        /*************** Product Info Position Is On Image Hover ***************/

        //Add additional html tag around product elements
        add_action('qode_action_shop_elegant_woo_pl_info_on_image_hover', 'qode_elegant_pl_inner_additional_tag_after', 22);

        //Add open and close link position
        add_action('qode_action_shop_elegant_woo_pl_info_on_image_hover', 'woocommerce_template_loop_product_link_open', 21);
        add_action('qode_action_shop_elegant_woo_pl_info_on_image_hover', 'woocommerce_template_loop_product_link_close', 21);

        //Add additional html around product info elements
        add_action('qode_action_shop_elegant_woo_pl_info_on_image_hover', 'qode_elegant_pl_inner_text_additional_tag_before', 5);
        add_action('qode_action_shop_elegant_woo_pl_info_on_image_hover', 'qode_elegant_pl_inner_text_additional_tag_after', 15);

        //Override product title with our own html
        remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
        add_action('qode_action_shop_elegant_woo_pl_info_on_image_hover', 'qode_elegant_woocommerce_template_loop_product_title', 7);

        //Add additional html tags around rating star element
        add_action('qode_action_shop_elegant_woo_pl_info_on_image_hover', 'qode_elegant_pl_rating_additional_tag_before', 9);
        add_action('qode_action_shop_elegant_woo_pl_info_on_image_hover', 'qode_elegant_pl_rating_additional_tag_after', 11);

        //Change rating star position
        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
        add_action('qode_action_shop_elegant_woo_pl_info_on_image_hover', 'woocommerce_template_loop_rating', 10);

        //Change price position
        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
        add_action('qode_action_shop_elegant_woo_pl_info_on_image_hover', 'woocommerce_template_loop_price', 12);

        //Change add to cart position
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
        add_action('qode_action_shop_elegant_woo_pl_info_on_image_hover', 'woocommerce_template_loop_add_to_cart', 13);


        /*************** Product Info Position Is Below Image ***************/

        //Add open and close link position
        add_action('qode_action_shop_elegant_woo_pl_info_below_image', 'qode_elegant_pl_additional_info_before', 18);
        add_action('qode_action_shop_elegant_woo_pl_info_below_image', 'qode_elegant_pl_additional_info', 18);
        add_action('qode_action_shop_elegant_woo_pl_info_below_image', 'qode_elegant_pl_additional_info_after', 18);

        //Add open and close link position
        add_action('qode_action_shop_elegant_woo_pl_info_below_image', 'woocommerce_template_loop_product_link_open', 19);
        add_action('qode_action_shop_elegant_woo_pl_info_below_image', 'woocommerce_template_loop_product_link_close', 19);

        //Add additional html tag around product elements
        add_action('qode_action_shop_elegant_woo_pl_info_below_image', 'qode_elegant_pl_inner_additional_tag_after', 20);

        //Add additional html at the end of product info elements
        add_action('qode_action_shop_elegant_woo_pl_info_below_image', 'qode_elegant_pl_text_wrapper_additional_tag_before', 21);
        add_action('qode_action_shop_elegant_woo_pl_info_below_image', 'qode_elegant_pl_text_wrapper_additional_tag_after', 30);

        //Add categoriers html
	    add_action('qode_action_shop_elegant_woo_pl_info_below_image', 'qode_elegant_pl_categories', 22);

        //Override product title with our own html
        remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
        add_action('qode_action_shop_elegant_woo_pl_info_below_image', 'qode_elegant_woocommerce_template_loop_product_title', 23);

        //Change price position
        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
        add_action('qode_action_shop_elegant_woo_pl_info_below_image', 'woocommerce_template_loop_price', 27);

        //Change add to cart position
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
        add_action('qode_action_shop_elegant_woo_pl_info_below_image', 'qode_elegant_woocommerce_template_loop_add_to_cart', 28);

        //Add additional html around add to cart element
        add_action('qode_action_shop_elegant_woo_pl_info_below_image', 'qode_elegant_pl_inner_text_additional_tag_before', 1);
        add_action('qode_action_shop_elegant_woo_pl_info_below_image', 'qode_elegant_pl_inner_text_additional_tag_after', 4);

	/*************** PRODUCT LISTS FILTERS - end ***************/

}