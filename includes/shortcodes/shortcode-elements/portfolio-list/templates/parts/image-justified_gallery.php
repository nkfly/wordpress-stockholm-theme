<?php
$custom_portfolio_link = get_post_meta(get_the_ID(), 'qode_portfolio-external-link', true);
$portfolio_link = $custom_portfolio_link != "" ? $custom_portfolio_link : get_permalink();

if(get_post_meta(get_the_ID(), 'qode_portfolio-external-link-target', true) != ""){
    $custom_portfolio_link_target = get_post_meta(get_the_ID(), 'qode_portfolio-external-link-target', true);
} else {
    $custom_portfolio_link_target = '_blank';
}

$target = $custom_portfolio_link != "" ? $custom_portfolio_link_target : '_self';


if($disable_link != "yes"){ ?>
    <a class='portfolio_jg_image_link image_holder' href='<?php echo esc_url($portfolio_link); ?>' target='<?php echo esc_html($target); ?>'>
<?php
} else { ?>
    <span class='portfolio_jg_image_link image_holder'>
<?php }
        echo get_the_post_thumbnail(get_the_ID(), 'full');
if($disable_link != "yes"){ ?>
    </a>
<?php }
else { ?>
    </span>
<?php } ?>