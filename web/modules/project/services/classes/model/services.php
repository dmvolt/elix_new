<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Services {

    protected $tableName = 'services';
	protected $tableDesc = 'contents_descriptions';
    protected $tableName2 = 'contents_categories';
    protected $tableName3 = 'contents_files';
    protected $session;
	
    public function __construct() {
        $this->session = Session::instance();
    }
	
    public function add($data = array()) {
	
        $result = DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (price, parent_id, alias, `date`, weight, status) VALUES (:price, :parent_id, :alias, :date, :weight, :status)')
                ->parameters(array(
                    ':parent_id' => $data['parent_id'],
					':alias' => Security::xss_clean($data['alias']),					
					':date' => Security::xss_clean($data['date']), 		
					':price' => Security::xss_clean($data['price']), 
                    ':weight' => Security::xss_clean($data['weight']),
                    ':status' => Security::xss_clean($data['status'])
                ))
                ->execute();
        
        if ($result) {
            if(isset($data['descriptions'])){
				foreach($data['descriptions'] as $lang_id => $value){
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :module)')
						->parameters(array(
							':content_id' => (int) $result[0],
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => $value['teaser'],
							':content_body' => $value['body'],
							':module' => 'services',
						))
						->execute();
				}
			}
			return $result[0];
        } else {
            return FALSE;
        }
    }
	
    public function edit($Id, $data = array()) {
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `price` = :price, `parent_id` = :parent_id, `alias` = :alias, `date` = :date, `weight` = :weight, `status` = :status WHERE `id` = :id')
                ->parameters(array(
                    ':id' => $Id,  
					':parent_id' => $data['parent_id'],
                    ':alias' => Security::xss_clean($data['alias']), 
					':date' => Security::xss_clean($data['date']),
					':price' => Security::xss_clean($data['price']), 
                    ':weight' => Security::xss_clean($data['weight']), 
                    ':status' => Security::xss_clean($data['status'])
                ))
                ->execute();
				
		if(isset($data['descriptions'])){
			foreach($data['descriptions'] as $lang_id => $value){
				$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module AND `lang_id` = :lang_id')
                        ->parameters(array(
							':lang_id' => $lang_id,
                            ':content_id' => $Id,
							':module' => 'services',
                        ))->execute();
						
				if(count($result)>0){
					DB::query(Database::UPDATE, 'UPDATE `' . $this->tableDesc . '` SET `content_title` = :content_title, `content_teaser` = :content_teaser, `content_body` = :content_body WHERE `content_id` = :content_id AND `lang_id` = :lang_id AND `module` = :module')
					->parameters(array(
						':content_id' => (int) $Id,
						':lang_id' => $lang_id,
						':content_title' => Security::xss_clean($value['title']),
						':content_teaser' => $value['teaser'],
						':content_body' => $value['body'],
						':module' => 'services',
					))
					->execute();
				} else {
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :module)')
						->parameters(array(
							':content_id' => (int) $Id,
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => $value['teaser'],
							':content_body' => $value['body'],
							':module' => 'services',
						))
						->execute();
				}				
			}
		}
        return TRUE;
    }
	
    public function delete($id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
                ->param(':id', (int) $id)
                ->execute();
				
        DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableDesc . ' WHERE `content_id` = :id AND `module` = :module')
                ->parameters(array(
					':id' => $id,
					':module' => 'services',
                ))
                ->execute();
		if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	public function delete_by_content($content_id, $module = 'products') {
        DB::query(Database::DELETE, 'DELETE FROM `contents_services` WHERE `content_id` = :id AND `module` = :module')
                ->parameters(array(
                    ':id' => (int) $content_id,
                    ':module' => $module,
                ))
                ->execute();
		return true;
    }
	
	public function add_by_content($content_id, $cat_id, $module = 'products') {
        DB::query(Database::INSERT, 'INSERT INTO `contents_services` (service_id, content_id, module) VALUES (:service_id, :content_id, :module)')
				->parameters(array(
					':service_id' => $cat_id,
					':content_id' => $content_id,
					':module' => $module,
				))
				->execute();
		return true;
    }
	
    public function get_all($is_adminka = 0, $start = 0, $num = 100, $field = 'a.id', $inner_join = '', $filter = '', $lang_id = 1) {
		$contents = array();
        if ($is_adminka) {
            $sql = "SELECT * FROM " . $this->tableName . " a INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = a.id " . $inner_join . " WHERE cd.lang_id = :lang_id AND cd.module = :module " . $filter . " ORDER BY a.weight, :field DESC LIMIT :start, :num";
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " a INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = a.id " . $inner_join . " WHERE cd.lang_id = :lang_id AND cd.module = :module AND a.status = 1 " . $filter . " ORDER BY a.weight, :field DESC LIMIT :start, :num";
        } 
        $result = DB::query(Database::SELECT, $sql)
                ->parameters(array(
                    ':field' => $field, 
                    ':start' => (int) $start, 
                    ':num' => (int) $num,
					':lang_id' => $lang_id,
					':module' => 'services',
                    ))
                ->execute();
				
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;
    }
	
	public function get_parent_all($is_adminka = 0, $start = 0, $num = 100, $field = 'a.id', $inner_join = '', $filter = '', $parent_id = 0, $lang_id = 1) {
		$contents = array();
        if ($is_adminka) {
            $sql = "SELECT * FROM " . $this->tableName . " a INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = a.id " . $inner_join . " WHERE cd.lang_id = :lang_id AND cd.module = :module AND a.parent_id = ".$parent_id." " . $filter . " ORDER BY a.weight, :field DESC LIMIT :start, :num";
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " a INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = a.id " . $inner_join . " WHERE cd.lang_id = :lang_id AND cd.module = :module AND a.status = 1 AND a.parent_id = ".$parent_id." " . $filter . " ORDER BY a.weight, :field DESC LIMIT :start, :num";
        } 
        $result = DB::query(Database::SELECT, $sql)
                ->parameters(array(
                    ':field' => $field, 
                    ':start' => (int) $start, 
                    ':num' => (int) $num,
					':lang_id' => $lang_id,
					':module' => 'services',
                    ))
                ->execute();
				
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;
    }
	
	public function get_parent_and_children($parent_id = 0) {
		$contents = array();
        
        $sql = "SELECT * FROM " . $this->tableName . " WHERE parent_id = ".$parent_id." ORDER BY weight";
        
        $result = DB::query(Database::SELECT, $sql)->execute();
				
		if ($result AND count($result) > 0) {
            foreach ($result as $res) {
				$children = $this->get_parent_and_children($res['id']);
				$contents[] = array(
					'service' => $this->get_content_lite($res),
					'children' => $children,
				);
            }
			return $contents;
        } else {
			return false;
		}
    }
	
    public function get_all_to_cat($cat, $start = 0, $num = 100, $field = 'a.weight', $lang_id = 1) {
        $contents = array();
        $query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName2 . '` cc INNER JOIN ' . $this->tableName . ' a ON cc.content_id = a.id  WHERE cc.category_id = :category_id AND cc.module = :module ORDER BY ' . $field . ' LIMIT :start, :num')
                ->parameters(array(
                    ':category_id' => $cat, 
                    ':module' => 'services',
                    ':start' => (int) $start, 
                    ':num' => (int) $num,
                    ))->execute();
					
        $result = $query->as_array();
        if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;
    }
	
	public function get_autocomplete_content($filter_name, $lang_id = 1, $group_id = 1) {
        $query = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableDesc . " WHERE module = 'services' AND lang_id = :lang_id AND content_title LIKE '%" . $filter_name . "%' ORDER BY content_title LIMIT 0, 50")
                ->parameters(array(
                    ':lang_id' => $lang_id,
                ))->execute();

        if (count($query) > 0) {
			foreach($query as $value){
				$result[] = array(
					'name' => $value['content_title'],
					'id' => $value['content_id'],
				);
			}
			return $result;
        } else {
			return array();
		}
    }
	
	public function get_tree($parent_id = 0) {	
		$contents = array();		
        $result = DB::query(Database::SELECT, "SELECT id FROM " . $this->tableName . " WHERE `status` = 1 AND `parent_id` = ".$parent_id." ORDER BY `weight`")
					->execute();
		
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;		
    }
	
	public function get_last($num = 4) {	
		$contents = array();		
        $result = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `status` = 1 ORDER BY `weight` DESC LIMIT 0, ".$num)
					->execute();
		
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;		
    }
	
	public function get_content_id_by_alias($alias = '') {
	
		$sql = "SELECT id FROM " . $this->tableName . " WHERE `alias` = :alias";
		$query = DB::query(Database::SELECT, $sql, FALSE)
				->param(':alias', $id)
				->execute();
		
        $result = $query->as_array();
		
        if (count($result)>0){
			return $result[0]['id'];
		} else {
			return 0;
		}    
    }
	
    public function get_content($id = '') {
	
        if (is_numeric($id)) {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE `id` = :id";
            $query = DB::query(Database::SELECT, $sql, FALSE)
                    ->param(':id', (int) $id)
                    ->execute();
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE `alias` = :alias";
            $query = DB::query(Database::SELECT, $sql, FALSE)
                    ->param(':alias', $id)
                    ->execute();
        }
		
        $result = $query->as_array();
		
        if (count($result)>0){
            $lang_result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module')
                        ->parameters(array(
                            ':content_id' => $result[0]['id'],
							':module' => 'services',
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
			$files = $file_obj->get_files_by_content_id($result[0]['id'], 'services');
			if (empty($files)) {
				$filename = false;
			} else {
				$filename = $files[0]['file']->filepathname;
			}
			
			$edit_interface = Liteedit::get_interface($result[0]['id'], 'services', 'teaser', true);
			
			$contents = array(
				'id' => $result[0]['id'],
				'parent_id' => $result[0]['parent_id'],
				'descriptions' => $descriptions,
				'date' => $result[0]['date'],
				'alias' => $result[0]['alias'],	
				'price' => $result[0]['price'], 				
				'weight' => $result[0]['weight'],			
				'status' => $result[0]['status'],
				'thumb' => $filename,
				'images' => $files,
				'edit_interface' => $edit_interface,
			);
			return $contents;
		} else {
			return FALSE;
		}    
    }
	
	public function get_content_lite($result) {
	
		$lang_result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module')
					->parameters(array(
						':content_id' => $result['id'],
						':module' => 'services',
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
		
		$contents = array(
			'id' => $result['id'],
			'parent_id' => $result['parent_id'],
			'descriptions' => $descriptions,
			'date' => $result['date'],
			'price' => $result['price'],
			'alias' => $result['alias'],				
			'weight' => $result['weight'],			
			'status' => $result['status'],
		);
		return $contents;
    }
	
    public function get_parent($id = '') {
        $sql = "SELECT category_id FROM " . $this->tableName2 . " WHERE `content_id` = :id  AND `module` = :module";
        $query = DB::query(Database::SELECT, $sql, FALSE)
                ->parameters(array(
                    ':id' => (int) $id, 
                    ':module' => 'services',
                    ))
                ->execute();
        $result = $query->as_array();
        if (count($result) > 0) {
            foreach ($result as $item) {
                $result2[$item['category_id']] = $item['category_id'];
            } return $result2;
        } else {
            return FALSE;
        }
    }
	
	public function get_total_all($is_adminka = 0, $inner_join = '', $filter = '', $lang_id = 1) {
		
		if ($is_adminka) {
			$filter .= ' AND a.status = 1 ';
		}
		
		$query = DB::query(Database::SELECT, "SELECT COUNT(id) AS total FROM " . $this->tableName . " a INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = a.id " . $inner_join . " WHERE cd.lang_id = :lang_id AND cd.module = :module " . $filter)
					->parameters(array(
						':lang_id' => $lang_id,
						':module' => 'services',
                    ))->execute();
        $result = $query->as_array();
        $total = $result[0]['total'];
        return $total;
    }
	
    public function get_total($cat = 0, $is_adminka = 0) {
	
		if($cat){
			if ($is_adminka) {
				$sql = "SELECT COUNT(id) AS total FROM `" . $this->tableName2 . "` cc INNER JOIN " . $this->tableName . " a ON cc.content_id = a.id  WHERE cc.category_id = " . $cat . " AND cc.module = 'services'";
			} else {
				$sql = "SELECT COUNT(id) AS total FROM `" . $this->tableName2 . "` cc INNER JOIN " . $this->tableName . " a ON cc.content_id = a.id  WHERE cc.category_id = " . $cat . " AND cc.module = 'services' AND a.status = 1";
			}
		} else {
			if ($is_adminka) {
				$sql = "SELECT COUNT(id) AS total FROM " . $this->tableName;
			} else {
				$sql = "SELECT COUNT(id) AS total FROM " . $this->tableName . " WHERE status = 1";
			}
		}
		
		$query = DB::query(Database::SELECT, $sql)
                ->execute();
        $result = $query->as_array();
        $total = $result[0]['total'];
        return $total;
    }
}