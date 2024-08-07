<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Integrations\WordPressHelsinkiteema\Providers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'helsinki_testbed_core_svg_icon', __NAMESPACE__ . '\\provide_svg_icon', 10, 4 );
function provide_svg_icon( string $html, string $key, string $aria_label = '', string $extra_classes = '' ): string {
	return function_exists( 'helsinki_get_svg_icon' )
		? helsinki_get_svg_icon( $key, $extra_classes, $aria_label )
		: $html;
}
