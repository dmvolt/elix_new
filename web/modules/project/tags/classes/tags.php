<?php

defined('SYSPATH') or die('No direct script access.');

class Tags {

    public static function get_cloud() {
        $tags_obj = new Model_Tags();
        $tags = $tags_obj->get_all_active(1, 1);

        echo View::factory(Data::_('template_directory') . 'tags')->bind('tags', $tags);
    }
	
	public static function get_block($content_id, $group_id, $module = 'articles') {
		$tags_obj = new Model_Tags();		
		$content = array();
		
		$result = $tags_obj->get_tags_to_content($content_id, $group_id, $module);
		
		$group_tags = Kohana::$config->load('tags.group_tags');
		
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
				->bind('group_tags', $group_tags[$group_id])
                ->bind('content', $content);
    }
}
// Tags