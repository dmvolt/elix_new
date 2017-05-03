<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Ajaxfiles extends Controller {

    public function action_getimages() {
        $content_id = 0;
        $file_obj = new Model_File();
        $id = Arr::get($_POST, 'id', 0);
        $module = Arr::get($_POST, 'module', 0);
        if ($id != 0) {
            $filesdata = $file_obj->get_files_by_content_id($id, $module, 1);
        } else {
            $filesdata = $file_obj->get_files_by_session(1);
        }
		$view_data = View::factory('admin/images-block')->bind('filesdata', $filesdata)->bind('module', $module)->bind('languages', $this->languages);
		echo json_encode((string)$view_data);
    }
	
	public function action_getfiles() {
        $content_id = 0;
        $file_obj = new Model_File();
        $id = Arr::get($_POST, 'id', 0);
        $module = Arr::get($_POST, 'module', 0);
        if ($id != 0) {
			$filesdata = $file_obj->get_files_by_content_id($id, $module, 0);
        } else {
            $filesdata = $file_obj->get_files_by_session(0);
        }
        $view_data = View::factory('admin/files-block')->bind('filesdata', $filesdata)->bind('module', $module)->bind('languages', $this->languages);
		echo json_encode((string)$view_data);
    }
	
    public function action_loadfiles() {
		
        $file_obj = new Model_File();
        $id = Arr::get($_POST, 'id', 0);
        $module = Arr::get($_POST, 'module', 0);
        
        $image_setting = Kohana::$config->load('admin/image.setting');
        $result = array();
        // Работа с изображениями
        if ($this->request->method() === Request::POST) {
            foreach ($_FILES[$image_setting['param_name']]['tmp_name'] as $key => $image) {
				$ext = '.' . File::ext_by_mime($_FILES[$image_setting['param_name']]['type'][$key]);
				
				list($width, $height) = getimagesize($_FILES[$image_setting['param_name']]['tmp_name'][$key]);
				
				if (empty($width) OR empty($height)){
					$is_image = 0;
				} else {
					$is_image = 1;
				}
				
                $result[] = $file_obj->_upload_files($image, $ext, null, $_FILES[$image_setting['param_name']]['name'][$key], $is_image);
            }
        }
        $res = $file_obj->add($id, $module, $result);
        echo json_encode(array('result' => $res));
    }
	
    public function action_savenewsort() {
		
        $newsortstring = Arr::get($_POST, 'newsortstring', 0);
        $file_obj = new Model_File();
        $res = $file_obj->newsort($newsortstring);
        echo json_encode(array('result' => $res));
    }
	
    public function action_deletefile() {
		
        $file_id = Arr::get($_POST, 'id', '');
        $content_id = Arr::get($_POST, 'content_id', 0);
        $module = Arr::get($_POST, 'module', null);
        $file_obj = new Model_File();
        $res = $file_obj->delete($file_id, $content_id, $module);
        $res = $file_obj->delete_description($file_id);
        echo json_encode(array('result' => $res));
    }
}