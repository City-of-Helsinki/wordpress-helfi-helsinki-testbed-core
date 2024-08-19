<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Integrations\SearchWPLiveAjaxSearch;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'helsinki_testbed_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	add_filter( 'searchwp_live_search_results_template', __NAMESPACE__ . '\\custom_search_results_template_path' );
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
