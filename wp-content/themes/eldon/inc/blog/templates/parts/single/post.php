<article <?php post_class( 'qodef-blog-item qodef-e' ); ?>>
	<div class="qodef-e-inner">
		<?php
		// Include post media
		eldon_template_part( 'blog', 'templates/parts/post-info/media' );
		?>
		<div class="qodef-e-content">
			<div class="qodef-e-top-holder">
				<div class="qodef-e-info">
					<?php
					// Include post date info
					eldon_template_part( 'blog', 'templates/parts/post-info/date' );
					?>
					<?php
					// Include post category info
					eldon_template_part( 'blog', 'templates/parts/post-info/categories' );
					?>
				</div>
			</div>
			<div class="qodef-e-text">
				<?php
				// Include post title
				eldon_template_part( 'blog', 'templates/parts/post-info/title' );

				// Include post content
				the_content();

				// Hook to include additional content after blog single content
				do_action( 'eldon_action_after_blog_single_content' );
				?>
			</div>
			<div class="qodef-e-bottom-holder">
				<div class="qodef-e-left qodef-e-info">
					<?php
					// Include post category info
					eldon_template_part( 'blog', 'templates/parts/post-info/tags' );
					?>
				</div>
				<div class="qodef-e-right qodef-e-info">
					<?php
					// Include social share functionality
					if ( eldon_is_installed( 'core' ) ) {
						$params['title'] = 'share:';
						eldon_core_template_part( 'blog/shortcodes/blog-list/templates/post-info', 'social-share', '', $params );
					}
					?>
				</div>
			</div>
		</div>
	</div>
</article>
