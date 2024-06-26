<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\PostTypes\Page;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Init
  */
add_action( 'helsinki_testbed_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	add_action( 'init', __NAMESPACE__ . '\\enable_page_excerpts' );
}

function enable_page_excerpts(): void {
	add_post_type_support('page', 'excerpt');
}
