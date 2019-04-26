<?php

/**
 * Fired during plugin activation
 *
 * @link       http://arepadevs.website/
 * @since      1.0.0
 *
 * @package    Wp_Donaciones
 * @subpackage Wp_Donaciones/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Donaciones
 * @subpackage Wp_Donaciones/includes
 * @author     David y Maria <mariajoseguilarte@gmail.com>
 */
class Wp_Donaciones_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    global $wpdb;
    $tableName = $wpdb->prefix . 'donar';
    $tableExists = $wpdb->get_var("SHOW TABLES LIKE '$tableName'" );
    $charset_collate = $wpdb->get_charset_collate();
    
    if( !$tableExists ){
      $sql = "CREATE TABLE $tableName (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(191),
        category varchar(191),
        color varchar (191),
        goal int,
        shortcode varchar(191),
        PRIMARY KEY  (id)
      ) $charset_collate;";

      dbDelta( $sql );
    }
	}

}
