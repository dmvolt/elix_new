<?php

defined('SYSPATH') or die('No direct script access.');

class Model_News {

    protected $tableName = 'news';
	protected $tableName2 = 'contents_categories';
	protected $tableDesc = 'contents_descriptions';

    public function add($data = array()) {
        DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (date, `timestamp`, alias, weight, status) VALUES (:date, :timestamp, :alias, :weight, :status)')
				->parameters(array(		
					':alias' => Security::xss_clean($data['alias']),
					':weight' => Security::xss_clean($data['weight']), 
					':date' => Security::xss_clean($data['date']),
					':timestamp' => time(), 
					':status' => Security::xss_clean($data['status'])
					))->execute();
					
        $query = DB::query(Database::SELECT, 'SELECT id FROM `' . $this->tableName . '` WHERE `alias` = :alias')
                ->parameters(array(
					':alias' => Security::xss_clean($data['alias']),
                ));
				
        $result = $query->execute();

        if (count($result) > 0) {
			if(isset($data['descriptions'])){
				foreach($data['descriptions'] as $lang_id => $value){
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :module)')
						->parameters(array(
							':content_id' => (int) $result[0]['id'],
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => Security::xss_clean($value['teaser']),
							':content_body' => $value['body'],
							':module' => 'news',
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
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `date` = :date, `alias` = :alias, `weight` = :weight, `status` = :status WHERE `id` = :id')
				->parameters(array(
					':id' => $Id, 		
					':date' => Security::xss_clean($data['date']), 		
					':alias' => Security::xss_clean($data['alias']), 		
					':weight' => Security::xss_clean($data['weight']), 
					':status' => Security::xss_clean($data['status'])
					))->execute();
					
		if(isset($data['descriptions'])){
			foreach($data['descriptions'] as $lang_id => $value){
				$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module AND `lang_id` = :lang_id')
                        ->parameters(array(
							':lang_id' => $lang_id,
                            ':content_id' => $Id,
							':module' => 'news',
                        ))->execute();
						
				if(count($result)>0){
					DB::query(Database::UPDATE, 'UPDATE `' . $this->tableDesc . '` SET `content_title` = :content_title, `content_teaser` = :content_teaser, `content_body` = :content_body WHERE `content_id` = :content_id AND `lang_id` = :lang_id AND `module` = :module')
					->parameters(array(
						':content_id' => (int) $Id,
						':lang_id' => $lang_id,
						':content_title' => Security::xss_clean($value['title']),
						':content_teaser' => Security::xss_clean($value['teaser']),
						':content_body' => $value['body'],
						':module' => 'news',
					))
					->execute();
				} else {
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :module)')
						->parameters(array(
							':content_id' => (int) $Id,
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => Security::xss_clean($value['teaser']),
							':content_body' => $value['body'],
							':module' => 'news',
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
					':module' => 'news',
                ))
                ->execute();
				
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_all($is_adminka = 0, $start = 0, $num = 100, $field = 's.id', $lang_id = 1) {
		$contents = array();
        if ($is_adminka) {
            $sql = "SELECT * FROM " . $this->tableName . " s INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = s.id WHERE cd.lang_id = :lang_id AND cd.module = :module ORDER BY s.weight, :field LIMIT :start, :num";
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " s INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = s.id WHERE cd.lang_id = :lang_id AND cd.module = :module AND s.status` = 1 ORDER BY s.weight, :field LIMIT :start, :num";
        } 
        $result = DB::query(Database::SELECT, $sql)
                ->parameters(array(
                    ':field' => $field, 
					':module' => 'news',
                    ':start' => (int) $start, 
                    ':num' => (int) $num,
					':lang_id' => $lang_id,
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
                    ':module' => 'news',
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
	
	public function get_current_to_cat($cat, $id, $start = 0, $num = 100, $field = 'a.weight') {
        $contents = array();
        $query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName2 . '` cc INNER JOIN ' . $this->tableName . ' a ON cc.content_id = a.id  WHERE cc.category_id = :category_id AND cc.content_id != :content_id AND cc.module = :module ORDER BY ' . $field . ' LIMIT :start, :num')
                ->parameters(array(
                    ':category_id' => $cat, 
					':content_id' => $id,
                    ':module' => 'news',
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
	
	public function get_all_to_cat($cat, $start = 0, $num = 100, $field = 's.weight', $lang_id = 1) {
        $contents = array();
        $query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName2 . '` cc INNER JOIN ' . $this->tableName . ' s ON cc.content_id = s.id INNER JOIN ' . $this->tableDesc . ' cd ON cd.content_id = s.id WHERE cc.category_id = :category_id AND cd.lang_id = :lang_id AND cd.module = :module AND cc.module = :module ORDER BY ' . $field . ' LIMIT :start, :num')
                ->parameters(array(
                    ':category_id' => $cat, 
                    ':module' => 'news',
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

    public function get_last($num = 4) {	
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

    public function get_content($id = '') {
	
        $sql = "SELECT * FROM " . $this->tableName . " WHERE `id` = :id";
        $query = DB::query(Database::SELECT, $sql, FALSE)
			->param(':id', (int) $id)
			->execute();
			
        $result = $query->as_array();
		
        if ($result){
			$lang_result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module')
                        ->parameters(array(
                            ':content_id' => $id,
							':module' => 'news',
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
			$files = $file_obj->get_files_by_content_id($id, 'news');

			if (empty($files)) {
				$filename = false;
			} else {
				$filename = $files[0]['file']->filepathname;
			}
			
			$edit_interface = Liteedit::get_interface($id, 'news', 'teaser', true);
			
			$contents = array(
				'id' => $result[0]['id'],
				'date' => $result[0]['date'],
				'descriptions' => $descriptions,
				'alias' => $result[0]['alias'],
				'timestamp' => $result[0]['timestamp'],			
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
                    ':module' => 'news',
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
                    ':module' => 'news',
                    ))
                ->execute();
        $result = $query->as_array();
        if (count($result) > 0) {
			return $result[0]['category_id'];
        } else {
            return 0;
        }
    }
    public function get_total($cat = 0, $is_adminka = 0, $lang_id = 1) {
		if($cat){
			if ($is_adminka) {
				$sql = "SELECT COUNT(id) AS total FROM `" . $this->tableName2 . "` cc INNER JOIN " . $this->tableName . " s ON cc.content_id = s.id INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = s.id WHERE cd.lang_id = " . $lang_id . " AND cd.module = 'news' AND cc.category_id = " . $cat . " AND cc.module = 'news'";
			} else {
				$sql = "SELECT COUNT(id) AS total FROM `" . $this->tableName2 . "` cc INNER JOIN " . $this->tableName . " s ON cc.content_id = s.id INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = s.id WHERE cd.lang_id = " . $lang_id . " AND cd.module = 'news' AND cc.category_id = " . $cat . " AND cc.module = 'news' AND s.status = 1";
			}
		} else {
			if ($is_adminka) {
				$sql = "SELECT COUNT(id) AS total FROM " . $this->tableName . " s INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = s.id WHERE cd.lang_id = " . $lang_id . " AND cd.module = 'news'";
			} else {
				$sql = "SELECT COUNT(id) AS total FROM " . $this->tableName . " s INNER JOIN " . $this->tableDesc . " cd ON cd.content_id = s.id WHERE cd.lang_id = " . $lang_id . " AND cd.module = 'news' AND s.status = 1";
			}
		}
		
		$query = DB::query(Database::SELECT, $sql)
                ->execute();
        $result = $query->as_array();
        $total = $result[0]['total'];
        return $total;
    }

}