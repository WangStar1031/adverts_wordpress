<?php
/** ===============================================================================
  Plugin Name: Duplicator
  Plugin URI: https://snapcreek.com/duplicator/duplicator-free/
  Description: Migrate and backup a copy of your WordPress files and database. Duplicate and move a site from one location to another quickly.
  Version: 1.3.4
  Author: Snap Creek
  Author URI: http://www.snapcreek.com/duplicator/
  Text Domain: duplicator
  License: GPLv2 or later

  Copyright 2011-2017  SnapCreek LLC

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

  SOURCE CONTRIBUTORS:
  David Coveney of Interconnect IT Ltd
  https://github.com/interconnectit/Search-Replace-DB/
  ================================================================================ */

require_once("define.php");

if (!function_exists('sanitize_textarea_field')) {
    /**
     * Sanitizes a multiline string from user input or from the database.
     *
     * The function is like sanitize_text_field(), but preserves
     * new lines (\n) and other whitespace, which are legitimate
     * input in textarea elements.
     *
     * @see sanitize_text_field()
     *
     * @since 4.7.0
     *
     * @param string $str String to sanitize.
     * @return string Sanitized string.
     */
    function sanitize_textarea_field($str)
    {
        $filtered = _sanitize_text_fields($str, true);

        /**
         * Filters a sanitized textarea field string.
         *
         * @since 4.7.0
         *
         * @param string $filtered The sanitized string.
         * @param string $str      The string prior to being sanitized.
         */
        return apply_filters('sanitize_textarea_field', $filtered, $str);
    }
}

if (!function_exists('_sanitize_text_fields')) {
    /**
     * Internal helper function to sanitize a string from user input or from the db
     *
     * @since 4.7.0
     * @access private
     *
     * @param string $str String to sanitize.
     * @param bool $keep_newlines optional Whether to keep newlines. Default: false.
     * @return string Sanitized string.
     */
    function _sanitize_text_fields($str, $keep_newlines = false)
    {
        $filtered = wp_check_invalid_utf8($str);

        if (strpos($filtered, '<') !== false) {
            $filtered = wp_pre_kses_less_than($filtered);
            // This will strip extra whitespace for us.
            $filtered = wp_strip_all_tags($filtered, false);

            // Use html entities in a special case to make sure no later
            // newline stripping stage could lead to a functional tag
            $filtered = str_replace("<\n", "&lt;\n", $filtered);
        }

        if (! $keep_newlines) {
            $filtered = preg_replace('/[\r\n\t ]+/', ' ', $filtered);
        }
        $filtered = trim($filtered);

        $found = false;
        while (preg_match('/%[a-f0-9]{2}/i', $filtered, $match)) {
            $filtered = str_replace($match[0], '', $filtered);
            $found = true;
        }

        if ($found) {
            // Strip out the whitespace that may now exist after removing the octets.
            $filtered = trim(preg_replace('/ +/', ' ', $filtered));
        }

        return $filtered;
    }
}

if (!function_exists('wp_normalize_path')) {
    /**
     * Normalize a filesystem path.
     *
     * On windows systems, replaces backslashes with forward slashes
     * and forces upper-case drive letters.
     * Allows for two leading slashes for Windows network shares, but
     * ensures that all other duplicate slashes are reduced to a single.
     *
     * @since 3.9.0
     * @since 4.4.0 Ensures upper-case drive letters on Windows systems.
     * @since 4.5.0 Allows for Windows network shares.
     * @since 4.9.7 Allows for PHP file wrappers.
     *
     * @param string $path Path to normalize.
     * @return string Normalized path.
     */
    function wp_normalize_path( $path ) {
        $wrapper = '';
        if ( wp_is_stream( $path ) ) {
            list( $wrapper, $path ) = explode( '://', $path, 2 );
            $wrapper .= '://';
        }

        // Standardise all paths to use /
        $path = str_replace( '\\', '/', $path );

        // Replace multiple slashes down to a singular, allowing for network shares having two slashes.
        $path = preg_replace( '|(?<=.)/+|', '/', $path );

        // Windows paths should uppercase the drive letter
        if ( ':' === substr( $path, 1, 1 ) ) {
            $path = ucfirst( $path );
        }

        return $wrapper . $path;
    }
}

