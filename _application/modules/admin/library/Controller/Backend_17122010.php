<?php
/**
 * Backend_Controller_Common
 *
 * Backend Parent Class for Budpar
 */

class Library_Controller_Backend extends Zend_Controller_Action
{
	/** deklarasi variabel yang digunakan */
    protected $_controllerName;
    protected $_moduleName;
    protected $_actionName;
    protected $_cleanUrl;
    protected $_userInfo;
    protected $_moduleList;
	protected $_redirector = null;
    protected $_flash = null;
    protected $_paginator_sess = null;
    
    /**
     * IS: 
     * FS: 
     * Desc: Fungsi inisiasi
     */
	function init()
	{
        ob_start ("ob_gzhandler");
        header("Cache-Control: must-revalidate");
        $offset = 60 * 60 ;
        $ExpStr = "Expires: " . 
        gmdate("D, d M Y H:i:s",
        time() + $offset) . " GMT";
        header($ExpStr);		

        //Get Controller,Action,Module Name		
	    $this->_moduleName = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
	    $this->_controllerName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
	    $this->_actionName = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        $this->_cleanUrl = $this->view->rootUrl().'/'.$this->_moduleName.'/'.$this->_controllerName.'/'.$this->_actionName;

        //get user profile
        $this->setUserProfile();
		
        if(($this->_controllerName!='index')&&($this->_actionName!='index'))
        {
            if(!isset($this->_userInfo->name))
            {
                $this->_redirect($this->view->rootUrl('/admin/index'));
            }
        }
        
        //Set layout
		$layout = Zend_Layout::getMvcInstance();
		$layout->setLayoutPath(APPLICATION_PATH.'/modules/admin/layouts');
        $layout->setLayout('admin');
        
        //set redirector helper
        $this->_redirector = $this->_helper->getHelper('Redirector');
        
        //set flash messenger
        $this->_flash = $this->_helper->FlashMessenger;

        //set Edit state
        if ($this->_actionName == 'edit'){$this->view->state_edit = TRUE;}
        
        //set paginator session
        $this->_paginator_sess = new Zend_Session_Namespace('paginator');
	    $this->setPaginatorSession();
        
        //set default language (untuk sementara)
        Zend_Registry::set('language', 'en');
    }
	
    /**
     * IS: -
     * FS: Mengirimkan ke viewer: userInfo_name
     * Desc: Fungsi untuk membuat variabel yang menyimpan user session
     */
    protected function setUserProfile()
    {
        $this->_userInfo = new Zend_Session_Namespace('userInfo');
        $this->view->userInfo_name = $this->_userInfo->name;
    }
    
    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk mengosongkan session filter jika berpindah controller
     */
    protected function setPaginatorSession()
    {
        if ($this->_paginator_sess->controller_name != $this->_controllerName)
        {
                $this->_paginator_sess->controller_name = $this->_controllerName;
                $this->_paginator_sess->filter = 0;
        
        }
    }
    
    /**
     * IS: Parameter page terdeklarasi
     * FS: -
     * Desc: Fungsi untuk membuat paginator
     */
    protected function setPaginator($select, $countPerPage = 10, $pageRange = 5)
    {
        $paginator = Zend_Paginator::factory($select);
    	$pagenumber = ($this->_hasParam('page')) ? $this->_getParam('page') : 1;
        $paginator->setCurrentPageNumber($pagenumber);
        $paginator->setItemCountPerPage($countPerPage);
        $paginator->setPageRange($pageRange);
        return $paginator;
    }
    
    /**
     * IS: -
     * FS: record baru di basis data log admin
     * Desc: Fungsi yang dipanggil pada setiap aktifitas create, edit, dan 
     *       delete dari CMS administrator dan disimpan pada basis data log 
     *       admin 
     */
    protected function loggingaction($module, $action, $contentId, $languageId=1)
    {
        /** Preparing the date insert */
        date_default_timezone_set('Asia/Jakarta');
        $current = date("Y-m-d H:i:s", time());
        
        $data = array(
                'user_id'     => $this->_userInfo->id,
                'date'        => $current,
                'module'      => $module,
                'action'      => $action,
                'language_id' => $languageId,
                'content_id'  => $contentId
                );
        $table_log = new Model_DbTable_LogAdmin();
        $table_log->insertLog($data);
    }

}