<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Integrations\WordPressHelsinki\Blocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'helsinki_testbed_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	add_filter( 'helsinki_wp_allowed_blocks', __NAMESPACE__ . '\\filter_allowed_blocks' );
}

function filter_allowed_blocks( array $blocks ): array {
	if ( isset( $blocks['common'] ) ) {
		$blocks['common']['core/media-text'] = true;

		$blocks['common']['acf/person-list'] = true;
		$blocks['common']['hds/highlight'] = true;
		$blocks['common']['hds/icon-and-text'] = true;
		$blocks['common']['acf/content-list'] = true;
	}

	if ( isset( $blocks['post_types']['post'] ) ) {
		$blocks['post_types']['post']['core/group'] = array( 'group' );
		$blocks['post_types']['post']['hds-wp/banner'] = true;
	}

	return $blocks;
}
