<?php defined('SYSPATH') or die('No direct script access.');

DB::query(Database::INSERT, 'CREATE TABLE IF NOT EXISTS 
		`cpages` ( 
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`alias` varchar(250),
			`in_front` varchar(250),
			`weight` int(5),
			`status` int(1),
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8'
)->execute();

// Страницы about, contacts и др.
// Получение адресов существующих страниц, для вставление в параметры роута
$category_info = Model::factory('categories')->getCategory(2, SUBDOMEN);

if($category_info){

	$sql = "SELECT * FROM `contents_categories` cc INNER JOIN `cpages` p ON cc.content_id = p.id WHERE cc.category_id = " . $category_info[0]['id'] . " AND cc.module = 'cpages'";
	$pages = DB::query(Database::SELECT, $sql)
        ->execute();
		
	if (count($pages) > 0) {
		$parameters = '';
		foreach ($pages as $i => $page) {
			if ($i) {
				if ($page['alias'] != '') {
					$parameters .= '|' . $page['alias'] . '|' . $page['id'];
				} else {
					$parameters .= '|' . $page['id'];
				}
			} else {
				if ($page['alias'] != '') {
					$parameters .= $page['alias'] . '|' . $page['id'];
				} else {
					$parameters .= $page['id'];
				}
			}
		}
		
		Route::set('pages', '(<cat>/)<page>', array('cat' => 'cosmetology|epil', 'page' => $parameters))
		->defaults(array(
			'controller' => 'cpages',
			'action' => 'index',
		));
	}
}