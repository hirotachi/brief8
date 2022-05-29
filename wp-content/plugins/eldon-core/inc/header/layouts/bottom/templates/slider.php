<?php

if ( qode_framework_is_installed( 'revolution-slider' ) ) {
	$qodef_slider = eldon_core_get_post_value_through_levels( 'qodef_bottom_header_slider' );

	if ( ! empty( $qodef_slider ) ) {
		$qodef_slider_shortcode = '[rev_slider alias="' . $qodef_slider . '"]';
		?>

		<div id="qodef-slider-holder">
			<?php echo do_shortcode( wp_kses_post( $qodef_slider_shortcode ) ); // XSS OK ?>
		</div>

		<?php
	}
}
