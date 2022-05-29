<?php

include_once ELDON_CORE_SHORTCODES_PATH . '/pricing-table/class-eldoncore-pricing-table-shortcode.php';

foreach ( glob( ELDON_CORE_SHORTCODES_PATH . '/pricing-table/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
