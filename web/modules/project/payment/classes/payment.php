<?php

defined('SYSPATH') or die('No direct script access.');

class Payment {
	
	public static function call($data) {
		$config_mrch = Kohana::$config->load('payment.merchant');
        $default_parameters = array(
            'USER' => $config_mrch['user'],
            'VENDOR' => $config_mrch['vendor'],
            'PWD' => $config_mrch['pwd'],
            'PARTNER' => $config_mrch['partner'],
            'BUTTONSOURCE' => 'OpenCart_Cart_PFP',
        );

        $call_parameters = array_merge($data, $default_parameters);

		$url = $config_mrch['service_url2'];
        
        $query_params = array();
        
        foreach ($call_parameters as $key => $value) {
            $query_params[] = $key . '=' . utf8_decode($value);
        }
        
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, implode('&', $query_params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        
        $response_params = array();
        parse_str($response, $response_params);
        
        return $response_params;
    }
}
// Payment