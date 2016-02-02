<?php
/**
 * LogController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - log admin
 */
require_once 'Zend/Controller/Action.php';

class Admin_LogController extends Library_Controller_Backend
{
    /**
     * IS: -
     * FS: -
     * Desc: Inisiasi fungsi parent
     */
    protected $log;
    
    protected $filter;

    public function init()
	{
                $this->log = new Model_DbTable_LogAdmin();
                $this->filter = new Zend_Session_Namespace('filter');
		parent::init();
                
	}
    
    /**
     * IS: Terdeklarasinya filter dan param di session, dan page_row 
     * FS: Mengirimkan ke viewer: cleanUrl, filter_alert, page_row, 
     *     dan paginator
     * Desc: Mengatur aksi yang dilakukan untuk halaman index log
     */
	public function indexAction()
    {
        /** Send this page url to the view */
        $this->view->cleanurl = $this->_cleanUrl;
        $new_search = FALSE;
        /** Create table instance */
//        $table_log = new Model_DbTable_LogAdmin;
        
        if ($this->getRequest()->isPost()) {
        $post = $this->getRequest()->getPost();
        switch ($post['action']) {
        case 'filter':
          $this->filter->log        = $post['filter'];
          break;
        case 'sort':
          $this->filter->log          = $post['filter'];
          if ($this->filter->log['order'] == 'ASC')
            $this->filter->log['order'] = 'DESC';
          else
            $this->filter->log['order'] = 'ASC';
          break;
        case 'reset':
          $this->filter->unsetAll();
          break;
        default:
          break;
            }
        }
        
        $filter = $this->_paginator_sess->filter;
        $param = $this->_paginator_sess->param;
        
       $select = $this->log->getQueryAll($this->filter->log, $param);
       $data = $this->log->fetchAll($select);
       
        
        /** Get page row setting and send to the paginator control */
        $page_row = $this->_getParam('filterPageRow');
        $this->view->row = $page_row;

		if ($page_row != null) {
    		$paginator = parent::setPaginator($select, $page_row);
        } else {
    		$paginator = parent::setPaginator($select);
        }
        $pageNumber = $this->_getParam('page');
        $log = Zend_Paginator::factory($select);
        $log->setCurrentPageNumber($pageNumber);
        $log->setItemCountPerPage(5);
        if (null != $this->filter->log['row'])
        $log->setItemCountPerPage($this->filter->log['row']);

        /**
         * If this is a new search
         * then return the page number back to the 1st page
         */
        if ($new_search) { $paginator->setCurrentPageNumber(1); }
        
        /** Send data to the view */
		$this->view->paginator = $paginator;
                $this->view->log = $log;
                $this->view->filter = $this->filter->log;
    }
}