<article <?php post_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<?php
		// Include post media
		eldon_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/image', '', $params );
		?>
		<div class="qodef-e-content">
			<div class="qodef-e-top-holder">
				<div class="qodef-e-info">
					<?php
					// Include post author info
					eldon_core_theme_template_part( 'blog', 'templates/parts/post-info/author' );
					// Include post date info
					eldon_core_theme_template_part( 'blog', 'templates/parts/post-info/date', '', $params );
					?>
				</div>
			</div>
			<div class="qodef-e-text">
				<?php
				// Include post title
				eldon_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/title', '', $params );
				?>
			</div>
			<div class="qodef-e-bottom-holder">
				<div class="qodef-e-left">
					<?php
					// Include post read more
					eldon_core_theme_template_part( 'blog', 'templates/parts/post-info/read-more' );
					?>
				</div>
			</div>
		</div>
	</div>
</article>
