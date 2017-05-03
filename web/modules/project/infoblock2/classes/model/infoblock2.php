<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Infoblock2 {

    protected $tableName = 'infoblock2';
	protected $tableName2 = 'contents_categories';
    protected $session;

    public function __construct() {
        $this->session = Session::instance();
    }

    public function add($data = array()) {
        DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (`title`, `info`, `link1`, `link2`, `pos_x`, `pos_y`, `type`, status) VALUES (:title, :info, :link1, :link2, :pos_x, :pos_y, :type, :status)')
                ->parameters(array(  
					':title' => Security::xss_clean($data['title']), 					
                    ':info' => Security::xss_clean($data['info']),
					':link1' => Security::xss_clean($data['link1']),
					':link2' => Security::xss_clean($data['link2']),
					':pos_x' => Security::xss_clean($data['pos_x']),
					':pos_y' => Security::xss_clean($data['pos_y']),
					':type' => Security::xss_clean($data['type']),
                    ':status' => Security::xss_clean($data['status'])
                ))
                ->execute();

        return mysql_insert_id();
    }

    public function edit($Id, $data = array()) {
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `title` = :title, `info` = :info, `link1` = :link1, `link2` = :link2, `pos_x` = :pos_x, `pos_y` = :pos_y, `type` = :type, `status` = :status WHERE `id` = :id')
                ->parameters(array(
                    ':id' => $Id,
					':title' => Security::xss_clean($data['title']), 					
                    ':info' => Security::xss_clean($data['info']),
					':link1' => Security::xss_clean($data['link1']),
					':link2' => Security::xss_clean($data['link2']),
					':pos_x' => Security::xss_clean($data['pos_x']),
					':pos_y' => Security::xss_clean($data['pos_y']),
					':type' => Security::xss_clean($data['type']),
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

    public function get_all($is_adminka = 0, $start = 0, $num = 100, $inner_join = '', $filter = '') {
		$contents = array();
        if ($is_adminka) {
            $sql = "SELECT * FROM " . $this->tableName . " i2 " . $inner_join . " WHERE 1 " . $filter . " LIMIT :start, :num";
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " i2 " . $inner_join . " WHERE i2.status = 1 " . $filter . " LIMIT :start, :num";
        } 
        $result = DB::query(Database::SELECT, $sql)
                ->parameters(array(
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
                    ':module' => 'infoblock2',
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
	
	public function get_blocks($type = 1) {	
		$contents = array();
		$result = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `type` = ".$type." AND `status` = 1")
				->execute();		
		if (count($result) > 0) {
			foreach ($result as $res) {
				$contents[] = $this->get_content($res['id']);
			}
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
			$contents = array(
				'id' => $result[0]['id'],
				'title' => $result[0]['title'],
				'info' => $result[0]['info'],
				'link1' => $result[0]['link1'],
				'link2' => $result[0]['link2'],
				'pos_x' => $result[0]['pos_x'],
				'pos_y' => $result[0]['pos_y'],
				'type' => $result[0]['type'],		
				'status' => $result[0]['status'],
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
                    ':module' => 'infoblock2',
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
}