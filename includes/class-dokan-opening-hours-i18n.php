<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://woocommerce.db-dzine.de
 * @since      1.0.0
 *
 * @package    Dokan_Opening_Hours
 * @subpackage Dokan_Opening_Hours/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Dokan_Opening_Hours
 * @subpackage Dokan_Opening_Hours/includes
 * @author     Daniel Barenkamp <contact@db-dzine.de>
 */
class Dokan_Opening_Hours_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$loaded = load_plugin_textdomain(
			'dokan-opening-hours',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
