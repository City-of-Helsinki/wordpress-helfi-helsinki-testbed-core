<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
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
	'term-mapping' => array(
		'term-meta',
		'save-term',
		'redirection',
		'init'
	),
);
