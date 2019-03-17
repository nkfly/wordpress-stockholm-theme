<div <?php echo qode_class_attribute(implode(' ', $holder_classes)) ?>>
	<?php if($blog_query->have_posts()): ?>
		<div class="qode-sbl-posts-holder clearfix">
		<div class="qode-sbl-posts">
			<?php while($blog_query->have_posts()): ?>
				<?php $blog_query->the_post(); ?>
					<div class="qode-sbl-post">
						<div class="qode-sbl-post-text">
							<h6 class="qode-sbl-category"><?php the_category(', ') ?></h6>
							<<?php echo esc_attr($posts_title_tag); ?> class="qode-sbl-post-title entry_title" itemprop="name">
								<a href="<?php the_permalink() ?>" itemprop="url"><?php the_title(); ?></a>
							</<?php echo esc_attr($posts_title_tag); ?>>
							<?php $excerpt = ($params['excerpt_length'] !== '' && $params['excerpt_length'] > 0) ? substr(get_the_excerpt(), 0, intval($params['excerpt_length'])).'...' : get_the_excerpt(); ?>
							<p itemprop="description" class = "qode-sbl-post-excerpt"> <?php print $excerpt ?></p>
							<?php echo qode_get_button_html(
								array(
									'link'          => get_the_permalink(get_the_ID()),
									'text'          => esc_html__('Read More', 'qode'),
									'custom_class'  => $read_more_classes
								)
							); ?>
						</div>
					</div>
			<?php endwhile; ?>
		</div>
		</div>
	<?php endif; ?>
</div>