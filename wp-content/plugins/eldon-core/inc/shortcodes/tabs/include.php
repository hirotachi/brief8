<?php

include_once ELDON_CORE_SHORTCODES_PATH . '/tabs/class-eldoncore-tab-shortcode.php';
include_once ELDON_CORE_SHORTCODES_PATH . '/tabs/class-eldoncore-tab-child-shortcode.php';

foreach ( glob( ELDON_CORE_SHORTCODES_PATH . '/tabs/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
