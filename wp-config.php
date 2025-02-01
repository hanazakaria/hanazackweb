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
/** The name of the database for WordPress */
define( 'DB_NAME', 'hanazakaria' );

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
define( 'AUTH_KEY',         '*K*7QkRSVUmo,cKv-ZGAc%O[Yf;wLBG%6yJbuj+Iv}sD7>RMCdErK?/wWYQ)>9JY' );
define( 'SECURE_AUTH_KEY',  'JfHu!%gCM*@&pjEg}{#kW]7j>l5^~!I)[5;<Hu~ug~,69w%T1u9) H&edQxo/RE7' );
define( 'LOGGED_IN_KEY',    'hwe>aU(KI_,9xf4 X?Xc.nBE;g,XAH!q=K$k35;{xnG@b-g|#gaCcdb)r$K-tfW=' );
define( 'NONCE_KEY',        '3v~5J6Lrl1AGY/o1XhX$Zo{N/{9yAh/M3)DqgW$N@I#G=kni}#g?BH_EX_w~)#xq' );
define( 'AUTH_SALT',        '~OzH,Kb2jkQ{M-Gj1vV=lhHHFjgjgB2<!xsGwlHy<R%{d22:mDN=TDbhIY]IDm R' );
define( 'SECURE_AUTH_SALT', 'Arju7am/t#f]w^aS`H]_|36*1?(/VbxX>WM201:sETBQGv}7 NM+K9FN?oFX]h=;' );
define( 'LOGGED_IN_SALT',   'K=jr8en~0AAM*$QL l.gj)9f~t#](seZ_Khj10hW+^7ii;q}#$a58;OqVxglQ=2V' );
define( 'NONCE_SALT',       'VS0F39WN);<2<Lc%0}.(M/0p$>Gon3(3g<#[pIp/rI#l=:i$?b3OcLOaSxRuv1Q%' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
