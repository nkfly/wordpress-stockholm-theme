<?php

namespace Stockholm\Shortcodes\ImageWithOverlappingInfo;

use Stockholm\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class ImageWithOverlappingInfo
 */
class ImageWithOverlappingInfo implements ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	/**
	 * CardsGallery constructor.
	 */
	public function __construct() {
		$this->base = 'qode_image_with_overlapping_info';

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
			'name'                      => esc_html__('Image With Overlapping Info', 'qode'),
			'base'                      => $this->base,
			'category'                  => esc_html__('by SELECT', 'qode'),
			'icon'                      => 'icon-wpb-image-with-overlapping-info extended-custom-icon-qode',
			'params'					=> array(
				array(
					'type'			=> 'attach_image',
					'heading'		=> esc_html__('Image', 'qode'),
					'param_name'	=> 'image',
					'admin_label'	=> true
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__('Title', 'qode'),
					'param_name'	=> 'title',
					'admin_label'	=> true
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__('Title Tag', 'qode'),
					'param_name' => 'title_tag',
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
					'type'			=> 'textarea',
					'heading'		=> esc_html__('Text', 'qode'),
					'param_name'	=> 'text'
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__('Link', 'qode'),
					'param_name'	=> 'link'
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__('Target', 'qode'),
					'param_name'	=> 'link_target',
					'value'			=> array(
						esc_html__('Self', 'qode')		=> '_self',
						esc_html__('Blank', 'qode')	=> '_blank'

					)
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__('Link Text', 'qode'),
					'param_name'	=> 'link_text'
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__('Link Hover Animation', 'qode'),
					'param_name'	=> 'link_hover_animation',
					'value'			=> array(
						esc_html__('Default', 'qode')		=> '',
						esc_html__('Display Dash', 'qode')	=> 'display-dash'

					)
				),
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
            'image'						=> '',
            'title'						=> '',
            'title_tag'					=> 'h3',
            'text'						=> '',
            'link'						=> '',
            'link_target'				=> '',
            'link_text'					=> '',
            'link_hover_animation'		=> ''
        );

        $params	= shortcode_atts($args, $atts);

		$params['image_src'] = wp_get_attachment_url( $params['image'] );
		$params['link_classes'] = $this->linkClasses($params);

		return qode_get_shortcode_template_part('templates/image-with-overlapping-info-template', 'image-with-overlapping-info', '', $params);
	}

	private function linkClasses($params) {

		$classes = array('qode-iwoi-link');
		if($params['link_hover_animation'] == 'display-dash'){
			$classes[] = 'display_dash';
		}
		return implode(' ', $classes);
	}
}