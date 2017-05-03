<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Sertifications {

    protected $tableName = 'sertifications';
	protected $tableName2 = 'contents_categories';
	protected $tableDesc = 'contents_descriptions';
    protected $session;
	
    public function __construct() {
        $this->session = Session::instance();
    }
	
    public function add($data = array()) {
        DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (price, old_price, code, alias, weight, status) VALUES (:price, :old_price, :code, :alias, :weight, :status)')
                ->parameters(array(
                    ':alias' => Security::xss_clean($data['alias']),
					':price' => Security::xss_clean($data['price']),
					':old_price' => Security::xss_clean($data['old_price']),
					':code' => Security::xss_clean($data['code']),					
                    ':weight' => Security::xss_clean($data['weight']),
                    ':status' => Security::xss_clean($data['status'])
                ))
                ->execute();
        $result = DB::query(Database::SELECT, 'SELECT id FROM `' . $this->tableName . '` WHERE `alias` = :alias')
                ->parameters(array(
                    ':alias' => Security::xss_clean($data['alias']),
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
							':content_body' => $value['body'],
							':module' => 'sertifications',
						))
						->execute();
				}
			}
			return $result[0]['id'];
        } else {
            return FALSE;
        }
    }
	
    public function edit($Id, $data = array()) {
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `price` = :price, `old_price` = :old_price, `code` = :code, `alias` = :alias, `weight` = :weight, `status` = :status WHERE `id` = :id')
                ->parameters(array(
                    ':id' => $Id,                    
                    ':alias' => Security::xss_clean($data['alias']),
					':price' => Security::xss_clean($data['price']),
					':old_price' => Security::xss_clean($data['old_price']),
					':code' => Security::xss_clean($data['code']),
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
							':module' => 'sertifications',
                        ))->execute();
						
				if(count($result)>0){
					DB::query(Database::UPDATE, 'UPDATE `' . $this->tableDesc . '` SET `content_title` = :content_title, `content_teaser` = :content_teaser, `content_body` = :content_body WHERE `content_id` = :content_id AND `lang_id` = :lang_id AND `module` = :module')
					->parameters(array(
						':content_id' => (int) $Id,
						':lang_id' => $lang_id,
						':content_title' => Security::xss_clean($value['title']),
						':content_teaser' => '',
						':content_body' => $value['body'],
						':module' => 'sertifications',
					))
					->execute();
				} else {
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :module)')
						->parameters(array(
							':content_id' => (int) $Id,
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => '',
							':content_body' => $value['body'],
							':module' => 'sertifications',
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
					':module' => 'sertifications',
                ))
                ->execute();
		if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
    public function get_all($is_adminka = 0, $start = 0, $num = 100, $field = 's.id', $inner_join = '', $filter = '', $lang_id = 1) {
		$contents = array();
        if ($is_adminka) {
            $sql = "SELECT * FROM " . $this->tableName . " s INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = s.id " . $inner_join . " WHERE cd.lang_id = :lang_id AND cd.module = :module " . $filter . " ORDER BY s.weight, :field DESC LIMIT :start, :num";
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " s INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = s.id " . $inner_join . " WHERE cd.lang_id = :lang_id AND cd.module = :module AND s.status = 1 " . $filter . " ORDER BY s.weight, :field DESC LIMIT :start, :num";
        } 
        $result = DB::query(Database::SELECT, $sql)
                ->parameters(array(
                    ':field' => $field, 
                    ':start' => (int) $start, 
                    ':num' => (int) $num,
					':lang_id' => $lang_id,
					':module' => 'sertifications',
                    ))
                ->execute();
				
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;
    }
	
	public function get_last($num = 8) {	
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
	
	public function get_content_to_code($code = 0) {	
		$contents = false;
        $result = DB::query(Database::SELECT, "SELECT id FROM " . $this->tableName . " WHERE `code` = :code")
					->param(':code', $code)
					->execute();
		
		if (count($result) > 0) {
			$contents = $this->get_content($result[0]['id']);
        }
        return $contents;		
    }
	
    public function get_content($id = '') {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE `id` = :id";
        $query = DB::query(Database::SELECT, $sql, FALSE)
                ->param(':id', (int) $id)
                ->execute();
        $result = $query->as_array();
		
        if (count($result)>0){
            $lang_result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module')
                        ->parameters(array(
                            ':content_id' => $id,
							':module' => 'sertifications',
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
			$files = $file_obj->get_files_by_content_id($id, 'sertifications');
			if (empty($files)) {
				$filename = false;
			} else {
				$filename = $files[0]['file']->filepathname;
			}
			
			$edit_interface = Liteedit::get_interface($id, 'sertifications', 'teaser', true);
			
			$contents = array(
				'id' => $result[0]['id'],
				'descriptions' => $descriptions,
				'alias' => $result[0]['alias'],
				'code' => $result[0]['code'],
				'price' => $result[0]['price'],
				'old_price' => $result[0]['old_price'],
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
	
	public function get_parent($id = '') {
        $sql = "SELECT category_id FROM " . $this->tableName2 . " WHERE `content_id` = :id  AND `module` = :module";
        $query = DB::query(Database::SELECT, $sql, FALSE)
                ->parameters(array(
                    ':id' => (int) $id, 
                    ':module' => 'sertifications',
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
			$filter .= ' AND s.status = 1 ';
		}
		
		$query = DB::query(Database::SELECT, "SELECT COUNT(id) AS total FROM " . $this->tableName . " s INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = s.id " . $inner_join . " WHERE cd.lang_id = :lang_id AND cd.module = :module " . $filter)
					->parameters(array(
						':lang_id' => $lang_id,
						':module' => 'sertifications',
                    ))->execute();
        $result = $query->as_array();
        $total = $result[0]['total'];
        return $total;
    }
}