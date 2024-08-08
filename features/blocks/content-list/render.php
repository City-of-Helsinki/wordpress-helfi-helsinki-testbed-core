<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks\ContentList;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks;
use WP_Post;
use WP_Query;

function render( $attributes, $content ) : string {
	ob_start();

	create_html( $attributes, posts_query( $attributes ) );

	return ob_get_clean();
}

function create_html( array $attributes, WP_Query $query ): void {
	if ( $query->have_posts() ) {
		$block_anchor = $attributes['anchor'] ?? '';
		$block_id = use_pagination( $attributes ) ? 'listing' : $block_anchor;

		$block_classes = array_filter( array(
			'wp-block-content-list',
			$attributes['className'] ?? '',
		) );
		$title = list_title( $attributes );
		$use_pagination = use_pagination( $attributes );

		include plugin_dir_path( __FILE__ ) . 'templates/posts-grid.php';
	} else {
		not_found();
	}
}

function posts_grid( WP_Query $query ): void {
	include plugin_dir_path( __FILE__ ) . 'templates/posts-grid.php';
}

function post_entry( WP_Post $post, int $h_level ): void {
    $label = '';
    $id = get_the_ID( $post );
    $post_type = get_post_type( $post );
    $title = get_the_title( $post );
    $aria_label = $title;
    $excerpt = get_the_excerpt( $post );
    $categories = get_the_category( $post );
    $tags = get_the_tags( $post );
    $permalink = get_permalink( $post );
    $thumbnail = get_the_post_thumbnail( $post, 'large', [
        'sizes' => '(max-width: 576px) 100vw, (max-width: 992px) 50vw (max-width: 1440px) 33vw, 384px'
    ]);
	$placeholder_url = apply_filters( 'helsinki_testbed_core_images_url', '' ) . 'post-placeholder.png';

	$h_level = max(min($h_level, 6), 1);

    $entry_classes = [
		'teaser',
		"teaser--{$post_type}",
		"type-{$post_type}",
	];

	include plugin_dir_path( __FILE__ ) . 'templates/post-entry.php';
}

function not_found(): void {
	printf(
		'<div class="acf-block-placeholder text-center">%s</div>',
		esc_html__( 'No results found...', 'helsinki-testbed-core' )
	);
}

function list_title( array $attributes ): string {
	return Blocks\attribute_value( $attributes, 'title', '' );
}

function use_pagination( array $attributes ): bool {
	return Blocks\attribute_value( $attributes, 'use_pagination', false, 'boolval' );
}

function pagination( WP_Query $query, string $fragment = '' ): void {
	if ( $query->max_num_pages > 1 ) {
		$args = [
			'base' => str_replace(999999, '%#%', esc_url(get_pagenum_link(999999))),
			'format' => '?paged=%#%',
			'current' => max(1, get_query_var('paged')),
			'total' => $query->max_num_pages,
			'type' => 'list',
			'add_fragment' => $fragment ? "#{$fragment}" : null,
		];

		$next_icon = apply_filters( 'helsinki_testbed_core_svg_icon', '', 'angle-right', __('Next page', 'helsinki-testbed-core') );
		if ( $next_icon ) {
			$args['next_text'] = $next_icon;
		}

		$prev_icon = apply_filters( 'helsinki_testbed_core_svg_icon', '', 'angle-left', __('Previous page', 'helsinki-testbed-core') );
		if ( $prev_icon ) {
			$args['prev_text'] = $prev_icon;
		}

		include plugin_dir_path( __FILE__ ) . 'templates/pagination.php';
	}
}

function posts_query( array $attributes ): WP_Query {
	$query = array(
		'posts_per_page' => Blocks\attribute_value( $attributes, 'posts_per_page', 3, 'absint' ),
        'order_by' => Blocks\attribute_value( $attributes, 'order_by', ['date'] ),
        'order' => Blocks\attribute_value( $attributes, 'order', 'DESC' ),
        'post_type' => 'post',
        'use_pagination' => use_pagination( $attributes ),
        'post_status' => 'publish',
	);

	if ( use_pagination( $attributes ) ) {
		$query['paged'] = get_query_var('paged') ?: 1;
	}

	$quiet_post_key = apply_filters( 'helsinki_testbed_core_quiet_post_meta_key', '' );
    if ( $quiet_post_key && Blocks\attribute_value( $attributes, 'exclude_quiet_posts', false, 'boolval' ) ) {
        $query['meta_query'][] = [
            'relation' => 'OR',
            [
                'key' => $quiet_post_key,
                'compare' => 'NOT EXISTS'
            ],
            [
                'key' => $quiet_post_key,
                'value' => '1',
                'compare' => '!='
            ],
        ];
    }

	$category = Blocks\attribute_value( $attributes, 'category', 0, 'absint' );
    if ( $category ) {
        $query['tax_query'][] = [
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => $category,
        ];
    }

	return new WP_Query( $query );
}
