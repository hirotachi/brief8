<?php

if ( ! function_exists( 'eldon_core_add_switcher_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function eldon_core_add_switcher_widget( $widgets ) {
		$widgets[] = 'EldonCoreSwitcherWidget';

		return $widgets;
	}

	add_filter( 'eldon_core_filter_register_widgets', 'eldon_core_add_switcher_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class EldonCoreSwitcherWidget extends QodeFrameworkWidget {

		public function map_widget() {
			$this->set_base( 'eldon_core_switcher' );
			$this->set_name( esc_html__( 'Eldon Switcher', 'eldon-core' ) );
			$this->set_description( esc_html__( 'Add switcher element into widget areas', 'eldon-core' ) );

			$this->set_widget_option(
				array(
					'field_type' => 'text',
					'name'       => 'margin',
					'title'      => esc_html__( 'Margin', 'eldon-core' ),
				)
			);
		}

		public function render( $atts ) {
			$styles = array();
			if ( ! empty( $atts['margin'] ) ) {
				$styles[] = 'margin: ' . $atts['margin'];
			}
			?>
			<div class="widget qodef-switcher" <?php qode_framework_inline_style( $styles ); ?>>
				<div class="switch">
					<?php $rand = wp_rand( 0, 255 ); ?>
					<input type="checkbox" name="switch" class="switch__input" id="themeSwitch<?php echo esc_attr( $rand ); ?>" checked>
					<label class="switch__label" for="themeSwitch<?php echo esc_attr( $rand ); ?>">
						<span class="onoffswitch-inner"></span>
						<span class="onoffswitch-switch"></span>
					</label>
				</div>
			</div>
			<?php
		}
	}
}
