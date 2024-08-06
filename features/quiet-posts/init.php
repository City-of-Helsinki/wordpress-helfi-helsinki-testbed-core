<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\QuietPosts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'helsinki_testbed_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	add_action( 'add_meta_boxes_post', __NAMESPACE__ . '\\register_custom_meta_box' );
	add_action( 'save_post_post', __NAMESPACE__ . '\\save_custom_post_meta', 10, 3 );
}
