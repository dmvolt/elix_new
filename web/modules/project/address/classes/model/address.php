<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Address {

    protected $tableName = 'address';
    protected $tableName2 = 'contents_address';

    public function add($Id, $add_data = array(), $module = 'pages') {
		
		if (!empty($add_data)) {
            $this->delete($Id, $module);
            foreach ($add_data as $lang_id => $data) {		
				DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (text1, text2, lang_id, text3, text4) VALUES (:text1, :text2, :lang_id, :text3, :text4)')
						->parameters(array(
							':text1' => (isset($data['text1'])) ? Security::xss_clean($data['text1']) : '',
							':text2' => (isset($data['text2'])) ? Security::xss_clean($data['text2']) : '',
							':text3' => (isset($data['text3'])) ? Security::xss_clean($data['text3']) : '',
							':text4' => (isset($data['text4'])) ? Security::xss_clean($data['text4']) : '',
							':lang_id' => $lang_id,
						))
						->execute();
						
				$address_id = mysql_insert_id();
				
				if($address_id){		
					DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName2 . ' (content_id, address_id, module) VALUES (:content_id, :address_id, :module)')
							->parameters(array(
								':content_id' => $Id,
								':address_id' => $address_id,
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
						':id' => $value['address_id'],
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
						':id' => $value['address_id'],
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

    public function get_address_to_content($Id, $module = 'pages') {
	
		$address = array();
		
		$languages = Kohana::$config->load('language');
		foreach($languages as $value){
			$address[$value['lang_id']] = array(
					'id' => 0,
					'text1' => '',
					'text2' => '',
					'text3' => '',
					'text4' => '',
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
				$result2 = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `id` = :address_id")
						->param(':address_id', $value['address_id'])
						->execute();

				$address[$result2[0]['lang_id']] = array(
					'id' => $result2[0]['id'],
					'text1' => $result2[0]['text1'],
					'text2' => $result2[0]['text2'],
					'text3' => $result2[0]['text3'],
					'text4' => $result2[0]['text4'],
				);
			}
		}		
		return $address;
    }
}