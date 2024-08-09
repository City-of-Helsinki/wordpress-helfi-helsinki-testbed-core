<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'blocks' => array(
		'assets',
		'init',
	),
	'mandatory-excerpt' => array(
		'init',
	),
	'post-types' => array(
		'page',
		'person' => array(
			'post-type',
			'posts-table-columns',
			'post-meta',
			'save-post',
			'metabox',
			'init',
		),
	),
	'quiet-posts' => array(
		'post-meta',
		'post-state',
		'save-post',
		'init',
	),
	'term-mapping' => array(
		'term-meta',
		'save-term',
		'term-list-columns',
		'redirection',
		'init'
	),
	'misc',
);
