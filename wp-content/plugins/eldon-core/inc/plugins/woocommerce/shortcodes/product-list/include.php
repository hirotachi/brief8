<?php

include_once ELDON_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-list/class-eldoncore-product-list-shortcode.php';

foreach ( glob( ELDON_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
