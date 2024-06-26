<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\PostTypes\Person;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function person_meta_handlers(): array {
	return array(
		person_email_meta_key() => __NAMESPACE__ . '\\update_person_email',
		person_description_meta_key() => __NAMESPACE__ . '\\update_person_description',
	);
}

/**
  * Email
  */
function person_email_meta_key(): string {
	return 'email';
}

function person_email( int $post_id ): string {
	return get_post_meta( $post_id, person_email_meta_key(), true ) ?: '';
}

function update_person_email( int $post_id, $email = '' ): bool {
	$email = filter_var( $email, FILTER_SANITIZE_EMAIL );
	if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		$email = '';
	}

	return update_post_meta( $post_id, person_email_meta_key(), $email ) ? true : false;
}

/**
  * Description
  */
function person_description_meta_key(): string {
	return 'description';
}

function person_description( int $post_id ): string {
	return get_post_meta( $post_id, person_description_meta_key(), true ) ?: '';
}

function update_person_description( int $post_id, $description = '' ): bool {
	$description = sanitize_textarea_field( $description );

	return update_post_meta( $post_id, person_description_meta_key(), $description ) ? true : false;
}
