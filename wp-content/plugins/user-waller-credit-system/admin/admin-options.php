<?php
/**
 * Admin Options
 *
 * @author Justin Greer <justin@justin-greer.com>
 * @package User Wallet Credit System
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( dirname( __FILE__ ) . '/functions.php' );

class WPVW_Admin_Options {

	/**
	 * WO Options Name
	 * @var string
	 */
	protected $option_name = 'wpvw_options';

	/**
	 * [_init description]
	 * @return [type] [description]
	 */
	public static function init() {
		add_action( 'admin_init', array( new self, 'admin_init' ) );
		add_action( 'admin_menu', array( new self, 'add_page' ) );
	}

	/** register the dependant settings */
	public function admin_init() {
		register_setting( 'wpvw_options', $this->option_name, array( $this, 'validate' ) );
	}

	/** add the plugin option page to the admin menu */
	public function add_page() {
		add_submenu_page( null, 'User Wallet Options', 'Edit User\'s Wallet', 'manage_woocommerce', 'wpvw_edit_wallet', array(
			$this,
			'wpvw_edit_wallet_function'
		) );
	}

	/** load dependant scripts and styles */
	public function admin_head() {
		wp_enqueue_style( 'wpvw_admin' );
		wp_enqueue_script( 'wpvw_admin' );
		wp_enqueue_script( 'jquery-ui-tabs' );
	}

	/**
	 * [options_do_page description]
	 * @return [type] [description]
	 */
	public function wpvw_edit_wallet_function() {
		$this->admin_head();

		if ( ! isset( $_REQUEST['ID'] ) ) {
			exit( 'Invalid User' );
		}

		$user = get_userdata( intval( $_REQUEST['ID'] ) );
		if ( ! $user ) {
			exit( 'Invalid User' );
		}
		?>
        <div class="wrap">

            <div class="uw_notice notice notice-success is-dismissible">
                <p class="notice-content">User funds have been updated</p>
            </div>

            <h2>Edit User Wallet</h2>
            <h3>User: <span style="color: #21759b;"><?php echo $user->user_email; ?> </span></h3>
            <h3>Current Funds: <span class="user_funds" style="color: #21759b;">
                    <?php echo wc_price( get_user_meta( $user->ID, '_uw_balance', true ) ); ?>
                </span>
            </h3>

            <div class="section group">
                <div class="col span_8_of_12">
                    <p>
                        Use the form below to adjust the users funds.
                    </p>

                    <form id="adjust-users-virtual-wallet" action="/" method="get">
                        <input type="hidden" name="user" value="<?php echo $user->ID; ?>"/>
						<?php wp_nonce_field( 'update_user_wallet', 'update_user_wallet_' . $user->ID ); ?>

                        <p>
                            <label>Action: </label>
                            <select name="adjustment_type">
                                <option value="add">Add</option>
                                <option value="subtract">Subtract</option>
                                <option value="update">Update</option>
                            </select>
                        </p>

                        <p>
                            <label>Credit Amount: </label>
                            <input type="text" id="credit_amount_inout" name="credit_amount"
                                   placeholder="Enter Adjustment"/>
                        </p>

                        <p>
                            <label>Notify the User: </label>
                            <input type="checkbox" name="notify_user" value="1"/>
                        </p>

                        <p>
                            <textarea name="admin_note" placeholder="Message to user (if applicable)"></textarea>
                        </p>

						<?php submit_button( "Update User's Funds" ); ?>
                    </form>

                </div>
                <div class="col span_4_of_12">
					<?php if ( ! defined( 'UWCS_PRO' ) ): ?>
                        <div class="cta"
                             style="margin-bottom: 2em; background: #FFF; padding: 10px; box-sizing: border-box;">
                            <h3>Want More? Get Pro for 10% off</h3>
                            <p>
                                <strong>Pro features include:</strong>
                            <ul style="margin-left: 10px; padding-left: 10px; list-style: disc;">
                                <li>Users can load a custom amount</li>
                                <li>Settings for better control over the experience</li>
                                <li>Product Support & Updates</li>
                            </ul>
                            <strong>10% Discount just for you!</strong>
                            <br/><br/> Use: <span style="font-size: 18px; font-weight:bold;">PROME</span> <br/>at
                            checkout to receive and instant 10% off.
                            <br/>
                            <br/>
                            <a href="https://dash10.digital/products/user-wallet-credit-system-pro/"
                               class="button button-primary"
                               title="Purchase User Wallet Credit System Pro"
                               target="_blank">
                                Learn more about the pro version
                            </a>
                            </p>

                        </div>
					<?php endif; ?>
                    <div class="cta" style="background: #FFF; padding: 10px; box-sizing: border-box;">
                        <h3>Need to customize User Wallet Credit System?</h3>
                        <p>
                            Hire the expert WordPress developers that built this plugin. We offer custom
                            development services for affordable prices. There is not job too small.
                            <br/> <br/>
                            <a href="https://dash10.digital/contact-us/" class="button button-primary"
                               title="Dash10 Digital - Custom Web Design and Development"
                               target="_blank">
                                Contact Dash10 Digital
                            </a>
                        </p>

                    </div>
                </div>
            </div>

        </div>
		<?php
	}

	/**
	 * WO options validation
	 *
	 * @param  [type] $input [description]
	 *
	 * @return [type]        [description]
	 */
	public
	function validate(
		$input
	) {
		$input["enabled"] = isset( $input["enabled"] ) ? $input["enabled"] : 0;

		return $input;
	}
}

WPVW_Admin_Options::init();