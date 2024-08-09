<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks\Highlight;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks;

function render( $attributes, $content ) : string {
	$classes = array_filter( array(
		'wp-block-hds-highlight',
		$attributes['className'] ?? '',
	) );

	$backgroundColor = Blocks\attribute_value( $attributes, 'backgroundColor', '' );
	if ( $backgroundColor ) {
		$classes[] = "has-{$backgroundColor}-background-color has-background";
	}

	return sprintf(
		'<div class="%s">%s</div>',
		esc_attr( implode( ' ', $classes ) ),
		columns( array(
			'icon' => icon( $attributes ),
			'body' => body( $attributes ),
			'button' => button( $attributes ),
		) )
	);
}

function columns( array $items ): string {
	$columns = '';
	foreach ( $items as $key => $item ) {
		$columns .= column( $key, $item );
	}

	return sprintf(
		'<div class="wp-block-hds-highlight__columns">%s</div>',
		$columns
	);
}

function column( string $name, string $content ): string {
	return sprintf(
		'<div class="wp-block-hds-highlight__column %s-column">%s</div>',
		esc_attr( $name ),
		$content
	);
}

function icon( array $attributes ): string {
	$icon = Blocks\attribute_value( $attributes, 'iconName', '' );
	$color = Blocks\attribute_value( $attributes, 'iconColor', 'default' );

	return $icon
		? sprintf(
			'<div class="wp-block-hds-highlight__icon has-%s-icon has-%s-color">%s</div>',
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
			'<h2 class="wp-block-hds-highlight__heading has-%s-color">%s</h2>',
			esc_attr( $color ),
			wp_kses_post( $heading )
		)
		: '';
}

function body( array $attributes ): string {
	$body = Blocks\attribute_value( $attributes, 'body', '' );
	$color = Blocks\attribute_value( $attributes, 'textColor', 'default' );

	if ( $body ) {
		$body = sprintf(
			'<div class="wp-block-hds-highlight__body has-%s-color">%s</div>',
			esc_attr( $color ),
			wp_kses_post( $body )
		);
	}

	return heading( $attributes ) . $body;
}

function button( array $attributes ): string {
	$text = Blocks\attribute_value( $attributes, 'linkText', '' );
	$url = Blocks\attribute_value( $attributes, 'linkUrl', '' );
	$color = Blocks\attribute_value( $attributes, 'textColor', 'default' );

	return ($text && $url)
		? sprintf(
			'<div class="wp-block-button is-style-outline wp-block-hds-highlight__button">
				<a class="hds-button has-text-color wp-element-button has-%s-color" href="%s">%s</a>
			</div>',
			esc_attr( $color ),
			esc_url( $url ),
			esc_html( $text )
		)
		: '';
}
