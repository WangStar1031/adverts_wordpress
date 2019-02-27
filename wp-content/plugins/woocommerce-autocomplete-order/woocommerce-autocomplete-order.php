<?php
/**
	Plugin Name: WooCommerce - Autocomplete Orders
	Plugin URI: http://www.seriousplugins.com/woocommerce-autocomplete-orders/
	Description: Would you buy twice from a website that does not give you instanctly access to the product you purchased? Why would you want that for your customer? Take back the ownership of your ecommerce!
	Version: 1.1.4
	Author: Serious Plugins
	Author URI: http://www.seriousplugins.com	
		
		Copyright: (c)2016 Serious Plugins (email : social@seriousplugins.com)	
		License: GNU General Public License v3.0	
		LspRegisterPluginLinksicense URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * sp_register_plugin_links 
 *
 * Direct link to the settings page from the plugin page
 * * @param	array	$links
 * @param	string	$file
 * @author	Mirko Grewing <mirko.grewing@me.com>
 * @since	0.1
 *
 * @return	array
 */
function sp_register_plugin_links($links, $file)
{
	$base = plugin_basename(__FILE__);
	if ($file == $base) {
		$links[] = '<a href="admin.php?page=wc-settings&tab=sp_woo_eo">' . __('Settings','wooExtraOptions') . '</a>';
		$links[] = '<a href="http://www.seriousplugins.com/woocommerce-autocomplete-orders/faqs/">' . __('FAQ','wooExtraOptions') . '</a>';
		$links[] = '<a href="http://www.seriousplugins.com/woocommerce-autocomplete-orders/support/">' . __('Support','wooExtraOptions') . '</a>';
	}
	return $links;
}
add_filter('plugin_row_meta',  'sp_register_plugin_links', 10, 2);

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    load_plugin_textdomain('wooExtraOptions', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    if (!class_exists('SP_Woo_Extra_Options')) {
        /**
         * Main Loader Class
         * Used to extend WooCommerce settings.
         *
         * @category  Class
         * @package   Woocommerce_Autocomplete_Order
         * @author    Mirko Grewing <mirko.grewing@me.com>
         * @copyright 2012-2016 Mirko Grewing
         * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
         * @version   1.1.1
         * @link      http://www.seriousplugins.com
         * @since     Class available since Release 0.1
         *
         */
        class SP_Woo_Extra_Options
        {
            /**
             * $id 
             * holds settings tab id
             * @var string
             */
            public $id = 'sp_woo_eo';
            
            /**
             * __construct
             * class constructor will set the needed filter and action hooks
             */
            function __construct()
            {
				if (is_admin()) {
					//add settings tab
					add_filter('woocommerce_settings_tabs_array', array($this,'sp_woocommerce_settings_tabs_array'), 50);
					//show settings tab
					add_action('woocommerce_settings_tabs_'.$this->id, array($this,'sp_show_settings_tab'));
					//save settings tab 
					add_action('woocommerce_update_options_'.$this->id, array($this,'sp_update_settings_tab'));
					//add tabs select field
					add_action('woocommerce_admin_field_'.$this->id,array($this, 'show_'.$this->id.'_field'), 10);
					//save tabs select field
					add_action('woocommerce_update_option_'.$this->id,array($this, 'save_'.$this->id.'_field'), 10);
				}
                add_action('init', array($this,'sp_autocomplete_orders'), 0);
				
			}
			
			/**
			 * sp_woocommerce_settings_tabs_array
			 *
			 * Adds a WooCommerce settings tab
			 *
			 * @param	array	$settings_tabs
			 * @author	Mirko Grewing <mirko.grewing@me.com>
			 * @since	0.1
			 *
			 * @return 	array
			 */
			function sp_woocommerce_settings_tabs_array($settings_tabs)
			{
				$settings_tabs[$this->id] = __('Extra Options','wooExtraOptions');
				return $settings_tabs;
			}

			/**
			 * sp_show_settings_tab
			 *
			 * Displays WooCommerce settings tab content
			 *
			 * @author	Mirko Grewing <mirko.grewing@me.com>
			 * @since	0.1
			 *
			 * @return	null
			 */
			function sp_show_settings_tab()
			{
				woocommerce_admin_fields($this->sp_get_settings());
			}

			/**
			 * sp_update_settings_tab
			 *
			 * Saves WooCommerce settings tab values
			 *
			 * @author	Mirko Grewing <mirko.grewing@me.com>
			 * @since	0.1
			 *
			 * @return	null
			 */
			function sp_update_settings_tab()
			{
				woocommerce_update_options($this->sp_get_settings());
			}

			/**
			 * sp_get_settings
			 *
			 * Defines WooCommerce settings tab fields
			 *
			 * @author	Mirko Grewing <mirko.grewing@me.com>
			 * @since	0.1
			 *
			 * @return	string
			 */
			function sp_get_settings()
			{
				$settings = array(
					'section_title' => array(
						'name'     => __('Autocomplete Orders','wooExtraOptions'),
						'type'     => 'title',
						'desc'     => 'Activate the plugin selecting one option from the menu',
						'id'       => 'wc_'.$this->id.'_section_title'
					),
					'title' => array(
						'name'     => __('Mode', 'wooExtraOptions'),
						'type'     => 'select',
						'desc'     => __('Specify how you want the plugin to work.', 'wooExtraOptions'),
						'desc_tip' => true,
						'default'  => 'off',
						'id'       => 'wc_'.$this->id.'_mode',
						'options' => array(
							'off'     => 'Off',
							'virtual' => 'Paid orders of virtual products only',
							'paid'    => 'All paid orders of any product',
							'all'     => 'Any order (!!!)'
						)
					),
					'section_end' => array(
						'type' => 'sectionend',
						'id'   => 'wc_'.$this->id.'_section_end'
					)
				);
				return apply_filters('wc_'.$this->id.'_settings', $settings);
			}

			/**
			 * sp_autocomplete_orders 
			 *
			 * Autocomplete Orders
			 *
			 * @author	Mirko Grewing <mirko.grewing@me.com>
			 * @since	0.1
			 *
			 * @return	string
			 */
			function sp_autocomplete_orders()
			{
				$mode = get_option('wc_'.$this->id.'_mode');
				if ($mode == 'all') {
					add_action('woocommerce_thankyou', 'sp_autocomplete_all_orders');
					/**
					 * sp_autocomplete_all_orders 
					 *
					 * Register custom tabs Post Type
					 *
					 * @param	int	$order_id
					 * @author	Mirko Grewing <mirko.grewing@me.com>
					 * @since	0.1
					 *
					 * @return	null
					 */
					function sp_autocomplete_all_orders($order_id)
					{
						global $woocommerce;

						if (!$order_id)
							return;
						$order = new WC_Order($order_id);
						$order->update_status('completed');
					}
				} elseif ($mode == 'paid') {
					add_filter('woocommerce_payment_complete_order_status', 'sp_autocomplete_paid_orders', 10, 2);
					/**
					 * sp_autocomplete_paid_orders 
					 *
					 * Register custom tabs Post Type
					 *
					 * @param	string	$order_status
					 * @param	int		$order_id
					 * @author	Mirko Grewing <mirko.grewing@me.com>
					 * @since	0.1
					 *
					 * @return	string
					 */
					function sp_autocomplete_paid_orders($order_status, $order_id)
					{
						$order = new WC_Order($order_id);
						if ($order_status == 'processing' && ($order->status == 'on-hold' || $order->status == 'pending' || $order->status == 'failed')) {
							return 'completed';
						}
						return $order_status;
					}
				} elseif ($mode == 'virtual') {
					add_filter('woocommerce_payment_complete_order_status', 'sp_autocomplete_paid_virtual_orders', 10, 2);
					/**
					 * sp_autocomplete_paid_virtual_orders 
					 *
					 * Register custom tabs Post Type
					 *
					 * @param	string	$order_status
					 * @param	int		$order_id
					 * @author	Mirko Grewing <mirko.grewing@me.com>
					 * @since	0.1
					 *
					 * @return	string
					 */
					function sp_autocomplete_paid_virtual_orders($order_status, $order_id)
					{
						$order = new WC_Order($order_id);
						if ('processing' == $order_status && ('on-hold' == $order->status || 'pending' == $order->status || 'failed' == $order->status)) {
							$virtual_order = null;
							if (count($order->get_items()) > 0) {
								foreach ($order->get_items() as $item) {
									if ('line_item' == $item['type']) {
										$_product = $order->get_product_from_item($item);
										if (!$_product->is_virtual()) {
											$virtual_order = false;
											break;
										} else {
											$virtual_order = true;
										}
									}
								}
							}
							if ($virtual_order) {
								return 'completed';
							}
						}
						return $order_status;
					}
				}
			}
		}//end SP_Woo_Extra_Options class.
		new SP_Woo_Extra_Options();
	}
} elseif (defined('WOOCOMMERCE_VERSION') && version_compare(WOOCOMMERCE_VERSION, '2.1', '<')) {
	wc_add_notice(sprintf(__("This plugin requires WooCommerce 2.1 or higher!", "wooExtraOptions" ), 'error'));
} else {
    /**
     * sp_check_woocommerce
     *
     * Checks if WooCommerce is up and running
     *
     * @return	null
     */
    function sp_check_woocommerce()
    {
        if (!is_plugin_active('woocommerce/woocommerce.php')) {
            ob_start();
            ?><div class="error">
                <p><strong><?php _e('WARNING', 'wooExtraOptions'); ?></strong>: <?php _e('WooCommerce not installed or not active, therefore, WooCommerce Autocomplete Orders will not work!', 'wooExtraOptions'); ?></p>
            </div><?php
            echo ob_get_clean();
        }
    }
    add_action('admin_notices', 'sp_check_woocommerce');
}
?>