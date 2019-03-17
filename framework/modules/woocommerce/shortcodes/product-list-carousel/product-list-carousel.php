<?php
namespace Stockholm\Shortcodes\ProductListElegantCarousel;

use Stockholm\Shortcodes\Lib\ShortcodeInterface;

class ProductListElegantCarousel implements ShortcodeInterface {
	private $base;
	
	function __construct() {
		$this->base = 'qode_product_list_carousel';
		
		add_action('vc_before_init', array($this,'vcMap'));
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		vc_map( array(
			'name' => esc_html__('Product List Elegant - Carousel', 'qode'),
			'base' => $this->base,
			'icon' => 'icon-wpb-product-list-carousel extended-custom-icon-qode',
			'category' => array(
				esc_html__('by SELECT', 'qode'),
				esc_html__('by SELECT SHOP', 'qode'),
			),
			'allowed_container_element' => 'vc_row',
			'params' => array(
					array(
						'type'       => 'textfield',
						'param_name' => 'number_of_posts',
						'heading'    => esc_html__('Number of Products', 'qode')
					),
					array(
						'type'       => 'dropdown',
						'param_name' => 'space_between_items',
						'heading'    => esc_html__('Space Between Items', 'qode'),
						'value'      => array(
							esc_html__('Normal', 'qode')   => 'normal',
							esc_html__('Small', 'qode')    => 'small',
							esc_html__('Tiny', 'qode')     => 'tiny',
							esc_html__('No Space', 'qode') => 'no'
						),
						'save_always' => true,
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'order_by',
						'heading'     => esc_html__('Order By', 'qode'),
						'value'       => array_flip(qode_get_query_order_by_array()),
						'save_always' => true
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'order',
						'heading'     => esc_html__('Order', 'qode'),
						'value'       => array_flip(qode_get_query_order_array()),
						'save_always' => true
					),
					array(
	                    'type'       => 'dropdown',
	                    'param_name' => 'taxonomy_to_display',
	                    'heading'    => esc_html__('Choose Sorting Taxonomy', 'qode'),
	                    'value'      => array(
							esc_html__('Category', 'qode') => 'category',
							esc_html__('Tag', 'qode')      => 'tag',
							esc_html__('Id', 'qode')       => 'id'
	                    ),
	                    'description' => esc_html__('If you would like to display only certain products, this is where you can select the criteria by which you would like to choose which products to display', 'qode')
	                ),
	                array(
	                    'type'        => 'textfield',
	                    'param_name'  => 'taxonomy_values',
	                    'heading'     => esc_html__('Enter Taxonomy Values', 'qode'),
	                    'description' => esc_html__('Separate values (category slugs, tags, or post IDs) with a comma', 'qode')
	                ),
	                array(
						'type'       => 'dropdown',
						'heading'    => esc_html__('Image Proportions', 'qode'),
						'param_name' => 'image_size',
						'value'      => array(
							esc_html__('Default', 'qode')        => '',
							esc_html__('Original', 'qode')       => 'full',
							esc_html__('Square', 'qode')         => 'square',
							esc_html__('Landscape', 'qode')      => 'landscape',
							esc_html__('Portrait', 'qode')       => 'portrait',
							esc_html__('Medium', 'qode')         => 'medium',
							esc_html__('Large', 'qode')          => 'large',
							esc_html__('Shop Catalog', 'qode')   => 'shop_catalog',
							esc_html__('Shop Single', 'qode')    => 'shop_single',
							esc_html__('Shop Thumbnail', 'qode') => 'shop_thumbnail'
						)
					),
					array(
						'type'       => 'dropdown',
						'param_name' => 'number_of_visible_items',
						'heading'    => esc_html__('Number Of Visible Items', 'qode'),
						'value'      => array(
							esc_html__('One', 'qode')   => '1',
							esc_html__('Two', 'qode')   => '2',
							esc_html__('Three', 'qode') => '3',
							esc_html__('Four', 'qode')  => '4',
							esc_html__('Five', 'qode')  => '5',
							esc_html__('Six', 'qode')   => '6'
						),
						'save_always' => true,
						'group'       => esc_html__('Slider Settings', 'qode')
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'slider_loop',
						'heading'     => esc_html__('Enable Slider Loop', 'qode'),
						'value'       => array_flip(qode_get_yes_no_select_array(false, true)),
						'save_always' => true,
						'group'       => esc_html__('Slider Settings', 'qode')
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'slider_autoplay',
						'heading'     => esc_html__('Enable Slider Autoplay', 'qode'),
						'value'       => array_flip(qode_get_yes_no_select_array(false, true)),
						'save_always' => true,
						'group'       => esc_html__('Slider Settings', 'qode')
					),
					array(
						'type'        => 'textfield',
						'param_name'  => 'slider_speed',
						'heading'     => esc_html__('Slider Speed', 'qode'),
						'description' => esc_html__('Default value is 5000 (ms)', 'qode'),
						'group'       => esc_html__('Slider Settings', 'qode')
					),
					array(
						'type'        => 'textfield',
						'param_name'  => 'slider_speed_animation',
						'heading'     => esc_html__('Slider Slide Animation', 'qode'),
						'description' => esc_html__('Speed of slide animation in milliseconds. Default value is 600.', 'qode'),
						'group'       => esc_html__('Slider Settings', 'qode')
					),
					array(
						'type'		  => 'dropdown',
						'param_name'  => 'slider_navigation',
						'heading'	  => esc_html__('Enable Slider Navigation Arrows', 'qode'),
						'value'       => array_flip(qode_get_yes_no_select_array(false, true)),
						'save_always' => true,
						'group'       => esc_html__('Slider Settings', 'qode')
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'display_title',
						'heading'     => esc_html__('Display Title', 'qode'),
						'value'       => array_flip(qode_get_yes_no_select_array(false, true)),
						'group'	      => esc_html__('Product Info', 'qode')
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'title_tag',
						'heading'     => esc_html__('Title Tag', 'qode'),
						'value'       => array_flip(qode_get_title_tag(true)),
						'dependency'  => array('element' => 'display_title', 'value' => array('yes')),
						'group'	      => esc_html__('Product Info Style', 'qode')
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'title_transform',
						'heading'     => esc_html__('Title Text Transform', 'qode'),
						'value'       => array_flip(qode_get_text_transform_array(true)),
						'dependency'  => array('element' => 'display_title', 'value' => array('yes')),
						'group'	      => esc_html__('Product Info Style', 'qode')
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'display_category',
						'heading'     => esc_html__('Display Category', 'qode'),
						'value'       => array_flip(qode_get_yes_no_select_array(false)),
						'group'	      => esc_html__('Product Info', 'qode')
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'display_excerpt',
						'heading'     => esc_html__('Display Excerpt', 'qode'),
						'value'       => array_flip(qode_get_yes_no_select_array(false)),
						'group'	      => esc_html__('Product Info', 'qode')
					),
					array(
						'type'        => 'textfield',
						'param_name'  => 'excerpt_length',
						'heading'     => esc_html__('Excerpt Length', 'qode'),
						'description' => esc_html__('Number of characters', 'qode'),
						'dependency'  => array('element' => 'display_excerpt', 'value' => array('yes')),
						'group'	      => esc_html__('Product Info Style', 'qode')
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'display_rating',
						'heading'     => esc_html__('Display Rating', 'qode'),
						'value'       => array_flip(qode_get_yes_no_select_array(false)),
						'group'	      => esc_html__('Product Info', 'qode')
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'display_price',
						'heading'     => esc_html__('Display Price', 'qode'),
						'value'       => array_flip(qode_get_yes_no_select_array(false, true)),
						'group'	      => esc_html__('Product Info', 'qode')
					)
				)
		) );

	}
	public function render($atts, $content = null) {
		$default_atts = array(
            'number_of_posts' 		  => '8',
            'space_between_items'	  => '',
            'order_by' 				  => 'date',
            'order' 				  => 'ASC',
            'taxonomy_to_display' 	  => 'category',
            'taxonomy_values' 		  => '',
            'image_size'			  => 'full',
			'number_of_visible_items' => '1',
			'slider_loop'		      => 'yes',
			'slider_autoplay'		  => 'yes',
			'slider_speed'		      => '5000',
			'slider_speed_animation'  => '600',
			'slider_navigation'	      => 'yes',
            'display_title' 		  => 'yes',
            'title_tag'				  => 'h5',
            'title_transform'		  => '',
			'display_category'        => 'yes',
			'display_excerpt'		  => 'no',
			'excerpt_length' 		  => '20',
			'display_rating' 		  => 'no',
			'display_price' 		  => 'yes',
            'display_button' 		  => 'yes',
        );
		
		$params = shortcode_atts($default_atts, $atts);
		extract($params);
		
		$params['holder_classes'] = $this->getHolderClasses($params);
		$params['holder_data'] = $this->getProductListCarouselDataAttributes($params);
		$params['class_name'] = 'plc';
		
		$params['title_tag'] = !empty($params['title_tag']) ? $params['title_tag'] : $default_atts['title_tag'];
		$params['title_styles'] = $this->getTitleStyles($params);

		$queryArray = $this->generateProductQueryArray($params);
		$query_result = new \WP_Query($queryArray);
		$params['query_result'] = $query_result;

		$html = qode_get_woo_shortcode_module_template_part('templates/product-list-carousel', 'product-list-carousel', '', $params);
		
		return $html;
	}

