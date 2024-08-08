<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function common_assets(): void {
	$handle = apply_filters( 'helsinki_testbed_core_plugin_dirname', '' );
	$path = apply_filters( 'helsinki_testbed_core_plugin_path', '' );
	$assets = apply_filters( 'helsinki_testbed_core_assets_url', '' );
	$version = apply_filters( 'helsinki_testbed_core_asset_version', false );
	$is_debug = apply_filters( 'helsinki_testbed_core_is_debug', false );

	wp_enqueue_style(
        $handle . '-common',
        $is_debug ? $assets . 'common/css/styles.css' : $assets . 'common/css/styles.min.css',
        array(),
        $version
    );
}

function editor_assets() : void {
	$handle = apply_filters( 'helsinki_testbed_core_plugin_dirname', '' );
	$path = apply_filters( 'helsinki_testbed_core_plugin_path', '' );
	$assets = apply_filters( 'helsinki_testbed_core_assets_url', '' );
	$version = apply_filters( 'helsinki_testbed_core_asset_version', false );
	$is_debug = apply_filters( 'helsinki_testbed_core_is_debug', false );

	// wp_enqueue_script(
    //     $handle . '-editor',
	// 	$assets . 'blocks/editor.js',
    //     array( 'wp-blocks', 'wp-dom' ),
    //     $version
    // );

	common_assets();

	wp_enqueue_style(
        $handle . '-admin',
        $is_debug ? $assets . 'admin/css/styles.css' : $assets . 'admin/css/styles.min.css',
        array( $handle . '-common', 'wp-editor' ),
        $version
    );

	wp_set_script_translations( 'helsinki-testbed-core', 'helsinki-testbed-core', $path . 'languages' );
}

function public_assets() : void {
	$handle = apply_filters( 'helsinki_testbed_core_plugin_dirname', '' );
	$assets = apply_filters( 'helsinki_testbed_core_assets_url', '' );
	$is_debug = apply_filters( 'helsinki_testbed_core_is_debug', false );
	$version = apply_filters( 'helsinki_testbed_core_asset_version', '1.0.0' );

	common_assets();

	wp_enqueue_style(
        $handle . '-public',
		$is_debug ? $assets . 'public/css/styles.css' : $assets . 'public/css/styles.min.css',
        array( $handle . '-common', 'wp-block-library' ),
        $version
    );

	// wp_enqueue_script(
    //     $handle,
	// 	$is_debug ? $assets . 'public/js/scripts.js' : $assets . 'public/js/scripts.min.js',
    //     array(),
    //     $version,
	// 	true
    // );
}
