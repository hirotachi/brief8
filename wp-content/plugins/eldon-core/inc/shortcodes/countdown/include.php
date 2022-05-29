<?php

include_once ELDON_CORE_SHORTCODES_PATH . '/countdown/class-eldoncore-countdown-shortcode.php';

foreach ( glob( ELDON_CORE_SHORTCODES_PATH . '/countdown/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
