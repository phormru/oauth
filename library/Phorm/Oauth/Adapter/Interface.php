<?php
/**
 * Интерфейс абстрактного класса адаптеров Phorm_Oauth_Adapter_Abstract
 * 
 * @category Phorm
 * @package Oauth
 * @name /Phorm/Oauth/Adapter/Interface.php
 * @copyright phorm.ru
 * @since 02.11.2012
 * @author vladimir@kachalov.net
 * @license MIT License
 */

interface Phorm_Oauth_Adapter_Interface {
	
	/**
	 * Возвращает информацию о пользователе, приведенную к единому формату
	 * <pre>
	 * 	Допустимые поля:
	 * 		provider - название сервиса (google, yandex и пр.)
	 * 		userid - id пользователя в сервисе
	 * 		username - имя пользователя в сервисе
	 * 		email - основной email пользователя (если неизвестно, то userid@домен_сервиса)
	 * 		firstname - имя пользователя
	 * 		lastname - фамилия пользователя
	 * 		gender - пол (male,female)
	 * 		locale - локаль пользователя
	 * 		link - ссылка на профиль пользователя на сервере сервиса
	 * 		avatar - адрес аватара на сервере сервиса
	 * 	Неизвестное значение должно быть установлено в null
	 * </pre>
	 *
	 * @param array $userinfo
	 * @return array
	 */
	
	public function getMappedUserInfo($userinfo);

	
}