<?php

require_once('Phorm/Oauth/Adapter/Abstract.php');

/**
 * Адаптер Mail.ru (Мой Мир)
 * 
 * @category Phorm
 * @package Oauth
 * @name /Phorm/Oauth/Adapter/Mailru.php
 * @copyright phorm.ru
 * @since 03.11.2012
 * @version 1.0
 * @author vladimir@kachalov.net
 * @license MIT License
 */

class Phorm_Oauth_Adapter_Mailru extends Phorm_Oauth_Adapter_Abstract {
	
	/**
	 * Массив опций
	 * @var array
	 */
	protected $_options = array(
		'siteUrl' => 'http://mail.ru',
		'authorizeUrl' => 'https://connect.mail.ru/oauth/authorize',
		'requestTokenUrl' => 'https://connect.mail.ru/oauth/token',
		'userInfoUrl' => '' // Формируется ниже @see self::getUserInfo,
	);
	
	
	/**
	 * Возвращает информацию о пользователе, приведенную к единому формату
	 *
	 * @param array $userinfo
	 * @return array
	 */
	
	public function getMappedUserInfo($userinfo) {
		
		$userinfo = $userinfo[0];
		
		return array(
			'provider' => 'mailru',
			'userid' => $userinfo['uid'],
			'username' => $userinfo['nick'],
			'gender' => $userinfo['sex'] == 0 ? 'male' : 'female',
			'email' => $userinfo['email'],
			'locale' => null,
			'firstname' => $userinfo['first_name'],
			'lastname' => $userinfo['last_name'],
			'link' => $userinfo['link'],
			'avatar' => $userinfo['pic'],
		);
		
	}
	
	
	/**
	 * Возвращает результат GET-запроса к сервису за информацией о пользователе
	 *
	 * @param array $callback
	 * @return array
	 */
	
	public function getUserInfo($callback) {
		
		$params = array(
			'app_id=' . $this->_options['key'],
			'format=' . 'json',
			'method=' . 'users.getInfo',
			'secure=' . 1,
			'session_key=' . $callback['access_token'],
		);
		$params[] = 'sig=' . md5(implode('',$params) . $this->_options['secret']);
		
		$this->_options['userInfoUrl'] = 'http://www.appsmail.ru/platform/api?' . implode('&',$params);
		
		return parent::getUserInfo($callback);
		
	}
	
}
