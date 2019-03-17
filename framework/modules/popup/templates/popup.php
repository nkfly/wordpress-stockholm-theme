<div class="qode-popup-holder">
    <div class="qode-popup-shader"></div>
    <div class="qode-popup-table">
        <div class="qode-popup-table-cell">
            <div class="qode-popup-inner">
                <a class="qode-popup-close" href="javascript:void(0)">
                    <span class="icon_close"></span>
                </a>
                <div class="qode-popup-content-container">
                    <div class="qode-popup-title-holder">
                        <h2 class="qode-popup-title"><?php echo esc_html($title); ?></h2>
                    </div>
                    <div class="qode-popup-subtitle">
                        <?php echo esc_html($subtitle); ?>
                    </div>
                    <?php echo do_shortcode('[contact-form-7 id="' . $contact_form .'" html_class="'. $contact_form_style .'"]'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
