<?php

if ( ! empty( $link ) ) {
	$icon_params['link']   = $link;
	$icon_params['target'] = $target;
}

if ( 'icon-pack' === $icon_type ) {
	echo EldonCore_Icon_Shortcode::call_shortcode( $icon_params );
}
