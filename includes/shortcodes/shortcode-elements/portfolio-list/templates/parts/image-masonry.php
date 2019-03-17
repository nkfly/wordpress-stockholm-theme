<?php
$custom_portfolio_link = get_post_meta(get_the_ID(), 'qode_portfolio-external-link', true);
$portfolio_link = $custom_portfolio_link != "" ? $custom_portfolio_link : get_permalink();
if(get_post_meta(get_the_ID(), 'qode_portfolio-external-link-target', true) != ""){
	$custom_portfolio_link_target = get_post_meta(get_the_ID(), 'qode_portfolio-external-link-target', true);
} else {
	$custom_portfolio_link_target = '_blank';
}

$target = $custom_portfolio_link != "" ? $custom_portfolio_link_target : '_self';

$masonry_size =  get_post_meta(get_the_ID(), "qode_portfolio_type_masonry_style", true);

if($masonry_size == "large_width"){
	$image_size = "portfolio_masonry_wide";
}elseif($masonry_size == "large_height"){
	$image_size = "portfolio_masonry_tall";
}elseif($masonry_size == "large_width_height"){
	$image_size = "portfolio_masonry_large";
} else{
	$image_size = "portfolio_masonry_regular";
}

if($type == "masonry_with_space"){
	$image_size = "portfolio_masonry_with_space";
}
?>

<span class='image'><?php echo get_the_post_thumbnail(get_the_ID(), $image_size); ?></span>

<?php if($disable_link != "yes"){ ?>
    <a class='portfolio_link_class' href='<?php echo esc_url($portfolio_link); ?>' target='<?php echo esc_attr($target); ?>'></a>
<?php } ?>