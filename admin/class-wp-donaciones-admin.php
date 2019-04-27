<?php

namespace Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://arepadevs.website/
 * @since      1.0.0
 *
 * @package    Wp_Donaciones
 * @subpackage Wp_Donaciones/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Donaciones
 * @subpackage Wp_Donaciones/admin
 * @author     David y Maria <mariajoseguilarte@gmail.com>
 */
class Wp_Donaciones_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-donaciones-admin.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-donaciones-admin.js', array( 'jquery' ), $this->version, false );
    wp_localize_script( $this->plugin_name, 'ajax_object', ['ajax_url' => admin_url('admin-ajax.php')] );
	}

  public function add_menu(){
    add_menu_page(
      'Progress bars',              // Título de la página
      'Progress bars',              // Título del menú
      'manage_options',             // Permisos
      'progress-bars-admin-menu',   // Slug
       __NAMESPACE__ . '\Wp_Donaciones_Admin::load_html',              // Función
      'dashicons-admin-plugins'     // Url del ícono
    );
  }

  public static function load_html(){
    include 'partials/progress_bars_admin_menu_form.php';
  }

  public function list(){
    global $wpdb;
		$tableName = $wpdb->prefix . 'donar';
    $sql = 'SELECT * FROM ' . $tableName;

    wp_send_json( $wpdb->get_results($sql) );
  }

	public function store(){
    global $wpdb;
		$tableName = $wpdb->prefix . 'donar';

    $progress_bar = [
      'name'      => $_POST['name'],
      'category'  => $_POST['category'],
      'goal'      => $_POST['goal'],
      'color'     => $_POST['color']
    ];

    $vars = ['$name' => $_POST['name'], '$category' => $_POST['category'], '$goal' => $_POST['goal'], '$color' => $_POST['color'] ];
    $shortcode = '[wppb name="$name" category="$category" goal="$goal" color="$color"]';
    $progress_bar['shortcode'] = strtr($shortcode, $vars);

		$wpdb->insert($tableName, $progress_bar);
    return wp_send_json( $wpdb->insert_id );
  }

	public function show(){
		global $wpdb;
		$tableName = $wpdb->prefix . 'donar';
		$pbId = $_GET['id'];

		$sql = "SELECT * FROM " . $tableName . " WHERE id=" . $pbId;
		wp_send_json( $wpdb->get_results($sql) );
	}

	public function update(){}

  public function delete(){
		global $wpdb;
		$tableName = $wpdb->prefix . 'donar';
		$pbId = $_POST['id'];

    wp_send_json( $wpdb->delete($tableName, ['id'=>$pbId] ) );
	}

}
