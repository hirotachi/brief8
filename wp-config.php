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
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3306' );

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
define( 'AUTH_KEY',         'S`}c.e#i/E*tF7T^V,#Biojxz2W+61`ylfW)1a#WQX4C1#19[.Mh5!Hoc?lEDi(R' );
define( 'SECURE_AUTH_KEY',  'yYDcE,:}I5|0!OZNivuI:yejS3~]2Zg[23%|Zg^5ZQt8bMNu<aHAw!.jUp4gsqcE' );
define( 'LOGGED_IN_KEY',    'voc4%7%Z1(VaPY&~sK_eq>baKxspE<CoACAnn(B|#{<0&[;$$jt7127-0yo|=#cs' );
define( 'NONCE_KEY',        'u]~~J7%XHn>;^X$3M$47pOCj@Ty}0NnoU~#C!D@:y~~ApkOvx[nV;o6[~+$L&IiS' );
define( 'AUTH_SALT',        '>6tpERUTWm%4Q3pGBkEG::Nu/i[d^4Zo`4;L]GdL;lxg,CFO5=%>R%3?!F-E(j?<' );
define( 'SECURE_AUTH_SALT', '8_WGkNW%2#URr4)Q_&P51($Q,TGd&m!4T0{=Ko]a[<!%TV@K2d<?N]zDCGP37Val' );
define( 'LOGGED_IN_SALT',   'V6wog{>{c};c~ame>c{CZqeM,VUJ7^agggs9(uI*/e*#abD2yrA<~-Lx$2:wCJKJ' );
define( 'NONCE_SALT',       '1^Bt%L=rf *NX %&_<L|Jy<B/p_Y0TV;Lzz096XN-.IN_59S5Ng,0oMEoVkJPyWs' );

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
