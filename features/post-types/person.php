<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\PostTypes\Person;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Init
  */
add_action( 'helsinki_testbed_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	add_action( 'init', __NAMESPACE__ . '\\register_cpt_person' );

	$cpt = cpt_person_name();

	add_filter( "manage_{$cpt}_posts_columns", __NAMESPACE__ . '\\posts_table_columns' );
	add_action( "manage_{$cpt}_posts_custom_column", __NAMESPACE__ . '\\posts_table_columns_content', 10, 2 );
	add_action( 'admin_head', __NAMESPACE__ . '\\posts_table_columns_style' );
}

function cpt_person_name(): string {
	return 'person';
}

function register_cpt_person(): void {
	register_post_type(
		cpt_person_name(),
		array(
			'labels' => array(
				'name' => __( 'People', 'helsinki-testbed-core' ),
				'singular_name' => __( 'Persons', 'helsinki-testbed-core' ),
			),
			'public' => false,
			'show_ui' => true,
			'has_archive' => false,
			'show_in_rest' => true,
			'supports' => array( 'title', 'thumbnail' ),
			'menu_icon' => 'dashicons-admin-users',
		)
	);
}

function posts_table_columns( array $columns ): array {
	$sorted = array();
	foreach ($columns as $key => $value) {
		$sorted[$key] = $value;

		if ( is_checkbox_column( $key ) ) {
			$sorted[thumbnail_column_key()] = '';
		}
	}

	return $sorted;
}

function posts_table_columns_content( string $column, int $post_id ): void {
	if ( is_thumbnail_column( $column ) ) {
		echo get_the_post_thumbnail( $post_id, 'thumbnail' );
	}
}

function posts_table_columns_style(): void {
	echo sprintf(
		'<style>
            .wp-list-table th.column-%1$s { width: 28px; }
            .wp-list-table td.column-$1%s img {
                max-width: 37px;
                max-height: 37px;
                width: auto;
                height: auto;
            }
        </style>',
		thumbnail_column_key()
	);
}

function is_checkbox_column( string $column ): bool {
	return 'cb' === $column;
}

function is_thumbnail_column( string $column ): bool {
	return thumbnail_column_key() === $column;
}

function thumbnail_column_key(): string {
	return 'thumbnail';
}
