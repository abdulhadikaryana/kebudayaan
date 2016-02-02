<?php
/**
 * Budpar_Controller_Plugin_Demo
 *
 * Force redirect to a module or controller
 *
 * @package Budpar Library
 * @copyright Copyright (c) 2011 LAPI Divusi
 * @author Sangkuriang International
 */
 
class Budpar_Controller_Plugin_Demo
    extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
		$module = $request->module;
		$controller = $request->controller;
	
		if($module == 'default' AND ($controller != 'usercontributor' OR $controller != 'login'))
		{
            $request->setModuleName('default');
            $request->setControllerName('usercontributor');
		}
	}
}