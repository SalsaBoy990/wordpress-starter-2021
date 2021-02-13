<?php
/**
 * ####################################################################################
 * !!! Ez csak egy példa, git-re ne kerüljön fel éles wp-config.php fájl !!!
 * !!! Ezt a config fájlt töltsd majd fel a tárhelyedre az éles oldalad változóival !!!
 * ####################################################################################
 * 
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

// TODO: valószínű, hogy az osztott tárhelyen nem tudom használni, mert nem tudok Composer-t telepíteni
// Ehhez VPN-re lenne szükség
// Composer autoloader
require ( dirname(__DIR__, 2) . '/vendor/autoload.php' );

/* Környezeti változók beolvasása */
$dotenv = Dotenv\Dotenv::createImmutable( dirname(__DIR__, 2), '.env-prod');
$dotenv->load();


// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', $_ENV['LIVE_WP_DATABASE_NAME'] );

/** MySQL database username */
define( 'DB_USER', $_ENV['LIVE_WP_DATABASE_USER'] );

/** MySQL database password */
define( 'DB_PASSWORD', $_ENV['LIVE_WP_DATABASE_PASSWORD'] );

/** MySQL hostname */
define( 'DB_HOST', $_ENV['LIVE_WP_DATABASE_HOST'] );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', $_ENV['LIVE_WP_DATABASE_CHARSET'] );

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
 * 
 * Salt forgatóra / frissítőre is szükség lenne
 * Salt Rotator CLI for Wordpress - wpsucli.sh
 * see https://github.com/ahmadawais/WP-Salts-Update-CLI/blob/master/wpsucli.sh
 */
define( 'AUTH_KEY',         'IDFGaPy5FGv2wSwH4tVIHZInY7KDsHL9ylkF5KDTAiDfawCp74JvryE0JuvZ91Yk' );
define( 'SECURE_AUTH_KEY',  'NodkuxcXc1qlmjWSNjr8mFyRZ7hQn6O1OnLJaKnRKS1XF1rkZ8xRCu7xV2p0rJtN' );
define( 'LOGGED_IN_KEY',    'FbHxpmMApnZ6zrXjPJDi07Se1i8AzfRvAvZHT7X7TjgeFT2wf6rnjfpNEYzyC7Fu' );
define( 'NONCE_KEY',        'ANxPJPdqFqWqzNcnjxnR6oNrbDJUeCzKM8qb1pJt47256ysPrT1lWmppClmLuceO' );
define( 'AUTH_SALT',        'xeIcsWttY8inkmG5fKGMazhvx69OlbWHod4awEHXcgkuVYMfzydNsQ7nQ0MK42bL' );
define( 'SECURE_AUTH_SALT', 'BZfQLE8mvqeHaO7fZBcbQf91x7E2gzZzEgueCDrVmQHcqrCasC10DMyK3HFUmKGe' );
define( 'LOGGED_IN_SALT',   'DUspGHV3Y6Kqe3hOh3adm3oEoYoFJKnHuOJMkHZMw5ykwazXoPa3UljMZNVgYJO5' );
define( 'NONCE_SALT',       'Kvk8p4p9y55kQHVCtieZaAQZz8Hs7k7h0lnmODURG1sBrpgYdJCRZEswqLrdYaHa' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


define( 'FS_METHOD', 'direct' );
define( 'DISALLOW_FILE_MODS', false );

define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/wp-content' );
define( 'WP_CONTENT_URL', 'https://' . $_SERVER['HTTP_HOST'] . '/wp-content' );
if ( !defined('WP_CLI') ) {
    define( 'WP_SITEURL', 'https://' . $_SERVER['HTTP_HOST'] );
    define( 'WP_HOME',    'https://' . $_SERVER['HTTP_HOST'] );
}

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

define('WP_ALLOW_REPAIR', true);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/wp' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

define( 'WPMS_ON', true );
define( 'WPMS_SMTP_PASS', $_ENV['WPMS_SMTP_PASS'] );
