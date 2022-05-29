<?php

include_once ELDON_CORE_INC_PATH . '/social-share/shortcodes/social-share/class-eldoncore-social-share-shortcode.php';

foreach ( glob( ELDON_CORE_INC_PATH . '/social-share/shortcodes/social-share/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
