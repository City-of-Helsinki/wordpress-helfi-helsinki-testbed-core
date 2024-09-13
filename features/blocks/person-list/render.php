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
		$layout = person_list_layout( $attributes );
		$align = person_list_align(
			$attributes,
			person_list_default_align( $query->post_count, $layout )
		);

		$block_classes = array_filter( array(
			'wp-block-person-list',
			$attributes['className'] ?? '',
			'layout-' . $layout,
			'align-' . $align,
		) );
		$grid_class = 'wp-block-person-list__entries';

		include plugin_dir_path( __FILE__ ) . 'templates/people-grid.php';
	} else {
		not_found();
	}
}

function person_list_align( array $attributes, string $default = 'left' ): string {
	$align = Blocks\attribute_value( $attributes, 'align', $default );

	return in_array( $align, array( 'left', 'right', 'center' ) ) ? $align : $default;
}

function person_list_default_align( int $post_count, string $layout ): string {
	return (1 === $post_count && 'horizontal' === $layout) ? 'center' : 'left';
}

function person_list_layout( array $attributes ): string {
	return Blocks\attribute_value( $attributes, 'layout', 'vertical' );
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
		"teaser--{$post_type}",
		"type-{$post_type}",
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
		'orderby' => 'post__in',
	) );
}

function person_ids( array $attributes ): array {
	return Blocks\attribute_value( $attributes, 'persons', [], __NAMESPACE__ . '\\map_person_ids' );
}

function map_person_ids( array $ids ): array {
	return array_map( 'absint', $ids );
}
