<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks\IconAndText;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render( $attributes, $content ) : string {

	return print_r($attributes, true);
}
