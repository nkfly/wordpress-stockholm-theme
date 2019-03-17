(function($) {
    "use strict";
    var popup = {};
    qode.modules.popup = popup;

    $(document).ready(qodeOnDocumentReady);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function qodeOnDocumentReady() {
        qodePopup();
    }

    function qodePopup() {
        var popupOpener = $('a.qode-popup-opener'),
            popupClose = $( '.qode-popup-close' );

        popupOpener.click( function(e) {

            e.preventDefault();
            if ( qode_body.hasClass( 'qode-popup-opened' ) ) {
                qode_body.removeClass('qode-popup-opened');
                if(!qode_body.hasClass('page-template-full_screen-php')){
                    qode.modules.common.qodeEnableScroll();
                }
            } else {
                qode_body.addClass('qode-popup-opened');
                if(!qode_body.hasClass('page-template-full_screen-php')){
                    qode.modules.common.qodeDisableScroll();
                }
            }
            popupClose.click( function(e) {
                e.preventDefault();
                qode_body.removeClass('qode-popup-opened');
                if(!qode_body.hasClass('page-template-full_screen-php')){
                    qode.modules.common.qodeEnableScroll();
                }
            });
            //Close on escape
            $(document).keyup(function(e){
                if (e.keyCode == 27 ) { //KeyCode for ESC button is 27
                    qode_body.removeClass('qode-popup-opened');
                    if(!qode_body.hasClass('page-template-full_screen-php')){
                        qode.modules.common.qodeEnableScroll();
                    }
                }
            });
        });
    }


})(jQuery);
