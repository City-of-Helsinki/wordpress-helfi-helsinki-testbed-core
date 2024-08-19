<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\QuietPosts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function quiet_post_meta_key(): string {
	return 'quiet_post';
}

function is_quiet_post( int $post_id ): bool {
	return ! empty( get_post_meta( $post_id, quiet_post_meta_key(), true ) );
}

function update_quiet_post( int $post_id, bool $is_quiet ): bool {
	return update_post_meta( $post_id, quiet_post_meta_key(), $is_quiet ? 1 : 0 ) ? true : false;
}

function register_custom_meta_box(): void {
	add_meta_box(
		'post_display_settings',
		__( 'Display settings', 'helsinki-testbed-core' ),
		__NAMESPACE__ . '\\render_custom_meta_box',
		'post',
		'side',
		'high',
		array()
	);
}

function render_custom_meta_box( \WP_Post $post, array $args ): void {
	wp_nonce_field( post_meta_nonce_action( $post->ID ), post_meta_nonce_name() );

	printf(
		'<label>
			<input type="checkbox" name="%s" value="1" %s> %s
		</label>
		<p class="description">%s</p>',
		esc_attr( quiet_post_meta_key() ),
		checked( is_quiet_post( $post->ID ), true, false ),
		esc_html__( 'Make this post quiet', 'helsinki-testbed-core' ),
		esc_html__( 'Quiet posts will not be published to the front page and can be excluded from other content lists', 'helsinki-testbed-core' )
	);
}
