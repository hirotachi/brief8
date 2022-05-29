<?php

include_once ELDON_CORE_INC_PATH . '/header/top-area/class-eldoncore-top-area.php';
include_once ELDON_CORE_INC_PATH . '/header/top-area/helper.php';

foreach ( glob( ELDON_CORE_INC_PATH . '/header/top-area/dashboard/*/*.php' ) as $dashboard ) {
	include_once $dashboard;
}
