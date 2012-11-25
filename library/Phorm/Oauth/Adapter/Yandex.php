<?php

require_once('Phorm/Oauth/Adapter/Abstract.php');

/**
 * Адаптер Яндекс (Я.ру)
 * 
 * @category Phorm
 * @package Oauth
 * @name /Phorm/Oauth/Adapter/Yandex.php
 * @copyright phorm.ru
 * @since 03.11.2012
 * @version 1.0
 * @author vladimir@kachalov.net
 * @license MIT License
 */

class Phorm_Oauth_Adapter_Yandex extends Phorm_Oauth_Adapter_Abstract {
	
	/**
	 * Массив опций
	 * @var array
	 */
	protected $_options = array(
		'siteUrl' => 'https://oauth.yandex.ru',
		'authorizeUrl' => 'https://oauth.yandex.ru/authorize',
		'requestTokenUrl' => 'https://oauth.yandex.ru/token',
		'userInfoUrl' => 'https://login.yandex.ru/info?format=json&oauth_token=%s',
		'response' => array('access_token')
	);
	
	
	/**
	 * Возвращает информацию о пользователе, приведенную к единому формату
	 *
	 * @param array $userinfo
	 * @return array
	 */
	
	public function getMappedUserInfo($userinfo) {
		
		$fio = explode(' ',$userinfo['real_name']);
		
		return array(
			'provider' => 'yandex',
			'userid' => $userinfo['id'],
			'username' => $userinfo['display_name'],
			'gender' => in_array($userinfo['sex'],array('male','female')) ? $userinfo['sex'] : null,
			'email' => $userinfo['default_email'],
			'locale' => null,
			'firstname' => $fio[1],
			'lastname' => $fio[0],
			'link' => 'http://' . $userinfo['display_name'] . '.ya.ru',
			'avatar' => null,
		);
		
	}
	
}
