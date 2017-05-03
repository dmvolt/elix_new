<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Ajaxmenu extends Controller {
	
	public function action_loadfile() {		
        $file = new Model_File();        
        $image_setting = Kohana::$config->load('admin/image.setting');
        $res = '';

		if (!$_FILES['file']['error']) {
			ini_set("memory_limit", "256M");
			ini_set("max_execution_time", 900);
			ini_set("upload_max_filesize", "64M");
            $image = $_FILES['file']['tmp_name'];
			
			$filetype_arr = explode('/', $_FILES['file']['type']);
			$ext = '.' . end($filetype_arr);
				
			$result = $file->_upload_files($image, $ext, null, $_FILES['file']['name']);
			$res = $result->name;
        }
        echo $res;
    }
	
	public function action_update_img() {
		$res = true;
        $filename = Arr::get($_POST, 'filename', false);
		$id = Arr::get($_POST, 'id', 0);
		
		if($filename AND $id){		   
			$menu_obj = new Model_Menu();
			$res = $menu_obj->update_img($id, $filename);
		}
        echo json_encode($res);
    }
	
	public function action_delete_by_id() {
		$file_obj = new Model_File();
		$menu_obj = new Model_Menu();
		$res = true;       
        $module = Arr::get($_POST, 'module', 'menu');
		$id = Arr::get($_POST, 'id', 0);
			
		$filename = $menu_obj->get_img($id);	   
		if($filename){
			$res = $file_obj->delete_by_filename($filename);
			$res = $menu_obj->update_img($id);
		}
        echo json_encode($res);
    }
}