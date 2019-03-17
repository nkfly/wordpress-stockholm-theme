<?php

namespace Stockholm\Shortcodes\InteractiveImage;

use Stockholm\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class InteractiveImage
 */
class InteractiveImage implements ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	/**
	 * CardsGallery constructor.
	 */
	public function __construct() {
		$this->base = 'qode_interactive_image';

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
			'name'                      => esc_html__('Interactive Image', 'qode'),
			'base'                      => $this->base,
			'category'                  => esc_html__('by SELECT', 'qode'),
			'icon'                      => 'icon-wpb-interactive-image extended-custom-icon-qode',
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
					'heading'		=> esc_html__('Button Link', 'qode'),
					'param_name'	=> 'link'
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__('Button Target', 'qode'),
					'param_name'	=> 'link_target',
					'value'			=> array(
						esc_html__('Self', 'qode')		=> '_self',
						esc_html__('Blank', 'qode')	=> '_blank'

					)
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> esc_html__('Button Text', 'qode'),
					'param_name'	=> 'link_text'
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__('Button Style', 'qode'),
					'param_name'	=> 'link_style',
					'value'			=> array(
						esc_html__('Default', 'qode')		=> '',
						esc_html__('White', 'qode')	=> 'white',
						esc_html__('Underlined', 'qode')	=> 'underlined'
					)
				),
				array(
					'type'			=> 'checkbox',
					'heading'		=> esc_html__('Set as active', 'qode'),
					'param_name'	=> 'active'
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
            'image'						=> '',
            'title'						=> '',
            'title_tag'					=> 'h2',
            'text'						=> '',
            'link'						=> '',
            'link_target'				=> '',
            'link_text'					=> '',
            'link_style'					=> '',
            'active'					=> 'false'
        );

        $params	= shortcode_atts($args, $atts);

        $params['holderClasses'] = $this->getHolderClasses($params);
		$params['image_src'] = wp_get_attachment_url( $params['image'] );

		return qode_get_shortcode_template_part('templates/interactive-image', 'interactive-image', '', $params);
	}

	private function getHolderClasses($params) {

		$classes = '';
		if($params['active'] == 'true') {
			$classes = 'active';
		}

		return $classes;
	}
}