	/**
	   * Generates holder classes
	   *
	   * @param $params
	   *
	   * @return string
	*/
	private function getHolderClasses($params){
		$holderClasses = '';
		
		$columnsSpace = !empty($params['space_between_items']) ? 'qode-'.$params['space_between_items'].'-space' : 'qode-normal-space';
		
		$holderClasses .= ' '. $columnsSpace;
		
		return $holderClasses;
	}
	
    /**
     * Return all data that product list carousel needs
     *
     * @param $params
     * @return array
     */
    private function getProductListCarouselDataAttributes($params) {
	    $slider_data = array();
	
	    $slider_data['data-number-of-items']        = !empty($params['number_of_visible_items']) ? $params['number_of_visible_items'] : '1';
	    $slider_data['data-enable-loop']            = !empty($params['slider_loop']) ? $params['slider_loop'] : '';
	    $slider_data['data-enable-autoplay']        = !empty($params['slider_autoplay']) ? $params['slider_autoplay'] : '';
	    $slider_data['data-slider-speed']           = !empty($params['slider_speed']) ? $params['slider_speed'] : '5000';
	    $slider_data['data-slider-speed-animation'] = !empty($params['slider_speed_animation']) ? $params['slider_speed_animation'] : '600';
	    $slider_data['data-enable-navigation']      = !empty($params['slider_navigation']) ? $params['slider_navigation'] : '';
	
	    return $slider_data;
    }

