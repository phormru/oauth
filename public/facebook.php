<?php

/**
 * Устанавливаем путь к библиотекам Zend и Phorm
 */

set_include_path('../library/');

/**
 * Инициализируем пользовательскую сессию
 */

require_once('Zend/Session/Namespace.php');
$session = new Zend_Session_Namespace('OAuth');

/**
 * Устанавливаем опции адаптера Facebook
 */

$options = array(
	'key' => 'App ID/API Key',
	'secret' => 'Secret app key',
	'callback' => 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?action=callback',
	'adapter' => 'Phorm_Oauth_Adapter_Facebook',
);

/**
 * Подключаем файл класса адаптера 
 */

require_once('Phorm/Oauth/Adapter/Facebook.php');

/**
 * Инициализируем класс Phorm_Oauth
 */

require_once('Phorm/Oauth.php');
$oauth = new Phorm_Oauth($options);

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
	
	/**
	 * Страница для перенаправления на сервер соцсети (PHP_SELF?action=request)
	 */
	
	case 'request':
		
		header('Location: ' . $oauth->getRequestUrl());
		
		break;
		
	/**
	 * Страница для возврата с сервера соцсети (PHP_SELF?action=callback)
	 */
		
	case 'callback':
		
		if($callback = $oauth->getCallback($_GET)) {
						
			if($userinfo = $oauth->getUserInfo($callback)) {
						
				$session->userinfo = $oauth->getMappedUserInfo($userinfo);		
				header('Location: ' . $_SERVER['PHP_SELF']);
							
			} else {
							
				print 'Невозможно получить информацию о пользователе';
							
			}
					
		} else {
					
			print 'Невозможно получить ответ от сервера';
					
		}
		
		break;
		
	/**
	 * Главная страница
	 */
		
	default:
		
		if(isset($session->userinfo)) {
			
    		print_r($session->userinfo);
    		
    	}
    	
    	print '<a href="' . $_SERVER['PHP_SELF'] . '?action=request">Facebook</a>';
		
		break;
	
}
