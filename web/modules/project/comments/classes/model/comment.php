<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Comment {

    protected $tableName = 'comments';
	
	/**
     * Queries examples: "AND `module` = 'articles' AND `content_id` = 10 AND `lang_id` = 1"
     */
	public function get_all_comments($query = '') {
	
		$content = array();
		
		$user_obj = new Model_User();
		
		$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `parent_id` = :parent_id ' . $query . ' ORDER BY `timestamp`')
			->parameters(array(
				':parent_id' => 0,
			))->execute();
			
		if(count($result)>0){
			foreach($result as $value){
				$reply_result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `parent_id` = :parent_id ' . $query . ' ORDER BY `timestamp`')
					->parameters(array(
						':parent_id' => $value['id'],
					))->execute();
					
				$content[] = array(
					'id' => $value['id'],
					'user_id' => $value['user_id'],
					'lang_id' => $value['lang_id'],
					'content_id' => $value['content_id'],
					'module' => $value['module'],
					'parent_id' => $value['parent_id'],
					'date' => $value['date'],
					'author' => $value['author'],
					'message' => $value['message'],
					'status' => $value['status'],
				);
				
				if(count($reply_result)>0){
					foreach($reply_result as $reply_value){
							
						$content[] = array(
							'id' => $reply_value['id'],
							'user_id' => $reply_value['user_id'],
							'lang_id' => $reply_value['lang_id'],
							'content_id' => $reply_value['content_id'],
							'module' => $reply_value['module'],
							'parent_id' => $reply_value['parent_id'],
							'date' => $reply_value['date'],
							'author' => $reply_value['author'],
							'message' => $reply_value['message'],
							'status' => $reply_value['status'],
						);
					}
				}
			}
		}
		return $content;	
    }

    public function get_comments($content_id, $module = 'articles') {
	
		$content = array();
		
		$user_obj = new Model_User();
		
		$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `content_id` = :content_id AND `module` = :module AND `lang_id` = :lang_id AND `parent_id` = :parent_id ORDER BY `timestamp`')
			->parameters(array(
				':lang_id' => Data::_('lang_id'),
				':content_id' => $content_id,
				':module' => $module,
				':parent_id' => 0,
			))->execute();
			
		if(count($result)>0){
			foreach($result as $value){
				$reply_result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `content_id` = :content_id AND `module` = :module AND `lang_id` = :lang_id AND `parent_id` = :parent_id ORDER BY `timestamp`')
					->parameters(array(
						':lang_id' => Data::_('lang_id'),
						':content_id' => $content_id,
						':module' => $module,
						':parent_id' => $value['id'],
					))->execute();
					
				if($value['user_id']){
					$userdata = $user_obj->get_userdata($value['user_id']);
					if($userdata[0]->avatar){
						$avatar = $userdata[0]->avatar;
					} else {
						$avatar = Kohana::$config->load('comment_setting.default_admin_avatar');
					}
				} else {
					$avatar = Kohana::$config->load('comment_setting.default_user_avatar');
				}
					
				$content[] = array(
					'id' => $value['id'],
					'user_id' => $value['user_id'],
					'lang_id' => $value['lang_id'],
					'content_id' => $value['content_id'],
					'module' => $value['module'],
					'parent_id' => $value['parent_id'],
					'date' => $value['date'],
					'author' => $value['author'],
					'message' => $value['message'],
					'status' => $value['status'],
					'avatar' => $avatar,
				);
				
				if(count($reply_result)>0){
					foreach($reply_result as $reply_value){
						if($reply_value['user_id']){
							$userdata2 = $user_obj->get_userdata($reply_value['user_id']);
							if($userdata2[0]->avatar){
								$avatar2 = $userdata2[0]->avatar;
							} else {
								$avatar2 = Kohana::$config->load('comment_setting.default_admin_avatar');
							}
						} else {
							$avatar2 = Kohana::$config->load('comment_setting.default_user_avatar');
						}
							
						$content[] = array(
							'id' => $reply_value['id'],
							'user_id' => $reply_value['user_id'],
							'lang_id' => $reply_value['lang_id'],
							'content_id' => $reply_value['content_id'],
							'module' => $reply_value['module'],
							'parent_id' => $reply_value['parent_id'],
							'date' => $reply_value['date'],
							'author' => $reply_value['author'],
							'message' => $reply_value['message'],
							'status' => $reply_value['status'],
							'avatar' => $avatar2,
						);
					}
				}
			}
		}
		return $content;	
    }

    /**
     * Create new comment
     */
    public function create_comment($data) {
	
		$query = DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableName . '` (`content_id`, `lang_id`, `user_id`, `parent_id`, `module`, `author`, `message`, `date`, `status`, `timestamp`) VALUES (:content_id, :lang_id, :user_id, :parent_id, :module, :author, :message, :date, :status, :timestamp)')
                ->parameters(array(
                    ':content_id' => $data['content_id'],
                    ':lang_id' => Data::_('lang_id'),
                    ':parent_id' => $data['parent_id'],
                    ':module' => $data['module'],
                    ':author' => Security::xss_clean($data['author']),
                    ':message' => Security::xss_clean($data['message']),
                    ':date' => $data['date'],
					':status' => $data['status'],
					':user_id' => $data['user_id'],
					':timestamp' => time(),
                ))
                ->execute();
				
		return mysql_insert_id();
    }
	
	public function delete_comment($id) {
	
		$children = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `parent_id` = :id')
			->parameters(array(
				':id' => $id,
			))->execute();
			
        $query = DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
                ->param(':id', (int) $id)
                ->execute();
				
		if(count($children)>0){
			foreach($children as $child){
				DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
                ->param(':id', (int) $child['id'])
                ->execute();
			}
		}

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	public function delete_messages($data) {
		foreach ($data['delete'] as $id => $value) {            
			$this->delete_comment($id);          
		}
		return TRUE;
    }
	
	public function edit_status_messages($data) {
		foreach ($data['status'] as $id => $value) {            
			DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `status` = :status WHERE `id` = :id')
					->parameters(array(
						':id' => $id,
						':status' => $value,
					))
					->execute();            
		}
		return TRUE;
    }
	
	public function reply_messages($data) {
		foreach ($data['author'] as $id => $value) { 
			if($data['message'][$id] != ''){
			
				$comment_data = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName . '` WHERE `id` = :id')
					->parameters(array(
						':id' => $id,
					))->execute();
					
				if($data['module']){
					$module = $data['module'];
				} else {
					$module = $comment_data[0]['module'];
				}
				
				if($data['content_id']){
					$content_id = $data['content_id'];
				} else {
					$content_id = $comment_data[0]['content_id'];
				}
			
				DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableName . '` (`content_id`, `lang_id`, `user_id`, `parent_id`, `module`, `author`, `message`, `date`, `status`, `timestamp`) VALUES (:content_id, :lang_id, :user_id, :parent_id, :module, :author, :message, :date, :status, :timestamp)')
					->parameters(array(
						':content_id' => $content_id,
						':lang_id' => $data['lang_id'],
						':parent_id' => $id,
						':module' => $module,
						':author' => Security::xss_clean($value),
						':message' => Security::xss_clean($data['message'][$id]),
						':date' => date('d/m/Y'),
						':status' => 1,
						':user_id' => $data['user_id'],
						':timestamp' => time(),
					))
					->execute();
			}
		}
		return TRUE;
    }
}