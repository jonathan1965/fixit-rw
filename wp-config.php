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
define( 'DB_NAME', 'fixit-rw' );

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
define( 'AUTH_KEY',         'n{;I+KcG6cxG-?<8UAX9r I#rO}7%}GvXnT>Frg]VEs.N-dqR=MV:wf#64$8Y}Xd' );
define( 'SECURE_AUTH_KEY',  '3np_!a]jAQvpSqI->5dB-,VagQ0z+pQ0L^`v-^|R68/Msh=v+czrr0!(>{gs1ZnM' );
define( 'LOGGED_IN_KEY',    'V6pnaq(vc{niZs=*muE:yXDRxSH#o~dEo-FK)X= #88%x(T`!`STb1s7L:>mL0l9' );
define( 'NONCE_KEY',        '%*e#>u(gub<s0h<SU1dkOT=AQ:u%7A~IYXE3I$9|z`?8T^uDMg2EpFnmeQj1VaN>' );
define( 'AUTH_SALT',        'U~Msi7SHe&+%ut.d=gY;n.^g5z)c]K_!Y7Q-_T<@R1-bsH3VJ&&*#}fPR_Q~4b11' );
define( 'SECURE_AUTH_SALT', '830K/^~8#oqL)|tp4^FlzjTvpga2KgcEZ F60sWxB&zVWA/3BlAXAwW*(xP[wuF%' );
define( 'LOGGED_IN_SALT',   'z ]r9mBfE^f#1}:sXNKHG8`P(<iI&4l{+sb/NZ.N |]$BEi|:in%abPD wMN7 FA' );
define( 'NONCE_SALT',       'QZn,Vwe0AmKK|.t5|-[6DeO$&q3L<H+;=G%Ua<kK2;tgdUUT4#A9k2FO_DGN.jBa' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
