<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Actions {

    protected $tableName = 'actions';
	protected $tableName2 = 'contents_categories';
	protected $tableDesc = 'contents_descriptions';
    protected $session;
	
    public function __construct() {
        $this->session = Session::instance();
    }
	
    public function add($data = array()) {
        $result = DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (alias, in_front, weight, status) VALUES (:alias, :in_front, :weight, :status)')
                ->parameters(array(
                    ':alias' => Security::xss_clean($data['alias']),
					':in_front' => Security::xss_clean($data['in_front']),					
                    ':weight' => Security::xss_clean($data['weight']),
                    ':status' => Security::xss_clean($data['status'])
                ))
                ->execute();
        
        if ($result) {
            if(isset($data['descriptions'])){
				foreach($data['descriptions'] as $lang_id => $value){
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `content_text_field`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :content_text_field, :module)')
						->parameters(array(
							':content_id' => (int) $result[0],
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => $value['teaser'],
							':content_body' => $value['body'],
							':content_text_field' => $value['area'],
							':module' => 'actions',
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
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `alias` = :alias, `in_front` = :in_front, `weight` = :weight, `status` = :status WHERE `id` = :id')
                ->parameters(array(
                    ':id' => $Id,                    
                    ':alias' => Security::xss_clean($data['alias']),
					':in_front' => Security::xss_clean($data['in_front']),
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
							':module' => 'actions',
                        ))->execute();
						
				if(count($result)>0){
					DB::query(Database::UPDATE, 'UPDATE `' . $this->tableDesc . '` SET `content_title` = :content_title, `content_teaser` = :content_teaser, `content_body` = :content_body, `content_text_field` = :content_text_field WHERE `content_id` = :content_id AND `lang_id` = :lang_id AND `module` = :module')
					->parameters(array(
						':content_id' => (int) $Id,
						':lang_id' => $lang_id,
						':content_title' => Security::xss_clean($value['title']),
						':content_teaser' => $value['teaser'],
						':content_body' => $value['body'],
						':content_text_field' => $value['area'],
						':module' => 'actions',
					))
					->execute();
				} else {
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `content_text_field`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :content_text_field, :module)')
						->parameters(array(
							':content_id' => (int) $Id,
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => $value['teaser'],
							':content_body' => $value['body'],
							':content_text_field' => $value['area'],
							':module' => 'actions',
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
					':module' => 'actions',
                ))
                ->execute();
		if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
    public function get_all($is_adminka = 0, $start = 0, $num = 100, $field = 'id', $inner_join = '', $filter = '', $lang_id = 1) {
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
					':module' => 'actions',
                    ))
                ->execute();
				
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;
    }
	
	public function get_content_to_cat($cat, $alias) {
        $contents = array();
        $query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName2 . '` cc INNER JOIN ' . $this->tableName . ' a ON cc.content_id = a.id  WHERE cc.category_id = :category_id AND a.alias = :alias AND cc.module = :module')
                ->parameters(array(
                    ':category_id' => $cat, 
					':alias' => $alias,
                    ':module' => 'actions',
                    ))
                ->execute();
        $result = $query->as_array();
        if (count($result) > 0) {
            foreach ($result as $res) {
                $contents = $this->get_content($res['id']);
            }
			return $contents;
        } else {
			return false;
		}
    }
	
	public function get_all_to_cat($cat, $start = 0, $num = 100, $field = 's.weight', $lang_id = 1) {
        $contents = array();
        $query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName2 . '` cc INNER JOIN ' . $this->tableName . ' s ON cc.content_id = s.id INNER JOIN ' . $this->tableDesc . ' cd ON cd.content_id = s.id WHERE cc.category_id = :category_id AND cd.lang_id = :lang_id AND cd.module = :module AND cc.module = :module ORDER BY ' . $field . ' LIMIT :start, :num')
                ->parameters(array(
                    ':category_id' => $cat, 
                    ':module' => 'actions',
                    ':start' => (int) $start, 
                    ':num' => (int) $num,
					':lang_id' => $lang_id,
                    ))
                ->execute();
        $result = $query->as_array();
        if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;
    }
	
	public function get_current_to_cat($cat, $id, $start = 0, $num = 100, $field = 'a.weight') {
        $contents = array();
        $query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName2 . '` cc INNER JOIN ' . $this->tableName . ' a ON cc.content_id = a.id  WHERE cc.category_id = :category_id AND cc.content_id != :content_id AND cc.module = :module ORDER BY ' . $field . ' LIMIT :start, :num')
                ->parameters(array(
                    ':category_id' => $cat, 
					':content_id' => $id,
                    ':module' => 'actions',
                    ':start' => (int) $start, 
                    ':num' => (int) $num,
                    ))
                ->execute();
        $result = $query->as_array();
        if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;
    }
	
	public function get_all_to_cat_in_front($cat, $start = 0, $num = 100, $field = 'a.weight') {
        $contents = array();
        $query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName2 . '` cc INNER JOIN ' . $this->tableName . ' a ON cc.content_id = a.id  WHERE cc.category_id = :category_id AND cc.module = :module AND a.in_front = 1 ORDER BY ' . $field . ' LIMIT :start, :num')
                ->parameters(array(
                    ':category_id' => $cat, 
                    ':module' => 'actions',
                    ':start' => (int) $start, 
                    ':num' => (int) $num,
                    ))
                ->execute();
        $result = $query->as_array();
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
	
	public function get_first($num = 1) {	
		$contents = array();		
        $result = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `status` = 1 ORDER BY `weight` LIMIT 0, ".$num)
					->execute();
		
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;		
    }
	
	public function get_in_front() {	
		$contents = array();		
        $result = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `status` = 1 AND `in_front` = 1 ORDER BY `weight`")
					->execute();
		
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;		
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
							':module' => 'actions',
                        ))->execute();
						
			if(count($lang_result)>0){
				foreach($lang_result as $value){
					$descriptions[$value['lang_id']] = array(
						'title' => $value['content_title'],
						'teaser' => $value['content_teaser'],
						'body' => $value['content_body'],
						'area' => $value['content_text_field'],
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
						'area' => '',
					);
				}
			}
			
			$file_obj = new Model_File();
			$images = $file_obj->get_files_by_content_id($result[0]['id'], 'actions', 1);
			$files = $file_obj->get_files_by_content_id($result[0]['id'], 'actions', 0);
			if (empty($images)) {
				$filename = false;
			} else {
				$filename = $images[0]['file']->filepathname;
			}
			
			$edit_interface = Liteedit::get_interface($result[0]['id'], 'actions', 'teaser', true);
			
			$contents = array(
				'id' => $result[0]['id'],
				'descriptions' => $descriptions,
				'alias' => $result[0]['alias'],
				'in_front' => $result[0]['in_front'],
				'weight' => $result[0]['weight'],			
				'status' => $result[0]['status'],
				'thumb' => $filename,
				'images' => $images,
				'files' => $files,
				'edit_interface' => $edit_interface,
			);
			return $contents;
		} else {
			return FALSE;
		}    
    }
	
	public function get_parent($id = '') {
        $sql = "SELECT category_id FROM " . $this->tableName2 . " WHERE `content_id` = :id  AND `module` = :module";
        $query = DB::query(Database::SELECT, $sql, FALSE)
                ->parameters(array(
                    ':id' => (int) $id, 
                    ':module' => 'actions',
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
	
	public function get_one_parent($id = '') {
        $sql = "SELECT category_id FROM " . $this->tableName2 . " WHERE `content_id` = :id  AND `module` = :module";
        $query = DB::query(Database::SELECT, $sql, FALSE)
                ->parameters(array(
                    ':id' => (int) $id, 
                    ':module' => 'actions',
                    ))
                ->execute();
        $result = $query->as_array();
        if (count($result) > 0) {
			return $result[0]['category_id'];
        } else {
            return 0;
        }
    }
	
	public function get_service_parent($id = '') {
        $sql = "SELECT service_id FROM `contents_services` WHERE `content_id` = :id  AND `module` = :module";
        $query = DB::query(Database::SELECT, $sql, FALSE)
                ->parameters(array(
                    ':id' => (int) $id, 
                    ':module' => 'actions',
                    ))
                ->execute();
        $result = $query->as_array();
        if (count($result) > 0) {
            foreach ($result as $item) {
                $result2[$item['service_id']] = $item['service_id'];
            } return $result2;
        } else {
            return FALSE;
        }
    }
	
	public function get_total_all($is_adminka = 0, $inner_join = '', $filter = '', $lang_id = 1) {
		
		if ($is_adminka) {
			$filter .= ' AND a.status = 1 ';
		}
		
		$query = DB::query(Database::SELECT, "SELECT COUNT(id) AS total FROM " . $this->tableName . " a INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = a.id " . $inner_join . " WHERE cd.lang_id = :lang_id AND cd.module = :module AND a.status = 1 " . $filter)
					->parameters(array(
						':lang_id' => $lang_id,
						':module' => 'actions',
                    ))->execute();
        $result = $query->as_array();
        $total = $result[0]['total'];
        return $total;
    }
	
    public function get_total($cat = 0, $is_adminka = 0, $lang_id = 1) {
		if($cat){
			if ($is_adminka) {
				$sql = "SELECT COUNT(id) AS total FROM `" . $this->tableName2 . "` cc INNER JOIN " . $this->tableName . " s ON cc.content_id = s.id INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = s.id WHERE cd.lang_id = " . $lang_id . " AND cd.module = 'actions' AND cc.category_id = " . $cat . " AND cc.module = 'actions'";
			} else {
				$sql = "SELECT COUNT(id) AS total FROM `" . $this->tableName2 . "` cc INNER JOIN " . $this->tableName . " s ON cc.content_id = s.id INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = s.id WHERE cd.lang_id = " . $lang_id . " AND cd.module = 'actions' AND cc.category_id = " . $cat . " AND cc.module = 'actions' AND s.status = 1";
			}
		} else {
			if ($is_adminka) {
				$sql = "SELECT COUNT(id) AS total FROM " . $this->tableName . " s INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = s.id WHERE cd.lang_id = " . $lang_id . " AND cd.module = 'actions'";
			} else {
				$sql = "SELECT COUNT(id) AS total FROM " . $this->tableName . " s INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = s.id WHERE cd.lang_id = " . $lang_id . " AND cd.module = 'actions' AND s.status = 1";
			}
		}
		
		$query = DB::query(Database::SELECT, $sql)
                ->execute();
        $result = $query->as_array();
        $total = $result[0]['total'];
        return $total;
    }
}