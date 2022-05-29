<?php

include_once ELDON_CORE_SHORTCODES_PATH . '/icon-with-text/class-eldoncore-icon-with-text-shortcode.php';

foreach ( glob( ELDON_CORE_SHORTCODES_PATH . '/icon-with-text/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
