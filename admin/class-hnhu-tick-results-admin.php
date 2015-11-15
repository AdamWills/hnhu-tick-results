<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://adamwills.io
 * @since      1.0.0
 *
 * @package    Hnhu_Tick_Results
 * @subpackage Hnhu_Tick_Results/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Hnhu_Tick_Results
 * @subpackage Hnhu_Tick_Results/admin
 * @author     Adam Wills <adam@adamwills.com>
 */
class Hnhu_Tick_Results_Admin {

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
		 * defined in Hnhu_Tick_Results_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hnhu_Tick_Results_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/hnhu-tick-results-admin.css', array(), $this->version, 'all' );

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
		 * defined in Hnhu_Tick_Results_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hnhu_Tick_Results_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/hnhu-tick-results-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	* Create the tick report post type
	*
	* @since    1.0.0
	*/
	public function register_tick_post_type() {

		$labels = array(
			"name" => "Tick Results",
			"singular_name" => "Tick Result",
			);

		$args = array(
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"show_ui" => true,
			"has_archive" => false,
			"show_in_menu" => true,
			'menu_position' => 5,
			'menu_icon' => 'dashicons-clipboard',
			"exclude_from_search" => true,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => array( "slug" => "tick-result", "with_front" => true ),
			"query_var" => true,

			"supports" => array( "title" ),
		);
		register_post_type( "tick-result", $args );
	}

	/**
	* Change the placeholder text for the title in the WP Admin area
	*
	* @since    1.0.0
	*/
	public function change_tick_results_title( $title ) {
    $screen = get_current_screen();
    if( isset( $screen->post_type ) ) {
        if ( 'tick-result' == $screen->post_type ) {
            $title = __('Enter tick result ticket number here', $this->plugin_name );
        }
    }
    return $title;
	}
}
