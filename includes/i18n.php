<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function textdomain() {
	load_plugin_textdomain(
		'helsinki-testbed-core',
		false,
		apply_filters( 'helsinki_testbed_core_plugin_dirname', '' ) . '/languages'
	);
}
