<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
//define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/opt/lampp/htdocs/retirelynews/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'retirelynews-latest');
//define('DB_NAME', 'retirelynews');



/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

define('ABSOLUTE_URL', '//'.$_SERVER['SERVER_NAME']);

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
define('AUTH_KEY',         '/H4|B,I~;d/bg&kZx,/^_F7,M1JMGT>?`Ns-T 8S~S-F#]2P-bZ`|;3-J;NUZ%BE');
define('SECURE_AUTH_KEY',  '|Iw?thG8PQ6*N8+;@?H~w^R|-RCMD4c5K*72(W<g6H2J{H`R3?<V%kgYSsDZ&%KV');
define('LOGGED_IN_KEY',    'UKc.w6Xfw{hH_1?>B QYxN?MPDt}I_| F+|JmfC+7EHJ46P:<%ZGo$]kuRO|(T{O');
define('NONCE_KEY',        'g)~(+UIB q*SeyX~M{n9}} SY$vpErV-$>B6!.D$UcpojnyO8om4ajomy4;YDbsg');
define('AUTH_SALT',        ';D#(-K+y0x|+*-eR%ffN fuo=c11^69tGR$zRYhCn,R1Lh*+|E,K2leSf2D}I.8#');
define('SECURE_AUTH_SALT', '^=+uZ7ocngU)%Htd#j+!J|:q7C;&s0&~pC+Q8f7Dk@?]L`jhjD@X[.dAn;$C.7pX');
define('LOGGED_IN_SALT',   '}$N2+~CDUQO`m+-(.:FP|d|-lA[uk1-~$ywV^5/AgF-`gNQu}[983)J;uf~} ^=o');
define('NONCE_SALT',       'r#^r,M [V?0ZYWOs}2-|Z;.VfNuv&V>i-W/oB8{j::;xr$c39IP ZeUH<d/JFB--');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'a1_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);
define( 'WP_MEMORY_LIMIT', '64M' );
define( 'WP_MAX_MEMORY_LIMIT', '256M' );
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
