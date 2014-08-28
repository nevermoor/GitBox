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
define('DB_NAME', 'freekrau_fkdb');

/** MySQL database username */
define('DB_USER', 'freekrau_fkdb');

/** MySQL database password */
define('DB_PASSWORD', '8fFwDBZA');

/** MySQL hostname */
define('DB_HOST', 'mysql4.cloudsites.gearhost.com');

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
define('AUTH_KEY',         'Gv0{medL`.#;-U/]+WVlx&]Tw=e,cb#`(R0WQ.YfK!gcEB-uh<?m5a6.8;>#t_M ');
define('SECURE_AUTH_KEY',  'nsLO_fTogYTYE]G5Zi_e6rb|l=Q>wREE#[GeW7&iiOah)-+%Xf!?>^E^Z3&%Sh@*');
define('LOGGED_IN_KEY',    'K3j(9gQ6Cx.-sLDAZTU-i#Kk#Ut9*5!DuBt2Qki)^S/D.=7~SBhG-#cJ3tUe;- u');
define('NONCE_KEY',        'y+4gA^mOv4Yvh%MIVb}bl9IZ9{d;CBf]4}~Tu7=z0i2zRZHV!$bwlN3 Dup8[(ze');
define('AUTH_SALT',        ';_LZ6Q<]>fCDd~{GRim-+2I!%YLiQ[ ^;o^(84|mYnHIZ47,kc6$(:~zZQSqkv`9');
define('SECURE_AUTH_SALT', 'AJH*l0`|G/A9(Xv(*/zAg&uCKl>|~$Ke@yS[=0]0J[E0_p}b)Znk9AL#YNb6j8Y$');
define('LOGGED_IN_SALT',   '`Of7K/nUeD&<t0gc:2&<C65LbsPh|nP|(|=F7HXwG>[).|=VE;u.$96x=L.&T,uj');
define('NONCE_SALT',       'm=lYt[9_2qtEP^QG;ft0ot6U>*s`&}MU?l++=Js_wc~Ch e%g(:2:3H7V1&r6b|@');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'sand_';

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
/*define('WP_DEBUG', true);
define('SCRIPT_DEBUG', true);
*/

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
