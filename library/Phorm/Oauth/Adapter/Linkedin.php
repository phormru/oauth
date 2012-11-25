<?php

require_once('Phorm/Oauth/Adapter/Abstract.php');

/**
 * Адаптер LinkedIn
 * Регистрация приложения https://www.linkedin.com/secure/developer?newapp=
 * 
 * @category Phorm
 * @package Oauth
 * @name /Phorm/Oauth/Adapter/Vk.php
 * @copyright phorm.ru
 * @since 05.11.2012
 * @version 1.0
 * @author vladimir@kachalov.net
 * @license MIT License
 */

class Phorm_Oauth_Adapter_Linkedin extends Phorm_Oauth_Adapter_Abstract {
	
	/**
	 * Массив опций
	 * @var array
	 */
	protected $_options = array(
		'siteUrl' => 'https://api.linkedin.com/uas/oauth',
		'authorizeUrl' => 'https://api.linkedin.com/uas/oauth/authorize',
		'requestTokenUrl' => 'https://api.linkedin.com/uas/oauth/requestToken',
		'accessTokenUrl' => 'https://api.linkedin.com/uas/oauth/accessToken',
		'userInfoUrl' => 'https://api.linkedin.com/v1/people/~:(id,first-name,last-name,public-profile-url,picture-url,email-address)'
	);
	
	
	/**
	 * Возвращает информацию о пользователе, приведенную к единому формату
	 *
	 * @param array $userinfo
	 * @return array
	 */
	
	public function getMappedUserInfo($userinfo) {
		
		return array(
			'provider' => 'linkedin',
			'userid' => $userinfo['id'],
			'username' => $userinfo['firstName'] . ' ' . $userinfo['lastName'],
			'gender' => null,
			'email' => $userinfo['id'] . '@linkedin.com',
			'locale' => null,
			'firstname' => $userinfo['firstName'],
			'lastname' => $userinfo['lastName'],
			'link' => $userinfo['publicProfileUrl'],
			'avatar' => isset($userinfo['pictureUrl']) ? $userinfo['pictureUrl'] : null,
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
