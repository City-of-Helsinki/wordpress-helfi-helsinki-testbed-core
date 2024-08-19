<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\QuietPosts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function quiet_post_state( array $states, \WP_Post $post ): array {
	if ( $post->post_type === 'post' && is_quiet_post( $post->ID ) ) {
		$states[quiet_post_meta_key()] = __( 'Quiet post', 'helsinki-testbed-core' );
	}

	return $states;
}
