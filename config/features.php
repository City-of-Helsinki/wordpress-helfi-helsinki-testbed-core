<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
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
