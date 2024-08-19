<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Testbed\Core\Features\Misc;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'redirect_canonical', __NAMESPACE__ . '\\fix_pagination_on_singles' );
function fix_pagination_on_singles( $redirect_url ) {
    return ( is_single() && get_query_var( 'paged' ) ) ? false : $redirect_url;
}
