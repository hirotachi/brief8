<?php if ( $show_header_area ) { ?>
	<div id="qodef-top-area">
		<div id="qodef-top-area-inner" class="<?php echo apply_filters( 'eldon_core_filter_top_area_inner_class', array() ); ?>">
			<?php
			// Include widget area top right
			eldon_core_get_header_widget_area( 'left', 'top-area', 'top_area', true );

			// Include widget area top right
			eldon_core_get_header_widget_area( 'right', 'top-area', 'top_area', true );

			do_action( 'eldon_core_action_after_top_area' );
			?>
		</div>
	</div>
<?php } ?>
