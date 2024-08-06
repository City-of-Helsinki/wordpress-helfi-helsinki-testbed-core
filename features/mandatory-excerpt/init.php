<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\MandatoryExcerpt;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'helsinki_testbed_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	add_filter( 'wp_insert_post_data', __NAMESPACE__ . '\\maybe_draft_post_if_excerpt_missing' );
}

function maybe_draft_post_if_excerpt_missing( array $data ): array {
	if ( should_draft_post( $data ) ) {
		$data['post_status'] = 'draft';
	}

	return $data;
}

function should_draft_post( array $data ): bool {
	return excerpt_required_for_post_type( $data )
		&& ! has_excerpt( $data );
}

function excerpt_required_for_post_type( array $data ): bool {
	return 'post' === $data['post_type'];
}

function has_excerpt( array $data ): bool {
	return ! empty( $data['post_excerpt'] );
}
