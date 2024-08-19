<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Integrations\WordPressHelsinki\Blocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'helsinki_testbed_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	add_filter( 'helsinki_wp_disallowed_blocks', __NAMESPACE__ . '\\filter_disallowed_blocks' );
}

function filter_disallowed_blocks( array $disallowed ): array {
	if ( isset( $disallowed['common']['core/media-text'] ) ) {
		unset( $disallowed['common']['core/media-text'] );
	}

	if ( isset( $disallowed['post_types']['post']['core/group'] ) ) {
		unset( $disallowed['post_types']['post']['core/group'] );
	}

	return $disallowed;
}
