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
		'userInfoUrl' => 'https://api.twitter.com/1/users/show.json?user_id=%s',
		'response' => array('user_id')
	);
	
	
	/**
	 * Возвращает информацию о пользователе, приведенную к единому формату
	 *
	 * @param array $userinfo
	 * @return array
	 */
	
	public function getMappedUserInfo($userinfo) {
		
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
	
}

