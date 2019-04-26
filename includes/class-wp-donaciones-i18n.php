<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://arepadevs.website/
 * @since      1.0.0
 *
 * @package    Wp_Donaciones
 * @subpackage Wp_Donaciones/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Donaciones
 * @subpackage Wp_Donaciones/includes
 * @author     David y Maria <mariajoseguilarte@gmail.com>
 */
class Wp_Donaciones_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-donaciones',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
