<?php

/**
 * The plugin bootstrap file
 *
 *
 * @link              http://woocommerce.db-dzine.de
 * @since             1.0.0
 * @package           Dokan_Opening_Hours
 *
 * @wordpress-plugin
 * Plugin Name:       Dokan Opening Hours
 * Plugin URI:        http://woocommerce.db-dzine.de
 * Description:       Show Opening Hours in Dokan
 * Version:           1.0.0
 * Author:            DB-Dzine
 * Author URI:        http://www.db-dzine.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dokan-opening-hours
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dokan-opening-hours-activator.php
 */
function activate_Dokan_Opening_Hours() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dokan-opening-hours-activator.php';
	Dokan_Opening_Hours_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dokan-opening-hours-deactivator.php
 */
function deactivate_Dokan_Opening_Hours() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dokan-opening-hours-deactivator.php';
	Dokan_Opening_Hours_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Dokan_Opening_Hours' );
register_deactivation_hook( __FILE__, 'deactivate_Dokan_Opening_Hours' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dokan-opening-hours.php';

/**
 * Run the Plugin
 * @author Daniel Barenkamp
 * @version 1.0.0
 * @since   1.0.0
 * @link    http://woocommerce.db-dzine.de
 */
function run_Dokan_Opening_Hours() {

	$plugin_data = get_plugin_data( __FILE__ );
	$version = $plugin_data['Version'];

	$plugin = new Dokan_Opening_Hours($version);
	$plugin->run();

	return $plugin;

}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active('woocommerce/woocommerce.php') ){
	$Dokan_Opening_Hours = run_Dokan_Opening_Hours();
} else {
	add_action( 'admin_notices', 'Dokan_Opening_Hours_Not_Installed' );
}

function Dokan_Opening_Hours_Not_Installed()
{
	?>
    <div class="error">
      <p><?php _e( 'Dokan Opening Hours requires the WooCommerce and Dokan plugin. Please install or activate them before!', 'dokan-opening-hours'); ?></p>
    </div>
    <?php
}
