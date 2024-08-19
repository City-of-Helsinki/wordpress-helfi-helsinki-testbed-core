<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\TermMapping;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function term_mapping_meta_key(): string {
	return '_term_archive_mapping';
}

function post_term_mapping_meta_key(): string {
	return '_term_mapped';
}

function term_mapped_to_post( int $term_id ): int {
	$post_id = get_term_meta( $term_id, term_mapping_meta_key(), true );

	return $post_id ? (int) $post_id : 0;
}

function post_mapped_term( int $post_id ): int {
	$term_id = get_post_meta( $post_id, post_term_mapping_meta_key(), true );

	return $term_id ? (int) $term_id : 0;
}

function update_term_mapped_to_post( int $term_id, int $post_id ): bool {
	$current_post_id = term_mapped_to_post( $term_id );

	if ( $post_id ) {
		update_post_meta( $post_id, post_term_mapping_meta_key(), $term_id );
		$updated = update_term_meta( $term_id, term_mapping_meta_key(), $post_id );

		return ! is_wp_error( $updated ) && $updated;
	} else if ( $current_post_id ) {
		delete_post_meta( $current_post_id, post_term_mapping_meta_key() );

		return delete_term_meta( $term_id, term_mapping_meta_key() );
	} else {
		return false;
	}
}

function render_term_mapping_select( \WP_Term $term ): void {
	wp_nonce_field( term_meta_nonce_action( $term->term_id ), term_meta_nonce_name() );

	printf(
		'<table class="form-table" role="presentation">
			<tbody>
				<tr class="form-field">
					<th>
						<label for="%s-select">%s</label>
					</th>
					<td>
						%s
						<p class="description">%s</p>
					</td>
				</tr>
			</tbody>
		</table>',
		term_mapping_meta_key(),
		esc_html__( 'Archive Mapping', 'helsinki-testbed-core' ),
		term_mapping_page_select( term_mapped_to_post( $term->term_id ) ),
		esc_html__( 'Map a term archive to a page.', 'helsinki-testbed-core' )
	);
}

function term_mapping_page_select( int $selected ): string {
	return wp_dropdown_pages( array(
		'selected' => $selected,
		'echo' => false,
		'id' => term_mapping_meta_key() . '-select',
		'name' => term_mapping_meta_key(),
		'value_field' => 'ID',
		'option_none_value' => 0,
		'show_option_none' => esc_html__( 'Default', 'helsinki-testbed-core' ),
	) ) ?: term_mapping_no_page_select();
}

function term_mapping_no_page_select(): string {
	return sprintf(
		'<p>%s</p>',
		esc_html__( 'No page options available.', 'helsinki-testbed-core' )
	);
}
