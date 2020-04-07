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
define( 'DB_NAME', 'bystroem_dk' );

/** MySQL database username */
define( 'DB_USER', 'bystroem_dk' );

/** MySQL database password */
define( 'DB_PASSWORD', 'DuugrwJfh3wm3TA329AYuh8X' );

/** MySQL hostname */
define( 'DB_HOST', 'bystroem.dk.mysql' );

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
define( 'AUTH_KEY',         '|q%f8^+P uKZg E-k_N[<jgI&:EYPO,I{Z~$jNoMSMI~D1Pt7RaBD+0,.MLAy#)J' );
define( 'SECURE_AUTH_KEY',  '!&bG1z0jv+sii(4$Q!:&$i=jvh=TJN}Z$ze%4R5R$+}!{x2kn,7Zd:/}um V+-<@' );
define( 'LOGGED_IN_KEY',    'ULonG|9hsR@i$DT4cO1n3+M~+)}C~JU._=.tUBy_SaX6Z;<BMM|#a>LMv9*GQs+W' );
define( 'NONCE_KEY',        '/:2I&wj^*g)}^aFA!(:*Z&qOnbvefb<8(^xE7Oj(a;6qY{*nLEq%Fo9,%Po{e*-t' );
define( 'AUTH_SALT',        'EXb Q$V,*7&U8L6;U6v`u8Ic+KNDstIvG%b9rtwumR>y&H#$pc@onDt++9ntTY{+' );
define( 'SECURE_AUTH_SALT', 'D;B3xPHYM-yP{Hc)WDM3a&4R2a_A$($vk$KX_0#Z)R0Y_{BtWDy9D*_EMF+mnpW.' );
define( 'LOGGED_IN_SALT',   'QNH RrS+!UHkkAh8/)iVYAwRC@tx%FVCW]J-by5Z/h}{YzI+0pfro&#n6E|d/W/Y' );
define( 'NONCE_SALT',       '1%BKzo!uxF@np8}sMvg_31cg?m1DKz)0_su]RUVBeJg?C!UZ3?_1``4jLek<dx`]' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'storyscapingwp_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
