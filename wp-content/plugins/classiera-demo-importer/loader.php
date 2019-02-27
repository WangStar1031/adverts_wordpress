<?php

// Replace {$redux_opt_name} with your opt_name.
// Also be sure to change this function name!

if(!function_exists('classiera_register_custom_extension_loader')) :
    function classiera_register_custom_extension_loader($ReduxFramework) {
        $path    = dirname( __FILE__ ) . '/extensions/';
            $folders = scandir( $path, 1 );
            foreach ( $folders as $folder ) {
                if ( $folder === '.' or $folder === '..' or ! is_dir( $path . $folder ) ) {
                    continue;
                }
                $extension_class = 'ReduxFramework_Extension_' . $folder;
                if ( ! class_exists( $extension_class ) ) {
                    // In case you wanted override your override, hah.
                    $class_file = $path . $folder . '/extension_' . $folder . '.php';
                    $class_file = apply_filters( 'redux/extension/' . $ReduxFramework->args['opt_name'] . '/' . $folder, $class_file );
                    if ( $class_file ) {
                        require_once( $class_file );
                    }
                }
                if ( ! isset( $ReduxFramework->extensions[ $folder ] ) ) {
                    $ReduxFramework->extensions[ $folder ] = new $extension_class( $ReduxFramework );
                }
            }
    }
    // Modify {$redux_opt_name} to match your opt_name
    add_action("redux/extensions/redux_demo/before", 'classiera_register_custom_extension_loader', 0);
endif;
if ( !function_exists( 'classiera_importer_desc' ) ) {
	function classiera_importer_desc( $description ) {
		$message = '<h4>For Fresh Installation: Just Click on Import Demo button and wait.</h4>';
		$message .= '<h4>Change Demo: If you have already import our demo and you want to change demo. Then You need to follow these steps.</h4>';
		$message .= '<ul><li><strong>Method 1:</strong> Just Find dummy content folder in your downloads and just import theme options file using import/export option from classiera options and your demo will be changes. If some images are missing then import media file from dummy content -> demo -> single folder.</li><li><strong>Method 2:</strong> But if you want to import from here then you must need to delete old content including (<strong>Posts, Pages, Menu, Widgets</strong>)</li></ul>';
		$message .='<h4>Note: After to setup your demo please go to Plugins menu and deactivate classiera demo importer plugin.</h4>';
		return $message;
	}
	add_filter( 'wbc_importer_description', 'classiera_importer_desc', 10 );
}
//Demo Setup//
if ( !function_exists( 'classiera_demo_setup_content' ) ) {
	function classiera_demo_setup_content( $demo_active_import , $demo_directory_path ) {

		reset( $demo_active_import );
		$current_key = key( $demo_active_import );
		
		$wbc_menu_array = array( 'lime', 'strobe', 'coral', 'canary', 'ivy', 'iris' , 'allure', 'ruby', 'jade', 'onyx', 'pearl', 'lilac', 'opal', 'arabic');

		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && in_array( $demo_active_import[$current_key]['directory'], $wbc_menu_array ) ) {
			$primary = get_term_by( 'name', 'Main Menu', 'nav_menu' );
			$footer = get_term_by( 'name', 'Footer Menu', 'nav_menu' );
			
			set_theme_mod( 'nav_menu_locations', array(
					'primary' => $primary->term_id,
					'mobile'  => $primary->term_id,
					'footer' => $footer->term_id,
				)
			);
		}

		$wbc_home_pages = array(
			'lime' => 'Home',
			'strobe' => 'Home',
			'coral' => 'Home',
			'canary' => 'Home',
			'ivy' => 'Home',
			'iris' => 'Home',
			'allure' => 'Home',
			'ruby' => 'Home',
			'jade' => 'Home',
			'onyx' => 'Home',
			'pearl' => 'Home',
			'lilac' => 'Home',
			'opal' => 'Home',
			'arabic' => 'Home',
		);

		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
			$page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
			if ( isset( $page->ID ) ) {
				update_option( 'page_on_front', $page->ID );
				update_option( 'show_on_front', 'page' );
			}
		}

	}
	add_action( 'wbc_importer_after_content_import', 'classiera_demo_setup_content', 10, 2 );
}