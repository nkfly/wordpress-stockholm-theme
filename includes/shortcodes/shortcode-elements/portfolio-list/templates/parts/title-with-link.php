<?php
$title_style = '';
if($title_font_size != ""){
$title_style = 'style="font-size: '.$title_font_size.'px;"';
}

if($disable_link != "yes"){ ?>
    <<?php echo esc_attr($title_tag); ?> class="portfolio_title" <?php echo wp_kses_post($title_style); ?>><a href="<?php echo esc_url($portfolio_link); ?>" target="<?php echo esc_html($target); ?>"> <?php echo get_the_title() ?></a></<?php echo esc_attr($title_tag); ?>>
<?php } else { ?>
    <<?php echo esc_attr($title_tag); ?> class="portfolio_title" <?php echo wp_kses_post($title_style); ?>> <?php echo get_the_title() ?></<?php echo esc_attr($title_tag); ?>>
<?php } ?>