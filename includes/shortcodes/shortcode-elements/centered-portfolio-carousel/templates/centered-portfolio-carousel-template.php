<?php if($blog_query->have_posts()): ?>
	<div class="qode-centered-portfolio-carousel qode-owl-slider" <?php echo qode_get_inline_attrs($holder_data); ?>>
		<?php while($blog_query->have_posts()): ?>
			<?php $blog_query->the_post(); ?>
				<div class="qode-cpc-post">
					<?php if(has_post_thumbnail()) : ?>
						<div class="qode-cpc-post-image">
							<a href="<?php the_permalink() ?>" itemprop="url">
								<span class="qode-cpc-overlay"></span>
								<?php the_post_thumbnail($thumb_size); ?>
							</a>
						</div>
					<?php endif; ?>
				</div>
		<?php endwhile; ?>
	</div>
<?php endif; ?>
