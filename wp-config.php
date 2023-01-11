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
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'childarena' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
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
define( 'AUTH_KEY',         '*15CGCU^^efZbTM(0A<=^!*|OsQD)dP0|YdV5n`$NI0yFwP]c:P!r>T~))4_AkBi' );
define( 'SECURE_AUTH_KEY',  'C>QW$]cL^E#[5F,,P7Mm;X?RUyWs{z<#elSKR^lfQO)d@`-T`)?ZeUO=Yt1d?,gv' );
define( 'LOGGED_IN_KEY',    '{s)}WCchW6%B+G$CzSSvy6sS:R8rHc]{]BKmY;hZYL,IX0b{aauA`DC9iA~XA(!;' );
define( 'NONCE_KEY',        '9vKz_%j_7H;|:i5(g%UaTDWr=G`]Vn=E4(wYi ySux4[,|W$O&F_Tm!dtD@[Q<>z' );
define( 'AUTH_SALT',        '#$kbcjlI8B<4,]CwVZOJWk[v<aduwx78:D:r@v_UyRED{=4c$GSI5Hr-m=~b3ck[' );
define( 'SECURE_AUTH_SALT', 'QqM=[?I+;s?GUecT+50*;UY8Bi>[Sk8XA.v,_PBzO5>QpL$R%,^tz1Dap)Te<[EP' );
define( 'LOGGED_IN_SALT',   'oMj;E/ME4znV8&h#-KA|}GIoQ5*Hef&.P=dcqA%{|F>if&a6,eDN$Fkwcp+OM%=4' );
define( 'NONCE_SALT',       '::fnyH[AAm@a+IQFAce|S#Bgp~qjc9~%y=ufJpB+XIRs!Kjcf!58e,E;!},t#o=Z' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
