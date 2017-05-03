<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana user guide and api browser.
 *
 * @package    Kohana/Userguide
 * @category   Controllers
 * @author     Kohana Team
 */
 
class Controller_Admin_Modulinfo extends Controller_Admin_Template {

    public function action_add() {
		$modulinfo_obj = new Model_Modulinfo();
        if (isset($_POST['descriptions'][1]['body'])) {
            
			$add_data = array(
				'descriptions' => Arr::get($_POST, 'descriptions', array()),
				'module' => Arr::get($_GET, 'module', 'articles'),
			);
			$new_content_id = $modulinfo_obj->add($add_data);
			if ($new_content_id) {
				
				/********************* Операции с модулями ********************/
				Controller_Admin_Files::set_fields($new_content_id, $_POST, 'modulinfo');
				Controller_Admin_Seo::set_fields($new_content_id, $_POST, 'modulinfo');
				Controller_Admin_Categories::set_fields($new_content_id, $_POST, 'modulinfo');
				/***********************************************************/
				
				Request::initial()->redirect('admin/'.$add_data['module']);
			}
        }
		
		/********************* Операции с модулями ********************/
        $data['files_form'] = Controller_Admin_Files::get_fields(array(), 'modulinfo');
		$data['seo_form'] = Controller_Admin_Seo::get_fields(array(), 'modulinfo');
		$data['categories_form'] = Controller_Admin_Categories::get_fields(array(), 'modulinfo');		
		/***********************************************************/		
        $this->template->content = View::factory('admin/modulinfo-add', $data);
    }
	
    public function action_edit() {
        $Id = $this->request->param('id');
        $modulinfo_obj = new Model_Modulinfo();
		
        if (isset($_POST['descriptions'][1]['body'])) {       
			$edit_data = array(
				'descriptions' => Arr::get($_POST, 'descriptions', array())
			);	   
			$result = $modulinfo_obj->edit($Id, $edit_data);
			if ($result) {
			
				/********************* Операции с модулями ********************/
				Controller_Admin_Files::set_fields($Id, $_POST, 'modulinfo');
				Controller_Admin_Seo::set_fields($Id, $_POST, 'modulinfo');
				Controller_Admin_Categories::set_fields($Id, $_POST, 'modulinfo');
				/***********************************************************/
				$edit_content = $modulinfo_obj->get_content($Id);
				Request::initial()->redirect('admin/'.$edit_content['module']);
			}
        }
        $data['content'] = $modulinfo_obj->get_content($Id);
		
		/********************* Операции с модулями ********************/		
        $data['files_form'] = Controller_Admin_Files::get_fields($data['content'], 'modulinfo');
		$data['seo_form'] = Controller_Admin_Seo::get_fields($data['content'], 'modulinfo');
		$data['categories_form'] = Controller_Admin_Categories::get_fields($data['content'], 'modulinfo');	
		/***********************************************************/
        $this->template->content = View::factory('admin/modulinfo-edit', $data);
    }
	
    public function action_delete() {
        $Id = $this->request->param('id');
        $modulinfo_obj = new Model_Modulinfo();
		$file_obj = new Model_File();
		$seo_obj = new Model_Seo();
		$categories_obj = new Model_Categories();

        if (isset($_POST['delete'])) {
            $result = $modulinfo_obj->delete($Id);
			
			/********************* Операции с модулями ********************/
			$seo_obj->delete_by_content($Id, 'modulinfo');
			$file_obj->delete_files_by_content($Id, 'modulinfo');
			$categories_obj->delete_category_by_content($Id, 'modulinfo');
			/***********************************************************/
		
            if ($result) {
                Request::initial()->redirect('admin');
            }
        }
        $data['content'] = $modulinfo_obj->get_content($Id);
        $this->template->content = View::factory('admin/modulinfo-delete', $data);
    }
	
    public function unique_module($module) {
        return !DB::select(array(DB::expr('COUNT(module)'), 'total'))
                        ->from('modulinfo')
                        ->where('module', '=', $module)
                        ->execute()
                        ->get('total');
    }
}
// End Controller_Admin_Modulinfo