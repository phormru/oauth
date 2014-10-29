<?php

require_once('Phorm/Oauth/Adapter/Abstract.php');

/**
 * Адаптер VK.com (ВКонтакте)
 * 
 * @category Phorm
 * @package Oauth
 * @name /Phorm/Oauth/Adapter/Vk.php
 * @copyright phorm.ru
 * @since 03.11.2012
 * @version 1.0
 * @author vladimir@kachalov.net
 * @license MIT License
 */

class Phorm_Oauth_Adapter_Vk extends Phorm_Oauth_Adapter_Abstract {
	
	/**
	 * Массив опций
	 * @var array
	 */
	protected $_options = array(
		'siteUrl' => 'http://vk.com',
		'authorizeUrl' => 'https://oauth.vk.com/authorize',
		'requestTokenUrl' => 'https://oauth.vk.com/token',
		'userInfoUrl' => 'https://api.vk.com/method/users.get?fields=uid,first_name,last_name,nickname,screen_name,sex,bdate,photo_big&access_token=%s&uid=%s',
		'response' => array('access_token','user_id')
	);
	
	
	/**
	 * Возвращает информацию о пользователе, приведенную к единому формату
	 *
	 * @param array $userinfo
	 * @return array
	 */
	
	public function getMappedUserInfo($userinfo) {
		
		$userinfo = $userinfo['response'][0];
		
		return array(
			'provider' => 'vk',
			'userid' => $userinfo['uid'],
			'username' => !empty($userinfo['nickname']) ? $userinfo['nickname'] : $userinfo['first_name'] . ' ' . $userinfo['last_name'],
			'gender' => $userinfo['sex'] == 0 ? 'male' : 'female',
			'email' => $userinfo['uid'] . '@vk.com',
			'locale' => null,
			'firstname' => $userinfo['first_name'],
			'lastname' => $userinfo['last_name'],
			'link' => 'http://vk.com/' . $userinfo['screen_name'],
			'avatar' => $userinfo['photo_big'],
		);
		
	}
	
}
