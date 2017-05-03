<?php defined('SYSPATH') or die('No direct script access.');

class Request extends Kohana_Request {

	public static function detect_uri_with_langpart($lang_ident = 'ru')
	{
		$uri_array = explode('/', Request::detect_uri());
		
		if(Request::detect_uri() == ''){
			$uri = '/'.$lang_ident.Request::detect_uri();
		} else {
			$uri = '/'.$lang_ident.'/'.Request::detect_uri();
		}
		
		$languages = Kohana::$config->load('language');
				
		if(isset($uri_array[0])){
			if(isset($languages[$uri_array[0]])){
				if(isset($uri_array[1])){
					$uri = '/';
					$uri .= $lang_ident.'/';
					foreach($uri_array as $key => $value){
						if($key > 0){
							if($key == (count($uri_array)-1)){
								$uri .= $value;
							} else {
								$uri .= $value . '/';
							}
						}
					}
				} else {
					$uri = '/';
					$uri .= $lang_ident;
				}
			}
		}
		return $uri;
	}
	
	public function redirect($url = '', $code = 302, $char_codding = TRUE)
	{
		$referrer = $this->uri();

		if (strpos($referrer, '://') === FALSE)
		{
			$referrer = URL::site($referrer, TRUE, Kohana::$index_file);
		}

		if (strpos($url, '://') === FALSE)
		{
			// Make the URI into a URL
			$url = URL::site($url, TRUE, Kohana::$index_file, $char_codding);
		}

		if (($response = $this->response()) === NULL)
		{
			$response = $this->create_response();
		}

		echo $response->status($code)
			->headers('Location', $url)
			->headers('Referer', $referrer)
			->send_headers()
			->body();

		// Stop execution
		exit;
	}
}