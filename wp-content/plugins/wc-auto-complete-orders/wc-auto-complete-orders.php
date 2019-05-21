<?php
   /*
   Plugin Name: WC Auto Complete Orders
   Plugin URI: http://justingoff.me/projects/wc-auto-complete-orders-wordpress-plugin/
   Description: A plugin that enables auto-complete on all WooCommerce orders
   Version: 1.0
   Author: tehg33k
   Author URI: http://justingoff.me
   License: GPL2
   */
   
add_action( 'woocommerce_thankyou', 'custom_woocommerce_auto_complete_order' );
function custom_woocommerce_auto_complete_order( $order_id ) {
    if ( ! $order_id ) {
        return;
    }

    $order = wc_get_order( $order_id );
    $order->update_status( 'completed' );
}
?>
