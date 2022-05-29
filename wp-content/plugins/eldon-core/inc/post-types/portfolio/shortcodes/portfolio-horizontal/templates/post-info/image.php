<?php
$portfolio_list_image = get_post_meta( get_the_ID(), 'qodef_portfolio_list_image', true );
$has_image            = ! empty( $portfolio_list_image ) || has_post_thumbnail();

if ( $has_image ) {
	$portfolio_url       = eldon_core_get_portfolio_list_item_url( get_the_ID() );
	$image_dimension     = isset( $image_dimension ) && ! empty( $image_dimension ) ? esc_attr( $image_dimension['size'] ) : 'custom';
	$custom_image_width  = isset( $custom_image_width ) && '' !== $custom_image_width ? intval( $custom_image_width ) : 960;
	$custom_image_height = isset( $custom_image_height ) && '' !== $custom_image_height ? intval( $custom_image_height ) : 960;
	?>
	<a itemprop="url" href="<?php echo esc_url( $this_shortcode->getItemLink() ); ?>" target="<?php echo esc_attr( $this_shortcode->getItemLinkTarget() ); ?>">
		<span class="qodef-e-media-image-holder">
			<span class="qodef-e-media-image-holder-inner">
				<?php echo eldon_core_get_list_shortcode_item_image( $image_dimension, $portfolio_list_image, $custom_image_width, $custom_image_height ); ?>
			</span>
		</span>
	</a>
<?php } ?>
