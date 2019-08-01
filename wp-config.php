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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'travster_c6d_beta' );

/** MySQL database username */
define( 'DB_USER', 'travster_c6d' );

/** MySQL database password */
define( 'DB_PASSWORD', 'A6DECB09pw18b3i52c7l4' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          ':GM@@GiX9Hk$$mYzwr,Ny>/7n}NA}S2ZIWOd&t_yih?&;x`Ujw(1wiR6q0/>b_4)' );
define( 'SECURE_AUTH_KEY',   '/^i#Hc9U58}_%*/*4>Pti>TZ_B4p]/N5l?WVM5I$8~#g&K4VVQo]]mxoK+`$Q.A~' );
define( 'LOGGED_IN_KEY',     'v7.oHnpQpiKYiKrg>i]r#!IU0eyM[Mvbqkx39OeMUVIa`%lX}(}[tzVQPyEytfad' );
define( 'NONCE_KEY',         'IZWet%FO(6h?)Fw5@Qsp*&&OP^6h^cq5QDD$U?y+:)@hqv.d9b#xrLI4e^lvR*4T' );
define( 'AUTH_SALT',         ']nJQA!SB6UqS!0vo!MP&#eWBlD=<?|E4+op)Ic*$Fby#G2X_IX<mJd#$jE5s8>lS' );
define( 'SECURE_AUTH_SALT',  '!+F#P4S.#z`,O+C3uWzYJDR<{&E9Ztyh$X6C<E+-4W._.|?,oF.W9$N~jCK[1DG?' );
define( 'LOGGED_IN_SALT',    'GOCJh0szvyiW!kPW_pb/M7e/DVHU7<eM;J{ba,ci :JgNV;VY!#SA X/O0Fu|Qtg' );
define( 'NONCE_SALT',        '{Ou2Fh%W4|QA9m`1t4Sd?SQpD,gArqP0*eLQ4r}VTlbDn(kBM|<(X}y7;?<caGbn' );
define( 'WP_CACHE_KEY_SALT', 'l/A+8R!6fl!Zl4XE/C!Rq38k`{ZYd$%4mh%o])|:U&Db601P R^@_s/E?<sb]gPt' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = '6f7_';



define( 'AUTOSAVE_INTERVAL',    300  );
define( 'WP_POST_REVISIONS',    5    );
define( 'EMPTY_TRASH_DAYS',     7    );
define( 'WP_AUTO_UPDATE_CORE',  true );
define( 'WP_CRON_LOCK_TIMEOUT', 120  );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
