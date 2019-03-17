<?php

namespace Stockholm\Shortcodes\SimpleBlogList;

use Stockholm\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class CardsGallery
 */
class SimpleBlogList implements ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	/**
	 * CardsGallery constructor.
	 */
	public function __construct() {
		$this->base = 'qode_simple_blog_list';

		add_action('qode_vc_map', array($this, 'vcMap'));
	}

	/**
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	/**
	 *
	 */
	public function vcMap() {
		vc_map(array(
			'name'                      => esc_html__('Simple Blog List', 'qode'),
			'base'                      => $this->base,
			'category'                  => esc_html__('by SELECT', 'qode'),
			'icon'                      => 'icon-wpb-simple-blog-list extended-custom-icon-qode',
			'params'					=> array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__('Posts Title Tag', 'qode'),
					'param_name' => 'posts_title_tag',
					'value' => array(
						''   => '',
						'h2' => 'h2',
						'h3' => 'h3',
						'h4' => 'h4',
						'h5' => 'h5',
						'h6' => 'h6',
					)
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> 'Excerpt Length',
					'param_name'	=> 'excerpt_length',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__('Number of Columns', 'qode'),
					'param_name' => 'number_of_columns',
					'value' => array(
						'3' => '3',
						'4' => '4',
						'5' => '5'
					),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__('Read More Hover Animation', 'qode'),
					'param_name'	=> 'read_more_hover_animation',
					'value'			=> array(
						esc_html__('Default', 'qode')		=> '',
						esc_html__('Display Dash', 'qode')	=> 'display-dash'
					)
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__('Enable Blog List Animation', 'qode'),
					'param_name'	=> 'blog_list_animation',
					'value'			=> array(
						esc_html__('No', 'qode')	=> 'no',
						esc_html__('Yes', 'qode')	=> 'yes'
					)
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__('Number', 'qode'),
					'param_name'	=> 'number',
					'description'	=> esc_html__('Number of blog posts on page (Leave empty for all)', 'qode'),
					'group'			=> esc_html__('Build Query ', 'qode')
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__('Order By', 'qode'),
					'param_name'	=> 'order_by',
					'value'			=> array(
						esc_html__('Date', 'qode')	=> 'date',
						esc_html__('Title', 'qode')	=> 'title'

					),
					'group'			=> esc_html__('Build Query ', 'qode')
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__('Order', 'qode'),
					'param_name'	=> 'order',
					'value'			=> array(
						esc_html__('DESC', 'qode')	=> 'DESC',
						esc_html__('ASC', 'qode')	=> 'ASC'
					),
					'group'			=> esc_html__('Build Query ', 'qode')
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__('Category', 'qode'),
					'param_name'	=> 'category',
					'description'	=> esc_html__('Category Slug (leave empty for all)', 'qode'),
					'group'			=> esc_html__('Build Query ', 'qode')
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__('Selected Posts', 'qode'),
					'param_name'	=> 'selected_projects',
					'description'	=> esc_html__('Selected Posts (leave empty for all, delimit by comma)', 'qode'),
					'group'			=> esc_html__('Build Query ', 'qode')
				)
			)

		));
	}

	/**
	 * @param array $atts
	 * @param null $content
	 *
	 * @return string
	 */
	public function render($atts, $content = null) {
        $args = array(
            'posts_title_tag'				=> 'h3',
            'excerpt_length'				=> '',
            'number_of_columns'				=> '3',
            'read_more_hover_animation'		=> '3',
            'blog_list_animation'	    	=> 'no',
            'number'						=> '-1',
            'order'							=> 'DESC',
            'order_by'						=> 'date',
            'category'						=> '',
            'selected_projects'				=> '',
            'title_color'					=> ''
        );

        $params	= shortcode_atts($args, $atts);

		$query_args = $this->createQueryArgs($params);
		$blog_query = new \WP_Query($query_args);
		$params['blog_query']			= $blog_query;
		$params['holder_classes']		= $this->holderClasses($params);
		$params['read_more_classes']	= $this->readMoreClasses($params);

		return qode_get_shortcode_template_part('templates/simple-blog-list-template', 'simple-blog-list', '', $params);
	}

	private function createQueryArgs($params) {

		$args = array(
			'post_type'			=> 'post',
			'orderby'			=> $params['order_by'],
			'order'				=> $params['order'],
			'posts_per_page'	=> $params['number']
		);

		if($params['category'] !== '') {
			$args['category_name'] = $params['category'];
		}

		if($params['selected_projects'] !== '') {
			$args['post__in'] = explode(",", $params['selected_projects']);
		}

		return $args;
	}


	private function holderClasses($params) {

		$classes = array('qode-simple-blog-list');
		if($params['number_of_columns'] != ''){
			$classes[] = 'qode-sbl-' . $params['number_of_columns'] . '-columns';
		}
		if($params['blog_list_animation'] == 'yes'){
			$classes[] = 'qode-sbl-animated';
		}
		return $classes;
	}
	private function readMoreClasses($params) {

		$classes = array('');
		if($params['read_more_hover_animation'] == 'display-dash'){
			$classes[] = 'display_dash';
		}
		return implode(' ', $classes);
	}
}