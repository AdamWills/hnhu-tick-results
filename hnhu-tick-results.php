<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://adamwills.io
 * @since             1.0.0
 * @package           Hnhu_Tick_Results
 *
 * @wordpress-plugin
 * Plugin Name:       HNHU Tick Results
 * Plugin URI:        https://hnhu.org
 * Description:       Allows visitors to retrieve tick results with a given ticket number
 * Version:           1.0.0
 * Author:            Adam Wills
 * Author URI:        https://adamwills.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       hnhu-tick-results
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-hnhu-tick-results-activator.php
 */
function activate_hnhu_tick_results() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-hnhu-tick-results-activator.php';
	Hnhu_Tick_Results_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-hnhu-tick-results-deactivator.php
 */
function deactivate_hnhu_tick_results() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-hnhu-tick-results-deactivator.php';
	Hnhu_Tick_Results_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_hnhu_tick_results' );
register_deactivation_hook( __FILE__, 'deactivate_hnhu_tick_results' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-hnhu-tick-results.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_hnhu_tick_results() {

	$plugin = new Hnhu_Tick_Results();
	$plugin->run();

}
run_hnhu_tick_results();
