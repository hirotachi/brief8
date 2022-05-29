<?php do_action( 'eldon_action_before_page_header' ); ?>

<header id="qodef-page-header">
	<div id="qodef-page-header-inner" class="<?php echo implode( ' ', apply_filters( 'eldon_filter_header_inner_class', array(), 'default' ) ); ?>">
		<?php
			eldon_core_get_opener_icon_html(
				array(
					'option_name'       => 'fullscreen_menu',
					'custom_class'      => 'qodef-fullscreen-menu-opener',
					'custom_text_empty' => true,
				),
				false
			);
			?>

		<?php
			// Include widget area one
			eldon_core_get_header_widget_area();
			eldon_core_get_header_logo_image();
		?>
	</div>
</header>
