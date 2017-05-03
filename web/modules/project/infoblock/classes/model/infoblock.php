<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Infoblock {

    protected $tableName = 'infoblock';
	protected $tableName2 = 'contents_categories';
	protected $tableDesc = 'contents_descriptions';
    protected $session;
	
    public function __construct() {
        $this->session = Session::instance();
    }
	
    public function add($data = array()) {
        DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (`date`, weight, `type`, `url`, status) VALUES (:date, :weight, :type, :url, :status)')
                ->parameters(array(  
					':date' => Security::xss_clean($data['date']), 					
                    ':weight' => Security::xss_clean($data['weight']),
					':type' => Security::xss_clean($data['type']),
					':url' => Security::xss_clean($data['url']),
                    ':status' => Security::xss_clean($data['status'])
                ))
                ->execute();
        $result = mysql_insert_id();
        if ($result) {
            if(isset($data['descriptions'])){
				foreach($data['descriptions'] as $lang_id => $value){
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :module)')
						->parameters(array(
							':content_id' => (int) $result,
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => $value['teaser'],
							':content_body' => '',
							':module' => 'infoblock',
						))
						->execute();
				}
			}
			return $result;
        } else {
            return FALSE;
        }
    }
	
    public function edit($Id, $data = array()) {
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `date` = :date, `weight` = :weight, `type` = :type, `url` = :url, `status` = :status WHERE `id` = :id')
                ->parameters(array(
                    ':id' => $Id,
					':date' => Security::xss_clean($data['date']),
                    ':weight' => Security::xss_clean($data['weight']), 
					':type' => Security::xss_clean($data['type']),
					':url' => Security::xss_clean($data['url']),
                    ':status' => Security::xss_clean($data['status'])
                ))
                ->execute();
				
		if(isset($data['descriptions'])){
			foreach($data['descriptions'] as $lang_id => $value){
				$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module AND `lang_id` = :lang_id')
                        ->parameters(array(
							':lang_id' => $lang_id,
                            ':content_id' => $Id,
							':module' => 'infoblock',
                        ))->execute();
						
				if(count($result)>0){
					DB::query(Database::UPDATE, 'UPDATE `' . $this->tableDesc . '` SET `content_title` = :content_title, `content_teaser` = :content_teaser, `content_body` = :content_body WHERE `content_id` = :content_id AND `lang_id` = :lang_id AND `module` = :module')
					->parameters(array(
						':content_id' => (int) $Id,
						':lang_id' => $lang_id,
						':content_title' => Security::xss_clean($value['title']),
						':content_teaser' => $value['teaser'],
						':content_body' => '',
						':module' => 'infoblock',
					))
					->execute();
				} else {
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :module)')
						->parameters(array(
							':content_id' => (int) $Id,
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['title']),
							':content_teaser' => $value['teaser'],
							':content_body' => '',
							':module' => 'infoblock',
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
					':module' => 'infoblock',
                ))
                ->execute();
		if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
    public function get_all($is_adminka = 0, $start = 0, $num = 100, $field = 'id') {
		$contents = array();
        if ($is_adminka) {
            $sql = "SELECT * FROM " . $this->tableName . " ORDER BY weight, :field DESC LIMIT :start, :num";
        } else {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE `status` = 1 ORDER BY weight, :field DESC LIMIT :start, :num";
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
                    ':module' => 'infoblock',
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
	
	public function get_blocks($type = 3, $url = false, $cat = 0) {	
		$contents = array();
		if($url){
			
			$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName2 . '` cc INNER JOIN ' . $this->tableName . ' s ON cc.content_id = s.id WHERE cc.category_id = :category_id AND cc.module = :module AND s.type = '.$type.' AND s.url = "'.$url.'" AND s.status = 1')
                ->parameters(array(
                    ':category_id' => $cat, 
                    ':module' => 'infoblock',
                    ))
                ->execute();
		
			if (count($result) > 0) {
				foreach ($result as $res) {
					$contents[] = $this->get_content($res['id']);
				}
			}
		}  
        return $contents;		
    }
	
	public function get_last($num = 3, $type = 1, $cat = 0) {	
		$contents = array();
		$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName2 . '` cc INNER JOIN ' . $this->tableName . ' s ON cc.content_id = s.id WHERE cc.category_id = :category_id AND cc.module = :module AND s.type = '.$type.' AND s.status = 1 ORDER BY s.weight LIMIT 0, '.$num)
                ->parameters(array(
                    ':category_id' => $cat, 
                    ':module' => 'infoblock',
                    ))
                ->execute();
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;		
    }
	
	/* public function get_last($num = 3, $type = 1, $cat = 0) {	
		$contents = array();
		$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` s WHERE s.type = '.$type.' AND s.status = 1 ORDER BY s.weight LIMIT 0, '.$num)
                ->parameters(array(
                    ':category_id' => $cat, 
                    ':module' => 'infoblock',
                    ))
                ->execute();
		if (count($result) > 0) {
            foreach ($result as $res) {
                $contents[] = $this->get_content($res['id']);
            }
        }
        return $contents;		
    } */
	
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
							':module' => 'infoblock',
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
			$files = $file_obj->get_files_by_content_id($id, 'infoblock');
			if (empty($files)) {
				$filename = false;
			} else {
				$filename = $files[0]['file']->filepathname;
			}
			
			$edit_interface = Liteedit::get_interface($id, 'infoblock', 'teaser', true);
			
			$contents = array(
				'id' => $result[0]['id'],
				'descriptions' => $descriptions,
				'date' => $result[0]['date'],	
				'type' => $result[0]['type'],
				'url' => $result[0]['url'],
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
                    ':module' => 'infoblock',
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