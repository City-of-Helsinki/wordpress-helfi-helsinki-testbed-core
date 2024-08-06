<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks\ContentList;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use WP_Post;
use WP_Query;

function render( $attributes, $content ) : string {
	ob_start();

	create_html( $attributes, posts_query( $attributes ) );

	return ob_get_clean();
}

function create_html( array $attributes, WP_Query $query ): void {
	if ( $query->have_posts() ) {
		$block_classes = $attributes['className'] ?? '';
		$title = list_title( $attributes );

		include plugin_dir_path( __FILE__ ) . 'templates/posts-grid.php';
	} else {
		not_found();
	}
}

function posts_grid( WP_Query $query ): void {
	include plugin_dir_path( __FILE__ ) . 'templates/posts-grid.php';
}

function post_entry(): void {
	include plugin_dir_path( __FILE__ ) . 'templates/post-entry.php';
}

function not_found(): void {
	echo sprintf(
		'<div class="acf-block-placeholder text-center">%s</div>',
		esc_html__( 'No results found...', 'helsinki-testbed-core' )
	);
}

function list_title( array $attributes ): string {
	return attribute_value( $attributes, 'title', '', 'strval' );
}

function use_pagination( array $attributes ): bool {
	return attribute_value( $attributes, 'use_pagination', false, 'boolval' );
}

function pagination( WP_Query $query ): void {
	include plugin_dir_path( __FILE__ ) . 'templates/pagination.php';
}

function posts_query( array $attributes ): WP_Query {
	$query = array(
		'posts_per_page' => attribute_value( $attributes, 'posts_per_page', 3, 'absint' ),
        'order_by' => attribute_value( $attributes, 'order_by', ['date'], 'strval' ),
        'order' => attribute_value( $attributes, 'order', 'DESC', 'strval' ),
        'post_type' => 'post',
        'use_pagination' => use_pagination( $attributes ),
        'post_status' => 'publish',
	);

	if ( use_pagination( $attributes ) ) {
		$query['paged'] = get_query_var('paged') ?: 1;
	}

    if ( attribute_value( $attributes, 'exclude_quiet_posts', false, 'boolval' ) ) {
        $query['meta_query'][] = [
            'relation' => 'OR',
            [
                'key' => 'quiet_post',
                'compare' => 'NOT EXISTS'
            ],
            [
                'key' => 'quiet_post',
                'value' => '1',
                'compare' => '!='
            ],
        ];
    }

	$category = attribute_value( $attributes, 'category', 0, 'absint' );
    if ( $category ) {
        $query['tax_query'][] = [
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => $category,
        ];
    }

	return new WP_Query( $query );
}

function attribute_value( array $attributes, string $key, $default, callable $cast ) {
	$legacy = isset( $attributes['data'][$key] )
		? call_user_func( $cast, $attributes['data'][$key] )
		: null;

	$value = $attributes[$key] ?: null;

	return $value ?: $legacy ?: $default;
}
