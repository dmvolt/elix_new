<?php

defined('SYSPATH') or die('No direct script access.');

class Seo {
	
	public static function get_select($group_id = 1, $module = 'articles') {
		$tags_obj = new Model_Tags();		
		$content = array();
		$group_tags = Kohana::$config->load('tags.group_tags');
		$result = $tags_obj->get_tags_for_select($group_id, $module);
		
		if(count($result[Data::_('lang_id')])>0) {
			foreach($result[Data::_('lang_id')] as $value){
				$content[] = array(
					'id' => $value['id'],
					'name' => $value['name'],
					'alias' => $value['alias'],
				);
			}
		}
		
		return View::factory(Data::_('template_directory') . 'block_tags_select')
				->bind('module', $module)
				->bind('group', $group_tags[$group_id][Data::_('lang_id')])
                ->bind('content', $content);
    }
	
	public static function get_block($content_id, $group_id = 1, $module = 'articles') {
		$tags_obj = new Model_Tags();		
		$content = array();
		
		$group_tags = Kohana::$config->load('tags.group_tags');
		
		$result = $tags_obj->get_tags_to_content($content_id, $group_id, $module);
		
		if(count($result[Data::_('lang_id')])>0) {
			foreach($result[Data::_('lang_id')] as $value){
				$content[] = array(
					'id' => $value['id'],
					'name' => $value['name'],
					'alias' => $value['alias'],
				);
			}
		}
		
		return View::factory(Data::_('template_directory') . 'block_tags')
				->bind('module', $module)
				->bind('group', $group_tags[$group_id][Data::_('lang_id')])
                ->bind('content', $content);
    }

}

// Tags