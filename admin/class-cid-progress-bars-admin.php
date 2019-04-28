<?php

namespace Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://arepadevs.website/
 * @since      1.0.0
 *
 * @package    Cid_Progress_Bars
 * @subpackage Cid_Progress_Bars/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cid_Progress_Bars
 * @subpackage Cid_Progress_Bars/admin
 * @author     David y Maria <mariajoseguilarte@gmail.com>
 */
class Cid_Progress_Bars_Admin {

	private $tableName;

	private $shortcodeTemplate;
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
		global $wpdb;

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->tableName = $wpdb->prefix . 'donar';
		$this->shortcodeTemplate = '[wppb name="$name" category="$category" goal="$goal" color="$color"]';
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cid-progress-bars-admin.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cid-progress-bars-admin.js', array( 'jquery' ), $this->version, false );
    wp_localize_script( $this->plugin_name, 'ajax_object', ['ajax_url' => admin_url('admin-ajax.php')] );
	}

  public function add_menu(){
    add_menu_page(
      'Progress bars',              // Título de la página
      'Progress bars',              // Título del menú
      'manage_options',             // Permisos
      'progress-bars-admin-menu',   // Slug
       __NAMESPACE__ . '\Cid_Progress_Bars_Admin::load_html',              // Función
      'dashicons-admin-plugins'     // Url del ícono
    );
  }

  public static function load_html(){
    include 'partials/cid-progress-bars-admin-menu-form.php';
  }

  public function listar(){
    global $wpdb;
    $sql    = 'SELECT * FROM ' . $this->tableName;
		$result = $wpdb->get_results($sql);

    wp_send_json( $result );
  }

	public function store(){
    global $wpdb;

    $progress_bar = [
      'name'      => $_POST['name'],
      'category'  => $_POST['category'],
      'goal'      => $_POST['goal'],
      'color'     => $_POST['color']
    ];

		$wpdb->insert($this->tableName, $progress_bar);
		$id = $wpdb->insert_id;

		$progress_bar['shortcode'] = '[wppb id="' . $id . '"]';
		$wpdb->update($this->tableName, $progress_bar, ['id' => $id]);

    return wp_send_json( $id );
  }

	public function show(){
		global $wpdb;
		$id  = $_GET['id'];
		$sql = "SELECT * FROM " . $this->tableName . " WHERE id=" . $id;
		$result = $wpdb->get_results($sql);

		wp_send_json( $result );
	}

	public function update(){
		global $wpdb;
		$id = $_POST['id'];

    $progress_bar = [
      'name'      => $_POST['name'],
      'category'  => $_POST['category'],
      'goal'      => $_POST['goal'],
      'color'     => $_POST['color']
    ];
		$progress_bar['shortcode'] = '[wppb id="' . $id . '"]';

		$success = $wpdb->update($this->tableName, $progress_bar, ['id' => $id]);
		$result = ['success'=>$success, 'id'=>$id];
    wp_send_json( $result );
	}

  public function delete(){
		global $wpdb;
		$id = $_POST['id'];
    wp_send_json( $wpdb->delete($this->tableName, ['id'=>$id] ) );
	}

	public function postToShortcode( $data ){
		$vars      = ['$name' => $data['name'], '$category' => $data['category'], '$goal' => $data['goal'], '$color' => $data['color'] ];
		$shortcode = strtr($this->shortcodeTemplate, $vars);
		return $shortcode;
	}

}
