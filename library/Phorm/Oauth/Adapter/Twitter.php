<?php

require_once('Phorm/Oauth/Adapter/Abstract.php');

/**
 * Адаптер Twitter
 * 
 * @category Phorm
 * @package Oauth
 * @name /Phorm/Oauth/Adapter/Twitter.php
 * @copyright phorm.ru
 * @since 03.11.2012
 * @version 1.0
 * @author vladimir@kachalov.net
 * @license MIT License
 */

class Phorm_Oauth_Adapter_Twitter extends Phorm_Oauth_Adapter_Abstract {
	
	/**
	 * Массив опций
	 * @var array
	 */
	protected $_options = array(
		'siteUrl' => 'https://api.twitter.com/oauth',
		'authorizeUrl' => 'https://api.twitter.com/oauth/authorize',
		'requestTokenUrl' => 'https://api.twitter.com/oauth/request_token',
		'accessTokenUrl' => 'https://api.twitter.com/oauth/access_token',
		'userInfoUrl' => 'https://api.twitter.com/1.1/users/show.json',
	);
	
	
	/**
	 * Возвращает информацию о пользователе, приведенную к единому формату
	 *
	 * @param array $userinfo
	 * @return array
	 */
	
	public function getMappedUserInfo($userinfo) {
		
		//print_r($userinfo);
		//die();
		
		$fio = explode(' ',$userinfo['name']);
		
		return array(
			'provider' => 'twitter',
			'userid' => $userinfo['id'],
			'username' => $userinfo['screen_name'],
			'gender' => null,
			'email' => $userinfo['id'] . '@twitter.com',
			'locale' => $userinfo['lang'],
			'firstname' => $fio[0],
			'lastname' => $fio[1],
			'link' => 'https://twitter.com/' . $userinfo['screen_name'],
			'avatar' => $userinfo['profile_image_url'],
		);
		
	}
	
	/**
	 * Возвращает результат GET-запроса к сервису за информацией о пользователе
	 *
	 * @param array $callback
	 * @return array
	 */
	
	public function getUserInfo($callback) {
		
		$options = array(
			'oauth_consumer_key' => $this->_options['key'],
			'oauth_token' => $callback['oauth_token'],
			'user_id' => $callback['user_id'],
			'oauth_nonce' => rand(1111,9999),
			'oauth_timestamp' => time(),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_version' => '1.0',
			'format' => 'json'
		);
		
		ksort($options);
		
		$sig = new Zend_Oauth_Signature_Hmac($this->_options['secret'],$callback['oauth_token_secret'],'sha1');
		$options['oauth_signature'] = $sig->sign($options,'GET',$this->_options['userInfoUrl']);
		
		$client = new Zend_Http_Client($this->_options['userInfoUrl'] . '?' . http_build_query($options));

		if($response = $client->request(Zend_Http_Client::GET)) {
			
			return Zend_Json::decode($response->getBody());
			
		}
		
		return false;
		
	}
	
}
