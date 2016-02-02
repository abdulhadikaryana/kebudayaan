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
define('DB_NAME', 'iaai_db');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
//define('DB_PASSWORD', 'Kr4k4t4u123');
define('DB_PASSWORD', 'Sangkuriang@Sampurna123');

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
define('AUTH_KEY',         'y`Nu4]=t[lV-MR}21[AE+rP+:1#sK!Wab#</d}00-l 7y[lm|{GEnA1AL{m`||pk');
define('SECURE_AUTH_KEY',  'uGDvIDz!{F@WUyfJOZ-~_90_cc7HOs- AD1-k)C3,r&? ? n(PWTg;el?t;6wZVM');
define('LOGGED_IN_KEY',    '1xz1ZlNGIb&YI9<[~g%*|K&j}_WTmY5o<Uz|$m/P+:-U1?t3R3V^-=[<K3Hi+o[+');
define('NONCE_KEY',        '0->zsFJp[y%D:oXk>3a3Wp%.blZVM0m/Ln$:MGBXh5KcwlXL(9d_<@:u,<R(`@W4');
define('AUTH_SALT',        'z@krM!6xhgf5h-tDNT.ar=HN.~A.du1y105hn68J+THG1U1KZwoV]bd]7x0K`9o9');
define('SECURE_AUTH_SALT', 't^SxsR;Ji]S5w+jShco%u)Kt*mzKx3=7#anvxn9}w6MWe0Yuiq-lP>Y&k:r+vb+5');
define('LOGGED_IN_SALT',   'da7YTzzg mO5eL8yr}yO3gjzyZ1w2>6[VHVy39]ulgJ=l_id@uldQ 2&k8W}8)f&');
define('NONCE_SALT',       'Q.[X<O|o]7z)EFh>PSTA^oHGI7pF*X59DS39wft#]{-/dG6>?EKEvO0uM7tg+xW<');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
