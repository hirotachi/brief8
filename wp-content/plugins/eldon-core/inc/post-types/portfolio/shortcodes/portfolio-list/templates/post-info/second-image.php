<?php
$portfolio_second_image = get_post_meta( get_the_ID(), 'qodef_portfolio_second_image', true );
$has_image              = ! empty( $portfolio_second_image );

if ( $has_image ) {
	$image_dimension     = isset( $image_dimension ) && ! empty( $image_dimension ) ? esc_attr( $image_dimension['size'] ) : 'full';
	$custom_image_width  = isset( $custom_image_width ) && '' !== $custom_image_width ? intval( $custom_image_width ) : 0;
	$custom_image_height = isset( $custom_image_height ) && '' !== $custom_image_height ? intval( $custom_image_height ) : 0;
	?>
	<div class="qodef-e-media-second-image">
		<a itemprop="url" href="<?php the_permalink(); ?>">
			<?php echo eldon_core_get_list_shortcode_item_image( $image_dimension, $portfolio_second_image, $custom_image_width, $custom_image_height ); ?>
		</a>
	</div>
<?php } ?>
