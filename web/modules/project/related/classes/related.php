<?php

defined('SYSPATH') or die('No direct script access.');

class Related {

    public static function get_related($product_id) {
        $related = array();
        $related_obj = new Model_Related();
        $articles_obj = new Model_Articles();
        $related_codes = $related_obj->get_related_to_content($product_id);
        
        if(count($related_codes)>0){
            foreach($related_codes as $value){
				$result = $articles_obj->get_content($value['code']);
				if($result){
					$related[] = $result;
				}
            }
        }
        echo View::factory(Data::_('template_directory') . 'related')->bind('related', $related);
    }
}
// Related