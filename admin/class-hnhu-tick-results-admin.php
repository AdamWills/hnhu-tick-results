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


			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/hnhu-tick-results-admin.js', array( 'jquery' ), $this->version, false );
			// add some data to this script, including a nonce to ensure that data is only coming through the proper channels
			if (isset($current_post) && isset($current_post->ID)) {
				$current_post_id = $current_post->ID;
			} else {
				$current_post_id = '';
			}
			wp_localize_script( $this->plugin_name, 'tick_vars', array(
				'tick_nonce' => wp_create_nonce( 'tick_nonce' ),
				'selected_status' => get_field('status', $current_post_id),
				)
			);

	}

	/**
	* Create the tick report post type and taxonomy
	*
	* @since    1.0.0
	*/
	public function register_tick_post_type() {

		$labels = array(
			"name" 							=> "Tick Results",
			"singular_name" 		=> "Tick Result",
			"add_new_item"  		=> "Add New Tick Result",
			"add_new"  					=> "Add New Result",
			"edit_item" 				=> "Edit Tick Result"
			);

		$capabilities = array(
			'edit_post'         => 'tickreports',
			'read_post'         => 'tickreports',
			'delete_post'       => 'tickreports',
			'edit_posts'        => 'tickreports',
			'edit_others_posts' => 'tickreports',
			'publish_posts'     => 'tickreports',
			'read_private_posts'=> 'tickreports',
		);

		$args = array(
			"labels" 						=> $labels,
			"description" 			=> "",
			"public" 						=> true,
			"show_ui" 					=> true,
			"has_archive" 			=> false,
			"show_in_menu" 			=> true,
			'menu_position' 		=> 5,
			'menu_icon' 				=> 'dashicons-clipboard',
			"exclude_from_search" => true,
			"capability_type" 	=> "post",
			"hierarchical" 			=> false,
			"rewrite" 					=> array( "slug" => "tick-result", "with_front" => true ),
			"query_var" 				=> true,
			"supports" 					=> array( "title" ),
			'capabilities'      => $capabilities
		);
		register_post_type( "tick-result", $args );

		$labels = array(
			"name" 							=> "Tick Types",
			"label" 						=> "Tick Types",
			'add_new_item' 			=> "Add Tick Type",
			'edit_item' 				=> "Edit Tick Type",
			);

		$capabilities = array(
			'manage_terms'      => 'tickreports',
			'edit_terms'        => 'tickreports',
			'delete_terms'      => 'tickreports',
			'assign_terms'      => 'tickreports',
		);

		$args = array(
			"labels" 						=> $labels,
			"hierarchical" 			=> false,
			"label" 						=> "Tick Types",
			"show_ui" 					=> true,
			"query_var" 				=> true,
			"rewrite" 					=> array( 'slug' => 'tick-types', 'with_front' => true ),
			"show_admin_column"	=> false,
			'capabilities'			=> $capabilities,
		);
		register_taxonomy( "tick-types", array( "tick-result" ), $args );

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
            $title = __('Enter tick result ticket number here (2015SIM001)', $this->plugin_name );
        }
    }
    return $title;
	}

	/**
	* Using ACF, create the custom fields!
	*
	* @since    1.0.0
	*/
	public function create_custom_fields() {
		if(function_exists("register_field_group")) {
			register_field_group(array (
				'id' => 'acf_tick-results-2',
				'title' => 'Tick Results',
				'fields' => array (
					array (
						'key' => 'field_56492f620170d',
						'label' => 'Date Sample Submitted',
						'name' => 'date_sample_submitted',
						'type' => 'date_picker',
						'required' => 1,
						'date_format' => 'yymmdd',
						'display_format' => 'dd/mm/yy',
						'first_day' => 0,
					),
					array (
						'key' => 'field_56492f760170e',
						'label' => 'Tick Type',
						'name' => 'tick_type',
						'type' => 'taxonomy',
						'required' => 1,
						'taxonomy' => 'tick-types',
						'field_type' => 'select',
						'allow_null' => 0,
						'load_save_terms' => 0,
						'return_format' => 'id',
						'multiple' => 0,
					),
					array (
						'key' => 'field_56492f860170f',
						'label' => 'Status',
						'name' => 'status',
						'type' => 'select',
						'required' => 1,
						'choices' => array (
							'' => '-- Select a Status --',
						),
						'default_value' => '',
						'allow_null' => 0,
						'multiple' => 0,
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'tick-result',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array (
					'position' => 'normal',
					'layout' => 'default',
					'hide_on_screen' => array (
					),
				),
				'menu_order' => 0,
			));
			register_field_group(array (
				'id' => 'acf_tick-types',
				'title' => 'Tick Types',
				'fields' => array (
					array (
						'key' => 'field_5649328be7fa0',
						'label' => 'Statuses',
						'name' => 'statuses',
						'type' => 'repeater',
						'sub_fields' => array (
							array (
								'key' => 'field_564932afe7fa1',
								'label' => 'Name',
								'name' => 'name',
								'type' => 'text',
								'column_width' => '',
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'formatting' => 'html',
								'maxlength' => '',
							),
							array (
								'key' => 'field_5651f4622f156',
								'label' => 'Status Message',
								'name' => 'status_message',
								'type' => 'wysiwyg',
								'column_width' => '',
								'default_value' => '',
								'toolbar' => 'full',
								'media_upload' => 'yes',
							),
							array (
								'key' => 'field_5651f5bb1f0a0',
								'label' => 'Recommendation Based on Status',
								'name' => 'recommendation',
								'type' => 'wysiwyg',
								'column_width' => '',
								'default_value' => '',
								'toolbar' => 'full',
								'media_upload' => 'yes',
							),
						),
						'row_min' => '',
						'row_limit' => '',
						'layout' => 'table',
						'button_label' => 'Add Status',
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'ef_taxonomy',
							'operator' => '==',
							'value' => 'tick-types',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array (
					'position' => 'normal',
					'layout' => 'default',
					'hide_on_screen' => array (
					),
				),
				'menu_order' => 0,
			));
		}
	}

	/**
	* Functionality used by AJAX in the admin area to populate the status dropdown based on Tick Types
	*
	* @since    1.0.0
	*/
	public function get_statuses_by_tick_type( $tick_type ) {
		// if the nonce isn't set properly, YOU SHALL NOT PASS!
		if( !isset( $_POST['tick_nonce'] ) || !wp_verify_nonce( $_POST['tick_nonce'], 'tick_nonce' ) )
    	die('Permission denied');

		// let's make sure that we're dealing with an integer here...
		$selected_tick_type = absint($_POST['tick_type']);
		if ($selected_tick_type < 1) {
			die('Not a valid tick type');
		}

		// get the statuses related to that tick type
		$tick_statuses = get_field( 'statuses', 'tick-types_' . $selected_tick_type );

		// we only need to populate the name - so let's only pass that info
		foreach ($tick_statuses as $key => $value) {
    	$statuses[] = $value['name'];
  	}
		return wp_send_json($statuses);
	}

	/**
	* Remove the meta box for the related taxonomy since we're using ACF to manipulate the info
	*
	* @since    1.0.0
	*/
	public function remove_tick_type_meta_box() {
		remove_meta_box( 'tagsdiv-tick-types', 'tick-result', 'side' );
	}

}
