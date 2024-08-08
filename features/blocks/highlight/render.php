<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks\Highlight;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks;

function render( $attributes, $content ) : string {
	return print_r($attributes, true);
}
