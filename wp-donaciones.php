<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://arepadevs.website/
 * @since             1.0.0
 * @package           Wp_Donaciones
 *
 * @wordpress-plugin
 * Plugin Name:       CID - Progress Bars
 * Plugin URI:        http://arepadevs.website/wp-plugins/cid_progress
 * Description:       Percentage progress bars, based on a WooCommerce category earnings against a goal amount for Corporación Infancia y desarrollo,
 * Version:           1.0.0
 * Author:            EspartaDevs
 * Author URI:        http://arepadevs.website/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-donaciones
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_DONACIONES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-donaciones-activator.php
 */
function activate_wp_donaciones() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-donaciones-activator.php';
	Wp_Donaciones_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-donaciones-deactivator.php
 */
function deactivate_wp_donaciones() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-donaciones-deactivator.php';
	Wp_Donaciones_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_donaciones' );
register_deactivation_hook( __FILE__, 'deactivate_wp_donaciones' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-donaciones.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_donaciones() {

	$plugin = new Wp_Donaciones();
	$plugin->run();

}
run_wp_donaciones();

function add_shortcodes_pb(){
  add_shortcode('wppb', 'shortcode_progress_bar');
}
add_shortcodes_pb();

function shortcode_progress_bar($args){
	global $wpdb;
	$tableName = $wpdb->prefix . 'donar';

	$a = shortcode_atts([
    'id'     => null,
    'category' => 'Sin categoría',
    'goal'     => 'Objetivo indefinido',
    'color'    => '#e9ecef'
  ], $args);

	$id  = $a['id'];
	$sql = "SELECT * FROM " . $tableName . " WHERE id=" . $id;
	$progress_bar = $wpdb->get_results($sql)[0];

	$earnings = get_category_total();

  $width    = ($earnings / $progress_bar->goal) * 100;
	$width    = number_format($width, 2);

	if( $width >= 100 ){
		$width = 100;
	}

  $template = '<div class="cid-progress">
                <div class="cid-progress-bar" role="progressbar"
                style="width:' . $width . '%; background:' . $progress_bar->color . ';" aria-valuenow="25"
                aria-valuemin="0" aria-valuemax="100">' . $width . '%</div>
              </div>';

  return $template;
}

function get_category_total(){
  $products = wc_get_orders([
    'category'   => 'donacion'
  ]);

  foreach( $products as $product ){
    $total += $product->total;
  }
  return $total;
}
