<?php

class Budpar_Controller_Plugin_AccessPlugin extends Zend_Controller_Plugin_Abstract {

  public $adminDb;
  public $acl;
  protected $_auth;

  public function __construct(Zend_Auth $auth) {
    $this->_auth = $auth;
    $this->acl   = new Zend_Acl();
  }

  public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
    if ($request->getModuleName() == 'admin') {
      
      if (!$this->_auth->hasIdentity()) {
        if ($request->getControllerName() == 'index'
                && $request->getActionName() == 'login') {
          return true;
        }
        $this->getResponse()->setRedirect(Zend_Controller_Front::getInstance()->getBaseUrl() . '/' . 'admin/index/login');
      } else {
        if ($request->getControllerName() == 'index'
                && $request->getActionName() == 'login') {
          $this->getResponse()->setRedirect(Zend_Controller_Front::getInstance()->getBaseUrl() . '/' . 'admin/index');
        }
      }
      
    }
  }

  public function preDispatch(Zend_Controller_Request_Abstract $request) {
    try {
      $module = $request->getModuleName();
      if ($module == 'admin') {
        $moduleList     = new Zend_Session_Namespace('moduleList');
        $userInfo       = new Zend_Session_Namespace('userInfo');
        $module         = $moduleList->module;
        $allowed_module = $userInfo->module_list;

        //generating all resources
        $acl = new Zend_Acl();

        //generating user permission
        $acl->addRole(new Zend_Acl_Role('admin'));
        $acl->addRole(new Zend_Acl_Role('anonymous'));

        $acl->add(new Zend_Acl_Resource('index'));
        $acl->add(new Zend_Acl_Resource('ajax'));
        $acl->allow('admin', 'index');
        $acl->allow('admin', 'ajax');
        if (!empty($module)) {
          foreach ($module as $value) {
            if (!$acl->has($value['controller'])) {
              $acl->add(new Zend_Acl_Resource($value['controller']));
            }

            if (in_array($value['id'], $allowed_module)) {
              if (($value['action']) != null) {
                $acl->allow('admin', $value['controller'], $value['action']);
              } else {
                $acl->allow('admin', $value['controller']);
              }
            }
          }
        }

        //allowing anonymous user to get into the login page
        $acl->allow('anonymous', 'index', 'index');
        $acl->allow('anonymous', 'index', 'login');
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
          $role = 'admin';
        } else {
          $role = 'anonymous';
        }

        $controller = $request->controller;
        $action     = $request->action;
        if (!$acl->isAllowed($role, $controller, $action)) {
          $request->setModuleName('admin');
          $request->setControllerName('error');
          $request->setActionName('acl');
          $request->setParam('type', 1);
        }
      }
    } catch (Zend_Acl_Exception $e) {
      $request->setModuleName('admin');
      $request->setControllerName('error');
      $request->setActionName('acl');
      $request->setParam('type', 2);
    }
  }

}