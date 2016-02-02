<?php
/**
 * ErrorController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * error message
 *
 * @package Front Controller
 */
class ErrorController extends Zend_Controller_Action
{
    /**
     * IS: -
     * FS: -
     * Desc: Fungsi inisialisasi
     */
    public function init()
    {
        parent::init();
    }

    /**
     * IS: Parameter error_handler terdeklarasi
     * FS: Mengirimkan ke viewer: exception, request, dan message
     * Desc: Mengatur aksi yang dilakukan jika terjadi error
     */
    public function errorAction()
    {
        $this->_helper->layout->setLayout('one-column');

        $errors = $this->_getParam('error_handler');
    

        switch ($errors->type)
        {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

            // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                $this->view->err = '1';
                break;
            default:
            // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                $this->view->err = '2';
                break;
        }
        
        $this->view->exception = $errors->exception;
        $this->view->request   = $errors->request;
        //print_r($err);
    }

}