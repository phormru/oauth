<?php

require_once('Phorm/Oauth/Adapter/Abstract.php');

/**
 * Адаптер Инстаграм
 * 
 * @category Phorm
 * @package Oauth
 * @name /Phorm/Oauth/Adapter/Instagram.php
 * @copyright phorm.ru
 * @since 19.11.2015
 * @version 1.0
 * @author vladimir@kachalov.net
 * @license MIT License
 */

class Phorm_Oauth_Adapter_Instagram extends Phorm_Oauth_Adapter_Abstract {
	
	/**
	 * Массив опций
	 * @var array
	 */
	protected $_options = array(
		'siteUrl' => 'https://api.instagram.com/oauth/',
		'authorizeUrl' => 'https://api.instagram.com/oauth/authorize/',
		'requestTokenUrl' => 'https://api.instagram.com/oauth/access_token',
		'userInfoUrl' => 'https://api.instagram.com/v1/users/self/?access_token=%s',
		'response' => array('access_token')
	);
	
	
	/**
	 * Возвращает информацию о пользователе, приведенную к единому формату
	 *
	 * @param array $userinfo
	 * @return array
	 */
	
	public function getMappedUserInfo($userinfo) {
		
		return array(
			'provider' => 'instagram',
			'userid' => $userinfo['data']['id'],
			'username' => $userinfo['data']['username'],
			'gender' => null,
			'email' => $userinfo['data']['username'] . '@instagram.com',
			'locale' => null,
			'firstname' => $userinfo['data']['full_name'],
			'lastname' => null,
			'link' => 'https://www.instagram.com/' . $userinfo['data']['username'] . '/',
			'avatar' => $userinfo['data']['profile_picture'],
		);
		
	}
	
}
