<?php

include_once ELDON_CORE_CPT_PATH . '/team/shortcodes/team-list/class-eldoncore-team-list-shortcode.php';

foreach ( glob( ELDON_CORE_CPT_PATH . '/team/shortcodes/team-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
