<?php

require_once('Phorm/Oauth/Adapter/Abstract.php');

/**
 * Адаптер Facebook
 * 
 * @category Phorm
 * @package Oauth
 * @name /Phorm/Oauth/Adapter/Facebook.php
 * @copyright phorm.ru
 * @since 23.11.2012
 * @version 1.0
 * @author vladimir@kachalov.net
 * @license MIT License
 */

class Phorm_Oauth_Adapter_Facebook extends Phorm_Oauth_Adapter_Abstract {
	
	/**
	 * Массив опций
	 * @var array
	 */
	protected $_options = array(
		'siteUrl' => 'https://graph.facebook.com',
		'authorizeUrl' => 'https://www.facebook.com/dialog/oauth',
		'requestTokenUrl' => 'https://graph.facebook.com/oauth/access_token',
		'userInfoUrl' => 'https://graph.facebook.com/me?access_token=%s',
		'response' => array('access_token')
	);
	
	/**
	 * Возвращает результат POST-запроса к сервису за токеном
	 * Facebook не возвращает JSON, поэтому переопределяем метод
	 *
	 * @param array $data [code]
	 * @return array
	 */
	
	public function getCallback($data) {
		
		if(!isset($data['code'])) return false;
		
		$client = new Zend_Http_Client($this->_options['requestTokenUrl']);
		$client -> setHeaders('Content-Type','application/x-www-form-urlencoded')
				-> setHeaders('Accept','application/json')
				-> setParameterPost(array(
					'code' => $data['code'],
					'client_id' => $this->_options['key'],
					'client_secret' => $this->_options['secret'],
					'redirect_uri' => $this->_options['callback'],
					'grant_type' => 'authorization_code',
				));
						
		if($response = $client->request(Zend_Http_Client::POST)) {
			parse_str($response->getBody(),$params);
			return $params;
		}
		
		return false;
		
	}
	
	/**
	 * Возвращает информацию о пользователе, приведенную к единому формату
	 *
	 * @param array $userinfo
	 * @return array
	 */
	
	public function getMappedUserInfo($userinfo) {
		
		$locale = explode('_',$userinfo['locale']);
		
		return array(
			'provider' => 'facebook',
			'userid' => $userinfo['id'],
			'username' => $userinfo['name'],
			'gender' => in_array($userinfo['gender'],array('male','female')) ? $userinfo['gender'] : null,
			'email' => $userinfo['id'] . '@facebook.com',
			'locale' => strtolower($locale[0]),
			'firstname' => $userinfo['first_name'],
			'lastname' => $userinfo['last_name'],
			'link' => $userinfo['link'],
			'avatar' => null,
		);
		
	}
	
}
