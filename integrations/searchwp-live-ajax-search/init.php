<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Integrations\SearchWPLiveAjaxSearch;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'helsinki_testbed_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	add_filter( 'searchwp_live_search_results_template', __NAMESPACE__ . '\\custom_search_results_template_path' );
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets', 1 );
}

function custom_search_results_template_path( string $template ): string {
	return apply_filters(
		'helsinki_testbed_core_path_to_php_file',
		array(
			'integrations',
			'searchwp-live-ajax-search',
			'templates',
			'search-results',
		)
	);
}

function enqueue_assets(): void {
	wp_enqueue_script(
		'testbed-searchwp-live-ajax-search',
		plugin_dir_url( __FILE__ ) . 'assets/scripts.js',
		array( 'swp-live-search-client' ),
		apply_filters( 'helsinki_testbed_core_asset_version', '' ),
		array(
			'strategy' => 'async',
			'in_footer' => true,
		)
	);
}
