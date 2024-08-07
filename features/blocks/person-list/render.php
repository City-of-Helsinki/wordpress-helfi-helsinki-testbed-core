<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks\PersonList;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\Testbed\Core\Features\Blocks;
use WP_Post;
use WP_Query;

function render( $attributes, $content ) : string {
	ob_start();

	create_html( $attributes, persons_query( $attributes ) );

	return ob_get_clean();
}

function create_html( array $attributes, WP_Query $query ): void {
	if ( $query->have_posts() ) {
		$layout = Blocks\attribute_value( $attributes, 'layout', 'vertical', 'strval' );

		$block_classes = array_filter( array(
			$attributes['className'] ?? '',
			'layout-' . $layout,
		) );
		$grid_class = $query->post_count > 1 ? 'grid' : '';

		include plugin_dir_path( __FILE__ ) . 'templates/people-grid.php';
	} else {
		not_found();
	}
}

function person_entry( WP_Post $post, string $layout ): void {
	$id = get_the_ID( $post );
	$post_type = get_post_type( $post );
	$title = get_the_title( $post );
	$thumbnail = get_the_post_thumbnail( $post, 'post-thumbnail', [
		'sizes' => '(max-width: 640px) 100vw, (max-width: 1024px) 33vw, 216px'
	]);
	$placeholder_url = apply_filters( 'helsinki_testbed_core_images_url', '' ) . 'person-placeholder.png';

	$entry_classes = [
		'teaser',
		"type-{$post_type}",
		"type-{$post_type}--teaser",
		"layout-{$layout}",
	];

	$email = apply_filters( 'helsinki_testbed_core_person_email', '', $id );
	$description = apply_filters( 'helsinki_testbed_core_person_description', '', $id );

	include plugin_dir_path( __FILE__ ) . 'templates/person-entry.php';
}

function not_found(): void {
	printf(
		'<div class="acf-block-placeholder text-center">%s</div>',
		esc_html__( 'No results found...', 'helsinki-testbed-core' )
	);
}

function persons_query( array $attributes  ): ?WP_Query {
	$ids = person_ids( $attributes );
	if ( ! $ids ) {
		return null;
	}

	return new WP_Query( array(
		'post_type' => apply_filters( 'helsinki_testbed_core_person_cpt_name', 'post' ),
		'post_status' => 'publish',
		'posts_per_page' => count( $ids ),
		'post__in' => $ids,
	) );
}

function person_ids( array $attributes ): array {
	return Blocks\attribute_value( $attributes, 'persons', [], __NAMESPACE__ . '\\map_person_ids' );
}

function map_person_ids( array $ids ): array {
	return array_map( 'absint', $ids );
}
