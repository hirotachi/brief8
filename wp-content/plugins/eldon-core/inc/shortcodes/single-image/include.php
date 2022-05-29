<?php

include_once ELDON_CORE_SHORTCODES_PATH . '/single-image/class-eldoncore-single-image-shortcode.php';

foreach ( glob( ELDON_CORE_SHORTCODES_PATH . '/single-image/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
