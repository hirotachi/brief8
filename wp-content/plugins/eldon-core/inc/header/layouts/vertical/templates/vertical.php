<?php do_action( 'eldon_action_before_page_header' ); ?>

<header id="qodef-page-header" role="banner">
	<div id="qodef-page-header-inner" class="<?php echo implode( ' ', apply_filters( 'eldon_filter_header_inner_class', array(), 'default' ) ); ?>">
		<?php
		// Include logo
		eldon_core_get_header_logo_image();

		// Include divided left navigation
		eldon_core_template_part( 'header', 'layouts/vertical/templates/navigation' );

		// Include widget area one
		eldon_core_get_header_widget_area();
		?>
	</div>
</header>
