<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\TermMapping;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function maybe_redirect_term(): void {
	if ( should_redirect_term( get_queried_object_id() ) ) {
		redirect_term( get_queried_object_id() );
	}
}

function should_redirect_term( int $term_id ): bool {
	return is_archive() && term_mapped_to_post( $term_id );
}

function redirect_term( int $term_id ): void {
	if ( wp_redirect( term_redirection_url( $term_id ) ) ) {
	    exit;
	}
}

function term_redirection_url( int $term_id ): string {
	return get_permalink( term_mapped_to_post( $term_id ) ) ?: '';
}
