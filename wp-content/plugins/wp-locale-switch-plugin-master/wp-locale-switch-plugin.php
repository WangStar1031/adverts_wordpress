<?php
/**
 * Plugin name: WP Locale Switch Plugin
 * Description: Provides a widget for users to switch locale on the frontend and shortcode [wp_locale_switch]
 * Author: freelancevip.pro
 * Author URI: https://freelancevip.pro/
 */

defined( 'ABSPATH' ) || exit();

require_once 'wp-locale-switch-plugin-widget.php';
require_once 'wp-locale-switch-plugin-settings.php';

WP_Locale_Switch_Plugin::get_instance();

/**
 * Class WP_Locale_Switch_Plugin
 */
class WP_Locale_Switch_Plugin {
	const NONCE = 'wlsp-nonce';
	const LANG_KEY = 'lang';
	private static $instance = null;
	private $plugin_page_title;
	private $plugin_menu_title;
	private $plugin_slug;
	/**
	 * @var WP_Locale_Switch_Plugin_Settings
	 */
	public $settings;

	/**
	 * WP_Locale_Switch_Plugin constructor.
	 */
	function __construct() {

		$this->plugin_page_title = 'Locale switch plugin';
		$this->plugin_menu_title = 'Locale switch';
		$this->plugin_slug       = 'wp-locale-switch-plugin';

		$this->settings = new WP_Locale_Switch_Plugin_Settings();

		add_filter( 'locale', array( $this, 'set_locale' ) );
		add_action( 'widgets_init', array( $this, 'register_widget' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_action( 'wp_ajax_wlsp_set_locale', array( $this, 'ajax_set_locale' ) );
		add_action( 'wp_ajax_nopriv_wlsp_set_locale', array( $this, 'ajax_set_locale' ) );

		add_shortcode( 'wp_locale_switch', array( $this, 'shortcode' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
	}

	/**
	 * @return null|WP_Locale_Switch_Plugin
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Shortcode callback
	 * @return string
	 */
	function shortcode() {
		return WP_Locale_Switch_Plugin_Widget::get_selectbox();
	}

	/**
	 * Ajax set lang cookie
	 */
	function ajax_set_locale() {
		check_ajax_referer( self::NONCE, 'nonce' );
		if ( ! wp_verify_nonce( $_REQUEST['nonce'], self::NONCE ) ) {
			exit();
		}
		$expire  = time() + 86400 * 30;
		$lang    = isset( $_REQUEST[ self::LANG_KEY ] ) ? $_REQUEST[ self::LANG_KEY ] : 'en';
		$locales = $this->settings->get_locales_array();
		if ( ! in_array( $lang, $locales ) ) {
			$lang = isset( $locales[0] ) ? $locales[0] : 'en';
		}
		setcookie( self::LANG_KEY, $lang, $expire, '/' );
		$current_url = strtok( $_REQUEST['uri'], '?' );
		$url         = $current_url . '?' . self::LANG_KEY . '=' . $lang;
		wp_die( $url );
	}

	/**
	 * @param $lang
	 *
	 * @return bool|string
	 */
	function set_locale($lang) {
		if ( ! is_admin() ) {
			$locale = $this->_get_locale();

			return $locale;
		}

		return $lang;
	}

	/**
	 * Register widget
	 */
	function register_widget() {
		register_widget( 'WP_Locale_Switch_Plugin_Widget' );
	}

	/**
	 * Add admin menu
	 */
	function admin_menu() {
		add_plugins_page( $this->plugin_page_title,
			$this->plugin_menu_title,
			'manage_options',
			$this->plugin_slug,
			array( $this, 'admin_page' ) );
	}

	/**
	 * Plugins page
	 */
	function admin_page() {
		require_once 'admin-page.php';
	}

	/**
	 * Plugins js script
	 */
	function scripts() {
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'wlsp-script', plugins_url( '/js/script.js', __FILE__ ), 'jquery' );
		wp_localize_script( 'wlsp-script', 'wlspOptions', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( self::NONCE ),
			'langKey' => self::LANG_KEY
		) );
		wp_enqueue_script( 'wlsp-script' );
	}

	/**
	 * @return bool|string
	 */
	private function _get_locale() {
		return self::get_saved();
	}

	/**
	 * @return bool|string
	 */
	public static function get_saved() {
		$from_headers = substr( $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2 );
		$from_cookies = isset( $_COOKIE[ self::LANG_KEY ] ) ? $_COOKIE[ self::LANG_KEY ] : false;
		$from_request = isset( $_GET[ self::LANG_KEY ] ) ? $_GET[ self::LANG_KEY ] : false;
		if ( $from_request ) {
			return $from_request;
		}
		if ( $from_cookies ) {
			return $from_cookies;
		}

		return $from_headers;
	}
}