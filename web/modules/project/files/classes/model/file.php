<?php

defined('SYSPATH') or die('No direct script access.');

class Model_File {

    protected $tableName = 'files';
    protected $tableName2 = 'contents_files';
    protected $tableName3 = 'files_description';
    protected $errors = array();
    protected $session;
	
    public function __construct() {
        $this->session = Session::instance();
    }
	
    public function get_files_by_content_id($Id, $module = 'products', $is_image = 1) {
        $filesdata = array();
		
		$image_versions = Kohana::$config->load('admin/image.image_versions');
		
        $filesinfo = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName2 . ' WHERE `content_id` = :id AND `is_image` = :is_image AND `module` = :module ORDER BY `delta`', TRUE)
                ->as_object()
                ->parameters(array(
                    ':id' => $Id,
					':is_image' => $is_image,
                    ':module' => $module
                ))
                ->execute();
        if ($filesinfo AND count($filesinfo)>0) {
            foreach ($filesinfo as $data) {
                $fileobject = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName . ' WHERE `id` = :id', TRUE)
                        ->as_object()
                        ->param(':id', $data->file_id)
                        ->execute();						
				$file_description = $this->get_files_description($data->file_id);
                $filesdata[] = array(
					'file' => $fileobject[0],
					'description' => $file_description,
				);
				
				/* if(!file_exists(PARENT_DOCROOT . 'files/preview2/'.$fileobject[0]->filepathname)){
					$im = Image::factory(PARENT_DOCROOT . 'files/'.$fileobject[0]->filepathname);
					$im->resize($image_versions['preview2']['max_width'], $image_versions['preview2']['max_height'], Image::WIDTH);   	
					$im->crop($image_versions['preview2']['max_width'], $image_versions['preview2']['max_height'], NULL, 0);
					$im->save($image_versions['preview2']['upload_dir'] . $fileobject[0]->filepathname, $image_versions['preview2']['jpeg_quality']);
				} */
				
				/* if(!file_exists(PARENT_DOCROOT . 'files/preview2-mono/'.$fileobject[0]->filepathname)){
					$im = Image::factory(PARENT_DOCROOT . 'files/'.$fileobject[0]->filepathname);
					$im->gray();
					$im->resize($image_versions['preview2_mono']['max_width'], $image_versions['preview2_mono']['max_height'], Image::WIDTH);   	
					$im->crop($image_versions['preview2_mono']['max_width'], $image_versions['preview2_mono']['max_height'], NULL, 0);
					$im->save($image_versions['preview2_mono']['upload_dir'] . $fileobject[0]->filepathname, $image_versions['preview2_mono']['jpeg_quality']);
				} */
				
				/* if(!file_exists(DOCROOT . 'files/colorbox/'.$fileobject[0]->filepathname)){
					$im = Image::factory(DOCROOT . 'files/'.$fileobject[0]->filepathname);
					if ($im->width > $image_versions['colorbox']['max_width']) {
						$im->resize($image_versions['colorbox']['max_width'], $image_versions['colorbox']['max_height'], Image::AUTO);   	
					}
					$im->save($image_versions['colorbox']['upload_dir'] . $fileobject[0]->filepathname, $image_versions['colorbox']['jpeg_quality']);
				} */
            }
        }
        return $filesdata;
    }
	
	public function get_files_by_content($Id, $module = 'products', $is_image = 1) {
        return DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName2 . ' WHERE `content_id` = :id AND `is_image` = :is_image AND `module` = :module')
                ->parameters(array(
                    ':id' => $Id,
					':is_image' => $is_image,
                    ':module' => $module,
                ))
                ->execute();
    }
	
    public function get_files_by_session($is_image = 1) {
        $filesdata = array();
		
		if($is_image){
			$filesinfo = $this->session->get('add_images', 0);
		} else {
			$filesinfo = $this->session->get('add_files', 0);
		}
        	
        if ($filesinfo) {
            foreach ($filesinfo as $data) {
                $fileobject = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName . ' WHERE `id` = :id', TRUE)
                        ->as_object()
                        ->param(':id', $data)
                        ->execute();
                $filesdata[] = array(
					'file' => $fileobject[0],
					'description' => false,
				);
            }
        }
        return $filesdata;
    }
	
    public function get_files_description($file_id) {
        $filedescription = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName3 . ' WHERE `file_id` = :file_id', TRUE)
                ->as_object()
                ->param(':file_id', $file_id)
                ->execute();
		if(count($filedescription)>0){
			foreach($filedescription as $value){
				$descriptions[$value->lang_id] = array(
					'title' => $value->title,
					'link' => $value->link,
					'description' => $value->description,
				);
			}
		}
		$languages = Kohana::$config->load('language');
		foreach($languages as $value){
		if(!isset($descriptions[$value['lang_id']])){
				$descriptions[$value['lang_id']] = array(
					'title' => '',
					'link' => '',
					'description' => '',
				);
			}
		}
		if (isset($descriptions)) {
            return $descriptions;
        } else {
            return false;
        }
    }
	
    public function getErrors() {
        return $this->errors;
    }
	
    public function add($Id = 0, $module = 'products', $info = array()) {
	
        if ($Id != 0) {
            $max = DB::query(Database::SELECT, 'SELECT MAX(delta) AS maxdelta FROM ' . $this->tableName2 . ' WHERE `content_id` = :id AND `module` = :module', TRUE)
                    ->as_object()
                    ->parameters(array(
                        ':id' => $Id,
                        ':module' => $module
                    ))
                    ->execute();
        }
        foreach ($info as $delta => $data) {
            $query0 = DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName . ' (filename, filepathname, filesize, filetype, fileurl) VALUES (:filename, :filepathname, :filesize, :filetype, :fileurl)')
                    ->parameters(array(
                        ':filename' => Security::xss_clean($data->name),
                        ':filepathname' => Security::xss_clean($data->pathname),
                        ':filesize' => Security::xss_clean($data->size),
                        ':filetype' => Security::xss_clean($data->type),
                        ':fileurl' => Security::xss_clean($data->url)
                    ))
                    ->execute();
					
            $fileobject = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName . ' WHERE `filepathname` = :filepathname', TRUE)
                    ->as_object()
                    ->param(':filepathname', $data->pathname)
                    ->execute();
            if ($fileobject) {
                if ($Id != 0) {
                    $query2 = DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName2 . ' (file_id, content_id, delta, is_image, module) VALUES (:file_id, :content_id, :delta, :is_image, :module)')
                            ->parameters(array(
                                ':content_id' => (int) $Id,
                                ':file_id' => $fileobject[0]->id,
                                ':delta' => ($max[0]->maxdelta + 1) + $delta,
								':is_image' => $data->is_image,
                                ':module' => $module
                            ))
                            ->execute();
                } else {
					if($data->is_image){
						$add_images_id[] = $fileobject[0]->id;
					} else {
						$add_files_id[] = $fileobject[0]->id;
					}
                    
                }
            }
        }
		
		if (isset($add_images_id) AND !empty($add_images_id)) {
            $imagesinfo = $this->session->get('add_images', 0);
			
            if ($imagesinfo) {
                $this->session->delete('add_images');
                foreach ($imagesinfo as $fileid) {
                    $add_images_id[] = $fileid;
                }
            }
            $this->session->set('add_images', $add_images_id);
        }
        if (isset($add_files_id) AND !empty($add_files_id)) {
            $filesinfo = $this->session->get('add_files', 0);
			
            if ($filesinfo) {
                $this->session->delete('add_files');
                foreach ($filesinfo as $fileid) {
                    $add_files_id[] = $fileid;
                }
            }
            $this->session->set('add_files', $add_files_id);
        }
        if ($query0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	public function add_files_by_content($content_id, $file_id, $delta, $module = 'products', $is_image = 1) {
	
        DB::query(Database::INSERT, 'INSERT INTO ' . $this->tableName2 . ' (file_id, content_id, delta, is_image, module) VALUES (:file_id, :content_id, :delta, :is_image, :module)')
						->parameters(array(
							':content_id' => $content_id,
							':file_id' => $file_id,
							':delta' => $delta,
							':is_image' => $is_image,
							':module' => $module,
						))
						->execute();
        return true;
    }
	
    public function newsort($newsortstring) {
        if ($newsortstring) {
            $items = explode(',', $newsortstring);
        } else {
            $items = 0;
        }
        if (is_array($items)) {
            foreach ($items as $newdelta => $file_id) {
                DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName2 . ' SET `delta` = :delta WHERE `file_id` = :file_id')
                        ->parameters(array(
                            ':file_id' => $file_id,
                            ':delta' => $newdelta,
                        ))
                        ->execute();
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
    public function update_fileinfo($file_id, $data) {
		if(isset($data)){
			foreach($data as $lang_id => $value){
				$result = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName3 . '` WHERE `file_id` = :file_id AND `lang_id` = :lang_id')
                        ->parameters(array(
							':lang_id' => $lang_id,
                            ':file_id' => $file_id,
                        ))->execute();
				if(count($result)>0){
					DB::query(Database::UPDATE, 'UPDATE `' . $this->tableName3 . '` SET `title` = :title, `description` = :description, `link` = :link WHERE `file_id` = :file_id AND `lang_id` = :lang_id')
						->parameters(array(
							':file_id' => $file_id,
							':lang_id' => $lang_id,
							':title' => isset($value['title'])?Security::xss_clean($value['title']):'',
							':description' => isset($value['description'])?Security::xss_clean($value['description']):'',
							':link' => isset($value['link'])?Security::xss_clean($value['link']):'',
						))
					->execute();
				} else {
					DB::query(Database::INSERT, 'INSERT INTO `' . $this->tableName3 . '` (`file_id`, `lang_id`, `title`, `description`, `link`) VALUES (:file_id, :lang_id, :title, :description, :link)')
						->parameters(array(
							':file_id' => $file_id,
							':lang_id' => $lang_id,
							':title' => isset($value['title'])?Security::xss_clean($value['title']):'',
							':description' => isset($value['description'])?Security::xss_clean($value['description']):'',
							':link' => isset($value['link'])?Security::xss_clean($value['link']):'',
						))
						->execute();
				}				
			}
		}
        return TRUE;
    }
	
    public function _upload_files($tempfilename, $ext = NULL, $directory = NULL, $filename = NULL, $is_image = 1) {
	
        $file = new stdClass();
		
		if($is_image){
			$image_versions = Kohana::$config->load('admin/image.image_versions');
			$image_setting = Kohana::$config->load('admin/image.setting');
			if ($directory == NULL) {
				$directory = $image_setting['upload_dir'];
			}
			if ($ext == NULL) {
				$ext = '.jpg';
			}
			
			if ($filename == NULL) {
				$filename = time();
				$filename = $filename.$ext;
			} else {
				$filename = time().'_'.Text::transliteration($filename, 1);
			}
			
			$im = Image::factory($tempfilename);
			$im->save($directory . $filename);
			$file->name = $filename;
			$file->size = filesize($tempfilename);
			$file->type = $im->mime;
			$file->url = $image_setting['upload_url'] . $filename;
			$file->pathname = $filename;
			$file->is_image = $is_image;
			
			foreach ($image_versions as $key => $options) {
				// Изменение размера и загрузка изображения
				$im = Image::factory($tempfilename);
				if ($key == 'thumbnail') {
					$im->resize($options['max_width'], $options['max_height'], Image::HEIGHT); /* Высота изображения изменяется в точно заданный размер, а ширина согласно пропорции.*/
					$im->save($options['upload_dir'] . $filename, $options['jpeg_quality']);
				}
			}
		} else {
			
			$file_setting = Kohana::$config->load('admin/file.setting');
			if ($directory == NULL) {
				$directory = $file_setting['upload_dir'];
			}
			if ($ext == NULL) {
				$ext = '.doc';
			}
			
			if ($filename == NULL) {
				$filename = time();
				$filename = $filename.$ext;
			} else {
				$filename = time().'_'.Text::transliteration($filename, 1);
			}
			
			$filepath = $directory . $filename;
			
			copy($tempfilename, $filepath);
			
			$file->name = $filename;
			$file->size = filesize($tempfilename);
			$file->type = File::mime_by_ext($ext); /* File::mime($tempfilename); */
			$file->url = $file_setting['upload_url'] . $filename;
			$file->pathname = $filename;
			$file->is_image = $is_image;
		}
        return $file;
    }
	
	public function delete_files_by_content($content_id, $module = 'products', $delete_files = 1){
		$query = DB::query(Database::SELECT, 'SELECT * FROM `' . $this->tableName2 . '` WHERE `content_id` = :id AND `module` = :module')
                ->parameters(array(
					':id' => (int) $content_id,
					':module' => $module,
                ));
        $result = $query->execute();
        if (count($result) > 0) {
            foreach ($result as $res) {
                $this->delete($res['file_id'], $content_id, $module, $delete_files);
            }
        }
	}
	
    public function delete($Id, $content_id, $module = 'products', $delete_files = 1) {
        $add_files_id = array();
		$add_images_id = array();
        if ($content_id != 0) {
            DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName2 . ' WHERE `file_id` = :id AND `content_id` = :content_id AND `module` = :module')
                    ->parameters(array(
                        ':id' => $Id,
                        ':content_id' => $content_id,
                        ':module' => $module,
                    ))->execute();
            $files_to_content = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName2 . ' WHERE `content_id` = :id AND `module` = :module ORDER BY `delta`', TRUE)
                    ->as_object()
                    ->parameters(array(
                        ':id' => $content_id,
                        ':module' => $module,
                    ))
                    ->execute();
            if (count($files_to_content) > 0) {
                foreach ($files_to_content as $newdelta => $value) {
                    DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName2 . ' SET `file_id` = :file_id, `content_id` = :content_id, `delta` = :delta WHERE `file_id` = :file_id')
                           ->parameters(array(
                                ':file_id' => $value->file_id,
                                ':content_id' => $content_id,
                                ':delta' => $newdelta,
                            ))->execute();
                }
            }
            $result = DB::query(Database::SELECT, 'SELECT `file_id` FROM ' . $this->tableName2 . ' WHERE `file_id` = :id')
                        ->param(':id', $Id)
                        ->execute();
            if (count($result)==0){
                $fileobject = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName . ' WHERE `id` = :id', TRUE)
                        ->as_object()
                        ->param(':id', $Id)
						->execute();
                if ($delete_files) {
                    $image_versions = Kohana::$config->load('admin/image.image_versions');
                    $image_setting = Kohana::$config->load('admin/image.setting');
					$file_setting = Kohana::$config->load('admin/file.setting');
                    $file_path = $image_setting['upload_dir'] . $fileobject[0]->filename;
                    is_file($file_path) && unlink($file_path);
					
					$file_path2 = $file_setting['upload_dir'] . $fileobject[0]->filename;
                    is_file($file_path2) && unlink($file_path2);
					
					foreach ($image_versions as $options) {
						$file = $options['upload_dir'] . $fileobject[0]->filename;
						if (is_file($file)) {
							unlink($file);
						}
					}
                }
                $query = DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
                        ->param(':id', (int) $Id)
                        ->execute();
            }
        } else {
            $fileobject = DB::query(Database::SELECT, 'SELECT * FROM ' . $this->tableName . ' WHERE `id` = :id', TRUE)
                    ->as_object()
                   ->param(':id', $Id)
                   ->execute();
            if ($delete_files) {
                $image_versions = Kohana::$config->load('admin/image.image_versions');
                $image_setting = Kohana::$config->load('admin/image.setting');
				$file_setting = Kohana::$config->load('admin/file.setting');
                $file_path = $image_setting['upload_dir'] . $fileobject[0]->filename;
                is_file($file_path) && unlink($file_path);
				
				$file_path2 = $file_setting['upload_dir'] . $fileobject[0]->filename;
				is_file($file_path2) && unlink($file_path2);
				foreach ($image_versions as $options) {
					$file = $options['upload_dir'] . $fileobject[0]->filename;
					if (is_file($file)) {
						unlink($file);
					}
				}
            }
            $query = DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName . ' WHERE `id` = :id')
                    ->param(':id', (int) $Id)
                    ->execute();          
            $filesinfo = $this->session->get('add_files', 0);
            $this->session->delete('add_files');
            if ($filesinfo) {
               foreach ($filesinfo as $fileid) {
                    if ($fileid != $Id) {
                        $add_files_id[] = $fileid;
                    }
                }
                $this->session->set('add_files', $add_files_id);
            }
			
			$imagesinfo = $this->session->get('add_images', 0);
            $this->session->delete('add_images');
            if ($imagesinfo) {
               foreach ($imagesinfo as $fileid) {
                    if ($fileid != $Id) {
                        $add_images_id[] = $fileid;
                    }
                }
                $this->session->set('add_images', $add_images_id);
            }
        }
        return TRUE;
    }
	
	public function delete_by_filename($filename, $setting = false) {
		if($filename){
			if ($setting) {
				$image_versions = $setting['image_versions'];
				$image_setting = $setting['setting'];
			} else {
				$image_versions = Kohana::$config->load('admin/image.image_versions');
				$image_setting = Kohana::$config->load('admin/image.setting');
			}
			$file_path = $image_setting['upload_dir'] . $filename;
			$success = is_file($file_path) && unlink($file_path);
			if ($success) {
				foreach ($image_versions as $options) {
					$file = $options['upload_dir'] . $filename;
					if (is_file($file)) {
						unlink($file);
					}
				}
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
    }
	
    public function delete_description($Id) {
        DB::query(Database::DELETE, 'DELETE FROM ' . $this->tableName3 . ' WHERE `file_id` = :file_id')
                ->param(':file_id', (int) $Id)
                ->execute();
        return TRUE;
    }
}