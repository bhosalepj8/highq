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
define('DB_NAME', 'highq');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '!A@S#D$F%G');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'sI~t/bx%`+0)S5;@AAn`vWq#}p;5< OmRJh4br1n=<n4>LvS(gN}ZGkr+[_GPQ,t');
define('SECURE_AUTH_KEY',  'J>`+4#~fBb/7FBiTjf1@A@hxA&gf6~c~BU{yUO:hiXExt#~UoSd3-u*cX3Ng@t`t');
define('LOGGED_IN_KEY',    '3&mmSoq?|UdsCR2fL!Z1u%i:*dOB~SaUQ)_w~Yi1%~D$o#suu[09+QyP-2`><*<@');
define('NONCE_KEY',        'hsh10D}qCG?ao3xE4}Y`)2. EmqkTyfM6foQ05-Zl[ncI`DlLGOAdO(C&wxn~B] ');
define('AUTH_SALT',        'tEd3MtB|!}PtJO]FJY(z0l]=Tji!pS e4Ux&7>Gl_5x9-807yF*.y0,[f_e$hQsw');
define('SECURE_AUTH_SALT', 'tNr,+G!;_nD$S|j{O,6J|<yL)S(4<{&vMqAgj;FrT#h&`@4&cIAwf!dVWId?tXT3');
define('LOGGED_IN_SALT',   'Z~&26#KyaukTT5+|{e{?l^[`JLE?[u0j+5mB11u:{h38@7HQsiW^sUeC.HAYZ3]z');
define('NONCE_SALT',       'x#=D/oB0arLY(G0uHA+_9@zdLlxI4rO|/_@Co3QAND`n}(^N?DQF?`.;Klu`SWvK');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
