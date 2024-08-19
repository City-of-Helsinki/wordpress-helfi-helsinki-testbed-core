<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks\IconAndText;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks;

function render( $attributes, $content ) : string {
	$classes = array_filter( array(
		'wp-block-hds-icon-and-text',
		$attributes['className'] ?? '',
	) );

	return sprintf(
		'<div class="%s">%s</div>',
		esc_attr( implode( ' ', $classes ) ),
		implode( '', array(
			icon( $attributes ),
			heading( $attributes ),
			body( $attributes ),
		) )
	);
}

function icon( array $attributes ): string {
	$icon = Blocks\attribute_value( $attributes, 'iconName', '' );
	$color = Blocks\attribute_value( $attributes, 'iconColor', 'default' );

	return $icon
		? sprintf(
			'<div class="wp-block-hds-icon-and-text__icon has-%s-icon has-%s-color">%s</div>',
			esc_attr( $icon ),
			esc_attr( $color ),
			apply_filters( 'helsinki_testbed_core_svg_icon', '', $icon )
		)
		: '';
}

function heading( array $attributes ): string {
	$heading = Blocks\attribute_value( $attributes, 'heading', '' );
	$color = Blocks\attribute_value( $attributes, 'textColor', 'default' );

	return $heading
		? sprintf(
			'<div class="wp-block-hds-icon-and-text__heading has-%s-color">%s</div>',
			esc_attr( $color ),
			wp_kses_post( $heading )
		)
		: '';
}

function body( array $attributes ): string {
	$body = Blocks\attribute_value( $attributes, 'body', '' );
	$color = Blocks\attribute_value( $attributes, 'textColor', 'default' );

	return $body
		? sprintf(
			'<div class="wp-block-hds-icon-and-text__body has-%s-color">%s</div>',
			esc_attr( $color ),
			wp_kses_post( $body )
		)
		: '';
}
