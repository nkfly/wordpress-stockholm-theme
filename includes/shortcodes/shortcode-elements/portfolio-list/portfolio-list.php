<?php

namespace Stockholm\Shortcodes\PortfolioList;

use Stockholm\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class InteractiveImage
 */
class PortfolioList implements ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	/**
	 * CardsGallery constructor.
	 */
	public function __construct() {
		$this->base = 'portfolio_list';

		add_action('qode_vc_map', array($this, 'vcMap'));
	}

	/**
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}


	public function vcMap() {
		vc_map( array(
			"name" => "Portfolio List",
			"base" => "portfolio_list",
			"category" => 'by SELECT',
			"icon" => "icon-wpb-portfolio extended-custom-icon-qode",
			"allowed_container_element" => 'vc_row',
			"params" => array(
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Type",
					"param_name" => "type",
					"value" => array(
						"Standard" => "standard",
						"Standard No Space" => "standard_no_space",
						"Gallery Text" => "hover_text",
						"Gallery No Space" => "hover_text_no_space",
						"Masonry" => "masonry",
						"Pinterest" => "masonry_with_space",
						"Justified Gallery" => "justified_gallery"
					),
					'save_always' => true,
					"description" => ""
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Space Between Masonry",
					"param_name" => "masonry_space",
					"value" => array(
						"No" => "no",
						"Yes" => "yes"
					),
					"description" => "",
					'save_always' => true,
					"dependency" => array('element' => "type", 'value' => array('masonry'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Space Between Pinterest",
					"param_name" => "pinterest_space",
					"value" => array(
						"No" => "no",
						"Yes" => "yes"
					),
					"description" => "",
					'save_always' => true,
					"dependency" => array('element' => "type", 'value' => array('masonry_with_space'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Loading Type",
					"param_name" => "portfolio_loading_type",
					"value" => array(
						"Default" => "",
						"Appear From Bottom" => "appear_from_bottom"
					),
					"description" => "",
					'save_always' => true,
					"dependency" => array('element' => "type", 'value' => array('masonry_with_space', 'masonry'))
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => "Parallax Item Speed",
					"param_name" => "parallax_item_speed",
					"value" => "",
					"description" => 'This option only takes effect on portfolio items on which "Set Masonry Item in Parallax" is set to "Yes", default value is 0.3',
					"dependency" => array('element' => "masonry_space", 'value' => array('yes'))
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => "Parallax Item Offset",
					"param_name" => "parallax_item_offset",
					"value" => "",
					"description" => 'This option only takes effect on portfolio items on which "Set Masonry Item in Parallax" is set to "Yes", default value is 0',
					"dependency" => array('element' => "masonry_space", 'value' => array('yes'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Hover Type",
					"param_name" => "hover_type",
					"value" => array(
						"Default" => "default_hover",
						"Standard" => "standard_hover",
						"Elegant Without Icons" => "elegant_hover",
						"Move from Left" => "move_from_left",
						"Overlapping Title" => "overlapping_title_hover"
					),
					'save_always' => true,
					"dependency" => array('element' => "type", 'value' => array('hover_text','hover_text_no_space','masonry'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Pinterest Hover Type",
					"param_name" => "pinterest_hover_type",
					"value" => array(
						"Default" => "",
						"Info on Hover" => "info_on_hover"
					),
					'save_always' => true,
					"dependency" => array('element' => "type", 'value' => array('masonry_with_space'))
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => "Box Background Color",
					"param_name" => "box_background_color",
					"value" => "",
					"description" => "",
					"dependency" => array('element' => "type", 'value' => array('standard','standard_no_space', 'masonry_with_space'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Box Border",
					"param_name" => "box_border",
					"value" => array(
						"Default" => "",
						"No" => "no",
						"Yes" => "yes"
					),
					"description" => "",
					"dependency" => array('element' => "type", 'value' => array('standard','standard_no_space', 'masonry_with_space'))
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => "Box Border Width (px)",
					"param_name" => "box_border_width",
					"value" => "",
					"description" => "",
					"dependency" => array('element' => "box_border", 'value' => array('yes'))
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => "Box Border Color",
					"param_name" => "box_border_color",
					"value" => "",
					"description" => "",
					"dependency" => array('element' => "box_border", 'value' => array('yes'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Columns",
					"param_name" => "columns",
					"value" => array(
						"" => "",
						"2" => "2",
						"3" => "3",
						"4" => "4",
						"5" => "5",
						"6" => "6"
					),
					"description" => "",
					'save_always' => true,
					"dependency" => array('element' => "type", 'value' => array('standard','standard_no_space','hover_text','hover_text_no_space','masonry_with_space'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Image size",
					"param_name" => "image_size",
					"value" => array(
						"Default" => "",
						"Original Size" => "full",
						"Square" => "square",
						"Landscape" => "landscape",
						"Portrait" => "portrait"
					),
					"description" => "",
					"dependency" => array('element' => "type", 'value' => array('standard','standard_no_space','hover_text','hover_text_no_space'))
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => "Row Height (px)",
					"param_name" => "row_height",
					"value" => "200",
					"save_always" => true,
					"description" => "Targeted row height, which may vary depending on the proportions of the images.",
					"dependency" => array('element' => "type", 'value' => array('justified_gallery'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Last Row Behavior",
					"param_name" => "justify_last_row",
					"value" => array(
						"Align left" => "nojustify",
						"Align right" => "right",
						"Align centrally" => "center",
						"Justify" => "justify",
						"Hide" => "hide"
					),
					"description" => "Defines whether to justify the last row, align it in a certain way, or hide it.",
					"dependency" => array('element' => "type", 'value' => array('justified_gallery'))
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => "Justify Threshold (0-1)",
					"param_name" => "justify_threshold",
					"value" => "0.75",
					"description" => "If the last row takes up more than this part of available width, it will be justified despite the defined alignment. Enter 1 to never justify the last row.",
					"dependency" => array('element' => "justify_last_row", 'value' => array('nojustify','right','center'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Order By",
					"param_name" => "order_by",
					"value" => array(
						"" => "",
						"Menu Order" => "menu_order",
						"Title" => "title",
						"Date" => "date"
					),
					"description" => ""
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Order",
					"param_name" => "order",
					"value" => array(
						"" => "",
						"ASC" => "ASC",
						"DESC" => "DESC",
					),
					"description" => ""
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Filter",
					"param_name" => "filter",
					"value" => array(
						"" => "",
						"Yes" => "yes",
						"No" => "no"
					),
					"description" => "Default value is No"
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Filter Position",
					"param_name" => "filter_position",
					"value" => array(
						"Top" => "top",
						"Left" => "left"
					),
					"description" => "Default value is Top"
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Filter Order By",
					"param_name" => "filter_order_by",
					"value" => array(
						"Name"  => "name",
						"Count" => "count",
						"Id"    => "id",
						"Slug"  => "slug"
					),
					'save_always' => true,
					"description" => "Default value is Name",
					"dependency" => array('element' => "filter", 'value' => array('yes'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Disable Filter Title",
					"param_name" => "disable_filter_title",
					"value" => array(
						"" => "",
						"Yes" => "yes",
						"No" => "no"
					),
					"description" => "Default value is No",
					"dependency" => array('element' => "filter", 'value' => array('yes'))
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => "Filter Title Text",
					"param_name" => "filter_title_text",
					"value" => "",
					"description" => "Enter custom filter title text",
					"dependency" => array('element' => "disable_filter_title", 'value' => array('','no'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Filter Align",
					"param_name" => "filter_align",
					"value" => array(
						"Left" => "left_align",
						"Center" => "center_align",
						"Right" => "right_align"
					),
					'save_always' => true,
					"dependency" => array('element' => "filter", 'value' => array('yes'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Disable Portfolio Link",
					"param_name" => "disable_link",
					"value" => array(
						"" => "",
						"Yes" => "yes",
						"No" => "no"
					),
					"description" => "Default value is No",
					"dependency" => array('element' => "type", 'value' => array('standard','standard_no_space','hover_text','hover_text_no_space','masonry','masonry_with_space'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Show Lightbox",
					"param_name" => "lightbox",
					"value" => array(
						"" => "",
						"Yes" => "yes",
						"No" => "no"
					),
					"description" => "Default value is Yes"
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Show Like",
					"param_name" => "show_like",
					"value" => array(
						"" => "",
						"Yes" => "yes",
						"No" => "no"
					),
					"description" => "Default value is Yes"
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Show Load More",
					"param_name" => "show_load_more",
					"value" => array(
						"" => "",
						"Yes" => "yes",
						"No" => "no"
					),
					"description" => "Default value is Yes",
					"dependency" => array('element' => "type", 'value' => array('standard','standard_no_space','hover_text','hover_text_no_space', 'masonry_with_space', 'justified_gallery'))
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => "Number",
					"param_name" => "number",
					"value" => "-1",
					"description" => "Number of portolios on page (-1 is all)",
					"dependency" => array('element' => "type", 'value' => array('standard','standard_no_space','hover_text','hover_text_no_space','masonry','masonry_with_space', 'justified_gallery'))
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => "Category",
					"param_name" => "category",
					"value" => "",
					"description" => "Category Slug (leave empty for all)"
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => "Selected Projects",
					"param_name" => "selected_projects",
					"value" => "",
					"description" => "Selected Projects (leave empty for all, delimit by comma)"
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Title Tag",
					"param_name" => "title_tag",
					"value" => array(
						""   => "",
						"h2" => "h2",
						"h3" => "h3",
						"h4" => "h4",
						"h5" => "h5",
						"h6" => "h6",
					),
					"description" => "",
					"dependency" => array('element' => "type", 'value' => array('standard','standard_no_space','hover_text','hover_text_no_space','masonry','masonry_with_space'))
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => "Title Custom Font Size (px)",
					"param_name" => "title_font_size",
					"value" => "",
					"dependency" => array('element' => "type", 'value' => array('standard','standard_no_space','hover_text','hover_text_no_space','masonry','masonry_with_space'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Text align",
					"param_name" => "text_align",
					"value" => array(
						""   => "",
						"Left" => "left",
						"Center" => "center",
						"Right" => "right"
					),
					"description" => "",
					"dependency" => array('element' => 'type', 'value' => array('standard', 'standard_no_space', 'masonry_with_space'))
				)
			)
		) );
	}

	/**
	 * @param array $atts
	 * @param null $content
	 *
	 * @return string
	 */
	public function render($atts, $content = null) {
		$args = array(
			"type"                  	=> "standard",
			"masonry_space"             => "no",
			"pinterest_space"           => "no",
			"hover_type"            	=> "default_hover",
			"pinterest_hover_type"		=> "",
			"portfolio_loading_type"	=> "",
			"parallax_item_speed" 		=> "0.3",
			"parallax_item_offset" 		=> "0",
			"box_border"            	=> "",
			"box_background_color" 		=> "",
			"box_border_color"      	=> "",
			"box_border_width"      	=> "",
			"columns"               	=> "3",
			"image_size"            	=> "",
			"order_by"              	=> "date",
			"order"                 	=> "ASC",
			"number"                	=> "-1",
			"filter"                	=> "no",
			"filter_position"           => "top",
			"filter_order_by"           => "name",
			"disable_filter_title"      => "no",
			"filter_title_text"      	=> "",
			"filter_align"          	=> "left_align",
			"disable_link"          	=> "no",
			"lightbox"             		=> "yes",
			"show_like"             	=> "yes",
			"category"              	=> "",
			"selected_projects"     	=> "",
			"show_load_more"        	=> "yes",
			"title_tag"             	=> "h4",
			"title_font_size"       	=> "",
			"text_align"            	=> "",
			"row_height"                => "",
			"justify_last_row"          => "nojustify",
			"justify_threshold"         => 0.75
		);

        $params	= shortcode_atts($args, $atts);

		$params['thisObject'] = $this;

		$params['portfolio_qode_like'] = qode_options()->getOptionValue('portfolio_qode_like');

		$params['portfolio_list_hide_category'] = false;
		if (qode_options()->getOptionValue('portfolio_list_hide_category') == "yes") {
			$params['portfolio_list_hide_category'] = true;
		}

		if(qode_options()->getOptionValue('portfolio_filter_disable_separator') == "yes"){
			$params['portfolio_filter_class'] = "without_separator";
		} else {
			$params['portfolio_filter_class'] = "";
		}

		if($params['filter_title_text'] !== ''){
			$params['filter_title'] = $params['filter_title_text'];
		}else{
			$params['filter_title'] = esc_html('Sort Portfolio:', 'qode');
		}

		$params['_type_class'] = '';
		$params['_portfolio_space_class'] = '';
		$params['_portfolio_masonry_with_space_class'] = '';
		$params['_portfolio_masonry_class'] = '';
		$params['_loading_class'] = '';

		if ($params['type'] == "hover_text") {
			$params['_type_class'] = " hover_text";
			$params['_portfolio_space_class'] = "portfolio_with_space portfolio_with_hover_text";
		} elseif ($params['type'] == "standard" || $params['type'] == "masonry_with_space"){
			$params['_type_class'] = " standard";
			$params['_portfolio_space_class'] = "portfolio_with_space portfolio_standard";
			if($params['type'] == "masonry_with_space"){
				$params['_portfolio_masonry_with_space_class'] = ' masonry_with_space';
			}
			if($params['pinterest_space'] == "yes" && $params['type'] == "masonry_with_space"){
				$params['_portfolio_masonry_with_space_class'] = 'masonry_with_space pinterest_space';
			}
		} elseif ($params['type'] == "standard_no_space"){
			$params['_type_class'] = " standard_no_space";
			$params['_portfolio_space_class'] = "portfolio_no_space portfolio_standard";
		} elseif ($params['type'] == "hover_text_no_space"){
			$params['_type_class'] = " hover_text no_space";
			$params['_portfolio_space_class'] = "portfolio_no_space portfolio_with_hover_text";
		} elseif ($params['type'] == "justified_gallery"){
			$params['_type_class'] = " justified_gallery";
			$params['_portfolio_space_class'] = "portfolio_no_space";
		}

		$params['filter_position_class'] = $this->getFilterPositionClass($params);

		//get proper image size
		switch($params['image_size']) {
			case 'landscape':
				$params['thumb_size_class'] = 'portfolio_landscape_image';
				break;
			case 'portrait':
				$params['thumb_size_class'] = 'portfolio_portrait_image';
				break;
			case 'square':
				$params['thumb_size_class'] = 'portfolio_square_image';
				break;
			case 'full':
				$params['thumb_size_class'] = 'portfolio_full_image';
				break;
			default:
				$params['thumb_size_class'] = 'portfolio_default_image';
				break;
		}

		if ($params['type'] == 'justified_gallery') {
			$params['hover_type'] = " justified_gallery_hover ";
		}

		if ($params['portfolio_loading_type'] != ""){
			$params['_loading_class'] =  $params['portfolio_loading_type'];
		}

		if ($params['type'] == 'masonry_with_space' && $params['pinterest_hover_type'] == "info_on_hover") {
			$params['hover_type'] = " pinterest_info_on_hover ";
		}

		if($params['masonry_space'] == 'yes') {
			$params['_portfolio_masonry_class'] .= 'masonry_extended';
		}

		$params['portfolio_box_style'] = "";
		$params['portfolio_description_class'] = "";

		if($params['box_border'] == "yes" || $params['box_background_color'] != ""){

			$params['portfolio_box_style'] .= "style=";
			if($params['box_border'] == "yes"){
				$params['portfolio_box_style'] .= "border-style:solid;";
				if($params['box_border_color'] != "" ){
					$params['portfolio_box_style'] .= "border-color:" . $params['box_border_color'] . ";";
				}
				if($params['box_border_width'] != "" ){
					$params['portfolio_box_style'] .= "border-width:" . $params['box_border_width'] . "px;";
				} else {
					$params['portfolio_box_style'] .= "border-width: 1px;";
				}
			}
			if($params['box_background_color'] != ""){
				$params['portfolio_box_style'] .= "background-color:" . $params['box_background_color'] . ";";
			}
			$params['portfolio_box_style'] .= "'";

			$params['portfolio_description_class'] .= 'with_padding';

			$params['_portfolio_space_class'] = ' with_description_background';

		}

		if($params['text_align'] !== '') {
			$params['portfolio_description_class'] .= ' text_align_'.$params['text_align'];
		}

		$query_array = $this->getQueryArray($params);
		$query_results = new \WP_Query( $query_array );
		$params['query_results'] = $query_results;

	
		$params['slug_list_'] = "pretty_photo_gallery";
		$params['title'] = get_the_title();

		return qode_get_shortcode_template_part('templates/portfolio-holder', 'portfolio-list', $params['type'], $params);
	}

	public function getQueryArray( $params ) {
		if (get_query_var('paged')) {
			$paged = get_query_var('paged');
		} elseif (get_query_var('page')) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}
		if ($params['category'] == "") {
			$args = array(
				'post_type' => 'portfolio_page',
				'orderby' => $params['order_by'],
				'order' => $params['order'],
				'posts_per_page' => $params['number'],
				'paged' => $paged
			);
		} else {
			$args = array(
				'post_type' => 'portfolio_page',
				'portfolio_category' => $params['category'],
				'orderby' => $params['order_by'],
				'order' => $params['order'],
				'posts_per_page' => $params['number'],
				'paged' => $paged
			);
		}
		$project_ids = null;
		if ($params['selected_projects'] != "") {
			$project_ids = explode(",", $params['selected_projects']);
			$args['post__in'] = $project_ids;
		}

		return $args;
	}

	public function getMasonryItemClasses( $params ) {
		$classes = array();

		$terms = wp_get_post_terms(get_the_ID(), 'portfolio_category');
		foreach ($terms as $term) {
			$classes[] = "portfolio_category_".$term->term_id;
		}

		$masonry_parallax = get_post_meta(get_the_ID(), "qode_portfolio_masonry_parallax", true);
		if($masonry_parallax == "yes"){
			$classes[] = "parallax_item";
		}

		$masonry_size =  get_post_meta(get_the_ID(), "qode_portfolio_type_masonry_style", true);
		$classes[] = $masonry_size;

		return $classes;
	}

	public function getItemClasses( $params ) {
		$classes = array();

		$terms = wp_get_post_terms(get_the_ID(), 'portfolio_category');
		foreach ($terms as $term) {
			$classes[] = "portfolio_category_".$term->term_id;
		}

		return $classes;
	}

	public function getFilterPositionClass( $params ) {
		$classes = array();
		$filter_position = $params['filter_position'];

		switch ($filter_position) {
			case 'top':
				$classes[] = 'qode-filter-position-top';
				break;
			case 'left':
				$classes[] = 'qode-filter-position-left';
				break;
			default:
				$classes[] = 'qode-filter-position-top';
				break;
		}
		return $classes;
	}
}

