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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'iRL]9<MfNM;6Q5Y!U^t;y.y0.ly[WAm+Q? Jg;5%8<`HRu:=uo6pldFi)4cC}Jpz' );
define( 'SECURE_AUTH_KEY',  'VAr a6(!Wzgpe-oX%>qZ3l-^;>}43`sE*]0n|8B]3G~Wcj)8M;=b?acrRqd3/U6S' );
define( 'LOGGED_IN_KEY',    '#]pch );8o_]8/nRJpi7rWYPBRn!F(&}mp>o;{H<#ViNu.7 }`czT%jwdO#}_R]s' );
define( 'NONCE_KEY',        'dr}LjXwk qSIRrTMX.b/`3<BlYfe6Udt/WxEE<D2?CZmq(_dq0UQ(;Ggu^Lao#Lt' );
define( 'AUTH_SALT',        '|=B^eznacyNDN7qw{%;iTzFH{-:<5GW=O}Ghu;2$Ns]fr9aV;%R$RHZq-iSh6Zp@' );
define( 'SECURE_AUTH_SALT', 'fDpk6jWEh0dE0wjKT4s5oG{s=/o9ao<)c3elw5JvXPLC1-7Lb&Q+x4XVYW+ie@#y' );
define( 'LOGGED_IN_SALT',   '_k)aXz8K=( l{8>wr%U&m}?4/dWOaW>eIaE^E+|A.H `sr$X`_f< R~LT[/V~=P,' );
define( 'NONCE_SALT',       '!wigZ@cintou+36VS}Aa/OmWzUgs9rFeC3N5kYr(N;<$0QYiml8#L-`&!1T~a6;t' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
define('FS_METHOD','direct');

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
