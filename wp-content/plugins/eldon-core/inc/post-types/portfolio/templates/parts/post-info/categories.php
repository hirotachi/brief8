<?php
$categories = wp_get_post_terms( get_the_ID(), 'portfolio-category' );

if ( ! empty( $categories ) ) { ?>
	<div class="qodef-e qodef-info--category">
		<h6 class="qodef-e-label"><?php esc_html_e( 'Category: ', 'eldon-core' ); ?></h6>
		<div class="qodef-e-category">
			<?php echo get_the_term_list( get_the_ID(), 'portfolio-category', '', '<span class="qodef-info-separator-single"></span>' ); ?>
		</div>
	</div>
<?php } ?>
