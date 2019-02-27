<?php
/**
 * Plugin Name: User Wallet Credit System
 * Plugin URI: https://dash10.digital
 * Version: 3.0.13
 * Description: Gives the ability for users to load their wallet balance using WooCommerce. The wallet balance can then be used (if enabled) to make purchases.
 * Author: Dash10 Digital
 * Author URI: https://dash10.digital
 * License: GPL2
 *
 * WC requires at least: 3.0.0
 * WC tested up to: 3.2.0
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 *
 * @author  Justin Greer <justin@justin-greer.com>
 * @package User Wallet
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( ! defined( 'WPUW_FILE' ) ) {
	define( 'WPUW_FILE', __FILE__ );
}

function uwcs_action_links( $actions, $user_object ) {

	// This is not displayed to users that can not manage the wallet.
	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		return $actions;
	}

	$actions['edit_wallet'] = "<a class='uwcs_edit_wallet' href='" . admin_url( "admin.php?page=wpvw_edit_wallet&amp;ID=$user_object->ID" ) . "'>" . __( 'Edit Wallet', 'cgc_ub' ) . "</a>";

	return $actions;
}

add_filter( 'user_row_actions', 'uwcs_action_links', 10, 2 );

require_once( dirname( __FILE__ ) . '/user-wallet-main.php' );

require_once( dirname( __FILE__ ) . '/includes/widget.php' );