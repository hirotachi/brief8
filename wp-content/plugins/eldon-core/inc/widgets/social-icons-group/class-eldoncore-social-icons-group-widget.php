<?php

if ( ! function_exists( 'eldon_core_add_social_icons_group_widget' ) ) {
	/**
	 * function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function eldon_core_add_social_icons_group_widget( $widgets ) {
		$widgets[] = 'EldonCore_Social_Icons_Group_Widget';

		return $widgets;
	}

	add_filter( 'eldon_core_filter_register_widgets', 'eldon_core_add_social_icons_group_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class EldonCore_Social_Icons_Group_Widget extends QodeFrameworkWidget {
		public $no_of_icons = 5;

		public function map_widget() {
			$this->set_base( 'eldon_core_social_icons_group' );
			$this->set_name( esc_html__( 'Eldon Social Icons Group', 'eldon-core' ) );
			$this->set_description( sprintf( esc_html__( 'Use this widget to add a group of up to %s social icons to a widget area.', 'eldon-core' ), $this->no_of_icons ) );
			$this->set_widget_option(
				array(
					'field_type' => 'text',
					'name'       => 'widget_title',
					'title'      => esc_html__( 'Title', 'eldon-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type'    => 'select',
					'name'          => 'icon_layout',
					'title'         => esc_html__( 'Layout', 'eldon-core' ),
					'options'       => array(
						'normal'  => esc_html__( 'Normal', 'eldon-core' ),
						'circle'  => esc_html__( 'Circle', 'eldon-core' ),
						'square'  => esc_html__( 'Square', 'eldon-core' ),
						'textual' => esc_html__( 'Textual', 'eldon-core' ),
					),
					'default_value' => 'normal',
				)
			);
			for ( $i = 1; $i <= $this->no_of_icons; $i ++ ) {
				$this->set_widget_option(
					array(
						'field_type' => 'iconpack',
						'name'       => 'main_icon_' . $i,
						'title'      => sprintf( esc_html__( 'Icon %s', 'eldon-core' ), $i ),
						'dependency' => array(
							'hide' => array(
								'icon_layout' => array(
									'values'        => 'textual',
									'default_value' => 'normal',
								),
							),
						),
					)
				);
				$this->set_widget_option(
					array(
						'field_type' => 'text',
						'name'       => 'text_icon_' . $i,
						'title'      => sprintf( esc_html__( 'Text Icon %s', 'eldon-core' ), $i ),
						'dependency' => array(
							'show' => array(
								'icon_layout' => array(
									'values'        => 'textual',
									'default_value' => 'normal',
								),
							),
						),
					)
				);
				$this->set_widget_option(
					array(
						'field_type' => 'text',
						'name'       => 'link_' . $i,
						'title'      => sprintf( esc_html__( 'Link %s', 'eldon-core' ), $i ),
					)
				);
				$this->set_widget_option(
					array(
						'field_type'    => 'select',
						'name'          => 'target_' . $i,
						'title'         => sprintf( esc_html__( 'Link %s Target', 'eldon-core' ), $i ),
						'options'       => eldon_core_get_select_type_options_pool( 'link_target', false ),
						'default_value' => '_blank',
					)
				);
				$this->set_widget_option(
					array(
						'field_type' => 'text',
						'name'       => 'custom_size_' . $i,
						'title'      => sprintf( esc_html__( 'Icon %s Size', 'eldon-core' ), $i ),
						'dependency' => array(
							'hide' => array(
								'icon_layout' => array(
									'values'        => 'textual',
									'default_value' => 'normal',
								),
							),
						),
					)
				);
				$this->set_widget_option(
					array(
						'field_type' => 'text',
						'name'       => 'margin_' . $i,
						'title'      => sprintf( esc_html__( 'Icon %s Margin', 'eldon-core' ), $i ),
					)
				);
				$this->set_widget_option(
					array(
						'field_type' => 'color',
						'name'       => 'icon_color_' . $i,
						'title'      => sprintf( esc_html__( 'Icon %s Color', 'eldon-core' ), $i ),
					)
				);
				$this->set_widget_option(
					array(
						'field_type' => 'color',
						'name'       => 'icon_background_color_' . $i,
						'title'      => sprintf( esc_html__( 'Icon %s Background Color', 'eldon-core' ), $i ),
						'dependency' => array(
							'hide' => array(
								'icon_layout' => array(
									'values'        => 'textual',
									'default_value' => 'normal',
								),
							),
						),
					)
				);
				$this->set_widget_option(
					array(
						'field_type' => 'color',
						'name'       => 'icon_hover_color_' . $i,
						'title'      => sprintf( esc_html__( 'Icon %s Hover Color', 'eldon-core' ), $i ),
					)
				);
				$this->set_widget_option(
					array(
						'field_type' => 'color',
						'name'       => 'icon_hover_background_color_' . $i,
						'title'      => sprintf( esc_html__( 'Icon %s Hover Background Color', 'eldon-core' ), $i ),
						'dependency' => array(
							'hide' => array(
								'icon_layout' => array(
									'values'        => 'textual',
									'default_value' => 'normal',
								),
							),
						),
					)
				);
			}
		}

		public function render( $atts ) { ?>
			<div class="qodef-social-icons-group">
				<?php
				for ( $i = 1; $i <= $this->no_of_icons; $i ++ ) {
					$selected_icon_pack = str_replace( '-', '_', $atts[ 'main_icon_' . $i ] );
					$is_textual_icon    = isset( $atts[ 'text_icon_' . $i ] ) && ! empty( $atts[ 'text_icon_' . $i ] );

					if ( $is_textual_icon ) {
						$textual_styles = array();

						if ( ! empty( $atts[ 'icon_color_' . $i ] ) ) {
							$textual_styles[] = 'color: ' . $atts[ 'icon_color_' . $i ];
						}

						if ( ! empty( $atts[ 'margin_' . $i ] ) ) {
							$textual_styles[] = 'margin: ' . $atts[ 'margin_' . $i ];
						}

						$textual_hover_styles = array();
						if ( ! empty( $atts[ 'icon_hover_color_' . $i ] ) ) {
							$textual_hover_styles[] = $atts[ 'icon_hover_color_' . $i ];
						}
						?>
						<span class="qodef-icon-holder qodef--textual" <?php qode_framework_inline_style( $textual_styles ); ?> <?php qode_framework_inline_attr( $textual_hover_styles, 'data-hover-color' ); ?>>
							<?php
							echo sprintf(
								'%s%s%s',
								! empty( $atts[ 'link_' . $i ] ) ? '<a itemprop="url" href="' . esc_url( $atts[ 'link_' . $i ] ) . '" target="' . esc_attr( $atts[ 'target_' . $i ] ) . '">' : '',
								esc_html( $atts[ 'text_icon_' . $i ] ),
								! empty( $atts[ 'link_' . $i ] ) ? '</a>' : ''
							);
							?>
						</span>
						<?php
					} elseif ( ! empty( $atts[ 'main_icon_' . $i . '_' . $selected_icon_pack ] ) ) {
						$params = array(
							'main_icon'                        => $atts[ 'main_icon_' . $i ],
							'main_icon_' . $selected_icon_pack => $atts[ 'main_icon_' . $i . '_' . $selected_icon_pack ],
							'link'                             => $atts[ 'link_' . $i ],
							'target'                           => $atts[ 'target_' . $i ],
							'custom_size'                      => $atts[ 'custom_size_' . $i ],
							'margin'                           => $atts[ 'margin_' . $i ],
							'background_color'                 => $atts[ 'icon_background_color_' . $i ],
							'color'                            => $atts[ 'icon_color_' . $i ],
							'hover_background_color'           => $atts[ 'icon_hover_background_color_' . $i ],
							'hover_color'                      => $atts[ 'icon_hover_color_' . $i ],
							'icon_layout'                      => $atts['icon_layout'],
						);

						echo EldonCore_Icon_Shortcode::call_shortcode( $params ); // XSS OK
					}
				}
				?>
			</div>
			<?php
		}
	}
}
