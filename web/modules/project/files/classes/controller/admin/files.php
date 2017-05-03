<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Files {

	public static function set_fields($content_id = 0, $post = array(), $module = 'products') {
		$session = Session::instance();
		$file_obj = new Model_File();		
		$add_files = $session->get('add_files', 0);
		$add_images = $session->get('add_images', 0);
		if ($add_files) {
			foreach ($add_files as $delta => $file_id) {
				$file_obj->add_files_by_content($content_id, $file_id, $delta, $module, 0);
			}
			$session->delete('add_files');
		}
		
		if ($add_images) {
			foreach ($add_images as $delta => $file_id) {
				$file_obj->add_files_by_content($content_id, $file_id, $delta, $module, 1);
			}
			$session->delete('add_images');
		}
		
		if (isset($post['file_descriptions'])) {
            $file_descriptions = Arr::get($post, 'file_descriptions', null);
            if ($file_descriptions) {
                foreach ($file_descriptions as $file_id => $data) {
                    $file_obj->update_fileinfo($file_id, $data);
                }
            }
        }		
		return true;
    }
	
	public static function get_fields($data = array(), $module = 'products') {
		$file_obj = new Model_File();
		if($data AND !empty($data)){
			$filedata['filesdata'] = $file_obj->get_files_by_content_id($data['id'], $module);
		} else {
			$data['id'] = 0;
		}
		
		return View::factory('admin/fields_files')
				->bind('module', $module)
				->bind('is_image', $is_image)
                ->bind('id', $data['id']);
    }
}