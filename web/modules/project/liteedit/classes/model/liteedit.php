<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Liteedit {

    protected $tableDesc = 'contents_descriptions';

    public function new_field($data, $field, $module) {

        if (is_array($data)) {
            foreach ($data as $id => $item) {
				foreach($item['descriptions'] as $lang_id => $value){
					$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableDesc . '` WHERE `content_id` = :content_id AND `module` = :module AND `lang_id` = :lang_id')
							->parameters(array(
								':lang_id' => $lang_id,
								':content_id' => $id,
								':module' => $module,
							))->execute();
							
					if(count($result)>0){
						DB::query(Database::UPDATE, 'UPDATE `' . $this->tableDesc . '` SET `content_'.$field.'` = :content_'.$field.' WHERE `content_id` = :content_id AND `lang_id` = :lang_id AND `module` = :module')
						->parameters(array(
							':content_id' => (int) $id,
							':lang_id' => $lang_id,
							':content_'.$field => $value[$field],
							':module' => $module,
						))
						->execute();
					} else {
						return FALSE;
					}					
				}
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
}