if (is_admin() == true) 
{
	//Classes
    require_once 'classes/class.settings.php';
    require_once 'classes/class.logging.php';    
    require_once 'classes/utilities/class.u.php';
	require_once 'classes/utilities/class.u.string.php';
    require_once 'classes/utilities/class.u.validator.php';
    require_once 'classes/class.db.php';
    require_once 'classes/class.server.php';
	require_once 'classes/ui/class.ui.viewstate.php';
	require_once 'classes/ui/class.ui.notice.php';
    require_once 'classes/package/class.pack.php';
	require_once 'views/packages/screen.php';
	 
    //Controllers
	require_once 'ctrls/ctrl.package.php';
	require_once 'ctrls/ctrl.tools.php';
	require_once 'ctrls/ctrl.ui.php';
    require_once 'ctrls/class.web.services.php';

	/** ========================================================
	 * ACTIVATE/DEACTIVE/UPDATE HOOKS
     * =====================================================  */
	register_activation_hook(__FILE__,   'duplicator_activate');
    register_deactivation_hook(__FILE__, 'duplicator_deactivate');
		
    /**
	 * Hooked into `register_activation_hook`.  Routines used to activate the plugin
     *
     * @access global
     * @return null
     */
    function duplicator_activate() 
	{
        global $wpdb;
		
        //Only update database on version update
        if (DUPLICATOR_VERSION != get_option("duplicator_version_plugin")) 
		{
            $table_name = $wpdb->prefix . "duplicator_packages";

            //PRIMARY KEY must have 2 spaces before for dbDelta to work
			//see: https://codex.wordpress.org/Creating_Tables_with_Plugins
            $sql = "CREATE TABLE `{$table_name}` (
			   id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			   name VARCHAR(250) NOT NULL,
			   hash VARCHAR(50) NOT NULL,
			   status INT(11) NOT NULL,
			   created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
			   owner VARCHAR(60) NOT NULL,
			   package MEDIUMBLOB NOT NULL,
			   PRIMARY KEY  (id),
			   KEY hash (hash))";

            require_once(DUPLICATOR_WPROOTPATH . 'wp-admin/includes/upgrade.php');
            @dbDelta($sql);
        }

        //WordPress Options Hooks
        update_option('duplicator_version_plugin', DUPLICATOR_VERSION);

        //Setup All Directories
        DUP_Util::initSnapshotDirectory();
    }

    /**
	 * Hooked into `plugins_loaded`.  Routines used to update the plugin
     *
     * @access global
     * @return null
     */
    function duplicator_update() 
	{
        if (DUPLICATOR_VERSION != get_option("duplicator_version_plugin")) {
            duplicator_activate();
        }
		load_plugin_textdomain( 'duplicator' );
    }

	/**
	 * Hooked into `register_deactivation_hook`.  Routines used to deactivate the plugin
	 * For uninstall see uninstall.php  WordPress by default will call the uninstall.php file
     *
     * @access global
     * @return null
     */
    function duplicator_deactivate() 
	{
        //Logic has been added to uninstall.php
    }

	/** ========================================================
	 * ACTION HOOKS
     * =====================================================  */
    add_action('plugins_loaded',	'duplicator_update');
    add_action('plugins_loaded',	'duplicator_wpfront_integrate');
    add_action('admin_init',		'duplicator_init');
    add_action('admin_menu',		'duplicator_menu');
    add_action('admin_enqueue_scripts', 'duplicator_admin_enqueue_scripts' );
	add_action('admin_notices',		array('DUP_UI_Notice', 'showReservedFilesNotice'));
	
	//CTRL ACTIONS
    DUP_Web_Services::init();
    add_action('wp_ajax_duplicator_active_package_info',        'duplicator_active_package_info');
    add_action('wp_ajax_duplicator_package_scan',				'duplicator_package_scan');
    add_action('wp_ajax_duplicator_package_build',				'duplicator_package_build');
    add_action('wp_ajax_duplicator_package_delete',				'duplicator_package_delete');
    add_action('wp_ajax_duplicator_duparchive_package_build',	'duplicator_duparchive_package_build');
    add_action('wp_ajax_nopriv_duplicator_duparchive_package_build',	'duplicator_duparchive_package_build');


	$GLOBALS['CTRLS_DUP_CTRL_UI']		= new DUP_CTRL_UI();
	$GLOBALS['CTRLS_DUP_CTRL_Tools']	= new DUP_CTRL_Tools();
	$GLOBALS['CTRLS_DUP_CTRL_Package']	= new DUP_CTRL_Package();
	
	/**
	 * User role editor integration 
     *
     * @access global
     * @return null
     */
    function duplicator_wpfront_integrate()
	{
        if (DUP_Settings::Get('wpfront_integrate')) {
            do_action('wpfront_user_role_editor_duplicator_init', array('export', 'manage_options', 'read'));
        }
    }
	
	/**
	 * Hooked into `admin_init`.  Init routines for all admin pages 
     *
     * @access global
     * @return null
     */
    function duplicator_init()
	{
        /* CSS */
        wp_register_style('dup-jquery-ui', DUPLICATOR_PLUGIN_URL . 'assets/css/jquery-ui.css', null, "1.11.2");
        wp_register_style('dup-font-awesome', DUPLICATOR_PLUGIN_URL . 'assets/css/font-awesome.min.css', null, '4.7.0');
        wp_register_style('dup-plugin-global-style', DUPLICATOR_PLUGIN_URL . 'assets/css/global_admin_style.css', null , DUPLICATOR_VERSION);
        wp_register_style('dup-plugin-style', DUPLICATOR_PLUGIN_URL . 'assets/css/style.css', array('dup-plugin-global-style') , DUPLICATOR_VERSION);

		wp_register_style('dup-jquery-qtip',DUPLICATOR_PLUGIN_URL . 'assets/js/jquery.qtip/jquery.qtip.min.css', null, '2.2.1');
		wp_register_style('dup-parsley-style', DUPLICATOR_PLUGIN_URL . 'assets/css/parsley.css', null, '2.3.5');
        /* JS */
		wp_register_script('dup-handlebars', DUPLICATOR_PLUGIN_URL . 'assets/js/handlebars.min.js', array('jquery'), '4.0.10');
        wp_register_script('dup-parsley', DUPLICATOR_PLUGIN_URL . 'assets/js/parsley.min.js', array('jquery'), '1.1.18');
		wp_register_script('dup-jquery-qtip', DUPLICATOR_PLUGIN_URL . 'assets/js/jquery.qtip/jquery.qtip.min.js', array('jquery'), '2.2.1');


        // Clean tmp folder
        DUP_Package::not_active_files_tmp_cleanup();
    }

    /**
	 * Hooked into `admin_enqueue_scripts`.  Init routines for all admin pages
     *
     * @access global
     * @return null
     */
    function duplicator_admin_enqueue_scripts() {
        wp_enqueue_style('dup-plugin-global-style');
    }
	
	/**
	 * Redirects the clicked menu item to the correct location
     *
     * @access global
     * @return null
     */
    function duplicator_get_menu() 
	{
        $current_page = isset($_REQUEST['page']) ? sanitize_text_field($_REQUEST['page']) : 'duplicator';
        switch ($current_page) 
		{
            case 'duplicator':			include('views/packages/controller.php');	break;
            case 'duplicator-settings': include('views/settings/controller.php');	break;
            case 'duplicator-tools':	include('views/tools/controller.php');      break;
			case 'duplicator-debug':	include('debug/main.php');					break;
			case 'duplicator-gopro':	include('views/settings/gopro.php');			break;
        }
    }

	/**
	 * Hooked into `admin_menu`.  Loads all of the wp left nav admin menus for Duplicator
     *
     * @access global
     * @return null
     */
    function duplicator_menu() 
	{
        $wpfront_caps_translator = 'wpfront_user_role_editor_duplicator_translate_capability';
		$icon_svg = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iQXJ0d29yayIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiIHdpZHRoPSIyMy4yNXB4IiBoZWlnaHQ9IjIyLjM3NXB4IiB2aWV3Qm94PSIwIDAgMjMuMjUgMjIuMzc1IiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCAyMy4yNSAyMi4zNzUiIHhtbDpzcGFjZT0icHJlc2VydmUiPjxwYXRoIGZpbGw9IiM5Q0ExQTYiIGQ9Ik0xOC4wMTEsMS4xODhjLTEuOTk1LDAtMy42MTUsMS42MTgtMy42MTUsMy42MTRjMCwwLjA4NSwwLjAwOCwwLjE2NywwLjAxNiwwLjI1TDcuNzMzLDguMTg0QzcuMDg0LDcuNTY1LDYuMjA4LDcuMTgyLDUuMjQsNy4xODJjLTEuOTk2LDAtMy42MTUsMS42MTktMy42MTUsMy42MTRjMCwxLjk5NiwxLjYxOSwzLjYxMywzLjYxNSwzLjYxM2MwLjYyOSwwLDEuMjIyLTAuMTYyLDEuNzM3LTAuNDQ1bDIuODksMi40MzhjLTAuMTI2LDAuMzY4LTAuMTk4LDAuNzYzLTAuMTk4LDEuMTczYzAsMS45OTUsMS42MTgsMy42MTMsMy42MTQsMy42MTNjMS45OTUsMCwzLjYxNS0xLjYxOCwzLjYxNS0zLjYxM2MwLTEuOTk3LTEuNjItMy42MTQtMy42MTUtMy42MTRjLTAuNjMsMC0xLjIyMiwwLjE2Mi0xLjczNywwLjQ0M2wtMi44OS0yLjQzNWMwLjEyNi0wLjM2OCwwLjE5OC0wLjc2MywwLjE5OC0xLjE3M2MwLTAuMDg0LTAuMDA4LTAuMTY2LTAuMDEzLTAuMjVsNi42NzYtMy4xMzNjMC42NDgsMC42MTksMS41MjUsMS4wMDIsMi40OTUsMS4wMDJjMS45OTQsMCwzLjYxMy0xLjYxNywzLjYxMy0zLjYxM0MyMS42MjUsMi44MDYsMjAuMDA2LDEuMTg4LDE4LjAxMSwxLjE4OHoiLz48L3N2Zz4=';
        
		//Main Menu
        $perms = 'export';
        $perms = apply_filters($wpfront_caps_translator, $perms);
        $main_menu = add_menu_page('Duplicator Plugin', 'Duplicator', $perms, 'duplicator', 'duplicator_get_menu', $icon_svg);
        $perms = 'export';
        $perms = apply_filters($wpfront_caps_translator, $perms);
		$lang_txt = esc_html__('Packages', 'duplicator');
        $page_packages = add_submenu_page('duplicator', $lang_txt, $lang_txt, $perms, 'duplicator', 'duplicator_get_menu');
		$GLOBALS['DUP_PRO_Package_Screen'] = new DUP_Package_Screen($page_packages);

		$perms = 'manage_options';
        $perms = apply_filters($wpfront_caps_translator, $perms);
		$lang_txt = esc_html__('Tools', 'duplicator');
        $page_tools = add_submenu_page('duplicator', $lang_txt, $lang_txt, $perms, 'duplicator-tools', 'duplicator_get_menu');

        $perms = 'manage_options';
        $perms = apply_filters($wpfront_caps_translator, $perms);
		$lang_txt = esc_html__('Settings', 'duplicator');
        $page_settings = add_submenu_page('duplicator', $lang_txt, $lang_txt, $perms, 'duplicator-settings', 'duplicator_get_menu');

		$perms = 'manage_options';
		$lang_txt = esc_html__('Go Pro!', 'duplicator');
		$go_pro_link = '<span style="color:#f18500">' . $lang_txt . '</span>';
        $perms = apply_filters($wpfront_caps_translator, $perms);
        $page_gopro = add_submenu_page('duplicator', $go_pro_link, $go_pro_link, $perms, 'duplicator-gopro', 'duplicator_get_menu');

        //Apply Scripts
        add_action('admin_print_scripts-' . $page_packages, 'duplicator_scripts');
        add_action('admin_print_scripts-' . $page_settings, 'duplicator_scripts');
        add_action('admin_print_scripts-' . $page_tools, 'duplicator_scripts');
		add_action('admin_print_scripts-' . $page_gopro, 'duplicator_scripts');
		
        //Apply Styles
        add_action('admin_print_styles-' . $page_packages, 'duplicator_styles');
        add_action('admin_print_styles-' . $page_settings, 'duplicator_styles');
        add_action('admin_print_styles-' . $page_tools, 'duplicator_styles');
		add_action('admin_print_styles-' . $page_gopro, 'duplicator_styles');
    }

    /**
	 * Loads all required javascript libs/source for DupPro
     *
     * @access global
     * @return null
     */
    function duplicator_scripts() 
	{
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-progressbar');
        wp_enqueue_script('dup-parsley');
		wp_enqueue_script('dup-jquery-qtip');
		
    }

    /**
	 * Loads all CSS style libs/source for DupPro
     *
     * @access global
     * @return null
     */
    function duplicator_styles() 
	{
        wp_enqueue_style('dup-jquery-ui');
        wp_enqueue_style('dup-font-awesome');
		wp_enqueue_style('dup-plugin-style');
		wp_enqueue_style('dup-jquery-qtip');
    }


	/** ========================================================
	 * FILTERS
     * =====================================================  */
	add_filter('plugin_action_links', 'duplicator_manage_link', 10, 2);
    add_filter('plugin_row_meta', 'duplicator_meta_links', 10, 2);
	
	/**
	 * Adds the manage link in the plugins list 
     *
     * @access global
     * @return string The manage link in the plugins list 
     */	
    function duplicator_manage_link($links, $file) 
	{
        static $this_plugin;
        if (!$this_plugin)
            $this_plugin = plugin_basename(__FILE__);

        if ($file == $this_plugin) {
            $settings_link = '<a href="admin.php?page=duplicator">' . esc_html__("Manage", 'duplicator') . '</a>';
            array_unshift($links, $settings_link);
        }
        return $links;
    }
	
	/**
	 * Adds links to the plugins manager page
     *
     * @access global
     * @return string The meta help link data for the plugins manager
     */
    function duplicator_meta_links($links, $file) 
	{
        $plugin = plugin_basename(__FILE__);
        // create link
        if ($file == $plugin) {
            $links[] = '<a href="admin.php?page=duplicator-gopro" title="' . esc_attr__('Get Help', 'duplicator') . '" style="">' . esc_html__('Go Pro', 'duplicator') . '</a>';
            return $links;
        }
        return $links;
    }

	/** ========================================================
	 * GENERAL
     * =====================================================  */
	/**
	 * Used for installer files to redirect if accessed directly
     *
     * @access global
     * @return null
     */
    function duplicator_secure_check()
	{
		$baseURL = "http://" . strlen($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST'];
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $baseURL");
		exit;
    }

}
?>
