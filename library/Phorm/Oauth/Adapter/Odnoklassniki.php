<?php

require_once('Phorm/Oauth/Adapter/Abstract.php');

/**
 * Адаптер Одноклассники.ру
 * 
 * @category Phorm
 * @package Oauth
 * @name /Phorm/Oauth/Adapter/Odnoklassniki.php
 * @copyright phorm.ru
 * @since 05.11.2012
 * @version 1.0
 * @author vladimir@kachalov.net
 * @license MIT License
 */

class Phorm_Oauth_Adapter_Odnoklassniki extends Phorm_Oauth_Adapter_Abstract {
	
	/**
	 * Массив опций
	 * @var array
	 */
	protected $_options = array(
		'siteUrl' => 'http://odnokassniki.ru',
		'authorizeUrl' => 'http://www.odnoklassniki.ru/oauth/authorize',
		'requestTokenUrl' => 'http://api.odnoklassniki.ru/oauth/token.do',
		'userInfoUrl' => '', // Формируется ниже @see self::getUserInfo
		'request' => array(
			'scope' => 'VALUABLE ACCESS'
		)
	);
	
	
	/**
	 * Возвращает информацию о пользователе, приведенную к единому формату
	 *
	 * @param array $userinfo
	 * @return array
	 */
	
	public function getMappedUserInfo($userinfo) {
		
		return array(
			'provider' => 'odnokassniki',
			'userid' => $userinfo['uid'],
			'username' => $userinfo['name'],
			'gender' => in_array($userinfo['gender'],array('male','female')) ? $userinfo['gender'] : null,
			'email' => $userinfo['uid'] . '@odnoklassniki.ru',
			'locale' => $userinfo['locale'],
			'firstname' => $userinfo['first_name'],
			'lastname' => $userinfo['last_name'],
			'link' => 'http://www.odnoklassniki.ru/profile/' . $userinfo['uid'],
			'avatar' => $userinfo['pic_2'],
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
			'application_key=' . $this->_options['appkey'],
			'format=' . 'json',
			'method=' . 'users.getCurrentUser',
		);
		$params[] = 'sig=' . md5(implode('',$params) . md5($callback['access_token'] . $this->_options['secret']));
		$params[] = 'access_token=' . $callback['access_token'];
		
		$this->_options['userInfoUrl'] = 'http://api.odnoklassniki.ru/fb.do?' . implode('&',$params);
		
		return parent::getUserInfo($callback);
		
	}
	
}
