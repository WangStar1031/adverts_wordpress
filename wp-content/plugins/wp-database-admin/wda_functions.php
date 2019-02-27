<?php
/**
 * @package wp_db_admin
 */

/**
 *	Plugin Name: Wordpress Database Administrator
 *	Plugin URI: http://about.me/dmparekh
 *	Description: Wordpress Database Administrator plugin for Wordpress Database Access. Simple but Powerfull.
 *	Version: 1.0.3
 *	Author: Dhaval Parekh
 *	Author URI: http://about.me/dmparekh
 *	License: GPLv2 or later
 *	Text Domain: wp_db_admin
 */

define('WDA_URL',plugin_dir_url( __FILE__ ));
define('WDA_PATH',plugin_dir_path( __FILE__ ));
$pageName= 'wpdbadmin'; // name of page in admin panal
require_once('class.wda_db_access.php');
// Library
require_once('wda_lib.php');

$URL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?page='.$pageName.'';

// Database Acccess

$wdaDbObj= new wdaDatabaseAccess(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME); // Get Constant form wordpress config.php
//$URL = wda_TruncQueryString('action',$URL);
//$URL = wda_TruncQueryString('tbl',$URL);

// Query String Manage
$QueryStringStart='?';
if( count($_GET)==0 ){
	$QueryStringStart='?';
}else{
	$QueryStringStart="&";	
}

/**
 *	Link stylesheet and javascript for Plugins
 */
function wda_attech_scripts(){
	global $pageName;
	
	if(isset($_GET['page']) && $_GET['page']==$pageName): // Checking for IS page is 'wpdbadmin'
		//wp_enqueue_script( 'jquery-1.11.1',WDA_URL.'js/jquery-1.11.1.js',array(), '1.11.1', true);
		wp_enqueue_script('jquery');
		
		//wp_register_script( 'jquery-ui',WDA_URL.'js/jquery-ui.js',array('jquery'));
		//wp_enqueue_script( 'jquery-ui-core');
		wp_enqueue_script( 'jquery-ui-draggable');
		wp_enqueue_script( 'jquery-ui-droppable');
		
		wp_register_script( 'wda_jquery',WDA_URL.'js/wda_jquery.js',array('jquery'));
		wp_enqueue_script( 'wda_jquery');
		
		wp_enqueue_style('wda_style', WDA_URL.'css/wda_style.css',array(), '1.0','screen');
		
		wp_enqueue_style('font-awesome',WDA_URL.'font-awesome-4.2.0/css/font-awesome.css',array(), '4.2.0','screen');
	endif;
}
add_action( 'init', 'wda_attech_scripts' );
/**
 *	Set up menu in admin panal in settings
 */
function wda_main(){
	require_once('wda_ui.php');
}
add_action('admin_menu','wda_page_setup');
function wda_page_setup(){
	global $pageName;
	add_management_page('Database Admin','DB Admin','manage_options',$pageName,'wda_main');
	//add_management_page( $page_title, $menu_title, $capability, $menu_slug, $function);
} 
?>