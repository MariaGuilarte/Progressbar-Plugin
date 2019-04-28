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
 * @package    Cid_Progress_Bars
 * @subpackage Cid_Progress_Bars/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Cid_Progress_Bars
 * @subpackage Cid_Progress_Bars/includes
 * @author     David y Maria <mariajoseguilarte@gmail.com>
 */
class Cid_Progress_Bars_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'-cid-progress-bars',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
