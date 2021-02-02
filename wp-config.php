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
define( 'DB_NAME', 'prueba2' );

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
define( 'AUTH_KEY',         'gt&uCd,}`iM:7j$zW9fv|&V<-BKnpW/hPg6lwf=P{2}xof<+cp6u*wjJr~G.S7zg' );
define( 'SECURE_AUTH_KEY',  '/!!*N+i0$eHyE&@inHZ @5l~_fEYhnl$eCe}P;5%^I^{hPirD(yoilg!U8)pl7}~' );
define( 'LOGGED_IN_KEY',    '_<xUwkmk{;kd[HBE1p4#)<Q1+D//EbV2[x2oR4/nrH Ka7<ykx#,:3!A]6l=]J[h' );
define( 'NONCE_KEY',        'al?ELx9fupr_Yr$r:-td7ocy)o>r%o<pUa0aP&sJnAMWe5Xc^*RK|gw0j3 wVFJX' );
define( 'AUTH_SALT',        'zUC/bFc|1b.`e*BHHE~]B0PCj5hY0YoNNfve:$n*=ErMC62h@Zu,d+Gd~9c^z#+k' );
define( 'SECURE_AUTH_SALT', '0GAHgkquN^]o@9|@GCX{r+_PMzCibc*+)Fa/z?(obKrh:`i$aH5>7.-HW?ag52Bf' );
define( 'LOGGED_IN_SALT',   'K:G_bS4]U/Ff45Nh+y5OshK|xB~s:(bs+d630d]Z*,*!$bmpPF`=3MY.90BY{3SM' );
define( 'NONCE_SALT',       'Nu>{]W+?*Wd1v<DTt{pp_s&5q]`-?VGvzPfv+B=0~*DI+$-<+mvVNr.uPRDE7ElJ' );

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
