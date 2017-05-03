<?php defined('SYSPATH') or die('No direct script access.');

class URL extends Kohana_URL {
	
	public static function site($uri = '', $protocol = NULL, $index = TRUE, $char_codding = TRUE)
	{
		// Chop off possible scheme, host, port, user and pass parts
		$path = preg_replace('~^[-a-z0-9+.]++://[^/]++/?~', '', trim($uri, '/'));
		if($char_codding){
			if ( ! UTF8::is_ascii($path))
			{
				// Encode all non-ASCII characters, as per RFC 1738
				$path = preg_replace('~([^/]+)~e', 'rawurlencode("$1")', $path);
			}
		}
		// Concat the URL
		return URL::base($protocol, $index).$path;
	}
}