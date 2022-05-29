<?php

include_once ELDON_CORE_SHORTCODES_PATH . '/image-with-text/class-eldoncore-image-with-text-shortcode.php';

foreach ( glob( ELDON_CORE_SHORTCODES_PATH . '/image-with-text/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
