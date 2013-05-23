<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ro_rendigs');

/** MySQL database username */
define('DB_USER', 'ro_rendigs');

/** MySQL database password */
define('DB_PASSWORD', 'ro_rendigs');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'pBCPHeDw0f>=!a5@W+srSKG_*|vM>eQ`pm]f|AZHs2U|J?LGIBk:t,rU}:m0&#,s');
define('SECURE_AUTH_KEY',  '-=j<@@QLZ^T1$.zwjz2]]:es.G&`^HPxW!k{HrGoI<y^RVP_a xBq`f!=Qp+(@c>');
define('LOGGED_IN_KEY',    '%e67!hNVdXLZx4G)^we}D]s1Mnrlr3}X4+o135=91dv;Q*,l!?9Alw&@U.fRwAB!');
define('NONCE_KEY',        '3<$X:|:V#7D}0TUVy:42s_Lk.F{869Z>&kloOgPSTu+7t=]mp%F1N<*?}L>7(.3o');
define('AUTH_SALT',        '|{{LsC,zC=[,-k2*JrqTRrB|~sMx?iUs5R-]+C;p3CSXmsuBv^N_egMWP[,E}/}n');
define('SECURE_AUTH_SALT', 'He2JKQ4>2HC>GCSW]#|96|A?KEH$GTo?1`Ll#SrKt8[4C;7I@5)CS$)?jLf=sWkR');
define('LOGGED_IN_SALT',   '>x6,pmk[HKO*rS%Jr~i%&YGd!?6Hv9]6)8B}mjUDa4{!nX2|6M]<=EHa)A#0m3-v');
define('NONCE_SALT',       ':A^(5fC;=Tlcgirq%eSv[p#)a4_`}yEw2=cH;Xa*VuEwHLFgR+F/Dd*@#~]A9Ljs');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ren';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
