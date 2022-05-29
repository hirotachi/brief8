<?php

include_once ELDON_CORE_SHORTCODES_PATH . '/custom-font/class-eldoncore-custom-font-shortcode.php';

foreach ( glob( ELDON_CORE_SHORTCODES_PATH . '/custom-font/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
