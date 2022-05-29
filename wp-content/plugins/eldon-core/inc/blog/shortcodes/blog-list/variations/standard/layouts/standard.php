<article <?php post_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<?php
		// Include post media
		eldon_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/media', '', $params );
		?>
		<div class="qodef-e-content">
			<div class="qodef-e-top-holder">
				<div class="qodef-e-info">
					<?php
					// Include post date info
					eldon_core_theme_template_part( 'blog', 'templates/parts/post-info/date' );

					// Include post date info
					eldon_core_theme_template_part( 'blog', 'templates/parts/post-info/categories' );
					?>
				</div>
			</div>
			<div class="qodef-e-text">
				<?php
				// Include post title
				eldon_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/title', '', $params );

				// Include post excerpt
				eldon_core_theme_template_part( 'blog', 'templates/parts/post-info/excerpt', '', $params );

				// Hook to include additional content after blog single content
				do_action( 'eldon_action_after_blog_single_content' );
				?>
			</div>
			<div class="qodef-e-bottom-holder">
				<div class="qodef-e-left">
					<?php
					// Include post read more
					eldon_core_theme_template_part( 'blog', 'templates/parts/post-info/read-more' );
					?>
				</div>
				<div class="qodef-e-right qodef-e-info">
					<?php
					// Include social share functionality
					eldon_core_template_part( 'blog/shortcodes/blog-list/templates/post-info', 'social-share', '', $params );
					?>
				</div>
			</div>
		</div>
	</div>
</article>
