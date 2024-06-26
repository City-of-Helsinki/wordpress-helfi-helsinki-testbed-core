<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\TermMapping;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'helsinki_testbed_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	foreach ( public_taxonomies() as $taxonomy ) {
		add_action( "{$taxonomy}_edit_form", __NAMESPACE__ . '\\render_term_mapping_select' );
	}

	add_action( 'edit_term', __NAMESPACE__ . '\\save_term_meta' );

	add_action( 'template_redirect', __NAMESPACE__ . '\\maybe_redirect_term' );
}

function public_taxonomies(): array {
	return get_taxonomies( array( 'public' => true ), 'names' );
}
