<?php

if ( ! function_exists( 'eldon_core_add_single_image_widget' ) ) {
	/**
	 * function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function eldon_core_add_single_image_widget( $widgets ) {
		$widgets[] = 'EldonCore_Single_Image_Widget';

		return $widgets;
	}

	add_filter( 'eldon_core_filter_register_widgets', 'eldon_core_add_single_image_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class EldonCore_Single_Image_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$this->set_base( 'eldon_core_single_image' );
			$this->set_name( esc_html__( 'Eldon Single Image', 'eldon-core' ) );

			$this->set_widget_option(
				array(
					'field_type' => 'image',
					'name'       => 'black_skin_image',
					'title'      => esc_html__( 'Black Skin Image', 'eldon-core' ),
				)
			);

			$this->set_widget_option(
				array(
					'field_type' => 'image',
					'name'       => 'white_skin_image',
					'title'      => esc_html__( 'White Skin Image', 'eldon-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'text',
					'name'       => 'single_image_link',
					'title'      => esc_html__( 'Link', 'eldon-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'select',
					'name'       => 'single_image_link_target',
					'options'    => eldon_core_get_select_type_options_pool( 'link_target' ),
					'title'      => esc_html__( 'Link target', 'eldon-core' ),
					'default_value'    => '_self',
				)
			);
		}

		public function render( $atts ) { ?>
			<div class="qodef-single-image-widget widget">
				<?php if ( ! empty( $atts['single_image_link'] ) ) { ?>
					<a itemprop="url" href="<?php echo esc_url( $atts['single_image_link'] ); ?>" target="<?php echo esc_attr( $atts['single_image_link_target'] ); ?>">
				<?php } ?>
					<div class="qodef-single-image-black-skin">
						<?php echo wp_get_attachment_image( $atts['black_skin_image'], 'full' ); ?>
					</div>
					<div class="qodef-single-image-white-skin">
						<?php echo wp_get_attachment_image( $atts['white_skin_image'], 'full' ); ?>
					</div>
				<?php if ( ! empty( $atts['single_image_link'] ) ) { ?>
					</a>
				<?php } ?>
			</div>
			<?php
		}
	}
}
