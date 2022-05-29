<?php

if ( ! function_exists( 'eldon_core_add_testimonials_meta_box' ) ) {
	/**
	 * Function that adds fields for testimonials
	 */
	function eldon_core_add_testimonials_meta_box() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope' => array( 'testimonials' ),
				'type'  => 'meta',
				'slug'  => 'testimonials',
				'title' => esc_html__( 'Testimonials Parameters', 'eldon-core' ),
			)
		);

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_testimonials_title',
					'title'      => esc_html__( 'Title', 'eldon-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'textarea',
					'name'       => 'qodef_testimonials_text',
					'title'      => esc_html__( 'Text', 'eldon-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_testimonials_author',
					'title'      => esc_html__( 'Author', 'eldon-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'textarea',
					'name'        => 'qodef_testimonials_author_signature_svg_path',
					'title'       => esc_html__( 'Author Signature SVG Path', 'eldon-core' ),
					'description' => esc_html__( 'Enter your author signature image SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'eldon-core' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'eldon_core_action_after_testimonials_meta_box_map', $page );
		}
	}

	add_action( 'eldon_core_action_default_meta_boxes_init', 'eldon_core_add_testimonials_meta_box' );
}
