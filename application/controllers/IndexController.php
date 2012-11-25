<?php

/**
 * Контроллер для обработки запросов OAUTH к внешним сервисам
 *
 */

class IndexController extends Zend_Controller_Action {
	
	/**
	 * Объект загрузки приложения
	 * @var Zend_Bootstrap
	 */
	protected $_boot;
	
	/**
	 * Параметры запроса
	 * @var array
	 */
	protected $_params;
	
	/**
	 * Массив конфигурации приложения
	 * @var array
	 */
	protected $_cnf;
	
	/**
	 * Объект пользовательской сессии
	 * @var Zend_Session_Namespace
	 */
	protected $_session;

	/**
	 * Инициализация параметров контроллера
	 *
	 * @return void
	 */
	
	public function init() {
		
		$this->_session = new Zend_Session_Namespace('OAuth');
		
		$this->_boot = $this->getInvokeArg('bootstrap');
		$this->_cnf = $this->_boot->getOptions();
		$this->_params = $this->_request->getParams();
		
		$this->view->assign('cnf',$this->_cnf);
		$this->view->assign('params',$this->_params);
		
	}
	
	/**
	 * Главная страница
	 *
	 * @return void
	 */
    
    public function indexAction() {
    	
    	if(isset($this->_session->userinfo)) {
    		
    		$this->view->assign('userinfo',$this->_session->userinfo);
    		
    	}
    	
    }
    
    /**
	 * Страница формирования запроса
	 *
	 * @return void
	 */
    
	public function requestAction() {
		
		Zend_Controller_Action_HelperBroker::removeHelper('viewRenderer');
		
		if(isset($this->_params['provider']) && key_exists($this->_params['provider'],$this->_cnf['oauth'])) {
			
			$options = $this->_cnf['oauth'][$this->_params['provider']];
			$connect = new Phorm_Oauth($options);

			return $this->_redirect($connect->getRequestUrl());
			
		}
    	
    }
    
    /**
	 * Страница обработки результатов запроса
	 *
	 * @return void
	 */
    
	public function callbackAction() {
		
		Zend_Controller_Action_HelperBroker::removeHelper('viewRenderer');
		
		if(isset($this->_params['provider']) && key_exists($this->_params['provider'],$this->_cnf['oauth'])) {
			
			$options = $this->_cnf['oauth'][$this->_params['provider']];
			$connect = new Phorm_Oauth($options);
				
			if($callback = $connect->getCallback($this->_params)) {
						
				if($userinfo = $connect->getUserInfo($callback)) {
						
					$this->_session->userinfo = $connect->getMappedUserInfo($userinfo);
						
					return $this->_redirect('/');
							
				} else {
							
					$this->_response->setBody('Невозможно получить информацию о пользователе');
							
				}
					
			} else {
					
				$this->_response->setBody('Невозможно получить ответ от сервера');
					
			}
			
		}
    
    }

}

