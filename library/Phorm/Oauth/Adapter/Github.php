<?php

require_once('Phorm/Oauth/Adapter/Abstract.php');

/**
 * Адаптер Github
 * 
 * @category Phorm
 * @package Oauth
 * @name /Phorm/Oauth/Adapter/Github.php
 * @copyright phorm.ru
 * @since 03.11.2012
 * @version 1.0
 * @author vladimir@kachalov.net
 * @license MIT License
 */

class Phorm_Oauth_Adapter_Github extends Phorm_Oauth_Adapter_Abstract {
	
	/**
	 * Массив опций
	 * @var array
	 */
	protected $_options = array(
		'siteUrl' => 'https://github.com',
		'authorizeUrl' => 'https://github.com/login/oauth/authorize',
		'requestTokenUrl' => 'https://github.com/login/oauth/access_token',
		'userInfoUrl' => 'https://api.github.com/user?access_token=%s',
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
			'provider' => 'github',
			'userid' => $userinfo['id'],
			'username' => $userinfo['login'],
			'gender' => null,
			'email' => isset($userinfo['email']) ? $userinfo['email'] : '@github.com',
			'locale' => 'ru',
			'firstname' => isset($userinfo['name']) ? $userinfo['name'] : null,
			'lastname' => null,
			'link' => $userinfo['html_url'],
			'avatar' => $userinfo['avatar_url'],
		);
		
	}
	
}
