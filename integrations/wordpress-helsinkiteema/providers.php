<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Integrations\WordPressHelsinkiteema\Providers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'helsinki_testbed_core_svg_icon', __NAMESPACE__ . '\\provide_svg_icon', 10, 4 );
function provide_svg_icon( string $html, string $key, string $aria_label = '', string $extra_classes = '' ): string {
	return function_exists( 'helsinki_get_svg_icon' )
		? helsinki_get_svg_icon( $key, $extra_classes . ' testbed-icon hds-icon', $aria_label )
		: $html;
}

add_filter( 'helsinki_testbed_core_colors', __NAMESPACE__ . '\\provide_helsinki_colors', 10 );
function provide_helsinki_colors( array $colors ): array {
	$scheme = apply_filters( 'helsinki_scheme', '' );

	return $scheme && function_exists( 'helsinki_colors' )
		? helsinki_colors( $scheme )
		: $colors;
}
