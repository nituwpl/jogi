<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
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
define( 'DB_NAME', 'jogiarush_2004' );

/** MySQL database username */
define( 'DB_USER', 'jogiarush' );

/** MySQL database password */
define( 'DB_PASSWORD', 'jogiarush@2004@123#' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'T>w`;>y7{u-%!P{t ~.v1$d%b}FZi,$9<(>ypWI:@8)8x?(SUjE_oxL29_r;US1t' );
define( 'SECURE_AUTH_KEY',  '=ZS^n|ebA<u#^9J~d_|~DhSS*Nk! EqBkA#fVJ&w!.+6z%A}kF&)ocuY60D@]pFB' );
define( 'LOGGED_IN_KEY',    '+|k/1Mg/bB0(=AbsMOZ.|]ko}SZP}3;43&;d/|7{MFc0tu%?vpd{T Qh#:3c~vD/' );
define( 'NONCE_KEY',        '8*y%e({gc,uFPn_SRsLAG rP?(kP53c#j IH5*cTTVS},,#V6FS*&([,];k_lZNm' );
define( 'AUTH_SALT',        'it!I32wrBAa*{VW}PeGDaST!}d^O]F,,%,!:qNWt_M`adc/R;0+!FMmLA^Q 69Ps' );
define( 'SECURE_AUTH_SALT', ']vPw9%wUUg_=B8_3;B.Y9$0;$yDJ}MgfBg:ZbC#UtKq(f6RG^(ZUhUlV;|cP/G<h' );
define( 'LOGGED_IN_SALT',   'pPctAK_7<3T>TT[h2iDA?817{%e|]]TS%Qu,9?)TZr|~xeXPd7DPpjH09L0 Yy18' );
define( 'NONCE_SALT',       'Gi_=%vFe=?r7pY?6WE&qYYT%x=/zSeFh`n08$2U|}#/1njv#-dfQH,h; mmru9/v' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'ar_';

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
define( 'WP_POST_REVISIONS', 4 );
/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
tdefine( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';