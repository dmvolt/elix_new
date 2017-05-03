<?php

class Paypal {
	/**
	* Последние сообщения об ошибках
	* @var array
	*/
	protected $_errors = array();

	/**
	* Данные API
	* Обратите внимание на то, что для песочницы нужно использовать соответствующие данные
	* @var array
	*/
	protected $_credentials = array(
		'USER' => 'vasyache1_api1.hotmail.com',
		'PWD' => 'LDNL6JLW28JVJ4YG',
		'SIGNATURE' => 'A6Pc23YcugQboxJ0KRw.oaM82joHAJBflhSqTsPx3ncrlR4bVr267kbY',
	);

	/**
	* Указываем, куда будет отправляться запрос
	* Реальные условия - https://api-3t.paypal.com/nvp
	* Песочница - https://api-3t.sandbox.paypal.com/nvp
	* @var string
	*/
	protected $_endPoint = 'https://api-3t.sandbox.paypal.com/nvp';

	/**
	* Версия API
	* @var string
	*/
	protected $_version = '74.0';
	
	public function __construct() {
	
		$config_mrch = Kohana::$config->load('payment.merchant');
		
		$this->_credentials['USER'] = $config_mrch['user'];
		$this->_credentials['PWD'] = $config_mrch['pwd'];
		$this->_credentials['SIGNATURE'] = $config_mrch['signature'];
		$this->_endPoint = $config_mrch['service_url'];
		$this->_version = $config_mrch['version'];
    }

	/**
	* Сформировываем запрос
	*
	* @param string $method     Данные о вызываемом методе перевода
	* @param array $params      Дополнительные параметры
	* @return array / boolean Response array / boolean false on failure
	*/
	public function request($method,$params = array()) {
		$this -> _errors = array();
		if(empty($method)) { // Проверяем, указан ли способ платежа
			$this->_errors = array('Не указан способ платежа');
			return false;
		}

		// Параметры нашего запроса
		$requestParams = array(
			'METHOD' => $method,
			'VERSION' => $this->_version
		) + $this->_credentials;

		// Сформировываем данные для NVP
		$request = http_build_query($requestParams + $params);

		// Настраиваем cURL
		$curlOptions = array (
			CURLOPT_URL => $this->_endPoint,
			CURLOPT_VERBOSE => 1,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			//CURLOPT_CAINFO => DOCROOT.'sqrty/cacert.pem', // Файл сертификата
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $request
		);

		$ch = curl_init();
		curl_setopt_array($ch,$curlOptions);

		// Отправляем наш запрос, $response будет содержать ответ от API
		$response = curl_exec($ch);

		// Проверяем, нету ли ошибок в инициализации cURL
		if (curl_errno($ch)) {
			$this -> _errors = curl_error($ch);
			curl_close($ch);
			return false;
		} else  {
			curl_close($ch);
			$responseArray = array();
			parse_str($response,$responseArray); // Разбиваем данные, полученные от NVP в массив
			return $responseArray;
		}
	}
}