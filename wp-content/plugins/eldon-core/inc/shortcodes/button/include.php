<?php

include_once ELDON_CORE_SHORTCODES_PATH . '/button/class-eldoncore-button-shortcode.php';

foreach ( glob( ELDON_CORE_SHORTCODES_PATH . '/button/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
