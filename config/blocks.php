<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return [
	'content-list' => [
		'render_callback' => 'ContentList\render',
	],
    // 'highlight' => [],
    'icon-and-text' => [
		'render_callback' => 'IconAndText\render',
	],
    'person-list' => [
		'render_callback' => 'PersonList\render',
	],
];
