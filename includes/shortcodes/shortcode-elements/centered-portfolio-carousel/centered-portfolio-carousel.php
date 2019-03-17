<?php

namespace Stockholm\Shortcodes\CenteredPortfolioCarousel;

use Stockholm\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class CenteredPortfolioCarousel
 */
class CenteredPortfolioCarousel implements ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	/**
	 * CardsGallery constructor.
	 */
	public function __construct() {
		$this->base = 'qode_centered_portfolio_carousel';

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
			'name'                      => esc_html__('Centered Portfolio Carousel', 'qode'),
			'base'                      => $this->base,
			'category'                  => esc_html__('by SELECT', 'qode'),
			'icon'                      => 'icon-wpb-centered-portfolio-carousel extended-custom-icon-qode',
			'params'					=> array(
//				array(
//					'type' => 'dropdown',
//					'heading' => esc_html__('Number of Portfolio Items Shown', 'qode'),
//					'param_name' => 'posts_shown',
//					'value' => array(
//						'3' => '3',
//						'4' => '4',
//						'5' => '5'
//					),
//				),
				array(
					'type' => 'dropdown',
					'heading' => 'Image size',
					'param_name' => 'image_size',
					'value' => array(
						'Default'		=> '',
						'Original Size'	=> 'full',
						'Landscape'		=> 'landscape',
						'Portrait'		=> 'portrait'
					)
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__('Number', 'qode'),
					'param_name'	=> 'number',
					'description'	=> esc_html__('Number of portfolios on page (Leave empty for all)', 'qode'),
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
					'description'	=> esc_html__('Selected Portfolios (leave empty for all, delimit by comma)', 'qode'),
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
            'posts_shown'				=> '1',
            'image_size'				=> '',
            'number'					=> '-1',
            'order'						=> 'DESC',
            'order_by'					=> 'date',
            'category'					=> '',
            'selected_projects'			=> '',
            'title_background_color'	=> '',
            'title_color'				=> ''
        );

        $params	= shortcode_atts($args, $atts);

		$query_args = $this->createQueryArgs($params);
		$blog_query = new \WP_Query($query_args);
		$params['blog_query'] = $blog_query;
		$params['holder_data'] = $this->getHolderData($params);
		$params['thumb_size'] = $this->getImageSize($params);

		return qode_get_shortcode_template_part('templates/centered-portfolio-carousel-template', 'centered-portfolio-carousel', '', $params);
	}

	private function createQueryArgs($params) {

		$args = array(
			'post_type'			=> 'portfolio_page',
			'orderby'			=> $params['order_by'],
			'order'				=> $params['order'],
			'posts_per_page'	=> $params['number']
		);

		if($params['category'] !== '') {
			$args['portfolio_category'] = $params['category'];
		}

		if($params['selected_projects'] !== '') {
			$args['post__in'] = explode(",", $params['selected_projects']);
		}

		return $args;
	}

	private function getHolderData($params) {

		$data = array();
		$data['data-enable-center'] = 'yes';
		$data['data-slider-padding'] = 'yes';
		$data['data-slider-margin'] = '38';

		if($params['posts_shown'] != '') {
			$data['data-number-of-items'] = $params['posts_shown'];
		}



		return $data;
	}


	private function getImageSize($params) {

		switch ($params['image_size']) {
			case 'landscape':
				$thumb_size = 'portfolio-landscape';
				break;
			case 'portrait':
				$thumb_size = 'portfolio-portrait';
				break;
			default:
				$thumb_size = 'full';
				break;
		}

		return $thumb_size;
	}
}