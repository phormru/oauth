<?php
/**
 * Глобальный класс управления авторизацией через OAuth
 * Компонент возвращает исключительно массив информации о пользователе
 * Особенности по предоставлению доступа к этой информации см. в классе адаптера
 * 
 * @category Phorm
 * @package Oauth
 * @name /Phorm/Oauth.php
 * @copyright phorm.ru
 * @since 02.11.2012
 * @author vladimir@kachalov.net
 * @license MIT License
 */

class Phorm_Oauth {
	
	/**
	 * Массив опций
	 * @var array
	 */
	protected $_options = array();
	
	/**
	 * Экземпляр класса адаптера службы @see Phorm/Oauth/Adapter
	 * @var Phorm_Oauth_Adapter_Abstract
	 */
	protected $_adapter;
	
	/**
	 * Конструктор
	 *
	 * @param mixed $options array | Zend_Config
	 * <pre>
	 * 	Массив опций должен иметь обязательные ключи:
	 * 		adapter - название класса-адаптера @see Phorm/Oauth/Adapter
	 * 		key - id приложения, которое выдает служба (client_id)
	 * 		secret - секретный ключ, которое выдает приложение (client_secret)
	 * 		callback - URL для обработки запросов (redirect_uri)
	 * </pre>
	 * @return void
	 */
	
	public function __construct($options) {
		
		$this->setOptions($options);
		$this->setAdapter();
		
	}
	
	
	/**
	 * Устанавливает опции
	 *
	 * @param array $options
	 * @return array
	 */
	
	public function setOptions($options = array()) {
			
		if($options instanceof Zend_Config) {
			$options = $options->toArray();
		}
		
		if(isset($options['adapter'])) {
			if(!class_exists($options['adapter'],true)) {
				require_once 'Zend/Exception.php';
				throw new Zend_Exception('Couldn\'t load class ' . $options['adapter']);
			}
		} else {
			require_once 'Zend/Exception.php';
			throw new Zend_Exception('Provider name is empty');
		}
		
		if(!isset($options['key'])) {
			require_once 'Zend/Exception.php';
			throw new Zend_Exception('Client ID is empty');
		}
		
		if(!isset($options['secret'])) {
			require_once 'Zend/Exception.php';
			throw new Zend_Exception('Secret key is empty');
		}
		
		if(!isset($options['callback'])) {
			require_once 'Zend/Exception.php';
			throw new Zend_Exception('Redirect uri is empty');
		}
		
		$this->_options = $options;
		
		return $this->getOptions();
		
	}
	
	
	/**
	 * Возвращает опции
	 *
	 * @return array
	 */
	
	public function getOptions() {
		
		return $this->_options;
		
	}
	
	
	/**
	 * Устанавливает текущий адаптер
	 *
	 * @return Phorm_Oauth_Adapter_Abstract
	 */
	
	public function setAdapter() {
			
		$classname = $this->_options['adapter'];
		$this->_adapter = new $classname($this->getOptions());
		
		return $this->getAdapter();
		
	}
	
	
	/**
	 * Возвращает текущий адаптер
	 *
	 * @return Phorm_Oauth_Adapter_Abstract
	 */
	
	public function getAdapter() {
		
		return $this->_adapter;
		
	}
	
	
	/**
	 * Возвращает урл для перенаправления на страницу авторизации на сервисе
	 *
	 * @return string
	 */
	
	public function getRequestUrl() {
		
		return $this->_adapter->getRequestUrl();
		
	}
	
	
	/**
	 * Возвращает результат POST-запроса к сервису за токеном
	 *
	 * @param string $code
	 * @return string
	 */
	
	public function getCallback($code) {
		
		return $this->_adapter->getCallback($code);
		
	}
	
	
	/**
	 * Возвращает результат GET-запроса к сервису за информацией о пользователе
	 *
	 * @param string $token
	 * @return string
	 */
	
	public function getUserInfo($token) {
		
		return $this->_adapter->getUserInfo($token);
		
	}
	
	
	/**
	 * Возвращает информацию о пользователе, приведенную к единому формату
	 *
	 * @param array $userinfo
	 * @return array
	 */
	
	public function getMappedUserInfo($userinfo) {
		
		return $this->_adapter->getMappedUserInfo($userinfo);
		
	}
	
}
