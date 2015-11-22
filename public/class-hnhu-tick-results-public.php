<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://adamwills.io
 * @since      1.0.0
 *
 * @package    Hnhu_Tick_Results
 * @subpackage Hnhu_Tick_Results/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Hnhu_Tick_Results
 * @subpackage Hnhu_Tick_Results/public
 * @author     Adam Wills <adam@adamwills.com>
 */
class Hnhu_Tick_Results_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/hnhu-tick-results-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/hnhu-tick-results-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add our custom content to the end of the tick results template
	 *
	 * @since    1.0.0
	 */
	public function the_content( $post_content ) {

		if ( is_page_template('tpl.tick-results.php') ) :

			if (isset($_POST['ticket-number'])) {
				include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/tick-results.php';
				$post_content .= $output;
			}

			include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/tick-form.php';
			$post_content .= $output;

		endif;
    return $post_content;

	}

}
