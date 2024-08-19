<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\QuietPosts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function save_custom_post_meta( int $post_id, \WP_Post $post, bool $update ): void {
	if ( can_save_post_meta( $post_id ) ) {
		update_quiet_post( $post_id, ! empty( $_POST[quiet_post_meta_key()] ) );
	}
}

function can_save_post_meta( int $post_id ): bool {
	return current_user_can_edit_post( $post_id )
		&& verify_post_meta_nonce( $post_id );
}

function post_meta_nonce_name(): string {
	return 'quiet_post_nonce';
}

function post_meta_nonce_action( int $post_id ): string {
	return post_meta_nonce_name() . '_' . $post_id;
}

function verify_post_meta_nonce( int $post_id ): bool {
	$nonce = $_POST[post_meta_nonce_name()] ?? '';

	return wp_verify_nonce( $nonce, post_meta_nonce_action( $post_id ) ) ? true : false;
}

function current_user_can_edit_post( int $post_id ): bool {
	return current_user_can( 'edit_post', $post_id );
}