	/**
	   * Generates query array
	   *
	   * @param $params
	   *
	   * @return array
	*/
	public function generateProductQueryArray($params){
		$queryArray = array(
			'post_status' => 'publish',
			'post_type' => 'product',
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $params['number_of_posts'],
			'orderby' => $params['order_by'],
			'order' => $params['order']
		);

        if ($params['taxonomy_to_display'] !== '' && $params['taxonomy_to_display'] === 'category') {
            $queryArray['product_cat'] = $params['taxonomy_values'];
        }

        if ($params['taxonomy_to_display'] !== '' && $params['taxonomy_to_display'] === 'tag') {
            $queryArray['product_tag'] = $params['taxonomy_values'];
        }

        if ($params['taxonomy_to_display'] !== '' && $params['taxonomy_to_display'] === 'id') {
            $idArray = $params['taxonomy_values'];
            $ids = explode(',', $idArray);
            $queryArray['post__in'] = $ids;
        }

        return $queryArray;
	}
	
	/**
	 * Return Style for Title
	 *
	 * @param $params
	 * @return string
	 */
	public function getTitleStyles($params) {
		$styles = array();
		
		if (!empty($params['title_transform'])) {
			$styles[] = 'text-transform: '.$params['title_transform'];
		}
		
		return implode(';', $styles);
	}
}