<?php
/**
 * Plugin Name:     Case Antiques Extras
 * Plugin URI:      https://wenmarkdigital.com
 * Description:     Adds additional functionality to the Case Antiques website.
 * Author:          Michael Wender
 * Author URI:      https://mwender.com
 * Text Domain:     case-antiques-extras
 * Domain Path:     /languages
 * Version:         1.1.2
 *
 * @package         Case_Antiques_Extras
 */

// Define some helpful constants.
define( 'CASE_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'CASE_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'CASE_DB_VERSION', '1.0' );
define( 'CASE_API', 'case/v1' );

/**
 * Load Required Files
 */

// Classes
require_once CASE_DIR_PATH . 'lib/classes/acf-custom-save-path-setting.php';
require_once CASE_DIR_PATH . 'lib/classes/my-simple-space.php';

// Functions
require_once CASE_DIR_PATH . 'lib/fns/acf.php';
require_once CASE_DIR_PATH . 'lib/fns/debug.php';

/**
 * Adds custom metadata links to the Case Antiques Extras plugin row in the Plugins screen.
 *
 * Displays a "local" badge when running the local development version, and
 * appends links to the changelog and the package name.
 *
 * @since 1.1.2
 *
 * @param string[] $links An array of the plugin's metadata links.
 * @param string   $file  Path to the plugin file relative to the plugins directory.
 * @return string[] Modified array of metadata links.
 */
add_filter( 'plugin_row_meta', function( $links, $file ) {
  
  if ( strpos( $file, 'case-antiques-extras.php' ) !== false ) {
    
    // Check if we're running the local dev version:
    $plugin_dir = plugin_dir_path( __FILE__ );
    
    if ( strpos( $plugin_dir, 'localdev' ) !== false ) {
      array_unshift( $links, '<span style="padding:2px 8px; background:#0073aa; color:#fff; border-radius:10px; font-size:11px;">local</span> ' );;
    }

    $links[] = '<a href="https://github.com/WenderHost/case-antiques-extras?tab=readme-ov-file#changelog" target="_blank">Changelog</a>';
    $links[] = '<code>wenderhost/case-antiques-extras</code>';

  }

  return $links;

}, 10, 2 );