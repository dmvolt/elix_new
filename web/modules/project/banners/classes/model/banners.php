<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Banners {

    protected $tableName = 'banners';
	protected $tableName2 = 'contents_categories';
    protected $session;
	
    public function __construct() {
        $this->session = Session::instance();
    }
	
    public function add($data = array()) {
	
        $data = Arr::extract($data, array('title', 'display_pages', 'display_all', 'status'));
        $vData = $data;
        $validation = Validation::factory($vData);
        $validation->rule('title', 'not_empty');
        $validation->rule('title', 'min_length', array(':value', '3'));
        $validation->rule('title', 'max_length', array(':value', '64'));
		
        if (!$validation->check()) {
            $this->errors = $validation->errors('catErrors');
            return FALSE;
        }
		
        $result = DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (title, display_pages, display_all, status) VALUES (:title, :display_pages, :display_all, :status)')
                ->parameters(array(
                    ':title' => Security::xss_clean($data['title']),
                    ':display_pages' => $data['display_pages'],
                    ':display_all' => Security::xss_clean($data['display_all']),
                    ':status' => Security::xss_clean($data['status'])
                ))
                ->execute();
				
        if ($result) {
            return $result[0];
        } else {
            return FALSE;
        }
    }
	
    public function edit($Id, $data = array()) {
	
        $data = Arr::extract($data, array('title', 'display_pages', 'display_all', 'status'));
        $vData = $data;
        $validation = Validation::factory($vData);
        $validation->rule('title', 'not_empty');
        $validation->rule('title', 'min_length', array(':value', '3'));
        $validation->rule('title', 'max_length', array(':value', '64'));
		
        if (!$validation->check()) {
            $this->errors = $validation->errors('catErrors');
            return FALSE;
        }
		
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `title` = :title, `display_pages` = :display_pages, `display_all` = :display_all, `status` = :status WHERE `id` = :id')
                ->parameters(array(
                    ':id' => $Id,
                    ':title' => Security::xss_clean($data['title']),
                    ':display_pages' => $data['display_pages'],
                    ':display_all' => Security::xss_clean($data['display_all']),
                    ':status' => Security::xss_clean($data['status'])
                ))
                ->execute();
		return TRUE;
    }
	
    public function delete($id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
                ->param(':id', (int) $id)
                ->execute();
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
    public function get_all($is_adminka = 0, $start = 0, $num = 100, $field = 'b.id', $inner_join = '', $filter = '') {
		$contents = array();
        if ($is_adminka) {
            $sql = "SELECT * FROM " . $this->tableName . " b " . $inner_join . " WHERE 1 " . $filter . " ORDER BY :field DESC LIMIT :start, :num";
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " b " . $inner_join . " WHERE b.status = 1 " . $filter . " ORDER BY :field DESC LIMIT :start, :num";
        } 
        $result = DB::query(Database::SELECT, $sql)
                ->parameters(array(
                    ':field' => $field, 
                    ':start' => (int) $start, 
                    ':num' => (int) $num,
                    ))
                ->execute();
				
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;
    }
	
	public function get_all_to_cat($cat) {
        $contents = array();
        $query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName2 . '` cc INNER JOIN ' . $this->tableName . ' s ON cc.content_id = s.id WHERE cc.category_id = :category_id AND cc.module = :module')
                ->parameters(array(
                    ':category_id' => $cat, 
                    ':module' => 'banners',
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
	
	public function get_last_content($cat) {
	
		$query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName2 . '` cc INNER JOIN ' . $this->tableName . ' s ON cc.content_id = s.id WHERE cc.category_id = :category_id AND cc.module = :module AND s.status = 1 LIMIT 0,1')
                ->parameters(array(
                    ':category_id' => $cat, 
                    ':module' => 'banners',
                    ))
                ->execute();
        
        $result = $query->as_array();
		
        if (count($result)>0){
			$file_obj = new Model_File();
			$files = $file_obj->get_files_by_content_id($result[0]['id'], 'banners');
			
			$contents = array(
				'id' => $result[0]['id'],
				'title' => $result[0]['title'],		
				'status' => $result[0]['status'],
				'files' => $files,
				
			);
			return $contents;
		} else {
			return false;
		}   
    }
	
    public function get_content($id = '') {
	
        $sql = "SELECT * FROM " . $this->tableName . " WHERE `id` = :id";
        $query = DB::query(Database::SELECT, $sql, FALSE)
                ->param(':id', (int) $id)
                ->execute();
        $result = $query->as_array();
		
        if (count($result)>0){
		
			$file_obj = new Model_File();
			$files = $file_obj->get_files_by_content_id($id, 'banners');
			
			$contents = array(
				'id' => $result[0]['id'],
				'title' => $result[0]['title'],		
				'status' => $result[0]['status'],
				'files' => $files,
			);
			return $contents;
		} else {
			return false;
		}   
    }
	
	public function get_parent($id = '') {
        $sql = "SELECT category_id FROM " . $this->tableName2 . " WHERE `content_id` = :id  AND `module` = :module";
        $query = DB::query(Database::SELECT, $sql, FALSE)
                ->parameters(array(
                    ':id' => (int) $id, 
                    ':module' => 'banners',
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
	
	public function get_total_all($is_adminka = 0, $inner_join = '', $filter = '') {
		
		if ($is_adminka) {
			$filter .= ' AND b.status = 1 ';
		}
		
		$query = DB::query(Database::SELECT, "SELECT COUNT(id) AS total FROM " . $this->tableName . " b " . $inner_join . " WHERE 1 " . $filter)->execute();
        $result = $query->as_array();
        $total = $result[0]['total'];
        return $total;
    }
}