<?php

/**
 * Class WP_Locale_Switch_Plugin_Settings
 */
class WP_Locale_Switch_Plugin_Settings {

	/**
	 * WP_Locale_Switch_Plugin_Settings constructor.
	 */
	function __construct() {
		add_action( 'admin_init', array( $this, 'init' ) );
	}

	/**
	 * Initialization
	 */
	function init() {
		register_setting( $this->group(), $this->field() );
		register_setting( $this->group(), $this->wp_cache_support_field() );
	}

	/**
	 * @return mixed
	 */
	function get_locales() {
		return get_option( $this->field() );
	}

	/**
	 * @return array
	 */
	function get_locales_array() {
		return array_map( array( $this, 'clear_locales' ), explode( ',', $this->get_locales() ) );
	}

	/**
	 * @return string
	 */
	public function group() {
		return 'wlsp-settings-group';
	}

	/**
	 * @return string
	 */
	public function field() {
		return 'locales';
	}

	public function wp_cache_support_field() {
		return 'wp_cache_support';
	}

	/**
	 *
	 * @param $item
	 *
	 * @return string
	 */
	function clear_locales( $item ) {
		return trim( $item, ', ' );
	}

	/**
	 * Return cache is enabled setting
	 * How to use:
	 * $plugin  = WP_Locale_Switch_Plugin::get_instance();
	 * $bool = $plugin->settings->is_cache_enabled();
	 * @return boolean
	 */
	function is_cache_enabled() {
		return get_option( $this->wp_cache_support_field() ) === 'on';
	}

}