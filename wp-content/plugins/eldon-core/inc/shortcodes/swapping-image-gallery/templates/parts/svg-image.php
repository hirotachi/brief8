<?php echo wp_kses(
	$svg_image_path,
	array(
		'svg' => array(
			'xmlns'             => true,
			'version'           => true,
			'id'                => true,
			'class'             => true,
			'x'                 => true,
			'y'                 => true,
			'aria-hidden'       => true,
			'aria-labelledby'   => true,
			'role'              => true,
			'width'             => true,
			'height'            => true,
			'viewbox'           => true,
			'enable-background' => true,
			'focusable'         => true,
			'data-prefix'       => true,
			'data-icon'         => true,
		),
		'style' => array(
			'type' => true,
		),
		'polygon'  => array(
			'points' => true,
			'fill' => true,
			'stroke' => true,
			'stroke-width' => true,
			'stroke-miterlimit' => true,
		),
		'rect' => array(
			'class' => true,
			'x' => true,
			'y' => true,
			'd' => true,
			'width' => true,
			'height' => true,
			'fill' => true,
			'stroke' => true,
			'stroke-width' => true,
			'stroke-miterlimit' => true,
		),
		'line' => array(
			'class' => true,
			'x' => true,
			'y' => true,
			'd' => true,
			'width' => true,
			'height' => true,
			'fill' => true,
			'stroke' => true,
			'stroke-width' => true,
			'stroke-miterlimit' => true,
		),
		'path' => array(
			'class' => true,
			'x' => true,
			'y' => true,
			'd' => true,
			'width' => true,
			'height' => true,
			'fill' => true,
			'stroke' => true,
			'stroke-width' => true,
			'stroke-miterlimit' => true,
		),
		'polyline' => array(
			'class' => true,
			'x' => true,
			'y' => true,
			'd' => true,
			'points' => true,
			'width' => true,
			'height' => true,
			'fill' => true,
			'stroke' => true,
			'stroke-width' => true,
			'stroke-miterlimit' => true,
		),
		'circle' => array(
			'class' => true,
			'x' => true,
			'y' => true,
			'cx' => true,
			'cy' => true,
			'd' => true,
			'r' => true,
			'width' => true,
			'height' => true,
			'fill' => true,
			'stroke' => true,
			'stroke-width' => true,
			'stroke-miterlimit' => true,
		),
	)
);

