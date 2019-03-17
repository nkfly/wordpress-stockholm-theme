<?php
class QodePopupOpener extends QodeWidget {
    public function __construct() {
        parent::__construct(
            'qode_popup_opener', // Base ID
            esc_html__('Select Pop-up Opener', 'scribbler') // Name
        );

        $this->setParams();
    }

    protected function setParams() {

        $this->params = array(
            array(
                'name'			=> 'popup_opener_text',
                'type'			=> 'textfield',
                'title'			=> esc_html__('Pop-up Opener Text', 'scribbler'),
                'description'	=> esc_html__('Enter text for pop-up opener', 'scribbler')
            ),
            array(
                'name'			=> 'popup_opener_color',
                'type'			=> 'textfield',
                'title'			=> esc_html__('Pop-up Opener Color', 'scribbler'),
                'description'	=> esc_html__('Define color for pop-up opener', 'scribbler')
            )
        );

    }


    public function widget($args, $instance) {

        $popup_styles = array();
        $popup_text = '';

        if ( !empty($instance['popup_opener_color']) ) {
            $popup_styles[] = 'color: ' . $instance['popup_opener_color'];
        }
        if ( !empty($instance['popup_opener_text']) ) {
            $popup_text .= $instance['popup_opener_text'];
        }
        ?>
        <?php print $args['before_widget'] ?>

        <a class="widget qode-popup-opener" <?php qode_inline_style($popup_styles) ?> href="javascript:void(0)">
            <span class="qode-popup-opener-icon fa fa-envelope-o"></span> <span class="qode-popup-opener-text"><?php echo esc_html($popup_text); ?></span>
        </a>

		<?php print $args['after_widget'] ?>

    <?php }

}