<?php
/**
 * Plugin Name: WP Author Bio
 * Plugin URI:  https://jeweltheme.com
 * Description: WP Author Bio comes with rich customisable settings. Add author bio at the end of every post or Pages. See Live Social Updates of every Author.
 * Version:     1.0.5.2
 * Author:      Jewel Theme
 * Author URI:  https://jeweltheme.com
 * Text Domain: awesome-wp-author-bio
 * Domain Path: languages/
 * License:     GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package awesome-wp-author-bio
 */

/*
 * don't call the file directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	wp_die( esc_html__( 'You can\'t access this page', 'awesome-wp-author-bio' ) );
}

$jltauthorbio_plugin_data = get_file_data(
	__FILE__,
	array(
		'Version'     => 'Version',
		'Plugin Name' => 'Plugin Name',
		'Author'      => 'Author',
		'Description' => 'Description',
		'Plugin URI'  => 'Plugin URI',
	),
	false
);

// Define Constants.
if ( ! defined( 'JLTAUTHORBIO' ) ) {
	define( 'JLTAUTHORBIO', $jltauthorbio_plugin_data['Plugin Name'] );
}

if ( ! defined( 'JLTAUTHORBIO_VER' ) ) {
	define( 'JLTAUTHORBIO_VER', $jltauthorbio_plugin_data['Version'] );
}

if ( ! defined( 'JLTAUTHORBIO_AUTHOR' ) ) {
	define( 'JLTAUTHORBIO_AUTHOR', $jltauthorbio_plugin_data['Author'] );
}

if ( ! defined( 'JLTAUTHORBIO_DESC' ) ) {
	define( 'JLTAUTHORBIO_DESC', $jltauthorbio_plugin_data['Author'] );
}

if ( ! defined( 'JLTAUTHORBIO_URI' ) ) {
	define( 'JLTAUTHORBIO_URI', $jltauthorbio_plugin_data['Plugin URI'] );
}

if ( ! defined( 'JLTAUTHORBIO_DIR' ) ) {
	define( 'JLTAUTHORBIO_DIR', __DIR__ );
}

if ( ! defined( 'JLTAUTHORBIO_FILE' ) ) {
	define( 'JLTAUTHORBIO_FILE', __FILE__ );
}

if ( ! defined( 'JLTAUTHORBIO_SLUG' ) ) {
	define( 'JLTAUTHORBIO_SLUG', dirname( plugin_basename( __FILE__ ) ) );
}

if ( ! defined( 'JLTAUTHORBIO_BASE' ) ) {
	define( 'JLTAUTHORBIO_BASE', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'JLTAUTHORBIO_PATH' ) ) {
	define( 'JLTAUTHORBIO_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( ! defined( 'JLTAUTHORBIO_URL' ) ) {
	define( 'JLTAUTHORBIO_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
}

if ( ! defined( 'JLTAUTHORBIO_INC' ) ) {
	define( 'JLTAUTHORBIO_INC', JLTAUTHORBIO_PATH . '/Inc/' );
}

if ( ! defined( 'JLTAUTHORBIO_LIBS' ) ) {
	define( 'JLTAUTHORBIO_LIBS', JLTAUTHORBIO_PATH . 'Libs' );
}

if ( ! defined( 'JLTAUTHORBIO_ASSETS' ) ) {
	define( 'JLTAUTHORBIO_ASSETS', JLTAUTHORBIO_URL . 'assets/' );
}

if ( ! defined( 'JLTAUTHORBIO_IMAGES' ) ) {
	define( 'JLTAUTHORBIO_IMAGES', JLTAUTHORBIO_ASSETS . 'images' );
}

if ( ! class_exists( '\\JLTAUTHORBIO\\JLT_Author_Bio' ) ) {
	// Autoload Files.
	include_once JLTAUTHORBIO_DIR . '/vendor/autoload.php';
	// Instantiate JLT_Author_Bio Class.
	include_once JLTAUTHORBIO_DIR . '/class-awesome-wp-author-bio.php';
}