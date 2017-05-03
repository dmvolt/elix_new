<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Siteinfo {

    protected $tableName = 'siteinfo';
	protected $tableDesc = 'contents_descriptions';
	
    public function get_siteinfo($Id) {
	
		$content = array();
		
        $result = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName . ' WHERE `id` = :id', TRUE)
                ->as_object()
                ->param(':id', $Id)
                ->execute();
				
		$lang_result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module')
                        ->parameters(array(
                            ':content_id' => $Id,
							':module' => 'siteinfo',
                        ))->execute();
						
		if(count($lang_result)>0){
			foreach($lang_result as $value){
				$descriptions[$value['lang_id']] = array(
					'site_name' => $value['content_title'],
					'teaser' => $value['content_teaser'],
					'body' => $value['content_body'],
					'site_slogan' => $value['content_var_field1'],
					'site_copyright' => $value['content_var_field2'],
					'site_licence' => $value['content_text_field'],
				);
			}
			
		}
		
		$languages = Kohana::$config->load('language');
		foreach($languages as $value){
			if(!isset($descriptions[$value['lang_id']])){
				$descriptions[$value['lang_id']] = array(
					'site_name' => '',
					'teaser' => '',
					'body' => '',
					'site_slogan' => '',
					'site_copyright' => '',
					'site_licence' => '',
				);
			}
		}		
		
		$content = array(
			'id' => $result[0]->id,
			'email' => $result[0]->email,
			'tell' => $result[0]->tell,
			'descriptions' => $descriptions,
		);
        return $content;
    }
    public function edit($Id, $data = array()) {
        DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET email = :email, tell = :tell WHERE id = :id')
                ->parameters(array(     
                    ':email' => Security::xss_clean($data['site_email']),
                    ':tell' => Security::xss_clean($data['site_tell']),
                    ':id' => $Id,
                ))
                ->execute();
		if(isset($data['descriptions'])){
			foreach($data['descriptions'] as $lang_id => $value){
				$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module AND `lang_id` = :lang_id')
						->parameters(array(
							':lang_id' => $lang_id,
							':content_id' => $Id,
							':module' => 'siteinfo',
						))->execute();
						
				if(count($result)>0){
					DB::query(Database::UPDATE, 'UPDATE `' . $this->tableDesc . '` SET `content_title` = :content_title, `content_teaser` = :content_teaser, `content_body` = :content_body, `content_var_field1` = :slogan, `content_var_field2` = :copyright, `content_text_field` = :licence WHERE `content_id` = :content_id AND `lang_id` = :lang_id AND `module` = :module')
					->parameters(array(
						':content_id' => (int) $Id,
						':lang_id' => $lang_id,
						':content_title' => Security::xss_clean($value['site_name']),
						':content_teaser' => $value['teaser'],
						':content_body' => $value['body'],
						':slogan' => Security::xss_clean($value['site_slogan']),
						':licence' => Security::xss_clean($value['site_licence']),
						':copyright' => Security::xss_clean($value['site_copyright']),
						':module' => 'siteinfo',
					))
					->execute();
				} else {
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableDesc . '` (`content_id`, `lang_id`, `content_title`, `content_teaser`, `content_body`, `content_var_field1`, `content_var_field2`, `content_text_field`, `module`) VALUES (:content_id, :lang_id, :content_title, :content_teaser, :content_body, :slogan, :copyright, :licence, :module)')
						->parameters(array(
							':content_id' => (int) $Id,
							':lang_id' => $lang_id,
							':content_title' => Security::xss_clean($value['site_name']),
							':content_teaser' => $value['teaser'],
							':content_body' => $value['body'],
							':slogan' => Security::xss_clean($value['site_slogan']),
							':licence' => Security::xss_clean($value['site_licence']),
							':copyright' => Security::xss_clean($value['site_copyright']),
							':module' => 'siteinfo',
						))
						->execute();
				}			
			}
		}
		return TRUE;
    }
}