<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Seo {

    protected $tableName = 'seo';
    protected $tableName2 = 'contents_seo';

    public function add($Id, $add_data = array(), $module = 'pages') {
		
		if (!empty($add_data)) {
            $this->delete($Id, $module);
            foreach ($add_data as $lang_id => $data) {		
				DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (title, alt, lang_id, meta_k, meta_d) VALUES (:title, :alt, :lang_id, :meta_k, :meta_d)')
						->parameters(array(
							':title' => (isset($data['title'])) ? Security::xss_clean($data['title']) : '',
							':alt' => (isset($data['alt'])) ? Security::xss_clean($data['alt']) : '',
							':meta_k' => (isset($data['meta_k'])) ? Security::xss_clean($data['meta_k']) : '',
							':meta_d' => (isset($data['meta_d'])) ? Security::xss_clean($data['meta_d']) : '',
							':lang_id' => $lang_id,
						))
						->execute();
						
				$seo_id = mysql_insert_id();
				
				if($seo_id){		
					DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName2 . ' (content_id, seo_id, module) VALUES (:content_id, :seo_id, :module)')
							->parameters(array(
								':content_id' => $Id,
								':seo_id' => $seo_id,
								':module' => $module,
							))
							->execute();
				}
			}
			return TRUE;
		} else {
			return FALSE;
		}
    }

    public function delete($Id, $module = 'pages') {	
		$result = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName2 . " WHERE `content_id` = :content_id AND `module` = :module")
                    ->parameters(array(
                        ':content_id' => $Id,
                        ':module' => $module,
                    ))
                    ->execute();
					
		if($result AND count($result)>0){
			foreach($result as $value){
				DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
					->parameters(array(
						':id' => $value['seo_id'],
					))
					->execute();
			}
		}
		
        DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName2 . ' WHERE `content_id` = :content_id AND `module` = :module')
                ->parameters(array(
                    ':content_id' => $Id,
                    ':module' => $module,
                ))
                ->execute();  
		return TRUE;  
    }
	
	public function delete_by_content($Id, $module = 'pages') {	
		$result = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName2 . " WHERE `content_id` = :content_id AND `module` = :module")
                    ->parameters(array(
                        ':content_id' => $Id,
                        ':module' => $module,
                    ))
                    ->execute();
					
		if($result AND count($result)>0){
			foreach($result as $value){
				DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
					->parameters(array(
						':id' => $value['seo_id'],
					))
					->execute();
			}
		}
		
        DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName2 . ' WHERE `content_id` = :content_id AND `module` = :module')
                ->parameters(array(
                    ':content_id' => $Id,
                    ':module' => $module,
                ))
                ->execute();  
		return TRUE;  
    }

    public function get_seo_to_content($Id, $module = 'pages') {
	
		$seo = array();
		
		$languages = Kohana::$config->load('language');
		foreach($languages as $value){
			$seo[$value['lang_id']] = array(
					'id' => 0,
					'title' => '',
					'meta_k' => '',
					'meta_d' => '',
					'alt' => '',
				);
		}

		$result = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName2 . " WHERE `content_id` = :content_id AND `module` = :module")
				->parameters(array(
					':content_id' => $Id,
					':module' => $module,
				))
				->execute();
				
		if($result AND count($result)>0){
			foreach ($result as $value) {
				$result2 = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `id` = :seo_id")
						->param(':seo_id', $value['seo_id'])
						->execute();

				$seo[$result2[0]['lang_id']] = array(
					'id' => $result2[0]['id'],
					'title' => $result2[0]['title'],
					'meta_k' => $result2[0]['meta_k'],
					'meta_d' => $result2[0]['meta_d'],
					'alt' => $result2[0]['alt'],
				);
			}
		}		
		return $seo;
    }
}