<article <?php post_class( $item_classes ); ?>>
	<div class="qodef-e-inner" <?php qode_framework_inline_style( $this_shortcode->get_list_item_style( $params ) ); ?>>
		<div class="qodef-e-background-holder">
			<?php eldon_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'post-info/image', 'background', $params ); ?>
		</div>
		<div class="qodef-e-content">
			<div class="qodef-e-top-holder">
				<div class="qodef-e-text">
					<?php
					// Include post title
					eldon_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'post-info/title', '', $params );
					?>
				</div>
				<div class="qodef-e-info">
					<?php
					// Include post category info
					eldon_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'post-info/categories', '', $params );
					?>
				</div>
			</div>
		</div>
		<?php eldon_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'post-info/link' ); ?>
	</div>
</article>
