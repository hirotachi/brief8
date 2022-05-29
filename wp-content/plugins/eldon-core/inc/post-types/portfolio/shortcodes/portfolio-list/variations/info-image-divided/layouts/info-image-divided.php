<article <?php post_class( $item_classes ); ?>>
	<div class="qodef-e-inner" <?php qode_framework_inline_style( $this_shortcode->get_list_item_style( $params ) ); ?>>
		<div class="qodef-e-image">
			<div class="qodef-e-image-tilt">
				<?php eldon_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'post-info/image', '', $params ); ?>
			</div>
		</div>
		<div class="qodef-e-content">
			<div class="qodef-e-info">
				<?php eldon_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'post-info/subtitle', '', $params ); ?>
			</div>
			<?php eldon_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'post-info/title', '', $params ); ?>
			<?php eldon_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'post-info/read-more', '', $params ); ?>
		</div>
	</div>
</article>
