<?php

/**
 * ErrorController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - error
 */
class Admin_ErrorController extends Library_Controller_Backend {

  /**
   * IS: -
   * FS: -
   * Desc: Inisiasi fungsi parent
   */
  public function init() {
    parent::init();
  }

  /**
   * IS: Parameter error_handler terdeklarasi
   * FS: Mengirimkan ke viewer: exception, request, dan message
   * Desc: Mengatur aksi yang dilakukan jika terjadi error
   */
  public function errorAction() {
    $errors = $this->_getParam('error_handler');

    switch ($errors->type) {
      case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
      case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        // 404 error -- controller or action not found
        $this->getResponse()->setHttpResponseCode(404);
        $this->view->message = 'Page not found';
        break;
      default:
        // application error 
        $this->getResponse()->setHttpResponseCode(500);
        $this->view->message = 'Application error';
        break;
    }

    $this->view->exception = $errors->exception;
    $this->view->request = $errors->request;
  }

  /**
   * IS: Parameter type terdeklarasi
   * FS: Mengirimkan ke viewer: type
   * Desc: Mengatur tipe error 
   */
  public function aclAction() {
    $type = $this->_getParam('type');
    $this->view->type = $type;
  }

}
