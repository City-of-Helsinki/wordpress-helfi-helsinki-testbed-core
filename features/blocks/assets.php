<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function editor_color_palette( $theme_json ) {
	$colors = apply_filters( 'helsinki_testbed_core_colors', array() );

	$data = array(
		'version' => 2,
		'settings' => array(
			'background' => true,
			'text' => true,
			'color' => array(
				'palette' => array(
					array(
					    "name" => __( "Primary", 'helsinki-testbed-core' ),
					    "slug" => "primary",
					    "color" => $colors['primary']['color'] ?? "#0072c6",
					),
					array(
					    "name" => __( "Secondary", 'helsinki-testbed-core' ),
					    "slug" => "secondary",
					    "color" => $colors['secondary'] ?? "#767676",
					),
					array(
					    "name" => __( "White", 'helsinki-testbed-core' ),
					    "slug" => "white",
					    "color" => "#ffffff",
					),
					array(
					    "name" => __( "Light Grey", 'helsinki-testbed-core' ),
					    "slug" => "light-grey",
					    "color" => "#f6f6f6",
					),
					array(
					    "name" => __( "Medium gray", 'helsinki-testbed-core' ),
					    "slug" => "c-black-20",
					    "color" => "#cccccc",
					),
					array(
					    "name" => __( "Black", 'helsinki-testbed-core' ),
					    "slug" => "black",
					    "color" => "#000000",
					),
					array(
					    "name" => __( "Coat of Arms Blue", 'helsinki-testbed-core' ),
					    "slug" => "c-vakuuna-vakuuna",
					    "color" => "#0072c6",
					),
					array(
					    "name" => __( "Copper", 'helsinki-testbed-core' ),
					    "slug" => "c-kupari-kupari",
					    "color" => "#00d7a7",
					),
					array(
					    "name" => __( "Copper Light", 'helsinki-testbed-core' ),
					    "slug" => "c-kupari-kupari-light-20",
					    "color" => "#ccf7ed",
					),
					array(
					    "name" => __( "Fog", 'helsinki-testbed-core' ),
					    "slug" => "c-fog",
					    "color" => "#9fc9eb",
					),
					array(
					    "name" => __( "Fog Light", 'helsinki-testbed-core' ),
					    "slug" => "c-sumu-sumu-light-20",
					    "color" => "#ebf4fb",
					),
					array(
					    "name" => __( "Gold", 'helsinki-testbed-core' ),
					    "slug" => "c-coat-of-arms-gold",
					    "color" => "#c2a251",
					),
				),
			),
		),
	);

	return $theme_json->update_with( $data );
}

function common_assets(): void {
	$handle = apply_filters( 'helsinki_testbed_core_plugin_dirname', '' );
	$path = apply_filters( 'helsinki_testbed_core_plugin_path', '' );
	$assets = apply_filters( 'helsinki_testbed_core_assets_url', '' );
	$version = apply_filters( 'helsinki_testbed_core_asset_version', false );

	wp_enqueue_style(
        $handle . '-common',
        $assets . 'common/css/styles.css',
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

	wp_enqueue_script(
        $handle . '-admin',
		$is_debug ? $assets . 'admin/js/scripts.js' : $assets . 'admin/js/scripts.min.js',
        array( 'wp-blocks', 'wp-dom' ),
        $version
    );

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
		$assets . 'public/css/styles.css',
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
