<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ahv_advert');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

// ** Disabling Auto Save Draft in WordPress
// Changed by Wang
define( 'AUTOSAVE_INTERVAL', 3600 );
define('WP_POST_REVISIONS', false);
define('EMPTY_TRASH_DAYS', 0);

// Change end

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'WA*H~4v>P`z[M-(F>qAf)yr@%F!d%;pO72&]9xBLX^iBTP4RQT0xIEWn><kPL|`L');
define('SECURE_AUTH_KEY',  'Kg!^K&Hv ==Sd78q^*#)CPR~en[YV&1;w@?[Iets,ie#3QON&eviorpXclPAO/Z5');
define('LOGGED_IN_KEY',    '`T_[$.{`#w(DJ0pNwLe=Q/job0Nm=pa$N,y+GxA;Y-SN%)Z~Ox#/& ]-_7cPNZpF');
define('NONCE_KEY',        'UVCe)9RHGm@a-,<Apm?<?M@cTj<1*8^TN-.60iT.zGXDjZ&?4v2,0/&RB%eJE}4c');
define('AUTH_SALT',        '^6m8XCn2Z54Dt$=5v!<yBY6H4AceWq$`h_<(<M8*70Ko@R`ueH7Kq77|;%<3i:>K');
define('SECURE_AUTH_SALT', '~ qmNiY%6OR4os4J0rXEky=dd5mq#FjX_MUHU!GU]n-?=w}:nro3QCESl*@QjJCf');
define('LOGGED_IN_SALT',   '@|SoKFSxNAykF{unc^2#wXOwcK3.&c A#Tty745tHgi09l;{+v[Zb84ChD>kC ??');
define('NONCE_SALT',       '%:<-de}s.xw wxS23hj/y.xEH&nhbeM[O]D%aFFNA{vELKVDq3d]sdEdf>M@Y7Yf');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
