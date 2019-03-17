<?php
$params['portfolio_subtitle'] = '';
if(get_post_meta(get_the_ID(), 'qode_portfolio_subtitle', true) != ""){
	$params['portfolio_subtitle'] = get_post_meta(get_the_ID(), 'qode_portfolio_subtitle', true);
}
?>
<h6 class="portfolio_subtitle"><?php echo esc_html($params['portfolio_subtitle']); ?> </h6>