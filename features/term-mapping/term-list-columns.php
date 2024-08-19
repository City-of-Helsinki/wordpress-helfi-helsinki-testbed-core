<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\TermMapping;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function custom_columns( array $columns ): array {
	$reordered = array();

	foreach ( $columns as $key => $label ) {
		$reordered[$key] = $label;

		if ( 'slug' === $key ) {
			$reordered[post_term_mapping_meta_key()] = __( 'Redirection', 'helsinki-testbed-core' );
		}
	}

	return $reordered;
}

function custom_columns_content( string $content, string $column, int $term_id ): void {
	$is_redirected = post_term_mapping_meta_key() === $column
			&& term_mapped_to_post( $term_id );

	if ( $is_redirected ) {
		echo '&check;';
	}
}
