<?php
if ( ! function_exists('qode_get_popup') ) {
    /**
     * Loads search HTML based on search type option.
     */
    function qode_get_popup() {

        if ( qode_active_widget( false, false, 'qode_popup_opener' ) ) {
            if(qode_options()->getOptionValue('enable_popup') == 'yes') {
                qode_load_popup_template();
            }

        }
    }

}

if ( ! function_exists('qode_load_popup_template') ) {
    /**
     * Loads HTML template with parameters
     */
    function qode_load_popup_template() {
        $parameters = array();
        $parameters['title'] = qode_options()->getOptionValue('popup_title');
        $parameters['subtitle'] = qode_options()->getOptionValue('popup_subtitle');
        $parameters['contact_form'] = qode_options()->getOptionValue('popup_contact_form');
        $parameters['contact_form_style'] = qode_options()->getOptionValue('popup_contact_form_style');
        qode_get_module_template_part( 'templates/popup', 'popup', '', $parameters );
    }

}