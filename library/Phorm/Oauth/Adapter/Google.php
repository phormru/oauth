<?php

require_once('Phorm/Oauth/Adapter/Abstract.php');

/**
 * Адаптер Google+
 * 
 * @category Phorm
 * @package Oauth
 * @name /Phorm/Oauth/Adapter/Google.php
 * @copyright phorm.ru
 * @since 03.11.2012
 * @version 1.0
 * @author vladimir@kachalov.net
 * @license MIT License
 */

class Phorm_Oauth_Adapter_Google extends Phorm_Oauth_Adapter_Abstract {
	
	/**
	 * Массив опций
	 * @var array
	 */
	protected $_options = array(
		'siteUrl' => // Имя домена к которому осуществляются запросы
			'https://accounts.google.com',
		'authorizeUrl' => // Адрес страницы для авторизации
			'https://accounts.google.com/o/oauth2/auth',
		'requestTokenUrl' => // Адрес страницы для получения токена
			'https://accounts.google.com/o/oauth2/token',
		'request' => // Дополнительные параметры запроса при авторизации
			array(
				'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
			),
		'userInfoUrl' => // Адрес страницы для получения информации о пользователе
			'https://www.googleapis.com/oauth2/v1/userinfo?access_token=%s',
		'response' => // Имена ключей токена для подстановки в userInfoUrl через sprintf 
			array('access_token')
	);
	
	
	/**
	 * Возвращает информацию о пользователе, приведенную к единому формату
	 *
	 * @param array $userinfo
	 * @return array
	 */
	
	public function getMappedUserInfo($userinfo) {
		
		return array(
			'provider' => 'google',
			'userid' => $userinfo['id'],
			'username' => $userinfo['name'],
			'gender' => in_array($userinfo['gender'],array('male','female')) ? $userinfo['gender'] : null,
			'email' => $userinfo['email'],
			'locale' => $userinfo['locale'],
			'firstname' => $userinfo['given_name'],
			'lastname' => $userinfo['family_name'],
			'link' => $userinfo['link'],
			'avatar' => null,
		);
		
	}
	
}
