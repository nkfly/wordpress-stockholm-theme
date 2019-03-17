<?php
$terms = wp_get_post_terms(get_the_ID(), 'portfolio_category');
if(!$portfolio_list_hide_category){ ?>
	<span class="project_category">
        <span> <?php esc_html_e('In ', 'qode'); ?></span>
		<?php
		$k = 1;
		foreach ($terms as $term) {
			echo esc_html($term->name);
			if (count($terms) != $k) {
				echo ', ';
			}
			$k++;
		} ?>
    </span>
<?php } ?>