<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
// /** The name of the database for WordPress */
// define( 'DB_NAME', 'if0_37512536_wp86155' );

// /** Database username */
// define( 'DB_USER', '37512536_5' );

// /** Database password */
// define( 'DB_PASSWORD', 'p8l[Sj906@' );

// /** Database hostname */
// define( 'DB_HOST', 'sql206.byetcluster.com' );

// /** Database charset to use in creating database tables. */
// define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
// define( 'DB_COLLATE', '' );

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'qu7jm26iekryhbc08ccimpagmsitboml7iasxlwyq8omuoxficmands8u4ao1nld' );
define( 'SECURE_AUTH_KEY',  'q63co8gw3md9qhakqapwywwta98hlhafqbzq8oxhduadtsibd1mocwqdmqsvmonp' );
define( 'LOGGED_IN_KEY',    'dprwdkc1yulnxq1al4dcoisptu7iqheizqvshabbi2jzvwu53dwuq7hdlp70zt6h' );
define( 'NONCE_KEY',        'vkn540tdrpgfvs5l9zbejc4n0kjlvc8y7uiha1bzhnxqlbymazm9yp0xgw2ivuks' );
define( 'AUTH_SALT',        'n0iipyis7kptqkbsmsvbv533sx1klxmcfsyvwu3phuzxaueupf4lcpr0as2otxzg' );
define( 'SECURE_AUTH_SALT', 'ackqwbfjj0xtmvjwz3ltluehnn2tzypqphrrqlutp4qhxwfcbm8p3er3xa0wczis' );
define( 'LOGGED_IN_SALT',   'k7k6jmbdoletmj6upfqhdpzhpdumcqgkpmfthkmk0lxkxmurncsfzlfwne5byvjf' );
define( 'NONCE_SALT',       '6vfbt5akkxiek0hj0s4fz8jcdosds3pkjm0ku3gqzuevaxqymbpfa7261rjyipkd' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpu3_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
