<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
$apss_share_settings = array();
$share_options = array();
if ( isset( $_POST[ 'apss_share_settings' ][ 'share_options' ] ) ) {
    foreach ( $_POST[ 'apss_share_settings' ][ 'share_options' ] as $key => $value ) {
        $share_options[] = $value;
    }
}

$apss_share_settings[ 'share_options' ] = $share_options;
$apss_share_settings[ 'social_icon_set' ] = $_POST[ 'apss_share_settings' ][ 'social_icon_set' ];
$apss_share_settings[ 'share_positions' ] = $_POST[ 'apss_share_settings' ][ 'social_share_position_options' ];

$apss_social_newtwork_order = explode( ',', $_POST[ 'apss_social_newtwork_order' ] );
$social_network_array = array();
foreach ( $apss_social_newtwork_order as $social_network ) {
    $social_network_array[ $social_network ] = (isset( $_POST[ 'social_networks' ][ $social_network ] )) ? 1 : 0;
}

$apss_share_settings[ 'social_networks' ] = $social_network_array;
$apss_share_settings[ 'disable_frontend_assets' ] = isset( $_POST[ 'apss_share_settings' ][ 'disable_frontend_assets' ] ) ? $_POST[ 'apss_share_settings' ][ 'disable_frontend_assets' ] : '0';
$apss_share_settings[ 'share_text' ] = stripslashes_deep( $_POST[ 'apss_share_settings' ][ 'share_text' ] );
$apss_share_settings[ 'twitter_username' ] = stripslashes_deep( $_POST[ 'apss_share_settings' ][ 'twitter_username' ] );
$apss_share_settings[ 'counter_enable_options' ] = $_POST[ 'apss_share_settings' ][ 'counter_enable_options' ];
$apss_share_settings[ 'twitter_counter_api' ] = $_POST[ 'apss_share_settings' ][ 'twitter_counter_api' ];

$fb_app_id = isset( $_POST[ 'apss_share_settings' ][ 'api_configuration' ][ 'facebook' ][ 'app_id' ] ) ? $_POST[ 'apss_share_settings' ][ 'api_configuration' ][ 'facebook' ][ 'app_id' ] : '';
$fb_app_secret = isset( $_POST[ 'apss_share_settings' ][ 'api_configuration' ][ 'facebook' ][ 'app_secret' ] ) ? $_POST[ 'apss_share_settings' ][ 'api_configuration' ][ 'facebook' ][ 'app_secret' ] : '';
$apss_share_settings[ 'api_configuration' ][ 'facebook' ] = array(
    'app_id' => stripslashes_deep( $fb_app_id ),
    'app_secret' => stripslashes_deep( $fb_app_secret )
);

$apss_share_settings[ 'total_counter_enable_options' ] = $_POST[ 'apss_share_settings' ][ 'total_counter_enable_options' ];
$apss_share_settings[ 'enable_http_count' ] = $_POST[ 'apss_share_settings' ][ 'enable_http_count' ];
$apss_share_settings[ 'enable_cache' ] = $_POST[ 'apss_share_settings' ][ 'enable_cache' ];
$apss_share_settings[ 'cache_period' ] = is_numeric( $_POST[ 'apss_share_settings' ][ 'cache_settings' ] ) ? $_POST[ 'apss_share_settings' ][ 'cache_settings' ] : '24';
$apss_share_settings[ 'dialog_box_options' ] = $_POST[ 'apss_share_settings' ][ 'dialog_box_options' ];
// $apss_share_settings['footer_javascript']				= $_POST['apss_share_settings']['footer_javascript'];
$apss_share_settings[ 'apss_email_subject' ] = stripslashes_deep( $_POST[ 'apss_share_settings' ][ 'apss_email_subject' ] );
$apss_share_settings[ 'apss_email_body' ] = stripslashes_deep( $_POST[ 'apss_share_settings' ][ 'apss_email_body' ] );
if ( ! isset( $apss_share_settings[ 'apss_social_counts_transients' ] ) ) {
    $apss_share_settings[ 'apss_social_counts_transients' ] = array();
}

// The option already exists, so we just update it.
$status = update_option( APSS_SETTING_NAME, $apss_share_settings );
if ( $status == TRUE ) {
    wp_redirect( admin_url() . 'admin.php?page=accesspress-social-share&message=1' );
} else {
    wp_redirect( admin_url() . 'admin.php?page=accesspress-social-share&message=2' );
}
exit;

