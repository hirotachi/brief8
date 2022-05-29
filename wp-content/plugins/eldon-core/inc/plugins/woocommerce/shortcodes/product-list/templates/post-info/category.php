<?php
$categories = eldon_core_woo_get_product_categories();

if ( ! empty( $categories ) ) { ?>
	<div class="qodef-woo-product-categories qodef-e-info"><?php echo wp_kses_post( $categories ); ?></div>
	<div class="qodef-info-separator-end"></div>
<?php } ?>
