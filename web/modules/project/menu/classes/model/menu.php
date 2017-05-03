<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Menu {

    protected $tableName = 'menu';
	protected $tableDesc = 'contents_descriptions';
    protected $tree;
	
    public function __construct() {
        $this->tree = new Tree();
    }
	
    public function getTree($parent_id = 0, $level = 1) {  //Выводим дерево 
        return $this->tree->outMenuTree($parent_id, $level);
    }
	
    public function getNode($id) {
	
        $query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `id` = :id')
                ->param(':id', (int) $id)
                ->execute();
        $result = $query->as_array();
        if (count($result) > 0) {
			$lang_result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module')
                        ->parameters(array(
                            ':content_id' => $id,
							':module' => 'menu',
                        ))->execute();
						
			if(count($lang_result)>0){
				foreach($lang_result as $value){
					$descriptions[$value['lang_id']] = array(
						'title' => htmlspecialchars($value['content_title'], ENT_QUOTES, 'UTF-8', false),
						'teaser' => $value['content_teaser'],
						'body' => '',
					);
				}
			}
			
			$languages = Kohana::$config->load('language');
			foreach($languages as $value){
				if(!isset($descriptions[$value['lang_id']])){
					$descriptions[$value['lang_id']] = array(
						'title' => '',
						'teaser' => '',
						'body' => '',
					);
				}
			}
			
			$content = array(
				'id' => $result[0]['id'],
				'content_id' => $result[0]['content_id'],
				'parent_id' => $result[0]['parent_id'],
				'descriptions' => $descriptions,
				'url' => $result[0]['url'],
				'icon' => $result[0]['icon'],
				'dictionary_id' => $result[0]['dictionary_id'],
				'weight' => $result[0]['weight'],	
				'status' => $result[0]['status'],
				'module' => $result[0]['module'],
			);
			
            return $content;
        } else {
            return false;
        }
    }
    public function getParent($id) {   // Получаем id родителя
        $query = DB::query(Database::SELECT, 'SELECT parent_id FROM `' . $this->tableName . '` WHERE `id` = :id')
                ->param(':id', (int) $id)
                ->execute();
        $result = $query->as_array();
        return $result[0]['parent_id'];
    }
    
    public function get_parent_to_content_id($content_id, $module, $dictionary_id = 1) {   // Получаем id родителя
        $query = DB::query(Database::SELECT, 'SELECT parent_id FROM `' . $this->tableName . '` WHERE `content_id` = :content_id AND `module` = :module AND `dictionary_id` = :dictionary_id')
                ->parameters(array(
                    ':content_id' => $content_id,
                    ':module' => $module,
                    ':dictionary_id' => $dictionary_id,
                ))
                ->execute();
        $result = $query->as_array();
        return $result[0]['parent_id'];
    }
    public function getChildren($parent_id) {   // Получаем детей
        $query = DB::query(Database::SELECT, 'SELECT id FROM `' . $this->tableName . '` WHERE `parent_id` = :parent_id AND `status` = 1')
                ->param(':parent_id', (int) $parent_id)
                ->execute();
        $result = $query->as_array();
        if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->getNode($res['id']);
            }
            return $contents;
        } else {
            return FALSE;
        }
    }
    public function getDictionary($id) {  // Получаем id словаря
        $query = DB::query(Database::SELECT, 'SELECT dictionary_id FROM `' . $this->tableName . '` WHERE `id` = :id')
                ->param(':id', (int) $id)
                ->execute();
        $result = $query->as_array();
        return $result[0]['dictionary_id'];
    }
    public function isDictionary($dictionary_id) {  // Узнаем, есть ли категории в данном словаре
        $query = DB::query(Database::SELECT, 'SELECT COUNT(dictionary_id) AS count FROM `' . $this->tableName . '` WHERE `dictionary_id` = :dictionary_id')
                ->param(':dictionary_id', (int) $dictionary_id)
                ->execute();
        $result = $query->as_array();
        if ($result[0]['count'] > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	public function get_menu_to_dictionary_id($dictionary_id, $parent_id = 0) {  // Выбираем элементы определенного меню
        $result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `dictionary_id` = :dictionary_id AND `parent_id` = :parent_id AND `status` = 1 ORDER BY `weight`')
                ->parameters(array(
                    ':dictionary_id' => $dictionary_id,
					':parent_id' => $parent_id,
                ))
                ->execute();
        if ($result AND count($result)>0) {
			foreach ($result as $res) {
                $contents[] = $this->getNode($res['id']);
            }
            return $contents;
        } else {
            return FALSE;
        }
    }
	
	public function get_img($id) {
        $result = DB::query(Database::SELECT, 'SELECT `icon` FROM `' . $this->tableName . '` WHERE `id` = :id')
                ->parameters(array(
                    ':id' => $id,
                ))
                ->execute();
        if ($result[0]['icon'] != '') {
            return $result[0]['icon'];
        } else {
            return FALSE;
        }
    }
    
    public function get_menu_to_content_id($content_id, $module, $dictionary_id) {  // Узнаем, есть ли элемент меню на данный материал
        $result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `dictionary_id` = :dictionary_id AND `content_id` = :content_id AND `module` = :module')
                ->parameters(array(
                    ':content_id' => $content_id,
                    ':module' => $module,
                    ':dictionary_id' => $dictionary_id,
                ))
                ->execute();
        if ($result) {
			foreach ($result as $res) {
                $contents[] = $this->getNode($res['id']);
            }
            return $contents[0];
        } else {
            return FALSE;
        }
    }
    public function edit($id, $parentId, $data) {
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `parent_id` = :parent, `url` = :url, `weight` = :weight, `dictionary_id` = :dictionary_id, `status` = :status WHERE `id` = :id')
                ->parameters(array(
                    ':parent' => $parentId,
                    ':url' => $data['url'],
                    ':weight' => $data['weight'],
                    ':dictionary_id' => $data['dictionary_id'],
                    ':status' => $data['status'],
                    ':id' => $id,
                ))
                ->execute();
				
		if(isset($data['descriptions'])){
			foreach($data['descriptions'] as $lang_id => $value){
				$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module AND `lang_id` = :lang_id')
                        ->parameters(array(
							':lang_id' => $lang_id,
                            ':content_id' => $id,
							':module' => 'menu',
                        ))->execute();
						
				if(count($result)>0){
					DB::query(Database::UPDATE, 'UPDATE `' . $this->tableDesc . '` SET `content_title` = :content_title, `content_teaser` = :content_teaser, `content_body` = :content_body WHERE `content_id` = :content_id AND `lang_id` = :lang_id AND `module` = :module')
					->parameters(array(
						':content_id' => (int) $id,
						':lang_id' => $lang_id,
						':content_title' => Security::xss_clean($value['title']),
						':content_teaser' => '',
						':content_body' => '',
						':module' => 'menu',
					))
					->execute();
				} else {
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :module)')
						->parameters(array(
							':content_id' => (int) $id,
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => '',
							':content_body' => '',
							':module' => 'menu',
						))
						->execute();
				}				
			}
		}
		return TRUE;
    }
    
    public function edit_to_content_id($data) {
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `url` = :url, `status` = :status WHERE `content_id` = :content_id AND `module` = :module')
                ->parameters(array(
                    ':content_id' => $data['content_id'],
                    ':module' => $data['module'],
                    ':url' => $data['url'],
                    ':status' => $data['status'],
                ))
                ->execute();
				
		if(isset($data['descriptions'])){
			foreach($data['descriptions'] as $lang_id => $value){
				$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module AND `lang_id` = :lang_id')
                        ->parameters(array(
							':lang_id' => $lang_id,
                            ':content_id' => $data['content_id'],
							':module' => 'menu',
                        ))->execute();
						
				if(count($result)>0){
					DB::query(Database::UPDATE, 'UPDATE `' . $this->tableDesc . '` SET `content_title` = :content_title, `content_teaser` = :content_teaser, `content_body` = :content_body WHERE `content_id` = :content_id AND `lang_id` = :lang_id AND `module` = :module')
					->parameters(array(
						':content_id' => $data['content_id'],
						':lang_id' => $lang_id,
						':content_title' => Security::xss_clean($value['title']),
						':content_teaser' => '',
						':content_body' => '',
						':module' => 'menu',
					))
					->execute();
				} else {
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :module)')
						->parameters(array(
							':content_id' => $data['content_id'],
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => '',
							':content_body' => '',
							':module' => 'menu',
						))
						->execute();
				}				
			}
		}
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function editParent($id, $parentId) {
        $query = DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `parent_id` = :parent WHERE `id` = :id')
                ->parameters(array(
                    ':parent' => $parentId,
                    ':id' => $id,
                ))
                ->execute();
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	public function update_img($id, $filename = '') {
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `icon` = :icon WHERE `id` = :id')
                ->parameters(array(
                    ':icon' => $filename,
                    ':id' => $id,
                ))
                ->execute();
		return TRUE;
    }
    
    public function edit_parent_to_content_id($content_id, $parentId, $module,  $dictionary_id = 1) {
        $query = DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `parent_id` = :parent WHERE `content_id` = :content_id AND `module` = :module AND `dictionary_id` = :dictionary_id')
                ->parameters(array(
                    ':parent' => $parentId,
                    ':content_id' => $content_id,
                    ':module' => $module,
                    ':dictionary_id' => $dictionary_id,
                ))
                ->execute();
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function editChild($id, $dictionary_id) {
        $query = DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `dictionary_id` = :dictionary_id WHERE `id` = :id')
                ->parameters(array(
                    ':dictionary_id' => $dictionary_id,
                    ':id' => $id,
                ))
                ->execute();
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function add($parentId, $data = array()) {
        DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (content_id, module, parent_id, url, dictionary_id, weight, status) VALUES (:content_id, :module, :parent_id, :url, :dictionary_id, :weight, :status)')
                ->parameters(array(
                    ':parent_id' => $parentId,
                    ':content_id' => $data['content_id'],
                    ':module' => $data['module'],
                    ':url' => $data['url'],
                    ':weight' => $data['weight'],
                    ':dictionary_id' => $data['dictionary_id'],
                    ':status' => 1,
                ))
                ->execute();
				
        $query = DB::query(Database::SELECT, 'SELECT id FROM `' . $this->tableName . '` WHERE `dictionary_id` = :dictionary_id AND `url` = :url')
                    ->parameters(array(
                        ':url' => $data['url'],
                        ':dictionary_id' => $data['dictionary_id'],
                    ))
                    ->execute();
        $result = $query->as_array();
		
        if (count($result)>0) {			
			if(isset($data['descriptions'])){
				foreach($data['descriptions'] as $lang_id => $value){
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :module)')
						->parameters(array(
							':content_id' => (int) $result[0]['id'],
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => '',
							':content_body' => '',
							':module' => 'menu',
						))
						->execute();
				}
			}
            return $result[0]['id'];
        } else {
            return FALSE;
        }
    }
    public function delete($id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
                ->param(':id', (int) $id)
                ->execute();
				
		DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableDesc . ' WHERE `content_id` = :id AND `module` = :module')
                ->parameters(array(
					':id' => $id,
					':module' => 'menu',
                ))
                ->execute();
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function delete_to_content_id($id, $module) {
        
        $query = DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `content_id` = :content_id AND `module` = :module')
                ->parameters(array(
                    ':content_id' => $id,
                    ':module' => $module,
                ))
                ->execute();
				
		DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableDesc . ' WHERE `content_id` = :id AND `module` = :module')
                ->parameters(array(
					':id' => $id,
					':module' => 'menu',
                ))
                ->execute();
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}