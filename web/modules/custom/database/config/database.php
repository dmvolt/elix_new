<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'default' => array
	(
			'type'       => 'MySQLi',
			'connection' => array(
			
					/* 'hostname'   => 'localhost',
					'database'   => 'elixepil_newelix',
					'username'   => 'elixepil_newelix',
					'password'   => 'rk]LyKqdt=GC', */
					
					'hostname'   => 'localhost',
					'database'   => 'new_elix_db',
					'username'   => 'dimasic',
					'password'   => '12345',
					'port'       => NULL,
					'socket'     => NULL
			),
			'table_prefix' => '',
			'charset'      => 'utf8',
			'caching'      => FALSE,
	),
	'alternate' => array(
		'type'       => 'pdo',
		'connection' => array(
			/**
			 * The following options are available for PDO:
			 *
			 * string   dsn         Data Source Name
			 * string   username    database username
			 * string   password    database password
			 * boolean  persistent  use persistent connections?
			 */
			'dsn'        => 'mysql:host=localhost;dbname=koh_db',
			'username'   => 'dimasic77',
			'password'   => '12345',
			'persistent' => FALSE,
		),
		/**
		 * The following extra options are available for PDO:
		 *
		 * string   identifier  set the escaping identifier
		 */
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),
);