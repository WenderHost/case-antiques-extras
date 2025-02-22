<?php
/**
 * Plugin Name:     Case Antiques Extras
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Adds additional functionality to the Case Antiques website.
 * Author:          Michael Wender
 * Author URI:      https://mwender.com
 * Text Domain:     case-antiques-extras
 * Domain Path:     /languages
 * Version:         1.0.0
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

// Functions
require_once CASE_DIR_PATH . 'lib/fns/acf.php';
require_once CASE_DIR_PATH . 'lib/fns/debug.php';