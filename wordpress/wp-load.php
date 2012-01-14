<?php
/**
 * Bootstrap file for setting the ABSPATH constant
 * and loading the wp-config.php file. The wp-config.php
 * file will then load the wp-settings.php file, which
 * will then set up the WordPress environment.
 *
 * If the wp-config.php file is not found then an error
 * will be displayed asking the visitor to set up the
 * wp-config.php file.
 *
 * Will also search for wp-config.php in WordPress' parent
 * directory to allow the WordPress directory to remain
 * untouched.
 *
 * @internal This file must be parsable by PHP4.
 *
 * @package WordPress
 */

/** Define ABSPATH as this files directory */
define( 'ABSPATH', dirname(__FILE__) . '/' );

error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );

if ( file_exists( ABSPATH . 'wp-config.php') ) {

	/** The config file resides in ABSPATH */
	require_once( ABSPATH . 'wp-config.php' );

} elseif ( file_exists( dirname(ABSPATH) . '/wp-config.php' ) && ! file_exists( dirname(ABSPATH) . '/wp-settings.php' ) ) {

	/** The config file resides one level above ABSPATH but is not part of another install*/
	require_once( dirname(ABSPATH) . '/wp-config.php' );

} else {

	// A config file doesn't exist

	// Set a path for the link to the installer
	if ( strpos($_SERVER['PHP_SELF'], 'wp-admin') !== false )
		$path = '';
	else
		$path = 'wp-admin/';

	require_once( ABSPATH . '/wp-includes/load.php' );
	require_once( ABSPATH . '/wp-includes/version.php' );
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
	wp_check_php_mysql_versions();

	// Die with an error message
	require_once( ABSPATH . '/wp-includes/class-wp-error.php' );
	require_once( ABSPATH . '/wp-includes/functions.php' );
	require_once( ABSPATH . '/wp-includes/plugin.php' );
	$text_direction = /*WP_I18N_TEXT_DIRECTION*/'ltr'/*/WP_I18N_TEXT_DIRECTION*/;
	wp_die(sprintf(/*WP_I18N_NO_CONFIG*/'<p>Кажется, файл <code>wp-config.php</code> отсутствует. Перед началом потребуется создать его.</p> <p>Нужна помощь? <a href=\'http://codex.wordpress.org/Редактирование_wp-config.php\'>Пожалуйста</a>.</p> <p>Можно создать файл <code>wp-config.php</code> через веб-интерфейс, но это работает не на всех серверах. Наиболее надёжный способ &#8212; создать файл вручную.</p><p><a href=\'%ssetup-config.php\' class=\'button\'>Создать файл настроек</a></p>'/*/WP_I18N_NO_CONFIG*/, $path), /*WP_I18N_ERROR_TITLE*/'WordPress &rsaquo; Ошибка'/*/WP_I18N_ERROR_TITLE*/, array('text_direction' => $text_direction));

}

?>