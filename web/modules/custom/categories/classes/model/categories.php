<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Categories {
	
    protected $tableName = 'categories';
	protected $tableDesc = 'contents_descriptions';
	protected $tableName2 = 'contents_categories';
    protected $tableName3 = 'contents_files';
    protected $tree;
	
    public function __construct() {
        $this->tree = new Tree();
    }
	
    public function getTree($parent_id = 0, $level = 1) {
        return $this->tree->outTree($parent_id, $level);
    }
	
	public function delete_category_by_content($content_id, $module = 'products') {
        DB::query(Database::DELETE, 'DELETE FROM `' . $this->tableName2 . '` WHERE `content_id` = :id AND `module` = :module')
                ->parameters(array(
                    ':id' => (int) $content_id,
                    ':module' => $module,
                ))
                ->execute();
		return true;
    }
	
	public function add_category_by_content($content_id, $cat_id, $module = 'products') {
        DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName2 . ' (category_id, content_id, module) VALUES (:category_id, :content_id, :module)')
				->parameters(array(
					':category_id' => $cat_id,
					':content_id' => $content_id,
					':module' => $module,
				))
				->execute();
		return true;
    }
	
	public function get_category_by_content($content_id, $module = 'products') {
        return  DB::query(Database::SELECT, 'SELECT category_id FROM `' . $this->tableName2 . '` WHERE `content_id` = :id AND `module` = :module')
                        ->parameters(array(
                            ':id' => (int) $content_id,
                            ':module' => $module,
                        ))->execute();
    }
	
    public function getNode($id) {
	
		$filename = false;
		
        $query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `id` = :id')
                ->param(':id', (int) $id)
                ->execute();
        $result = $query->as_array();
		
        if (count($result) > 0) {
			$lang_result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module')
                        ->parameters(array(
                            ':content_id' => $id,
							':module' => 'categories',
                        ))->execute();
						
			if(count($lang_result)>0){
				foreach($lang_result as $value){
					$descriptions[$value['lang_id']] = array(
						'title' => $value['content_title'],
						'teaser' => $value['content_teaser'],
						'body' => $value['content_body'],
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
			
			$file_obj = new Model_File();
			$files = $file_obj->get_files_by_content_id($id, 'categories');
			if (!empty($files)) {
				$filename = $files[0]['file']->filepathname;
			}
			
			$content = array(
				'id' => $result[0]['id'],
				'parent_id' => $result[0]['parent_id'],
				'descriptions' => $descriptions,
				'alias' => $result[0]['alias'],
				'dictionary_id' => $result[0]['dictionary_id'],
				'weight' => $result[0]['weight'],
				'thumb' => $filename,			
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
	
    public function getChildren($parent_id) {   // Получаем id и name детей
		$contents = array();
        $query = DB::query(Database::SELECT, 'SELECT id FROM `' . $this->tableName . '` WHERE `parent_id` = :parent_id')
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
	
    public function getCategory($dictionary_id = 0, $alias) {
        if ($dictionary_id) {
            $query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `dictionary_id` = :dictionary_id AND `alias` = :alias')
                    ->parameters(array(
                        ':dictionary_id' => $dictionary_id,
                        ':alias' => $alias,
                    ))
                    ->execute();
        } else {
            $query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `alias` = :alias')
                    ->parameters(array(
                        ':alias' => $alias,
                    ))
                    ->execute();
        }
        $result = $query->as_array();
        if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->getNode($res['id']);
            }
            return $contents;
        } else {
            return false;
        }
    }
	
    /*
      $mode = 0 Родительская категория соответствует заявленой в параметре,
      $mode = 1 Родительская категория не соответствует заявленой в параметре,
      $mode = (любое другое значение, например 2) Родительская категория не участвует в выборке результата,
     */
    public function getCategories($dictionary_id, $parent_id = 0, $mode = 1) {
        if ($mode == 1) {
            $query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `dictionary_id` = :dictionary_id AND `parent_id` != :parent_id ORDER BY weight')
                    ->parameters(array(
                        ':parent_id' => $parent_id,
                        ':dictionary_id' => $dictionary_id,
                    ))
                    ->execute();
        } elseif ($mode == 0) {
            $query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `dictionary_id` = :dictionary_id AND `parent_id` = :parent_id ORDER BY weight')
                    ->parameters(array(
                        ':parent_id' => $parent_id,
                        ':dictionary_id' => $dictionary_id,
                    ))
                    ->execute();
        } else {
            $query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `dictionary_id` = :dictionary_id ORDER BY weight')
                    ->parameters(array(
                        ':dictionary_id' => $dictionary_id,
                    ))
                    ->execute();
        }
        $result = $query->as_array();
        if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->getNode($res['id']);
            }
            return $contents;
        } else {
            return false;
        }
    }
	
    public function catEdit($id, $parentId, $data) {
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `parent_id` = :parent, `alias` = :alias, `weight` = :weight, `dictionary_id` = :dictionary_id WHERE `id` = :id')
                ->parameters(array(
                    ':parent' => $parentId,
                    ':alias' => $data['alias'],
                    ':weight' => $data['weight'],
                    ':dictionary_id' => $data['dictionary_id'],
                    ':id' => $id,
                ))
                ->execute();
				
		if(isset($data['descriptions'])){
			foreach($data['descriptions'] as $lang_id => $value){
				$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module AND `lang_id` = :lang_id')
                        ->parameters(array(
							':lang_id' => $lang_id,
                            ':content_id' => $id,
							':module' => 'categories',
                        ))->execute();
						
				if(count($result)>0){
					DB::query(Database::UPDATE, 'UPDATE `' . $this->tableDesc . '` SET `content_title` = :content_title, `content_teaser` = :content_teaser, `content_body` = :content_body WHERE `content_id` = :content_id AND `lang_id` = :lang_id AND `module` = :module')
					->parameters(array(
						':content_id' => (int) $id,
						':lang_id' => $lang_id,
						':content_title' => Security::xss_clean($value['title']),
						':content_teaser' => '',
						':content_body' => Security::xss_clean($value['body']),
						':module' => 'categories',
					))
					->execute();
				} else {
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :module)')
						->parameters(array(
							':content_id' => (int) $id,
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => '',
							':content_body' => Security::xss_clean($value['body']),
							':module' => 'categories',
						))
						->execute();
				}				
			}
		}
		return TRUE; 
    }
	
    public function catEditParent($id, $parentId) {
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
	
    public function catEditChild($id, $dictionary_id) {
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
	
    public function catInsert($parentId, $data = array()) {
        DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (parent_id, alias, dictionary_id, weight) VALUES (:parent_id, :alias, :dictionary_id, :weight)')
                ->parameters(array(
                    ':parent_id' => $parentId,                   
                    ':alias' => $data['alias'],
                    ':weight' => $data['weight'],
                    ':dictionary_id' => $data['dictionary_id']
                ))
                ->execute();
        
        $result = DB::query(Database::SELECT, 'SELECT id FROM `' . $this->tableName . '` WHERE `dictionary_id` = :dictionary_id AND `alias` = :alias')
                    ->parameters(array(
                        ':alias' => $data['alias'],
                        ':dictionary_id' => $data['dictionary_id'],
                    ))
                    ->execute();
        
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
							':module' => 'categories',
						))
						->execute();
				}
			}
            return $result[0]['id'];
        } else {
            return FALSE;
        }
    }
	
    public function catDelete($id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
                ->param(':id', (int) $id)
                ->execute();
				
		DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableDesc . ' WHERE `content_id` = :id AND `module` = :module')
                ->parameters(array(
					':id' => $id,
					':module' => 'categories',
                ))
                ->execute();
        $query3 = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName3 . '` WHERE `content_id` = :id AND `module` = :module')
                ->parameters(array(
                    ':id' => (int) $id,
                    ':module' => 'categories',
                ))
                ->execute();
        $result3 = $query3->as_array();
        if (count($result3) > 0) {
            $delfile = new Model_File();
            foreach ($result3 as $res) {
                $delfile->delete($res['file_id'], $id, 'categories');
            }
        }
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}