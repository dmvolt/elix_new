<?php
/**
 * The directory in which your application specific resources are located.
 * The application directory must contain the bootstrap.php file.
 *
 * @see  http://kohanaframework.org/guide/about.install#application
 */
$application = 'application';
/**
 * The directory in which your modules are located.
 *
 * @see  http://kohanaframework.org/guide/about.install#modules
 */
$modules1 = 'modules/custom';
$modules2 = 'modules/project';
/**
 * The directory in which the Kohana resources are located. The system
 * directory must contain the classes/kohana.php file.
 *
 * @see  http://kohanaframework.org/guide/about.install#system
 */
$system = 'system';
/**
 * The default extension of resource files. If you change this, all resources
 * must be renamed to use the new extension.
 *
 * @see  http://kohanaframework.org/guide/about.install#ext
 */
define('EXT', '.php');

define('FILIAL', 'Красноярск');
/**
 * Set the PHP error reporting level. If you set this in php.ini, you remove this.
 * @see  http://php.net/error_reporting
 *
 * When developing your application, it is highly recommended to enable notices
 * and strict warnings. Enable them by using: E_ALL | E_STRICT
 *
 * In a production environment, it is safe to ignore notices and strict warnings.
 * Disable them by using: E_ALL ^ E_NOTICE
 *
 * When using a legacy application with PHP >= 5.3, it is recommended to disable
 * deprecated notices. Disable with: E_ALL & ~E_DEPRECATED
 */
error_reporting(E_ALL | E_STRICT);
/**
 * End of standard configuration! Changing any of the code below should only be
 * attempted by those with a working knowledge of Kohana internals.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 */
// Set the full path to the docroot
define('DOCROOT', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
define('PARENT_DOCROOT', '../');
define('ALL_DOCROOT', '../');

// Make the application relative to the docroot, for symlink'd index.php
if ( ! is_dir($application) AND is_dir(DOCROOT.$application))
	$application = DOCROOT.$application;
// Make the modules relative to the docroot, for symlink'd index.php
if ( ! is_dir($modules1) AND is_dir(PARENT_DOCROOT.$modules1))
	//$modules1 = DOCROOT.$modules1;
	$modules1 = PARENT_DOCROOT.$modules1;
	
// Make the modules relative to the docroot, for symlink'd index.php
if ( ! is_dir($modules2) AND is_dir(PARENT_DOCROOT.$modules2))
	//$modules2 = DOCROOT.$modules2;
	$modules2 = PARENT_DOCROOT.$modules2;
	
// Make the system relative to the docroot, for symlink'd index.php
if ( ! is_dir($system) AND is_dir(PARENT_DOCROOT.$system))
	//$system = DOCROOT.$system;
	$system = PARENT_DOCROOT.$system;
	
// Define the absolute paths for configured directories
define('APPPATH', realpath($application).DIRECTORY_SEPARATOR);
define('MODPATH_SYS', realpath($modules1).DIRECTORY_SEPARATOR);
define('MODPATH_PROJECT', realpath($modules2).DIRECTORY_SEPARATOR);
define('SYSPATH', realpath($system).DIRECTORY_SEPARATOR);

// Clean up the configuration vars
unset($application, $modules1, $modules2, $system);
if (file_exists('install'.EXT))
{
	// Load the installation check
	return include 'install'.EXT;
}
/**
 * Define the start time of the application, used for profiling.
 */
if ( ! defined('KOHANA_START_TIME'))
{
	define('KOHANA_START_TIME', microtime(TRUE));
}
/**
 * Define the memory usage at the start of the application, used for profiling.
 */
if ( ! defined('KOHANA_START_MEMORY'))
{
	define('KOHANA_START_MEMORY', memory_get_usage());
}
// Bootstrap the application
require APPPATH.'bootstrap'.EXT;
/**
 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
 * If no source is specified, the URI will be automatically detected.
 */
echo Request::factory()
	->execute()
	->send_headers()
	->body();