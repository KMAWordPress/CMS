<?php
/**
 * Основные параметры WordPress.
 *
 * Этот файл содержит следующие параметры: настройки MySQL, префикс таблиц,
 * секретные ключи, язык WordPress и ABSPATH. Дополнительную информацию можно найти
 * на странице {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Кодекса. Настройки MySQL можно узнать у хостинг-провайдера.
 *
 * Этот файл используется сценарием создания wp-config.php в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать этот файл
 * с именем "wp-config.php" и заполнить значения.
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'kma_wp');

/** Имя пользователя MySQL */
define('DB_USER', 'kma_wp');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'kma_wp');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется снова авторизоваться.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'F~ZES!$d^8_j!Yj{BvnYf,~ubDdXhOeEBp_ <k%1uluv^t4qtRsjt1{+y|g78-4&');
define('SECURE_AUTH_KEY',  '_*(.6Gf2NuFK9r+q2-tK_/XK9p%D PV+Y-(?mxy]+++rp0/>yA`_3C$AiO6[0@|h');
define('LOGGED_IN_KEY',    'HU7%,jfzPLjO&;t59-+;,J;1neQR30Af^1/YcxuSZIHJtp*a q(.f>E^,#O+Ev?6');
define('NONCE_KEY',        'xKt=>8VUJ@DVEPcJq-^O:n.Tp}1uK7x6:f+RxpX9BDY?`Ob(<VZo<>PXoW+N]wx&');
define('AUTH_SALT',        'C$-zlY&H7|)24r_=}b@TCk1{^N{;hKDbi-4-~bjLi99M^N2)>k2/M@*D]7<.lyY1');
define('SECURE_AUTH_SALT', 'D.MZ6)JsKhgc63SA:-F(,LLl=5}@f=M#.c &=7K|^nDK^&Hsi{o`wI)yM!zGSQxJ');
define('LOGGED_IN_SALT',   '8LlxgxvC.X:[G;xch+&X!FR<m:Jpfxd`*$/_Xd+p;[@1y]QdC|t>(,3(C5Ze7>J`');
define('NONCE_SALT',       'k|c$s|9~,y<Xi+f})njZ.cq5fKZ]+JR&VddP&KPu8AVq:}axUF(>4!Gq|[N97]OV');


/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько блогов в одну базу данных, если вы будете использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Язык локализации WordPress, по умолчанию английский.
 *
 * Измените этот параметр, чтобы настроить локализацию. Соответствующий MO-файл
 * для выбранного языка должен быть установлен в wp-content/languages. Например,
 * чтобы включить поддержку русского языка, скопируйте ru_RU.mo в wp-content/languages
 * и присвойте WPLANG значение 'ru_RU'.
 */
define('WPLANG', 'ru_RU');

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Настоятельно рекомендуется, чтобы разработчики плагинов и тем использовали WP_DEBUG
 * в своём рабочем окружении.
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');

if(is_admin()) {
 add_filter('filesystem_method', create_function('$a', 'return "direct";' ));
 define( 'FS_CHMOD_DIR', 0751 );
}