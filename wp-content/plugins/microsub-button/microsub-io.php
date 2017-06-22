<?php
/**
 * Plugin Name: Microsub Button
 * Plugin URI:  https://microsub.io/#/documentation/button
 * Description: Adding "support us" button.
 * Author:      Eugene Retunsky
 * Author URI:  https://microsub.io/
 * Version:     0.1
 * Text Domain: microsub
 * Domain Path: /languages
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Plugin constants.
 */
if ( ! defined( 'MICROSUB_VERSION' ) ) define( 'MICROSUB_VERSION', '0.1' );
if ( ! defined( 'MICROSUB_PATH' ) )    define( 'MICROSUB_PATH',    plugin_dir_path( __FILE__ ) );
if ( ! defined( 'MICROSUB_URL' ) )     define( 'MICROSUB_URL',     esc_url( plugin_dir_url( __FILE__ ) ) );
/**
 * Includes.
 */
require_once MICROSUB_PATH . 'includes/i18n.php';
require_once MICROSUB_PATH . 'includes/output.php';
/**
 * Admin includes.
 */
if ( is_admin() ) {
	require_once MICROSUB_PATH . 'includes/admin/meta-box.php';
	require_once MICROSUB_PATH . 'includes/admin/options.php';
	require_once MICROSUB_PATH . 'includes/admin/post-meta.php';
}
