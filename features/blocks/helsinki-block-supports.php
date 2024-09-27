<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function insert_helsinki_block_backgroud_color_attribute( array $args, string $block_type ): array {
	if ( is_valid_helsinki_block( $block_type ) ) {

		$supports = $args['supports'] ?? array();
		$color = $supports['color'] ?? array();

		$args['supports']['color'] = array_merge($color, array(
			'background' => true,
		));

		$attributes = $args['attributes'] ?? array();

		$args['attributes'] = array_merge($attributes, array(
			'backgroundColor' => array(
				'type'    => 'string',
				'default' => '',
			),
		));
	}

	return $args;
}

function insert_helsinki_block_backgroud_color_class( array $parsed_block ): array {
	if ( isset( $parsed_block['blockName'] ) && is_valid_helsinki_block( $parsed_block['blockName'] ) ) {
		$bg = $parsed_block['attrs']['backgroundColor'] ?? '';

		if ( $bg ) {
			$parsed_block['attrs']['className'] .= " has-{$bg}-background-color";
		}
	}

	return $parsed_block;
}

function is_valid_helsinki_block( string $name ): bool {
	return 'hds-wp/banner' === $name;
}
