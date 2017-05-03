<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Error extends Controller_Template {

	public function action_index()
    {
		$status = $this->request->param('code');
		
		if(!$status){
			$status = '404';
		}
		
		if (Request::$initial !== Request::$current)
        {
            $message = rawurldecode($this->request->param('message'));
        }
	
        $this->template->content = View::factory($status)->bind('message', $message);
		$this->page_class = 'page-404';
		$this->page_title = 'Извините, страница не найдена';
        $this->response->status($status);
    }
}