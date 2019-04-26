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

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Donaciones_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Donaciones_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-donaciones-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Donaciones_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Donaciones_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

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

    return $wpdb->insert($tableName, $progress_bar);
    wp_die();
  }

  public function list(){
    global $wpdb;
    $sql = 'SELECT * FROM wp_donaciones_donar';

    wp_send_json( $wpdb->get_results($sql) );
  }

  public function update(){}

  public function delete(){}


}
