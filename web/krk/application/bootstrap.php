<?php
defined('SYSPATH') or die('No direct script access.');
// -- Environment setup --------------------------------------------------------
// Load the core Kohana class
require SYSPATH . 'classes/kohana/core' . EXT;
if (is_file(APPPATH . 'classes/kohana' . EXT)) {
    // Application extends the core
    require APPPATH . 'classes/kohana' . EXT;
} else {
    // Load empty core extension
    require SYSPATH . 'classes/kohana' . EXT;
}

define('FULLURL', Kohana::getFullUrl());  // Полный путь включая http:// ..... и т.д.
define('PARENT_FULLURL', 'http://newelix.loc');  // Полный путь родительского домена включая http:// ..... и т.д.
define('SCHEME', Kohana::getScheme());
define('HOST', Kohana::getHost()); 
define('SUBDOMEN', Kohana::getSubdomen());  // Например omsk. ... .com
define('PARENT_HOST', 'newelix.loc');  // Родительский домен

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('Asia/Novosibirsk');
/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');
/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));
/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');
// -- Configuration and initialization -----------------------------------------
/**
 * Set the default language
 */
I18n::lang('ru-ru');
/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *  PRODUCTION  - Готовый продукт
 *  STAGING     - Подготовка
 * 	TESTING     - Тестирование
 * 	DEVELOPMENT - Разработка
 * 	
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
Kohana::$environment = Kohana::DEVELOPMENT;
if (isset($_SERVER['KOHANA_ENV'])) {
    Kohana::$environment = constant('Kohana::' . strtoupper($_SERVER['KOHANA_ENV']));
}
/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
    'base_url' => '/',
    'index_file' => FALSE
));
/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH . 'logs'));
/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(

    /********************* Системные модули ***********************/
	'cache' => MODPATH_SYS . 'cache', // Caching with multiple backends
    'database' => MODPATH_SYS . 'database', // Database access
    'image' => MODPATH_SYS . 'image', // Image manipulation
	'captcha' => MODPATH_SYS . 'captcha', // Модуль Каптча
    'email' => MODPATH_SYS . 'email', // Email
    'purifier' => MODPATH_SYS . 'purifier', // Protection against XSS attacks
	
	'user' => MODPATH_SYS . 'user', // Модуль Пользователи
	'siteinfo' => MODPATH_SYS . 'siteinfo', // Модуль Общая информация о сайте
	'categories' => MODPATH_SYS . 'categories', // Модуль Категории
	'language' => MODPATH_SYS . 'language', // Модуль Локализации
	'pagination' => MODPATH_SYS . 'pagination', // Модуль Pagination
	'template' => MODPATH_SYS . 'template', // Модуль Шаблонизации
	'error' => MODPATH_SYS . 'error', // Модуль Страница ошибок
	'multiaction' => MODPATH_SYS . 'multiaction', // Модуль Массовые операции
	'answer' => MODPATH_SYS . 'answer', // Модуль Ответная страница
	'front' => MODPATH_SYS . 'front', // Модуль Главная страница
	
    /********************* Модули проекта *************************/
	
	'address' => MODPATH_PROJECT . 'address', // Модуль Адреса 
	'cpages' => MODPATH_PROJECT . 'cpages', // Модуль Страницы 
	'files' => MODPATH_PROJECT . 'files', // Модуль Файлы 
	'modulinfo' => MODPATH_PROJECT . 'modulinfo', // Модуль Общая инфа модуля
	'feedback' => MODPATH_PROJECT . 'feedback', // Модуль Обратная связь
	'filials' => MODPATH_PROJECT . 'filials', // Модуль выбора филиала в мультисайтовом варианте
	
    'menu' => MODPATH_PROJECT . 'menu', // Модуль Меню  
	'articles'   => MODPATH_PROJECT.'articles',   // Модуль статей

	'services'   => MODPATH_PROJECT.'services',   // Модуль Услуги	
	
	'actions'   => MODPATH_PROJECT.'actions',   // Модуль Акции
    'reviews'   => MODPATH_PROJECT.'reviews',   // Модуль Отзывы
	'faq'   => MODPATH_PROJECT.'faq',   // Модуль Вопрос - Ответ
	'infoblock'   => MODPATH_PROJECT.'infoblock',   // Модуль Инфоблоки
	'infoblock2'   => MODPATH_PROJECT.'infoblock2',   // Модуль Позиционируемые инфоблоки
	'specials'   => MODPATH_PROJECT.'specials',   // Модуль Специалисты
	'photos'   => MODPATH_PROJECT.'photos',   // Модуль Фотогалерея
	'sertifications'   => MODPATH_PROJECT.'sertifications',   // Модуль Подарочные Сертификаты
    'tags' => MODPATH_PROJECT . 'tags', // Модуль тегов    
	'liteedit'   => MODPATH_PROJECT.'liteedit',   // Модуль быстрого редактирования контента на сайте
	'breadcrumbs' => MODPATH_PROJECT.'breadcrumbs',   // Модуль "Хлебные крошки"
	'seo' => MODPATH_PROJECT . 'seo', // Модуль SEO
	'comments' => MODPATH_PROJECT . 'comments', // Модуль Комментарии
	'related' => MODPATH_PROJECT . 'related', // Модуль Похожие материалы
	'partners' => MODPATH_PROJECT . 'partners', // Модуль Контакты
	'payment' => MODPATH_PROJECT . 'payment', // Модуль Онлайн Оплаты
	'orders' => MODPATH_PROJECT . 'orders', // Модуль Заказы
	
	'banners' => MODPATH_PROJECT . 'banners', // Модуль Баннеры
));
/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

// Ответы (answers)

Route::set('answer', 'answer')
->defaults(array(
	'controller' => 'answer',
	'action' => 'answer',
));

// Обработка траницы ошибок
		
Route::set('error', 'error/<code>(/<message>)', array('code' => '[0-9]++', 'message' => '.+'))
->defaults(array(
	'controller' => 'error',
	'action' => 'index',
));

// Главная с параметром категории
		
Route::set('cat_front', '<cat>', array('cat' => 'cosmetology|epil'))
->defaults(array(
	'controller' => 'front',
	'action' => 'index',
));

// По умолчанию - на главную
		
Route::set('default', '(<controller>(/<action>(/<id>)))')
->defaults(array(
	'controller' => 'front',
	'action' => 'index',
));