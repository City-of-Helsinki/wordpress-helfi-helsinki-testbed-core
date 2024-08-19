<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\TermMapping;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function save_term_meta( int $term_id ): void {
	if ( can_save_term_meta( $term_id ) ) {
		$value = $_POST[term_mapping_meta_key()] ?? 0;

		update_term_mapped_to_post( $term_id, absint( $value ) );
	}
}

function can_save_term_meta( int $term_id ): bool {
	return current_user_can_edit_term( $term_id )
		&& verify_term_meta_nonce( $term_id );
}

function term_meta_nonce_name(): string {
	return 'term_mapping_nonce';
}

function term_meta_nonce_action( int $term_id ): string {
	return term_meta_nonce_name() . '_' . $term_id;
}

function verify_term_meta_nonce( int $term_id ): bool {
	$nonce = $_POST[term_meta_nonce_name()] ?? '';

	return wp_verify_nonce( $nonce, term_meta_nonce_action( $term_id ) ) ? true : false;
}

function current_user_can_edit_term( int $term_id ): bool {
	return current_user_can( 'edit_term', $term_id );
}
