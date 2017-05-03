<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Ajaxinfoblock extends Controller {
	
	public function action_gallery_block() {
		$id = Arr::get($_POST, 'id', 0);
		$view_data = '';
        $infoblock_obj = new Model_Infoblock();
        $result = $infoblock_obj->get_content($id);
		
		if($result AND $result['images']){
			$view_data .= '<div class="horizontal-gallery-wrapper"><div class="before"></div><div class="next"></div>
				<div class="horizontal-gallery">';
					foreach($result['images'] as $file){
						$view_data .= '<a href="/files/colorbox/'.$file['file']->filepathname.'"  class="pic-fancybox" rel="horizontal"><img src="/files/preview2/'.$file['file']->filepathname.'" title="' . $file['description'][Data::_('lang_id')]['title'] . '" alt="' . $file['description'][Data::_('lang_id')]['link'] . '"></a>';
					}
				$view_data .= '</div>
			</div>';
		}
		
		/* $view_data = View::factory(Data::_('template_directory') . 'gallery-block')->set('gallery', $result); */
        echo json_encode((string)$view_data);
    }
}