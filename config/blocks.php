<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return [
	'content-list' => [
		'render_callback' => 'ContentList\render',
	],
    'highlight' => [
		'render_callback' => 'Highlight\render',
	],
    'icon-and-text' => [
		'render_callback' => 'IconAndText\render',
	],
    'person-list' => [
		'render_callback' => 'PersonList\render',
	],
];
