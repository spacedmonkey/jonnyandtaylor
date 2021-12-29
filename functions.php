<?php
/**
 * Jonny and Taylor functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Jonny_and_Taylor
 */

if ( ! defined( 'JAT_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'JAT_VERSION', '2.0.0' );
}

if ( ! function_exists( 'jonny_and_taylor_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function jonny_and_taylor_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Jonny and Taylor, use a find and replace
		 * to change 'jonny-and-taylor' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'jonny-and-taylor', get_template_directory() . '/languages' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles and fonts.
		add_editor_style( array(
			'style.css',
			jonny_and_taylor_fonts_url()
		) );

		// Disable loading core block inline styles.
		add_filter( 'should_load_separate_core_block_assets', '__return_false' );

		// Remove core block patterns.
		remove_theme_support( 'core-block-patterns' );
	}
endif;
add_action( 'after_setup_theme', 'jonny_and_taylor_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function jonny_and_taylor_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'jonny_and_taylor_content_width', 640 );
}
add_action( 'after_setup_theme', 'jonny_and_taylor_content_width', 0 );


/**
 * @return string|null
 */
function jonny_and_taylor_fonts_url() {
	$fonts = [
		'family=Parisienne:wght@400',
		'family=Cormorant+Garamond:wght@100;200;300;400;500;600;700;800;900'
	];

	// Make a single request for all Google Fonts.
	return esc_url_raw( 'https://fonts.googleapis.com/css2?' . implode( '&', array_unique( $fonts ) ) . '&display=swap' );
}

/**
 * Enqueue scripts and styles.
 */
function jonny_and_taylor_scripts() {
	$asset = jonny_and_taylor_asset_metadata( 'index' );
	wp_enqueue_style( 'jonny-and-taylor-vendor', get_theme_file_uri( '/build/index.css' ), array(), $asset['version'] );
	wp_enqueue_style( 'jonny-and-taylor-style', get_theme_file_uri( '/build/style-index.css' ), array('jonny-and-taylor-vendor'), $asset['version'] );
	wp_style_add_data( 'jonny-and-taylor-style', 'rtl', 'replace' );

	wp_enqueue_script( 'jonny-and-taylor-script', get_theme_file_uri( '/build/index.js' ), $asset['dependencies'], $asset['version'], true );

	wp_add_inline_script( 'jonny-and-taylor-script', sprintf( 'var react_theme_settings = %s', wp_json_encode( [] ) ), 'before' );

	wp_set_script_translations( 'jonny-and-taylor-script', 'jonny-and-taylor' );

	wp_enqueue_style( 'jonny-and-taylor-fonts', jonny_and_taylor_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'jonny_and_taylor_scripts' );


/**
 * Get metadata from generated file.
 *
 * @param string $slug Script handle.
 *
 * @return array
 */
function jonny_and_taylor_asset_metadata( $slug ) {
	$asset_file            = get_theme_file_path( 'build/' . $slug . '.asset.php' );
	$asset                 = is_readable( $asset_file ) ? require $asset_file : array();
	$asset['dependencies'] = isset( $asset['dependencies'] ) ? $asset['dependencies'] : array();
	$asset['version']      = isset( $asset['version'] ) ? $asset['version'] : JAT_VERSION;

	return $asset;
}


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
