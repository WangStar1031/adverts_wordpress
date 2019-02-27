=== User Wallet Credit System ===
Contributors: justingreerbbi
Donate link: http://justin-greer.com/#donate
Tags: woocommerce, wallet, woocommerce credits, user wallet
Requires at least: 4.7.3
Requires PHP: 5.6
Tested up to: 5.0
Stable tag: 3.0.13
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Gives users the ability to load a virtual wallet balance using WooCommerce checkout.

== Description ==

User Wallet Credit System is the first and original plugin for WooCommerce that provides each user of your WordPress website with their very own personal wallet. Users can load their wallet with virtual money paid for using real money. The plugin provides a way to purchase items from your store while using their virtual money. Store managers can also adjust user amount easily in the backend of WordPress.

[youtube https://youtu.be/Z70zGrxfaa8]

**Features**:

* Easy to install
* Load wallet using credit products which then can be used for later purchases.
* Ties into WooCommerce settings for currency formatting (simple).
* Manually adjust user wallet balances if need be from the admin area.
* Make purchases using the wallet balance.

**Pro Add-on gives more features:**

* Users can load any amount they wish
* Customization of buttons and messages
* Ability to transfer from one user to another
* Ability to withdraw funds to PayPal account (in development)
* Partial Payments (in development)

You can learn more about User Wallet Credit System by visiting https://dash10.digital/products/user-wallet-credit-system-pro/


**How To Use**:

*	Go to "Add Product" in WooCommerce and give the bundle a name.
* Ensure the product type is "Simple Product", "Virtual" check box is checked, and "Credit" is checked as the products category. Under the inventory tab check "Enable this to only allow one of this item to be bought in a single order"
*	Save the product. Once saved you will see an input label "Credit Amount". Enter the credit amount for the product. (If the product's retail price is 10.00 then the credit amount should be 10.00).
* Save the product again.

The plugin is setup not to list the credit bundles (products) in the store with other products. It is recommended that when you are offering users the ability to purchase products, that they do not have anything else in their cart.

**Shortcodes**:

Show Current User Wallet Balance:

`
[uw_balance display_username="true" separator=":" username_type="display_name"]
`

* display_username = (true|false) - Show username next to balance
* separator = (:|-) The character separating the username and wallet balance.
* username_type = (display_name|first_name|last_name|full_name)


Display a table containing the bundles (credit product) and "Buy Now" buttons:

`
[uw_product_table]
`

Display a custom deposit form (pro only)

`
[uwcs_dynamic_deposit_template button_text="Confirm Amount" description="Describe what the user is doing" default_amount="27.00"]
`

**Things to Note**:

* The plugins uses user meta fields to keep track of wallet balances. (_uw_balance).. Beware if you plan to change this. You could wipe everyones wallet balances out.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `user-wallet` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Refer to plugin description in regards to setting up how the plugins works

== Frequently Asked Questions ==

= Can User Wallet be used to make purchases? =

Yes. If you enabled the Virtual Wallet Payment Gateway (which is included in the plugin).

= Can the Wallet balance and Credit card Payment Methods be used together to make a purchase? =

No. Use Wallet can not be used with any other payment method at the same time during checkout.

= Is there Multisite Support =
Yes. The users funds will follow them accessed all network sites.

== Screenshots ==

1. Simple Wallet Display
2. List Bundles
3. Pay with Virtual Wallet

== Changelog ==

= 3.0.13 =
*Release Date - 19 February 2018*

* FIX: Fixed the history being returned for a user that is not logged in.
* NEW: Add funds to new accounts automatically.

= 3.0.12 =
*Release Date - 19 February 2018*

* Updates filter function names for better compatibility with other plugins and themes

= 3.0.11 =
*Release Date - 7 December 2017*

* Patched when adding credits when WC complete status is not triggered by actual buyer.

= 3.0.10 =
*Release Date - 6 December 2017*

* Fix to redirect URL issue.

= 3.0.9 =
*Release Date - 5 December 2017*

* NEW: Balance column to user table. ( Credit: @sanderscheer )
* FIX: Fix to AJAX Add To Cart issue ( Credit: @vanderwijk )
* FIX: Wrapper issue with displaying user wallet content using shortcode.

= 3.0.8 =
*Release Date - 14 November 2017*

* FIX: Update to post query that was preventing product from displaying.

= 3.0.7 =
*Release Date - 11 November 2017*

* FIX: Crediting gone haywire and being applied to admin instead. Credit: @alexandrepayen for reporting and providing a fix.

= 3.0.6 =
*Release Date - 8 November 2017*

* Added more compatibility for Pro version
* Updated query logic

= 3.0.5 =
* FIX: checkout_url bug fixed
* NEW: Pro Add-on Capabilities

= 3.0.4 =
* FIX: Applied button text patch for other plugins to change default button text for WC.

= 3.0.3 =
* FIX: Notice for buy now buttons for credit items

= 3.0.2 =
* Tested with latest WordPress Version.
* Add callout in admin

= 3.0.1 =
* Fixed the required issue with a file that does not exist.

= 3.0 =
* Restructure admin management flow for better performance.
* Security Update.
* Minor code refactoring

= 2.0 =
* Tested with WP 4.8.
* Added: `wpuw_update_status` filter. Defaults to "completed" (WC status). Used to modify the checkout status when using WPUW.
* Removed default values from main class to auto complete.
* -- Added a widget to display user wallet for logged in users

= 1.3 =
* Tested with latest version of WC and WP.
* Fixed undefined error if debug was set to true in wp-config.php
* Typo Updates
* Changed occurrences of plugin to User Wallet instead of Virtual Wallet

= 1.2 =
* Fixed issue where all orders go into "Complete" status, even if the product was not a currency package or virtual wallet was used as a payment method.

= 1.1 =
* Fixed infinite credit bug reported by dvolkering
* Updated version and confirmed working on 4.1

= 1.0 =
* Initial Release