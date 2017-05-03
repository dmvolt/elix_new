<?php
defined('SYSPATH') or die('No direct script access.');
class Controller_Liteedit extends Controller {
	public function action_editfield() {
		
        $module = Arr::get($_POST, 'module', false);
        $id = Arr::get($_POST, 'id', 0);
		$lang_id = Arr::get($_POST, 'lang_id', 1);
		$field = Arr::get($_POST, 'field', 'body');
		$html = Arr::get($_POST, 'html', '');
		
		$data = array();
        $validation = Validation::factory($_POST);      
		$validation->rule('html', 'not_empty');
        if (!$validation->check()) {
            $res = '<span class="error">Пустое текстовое поле!</span>';
        } else {
		
			if($module AND $id){
			
				$liteedit_obj = new Model_Liteedit();			
				$data[$id]['descriptions'][$lang_id][$field] = $html;				
				$res = $liteedit_obj->new_field($data, $field, $module);
				
				if($res){
					$res = '<span class="ok">Ok!</span>';
				} else {
					$res = '<span class="error">Ошибка!</span>';
				}
				
			} else {
				$res = '<span class="error">Ошибка!</span>';
			}		
        }
        echo json_encode(array('result' => $res));
    }
	
	public function action_load_file_in_text() {
		
		$image_setting = Kohana::$config->load('admin/image.setting'); 
		$directory = $image_setting['upload_dir'].'/files/';
 
		$_FILES['file']['type'] = strtolower($_FILES['file']['type']);
 
		//if ($_FILES['file']['type'] == 'image/png' 
		//	|| $_FILES['file']['type'] == 'image/jpg' 
		//	|| $_FILES['file']['type'] == 'image/gif' 
		//	|| $_FILES['file']['type'] == 'image/jpeg'
		//	|| $_FILES['file']['type'] == 'image/pjpeg')
		//{
			$filename = time().'_'.Text::transliteration($_FILES['file']['name'], 1);
			$file = $directory.$filename;
			copy($_FILES['file']['tmp_name'], $file);
					
			$array = array(
				'filelink' => PARENT_FULLURL.'/files/files/'.$filename,
				'filename' => $filename
			);
			
			echo stripslashes(json_encode($array));  
		//}
    }
	
	public function action_load_image_in_text() {
		
		$image_setting = Kohana::$config->load('admin/image.setting'); 
		$directory = $image_setting['upload_dir'];
 
		$_FILES['file']['type'] = strtolower($_FILES['file']['type']);
 
		if ($_FILES['file']['type'] == 'image/png' 
			|| $_FILES['file']['type'] == 'image/jpg' 
			|| $_FILES['file']['type'] == 'image/gif' 
			|| $_FILES['file']['type'] == 'image/jpeg'
			|| $_FILES['file']['type'] == 'image/pjpeg')
		{
			$filename = time().'_'.Text::transliteration($_FILES['file']['name'], 1);
			$file = $directory.$filename;
	
			$im = Image::factory($_FILES['file']['tmp_name']);
			$im->save($file);
			// displaying file    
			$array = array(
				'filelink' => PARENT_FULLURL.'/files/'.$filename
			);
			
			echo stripslashes(json_encode($array));  
		}
    }
}