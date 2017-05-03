<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Tags {

    protected $tableName = 'tags';
    protected $tableName2 = 'contents_tags';
	
	public function add_tag($add_data = array()) {

		if (count($add_data) > 0) {
            foreach ($add_data['name'] as $lang_id => $tag_name) {

				if (trim($tag_name) != '' AND $this->unique_tag(trim($tag_name))) {

					DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (name, group_id, alias, lang_id) VALUES (:name, :group_id, :alias, :lang_id)')
							->parameters(array(
								':name' => Security::xss_clean(trim($tag_name)),
								':group_id' => $add_data['group_id'],
								':alias' => Text::transliteration(trim($tag_name)),
								':lang_id' => $lang_id,
							))
							->execute();
				} else {
					return FALSE;
				}
			}
			return TRUE;
		} else {
			return FALSE;
		}
    }
	
	public function edit_tag($Id, $add_data = array()) {
		if (count($add_data) > 0) {
            foreach ($add_data['name'] as $lang_id => $tag_name) {
				if (trim($tag_name) != '') {
					DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `name` = :name, `group_id` = :group_id, `alias` = :alias, `lang_id` = :lang_id WHERE `id` = :id')
							->parameters(array(
								':name' => Security::xss_clean(trim($tag_name)),
								':group_id' => $add_data['group_id'],
								':alias' => $add_data['alias'],
								':lang_id' => $lang_id,
								':id' => $Id,
							))
							->execute();
					DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName2 . ' SET `group_id` = :group_id WHERE `tag_id` = :tag_id')
							->parameters(array(
								':group_id' => $add_data['group_id'],
								':tag_id' => $Id,
							))
							->execute();
				} else {
					return FALSE;
				}
			}
			return TRUE;
		} else {
			return FALSE;
		}
    }
	
	public function delete_tag($Id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
                ->parameters(array(
                    ':id' => $Id,
                ))
                ->execute();
		DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName2 . ' WHERE `tag_id` = :tag_id')
                ->parameters(array(
                    ':tag_id' => $Id,
                ))
                ->execute();

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	public function delete_for_multidelete($Id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
                ->parameters(array(
                    ':id' => $Id,
                ))
                ->execute();

        if ($query) {
			DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName2 . ' WHERE `tag_id` = :tag_id')
                ->parameters(array(
                    ':tag_id' => $Id,
                ))
                ->execute();
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	public function get_tag($id) {
		$query = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `id` = :id")
			->parameters(array(
				':id' => $id,
			))
			->execute();
		$tags = $query->as_array();
        return $tags[0];
    }
	
	public function get_tag_to_alias($alias, $lang_id) {
		$query = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `alias` = :alias AND `lang_id` = :lang_id")
			->parameters(array(
				':alias' => $alias,
				':lang_id' => $lang_id,
			))
			->execute();
		$tags = $query->as_array();
        return $tags[0];
    }

    public function add($Id, $group_id, $insert_data = array(), $module = 'products') {
	
		if(!empty($insert_data)){
			foreach($insert_data[$group_id] as $lang_id => $value){
				$tags_str = trim($value);
				$add_data[$lang_id] = ($tags_str == "") ? array() : explode(",", $tags_str);  /* Преобразование строки значений, разделенных запятыми (в данном случае) в массив */
			}
		}
		$this->delete($Id, $group_id, $module);
		
		if (count($add_data) > 0) {
            foreach ($add_data as $lang_id => $data) {

				if (count($data) > 0) {
					foreach ($data as $name) {

						if ($this->unique_tag(trim($name))) {

							DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (name, group_id, alias, lang_id) VALUES (:name, :group_id, :alias, :lang_id)')
									->parameters(array(
										':name' => Security::xss_clean(trim($name)),
										':group_id' => $group_id,
										':alias' => Text::transliteration(trim($name)),
										':lang_id' => $lang_id,
									))
									->execute();

							$query = DB::query(Database::SELECT, 'SELECT id FROM ' . $this->tableName . ' WHERE name = :name AND lang_id = :lang_id') /* Узнаем id только что добавленного тега */
									->parameters(array(
										':name' => Security::xss_clean(trim($name)),
										':lang_id' => $lang_id,
									))
									->execute();

							$result = $query->as_array();

							DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName2 . ' (content_id, tag_id, group_id, module) VALUES (:content_id, :tag_id, :group_id, :module)')
									->parameters(array(
										':content_id' => $Id,
										':group_id' => $group_id,
										':tag_id' => $result[0]['id'],
										':module' => $module,
									))
									->execute();
						} else {

							$query = DB::query(Database::SELECT, 'SELECT id FROM ' . $this->tableName . ' WHERE name = :name AND lang_id = :lang_id AND group_id = :group_id') /* Узнаем id тега */
									->parameters(array(
										':name' => Security::xss_clean(trim($name)),
										':group_id' => $group_id,
										':lang_id' => $lang_id,
									))
									->execute();

							$result = $query->as_array();

							$query2 = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName2 . ' WHERE content_id = :content_id AND tag_id = :tag_id AND group_id = :group_id') /* Узнаем, принадлежит ли данный товар к этому тегу */
									->parameters(array(
										':content_id' => $Id,
										':group_id' => $group_id,
										':tag_id' => $result[0]['id'],
									))
									->execute();

							if (count($query2) == 0) {

								DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName2 . ' (content_id, tag_id, group_id, module) VALUES (:content_id, :tag_id, :group_id, :module)')
										->parameters(array(
											':content_id' => $Id,
											':group_id' => $group_id,
											':tag_id' => $result[0]['id'],
											':module' => $module,
										))
										->execute();
							}
						}
					}					
				} 
			}
			return TRUE;
		} else {
			return FALSE;
		}
    }

    public function delete($Id, $group_id = 1, $module = 'products') {
        $query = DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName2 . ' WHERE `content_id` = :content_id  AND `group_id` = :group_id AND `module` = :module')
                ->parameters(array(
                    ':content_id' => $Id,
					':group_id' => $group_id,
                    ':module' => $module,
                ))
                ->execute();

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_all($group_id = false, $lang_id = false) {
        $tags = array();
		if($group_id){
			if($lang_id){
				$query = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `group_id` = :group_id AND `lang_id` = :lang_id")
				->parameters(array(
					':group_id' => $group_id,
					':lang_id' => $lang_id,
				))
				->execute();
			} else {
				$query = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `group_id` = :group_id")
				->parameters(array(
					':group_id' => $group_id,
				))
				->execute();
			}
		} else {
			if($lang_id){
				$query = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `lang_id` = :lang_id")
				->parameters(array(
					':lang_id' => $lang_id,
				))
				->execute();
			} else {
				$query = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName)->execute();
			}
		}
		
		$tags = $query->as_array();
        return $tags;
    }
	
	public function get_all_active($group_id = false, $lang_id = false) {
        $all_tags = array();
		$tags = array();
		if($group_id){
			if($lang_id){
				$query = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `group_id` = :group_id AND `lang_id` = :lang_id")
				->parameters(array(
					':group_id' => $group_id,
					':lang_id' => $lang_id,
				))
				->execute();
			} else {
				$query = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `group_id` = :group_id")
				->parameters(array(
					':group_id' => $group_id,
				))
				->execute();
			}
		} else {
			if($lang_id){
				$query = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `lang_id` = :lang_id")
				->parameters(array(
					':lang_id' => $lang_id,
				))
				->execute();
			} else {
				$query = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName)->execute();
			}
		}
		
		$all_tags = $query->as_array();
		
		if(count($all_tags)>0){
			foreach($all_tags as $item){
				$query2 = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName2 . " WHERE `tag_id` = :tag_id AND `module` = :module AND `group_id` = :group_id")
					->parameters(array(
						':tag_id' => $item['id'],
						':group_id' => 1,
						':module' => 'articles',
					))
					->execute();

				if ($query2) {
					$tags[] = array(
						'id' => $item['id'],
						'alias' => $item['alias'],
						'name' => $item['name'],
					);
				}
			}
		}
        return $tags;
    }
	
	public function add_tags_to_content($Id, $group_id, $data = array(), $module = 'products') { 
		if(!empty($data)){
			foreach($data as $lang_id => $value){
				DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName2 . ' (content_id, group_id, tag_id, module) VALUES (:content_id, :group_id, :tag_id, :module)')
				->parameters(array(
					':content_id' => $Id,
					':group_id' => $group_id,
					':tag_id' => $value['id'],
					':module' => $module,
				))
				->execute();
			}
		}		        
		return true;
    }

    public function get_tags_to_content($Id, $group_id, $module = 'products', $adminka = 0) {
	
		$tags = array();
		$tags2 = array();
		$tags_string = '';
		
		$languages = Kohana::$config->load('language');
		foreach($languages as $value){
			$tags[$value['lang_id']] = array();
		}

		$query = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName2 . " WHERE `content_id` = :content_id AND `module` = :module AND `group_id` = :group_id", FALSE)
				->parameters(array(
					':content_id' => $Id,
					':group_id' => $group_id,
					':module' => $module,
				))
				->execute();

		if ($query) {
			$result = $query->as_array();

			foreach ($result as $tag) {
				$query2 = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `id` = :tag_id", FALSE)
						->param(':tag_id', $tag['tag_id'])
						->execute();

				$result2 = $query2->as_array();

				$tags[$result2[0]['lang_id']][] = array(
					'id' => $result2[0]['id'],
					'group_id' => $result[0]['group_id'],
					'name' => $result2[0]['name'],
					'alias' => $result2[0]['alias'],
				);
			}
		}
		
        if ($adminka) { 
			foreach ($languages as $value) {
				if(!empty($tags)){
					foreach($tags as $lang_id => $item){					
						if($lang_id == $value['lang_id']){
						
							foreach($item as $key => $item2){
								if (!$key) {
									$tags_string .= $item2['name'];
								} else {
									$tags_string .= ', ' . $item2['name'];
								}
							}
						}					
					}
					$tags2[$value['lang_id']] = $tags_string;
					$tags_string = '';
				} else {
					$tags2[$value['lang_id']] = '';
				}				
			}
            return $tags2;			
        } else {			
            return $tags;
        }
    }

    public function get_content_to_tag($Id, $group_id, $module = 'articles', $start = 0, $num = 100, $filtred_content = array()) {
        $contents = array();

        if (!empty($Id) AND is_numeric($Id)) {

            $query = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName2 . " WHERE `tag_id` = :tag_id AND `module` = :module AND `group_id` = :group_id LIMIT :start, :num", FALSE)
                    ->parameters(array(
                        ':tag_id' => $Id,
						':group_id' => $group_id,
                        ':module' => $module,
                        ':start' => (int) $start,
                        ':num' => (int) $num,
                    ))
                    ->execute();

            if ($query) {
                $result = $query->as_array();

                foreach ($result as $id) {
					if(!empty($filtred_content)){
						if(isset($filtred_content[$id['content_id']])){
							$contents[$id['content_id']] = array(
								'id' => $id['content_id'],
							);
						}
					} else {
						$contents[$id['content_id']] = array(
							'id' => $id['content_id'],
						);
					}
                }
            }
        } elseif(!empty($Id)) {

            $query0 = DB::query(Database::SELECT, "SELECT id FROM " . $this->tableName . " WHERE `alias` = :alias", FALSE)
                    ->parameters(array(
                        ':alias' => $Id,
                    ))
                    ->execute();

            if ($query0) {

                $result0 = $query0->as_array();

                $query = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName2 . " WHERE `tag_id` = :tag_id AND `module` = :module AND `group_id` = :group_id LIMIT :start, :num", FALSE)
                        ->parameters(array(
                            ':tag_id' => $result0[0]['id'],
							':group_id' => $group_id,
                            ':module' => $module,
                            ':start' => (int) $start,
                            ':num' => (int) $num,
                        ))
                        ->execute();

                if ($query) {
                    $result = $query->as_array();

                    foreach ($result as $id) {
                        if(!empty($filtred_content)){
							if(isset($filtred_content[$id['content_id']])){
								$contents[$id['content_id']] = array(
									'id' => $id['content_id'],
								);
							}
						} else {
							$contents[$id['content_id']] = array(
								'id' => $id['content_id'],
							);
						}
                    }
                }
            }
        }
		return $contents;
    }

    public function get_total($Id, $group_id, $module = 'products') {
        $query0 = DB::query(Database::SELECT, "SELECT id FROM " . $this->tableName . " WHERE `alias` = :alias", FALSE)
                ->parameters(array(
                    ':alias' => $Id,
                ))
                ->execute();

        if ($query0) {

            $result0 = $query0->as_array();

            $query = DB::query(Database::SELECT, "SELECT COUNT(content_id) AS total FROM " . $this->tableName2 . " WHERE `tag_id` = :tag_id AND `module` = :module AND `group_id` = :group_id", FALSE)
                    ->parameters(array(
                        ':tag_id' => $result0[0]['id'],
						':group_id' => $group_id,
                        ':module' => $module,
                    ))
                    ->execute();

            $result = $query->as_array();
            $total = $result[0]['total'];
        } else {
            $total = 0;
        }
        return $total;
    }
	
	public function get_autocomplete_content($filter_name, $lang_id = 1, $group_id = 1) {
        $query = DB::query(Database::SELECT, "SELECT name FROM " . $this->tableName . " WHERE group_id = :group_id AND lang_id = :lang_id AND name LIKE '%" . $filter_name . "%' ORDER BY name LIMIT 0, 50")
                ->parameters(array(
                    ':lang_id' => $lang_id,
					':group_id' => $group_id,
                ))->execute();

        if (count($query) > 0) {
			foreach($query as $value){
				$result[] = array(
					'name' => $value['name'],
				);
			}
			return $result;
        } else {
			return array();
		}
    }

    public function unique_tag($name) {
        return !DB::select(array(DB::expr('COUNT(name)'), 'total'))
                        ->from($this->tableName)
                        ->where('name', '=', $name)
                        ->execute()
                        ->get('total');
    }

}