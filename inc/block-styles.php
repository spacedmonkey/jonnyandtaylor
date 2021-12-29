<?php
/**
 * Define block styles. 
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Spacedmonkey
 * @subpackage Jonny_and_taylor
 */

register_block_style(
	'core/group',
	array(
		'name'  => 'navigation',
		'label' => __( 'Navigation', 'jonny-and-taylor' ),
	)
);

register_block_style(
	'core/group',
	array(
		'name'  => 'footer',
		'label' => __( 'Footer', 'jonny-and-taylor' ),
	)
);
