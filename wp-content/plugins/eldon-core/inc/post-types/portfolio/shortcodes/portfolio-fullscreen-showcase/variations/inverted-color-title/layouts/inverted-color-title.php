<?php
$portfolio_list_image = get_post_meta( get_the_ID(), 'qodef_portfolio_list_image', true );
$has_image            = ! empty( $portfolio_list_image ) || has_post_thumbnail();

?>
<article <?php post_class( $item_classes ); ?>>
	<div class="qodef-e-inner" <?php qode_framework_inline_style( $this_shortcode->get_list_item_style( $params ) ); ?>>
		<?php
		if ( $has_image ) {
			$image_dimension = isset( $image_dimension ) && ! empty( $image_dimension ) && 'custom' !== $image_dimension ? esc_attr( $image_dimension['size'] ) : 'full';
			$image_url       = eldon_core_get_list_shortcode_item_image_url( $image_dimension, $portfolio_list_image );
			$style           = ! empty( $image_url ) ? 'background-image: url( ' . esc_url( $image_url ) . ')' : '';
			?>
			<div class="qodef-e-media-image">
				<?php echo eldon_core_get_list_shortcode_item_image( $image_dimension, $portfolio_list_image ); ?>
			</div>
			<div class="qodef-e-content">
				<h1 itemprop="name" class="qodef-e-title entry-title" <?php qode_framework_inline_style( $style ); ?>>
					<?php the_title(); ?>
				</h1>
			</div>
		<?php } ?>
		<?php eldon_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'post-info/link' ); ?>
	</div>
</article>
