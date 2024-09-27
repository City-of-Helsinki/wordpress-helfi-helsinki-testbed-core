<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\RelatedPosts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'template_redirect', __NAMESPACE__ . '\\init', 11 );
function init(): void {
	if ( is_single() && apply_filters( 'helsinki_blog_single_related', false ) ) {
		remove_action( 'helsinki_content_article_bottom', 'helsinki_content_article_related', 20 );
		add_action( 'helsinki_content_article_bottom', __NAMESPACE__ . '\\testbed_content_article_related', 20 );
	}
}

function testbed_content_article_related(): void {
	$posts_per_page = 4;
	$query = testbed_content_article_related_query(
		array( get_the_ID() ),
		array_map( fn( $term ) => $term->term_id, get_the_category() ),
		$posts_per_page
	);

	if ( $query->posts ) {
		get_template_part(
			'partials/content/parts/related',
			null,
			array(
				'posts' => $query->posts,
				'per_page' => $posts_per_page,
			)
		);
	}
}

function testbed_content_article_related_query( array $post_ids, array $cat_ids, int $posts_per_page ): \WP_Query {
	$args = array(
		'post__not_in' => $post_id,
		'post_type' => 'post',
		'posts_status' => 'publish',
		'posts_per_page' => $posts_per_page,
		'orderby' => 'date',
		'tax_query' => array(
			'relation' => 'OR',
		),
	);

	if ( $cat_ids ) {
		$args['tax_query'][] = array(
			array(
				'taxonomy' => 'category',
				'field' => 'term_id',
				'terms' => $cat_ids,
			),
		);
	}

	return new \WP_Query( $args );
}
