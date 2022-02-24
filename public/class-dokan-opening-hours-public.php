<?php

class Dokan_Opening_Hours_Public
{
	private $plugin_name;
	private $version;
	private $options;

	/**
	 * Advanced Categories Plugin Construct
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    http://woocommerce.db-dzine.de
	 * @param   string                         $plugin_name 
	 * @param   string                         $version    
	 */
	public function __construct($plugin_name, $version)
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Enqueue Styles
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    http://woocommerce.db-dzine.de
	 * @return  boolean
	 */
	public function enqueue_styles()
	{
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__).'css/dokan-opening-hours-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 * @author Daniel Barenkamp
	 * @version 1.0.0
	 * @since   1.0.0
	 * @link    http://woocommerce.db-dzine.de
	 * @return  boolean
	 */
	public function enqueue_scripts()
	{
		wp_enqueue_script($this->plugin_name.'-public', plugin_dir_url(__FILE__).'js/dokan-opening-hours-public.js', array('jquery'), $this->version, true);
	}
}