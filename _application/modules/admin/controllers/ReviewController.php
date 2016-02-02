<?php
/**
 * ReviewController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - review
 */
require_once 'Zend/Controller/Action.php';

class Admin_ReviewController extends Library_Controller_Backend
{
    /**
     * IS: -
     * FS: -
     * Desc: Inisiasi fungsi parent
     */
    public function init()
	{
		parent::init();
	}
	
    /**
     * IS: Terdeklarasinya filter dan param di session, dan page_row 
     * FS: Mengirimkan ke viewer: cleanUrl, message, filter_alert, page_row, 
     *     dan paginator
     * Desc: Mengatur aksi yang dilakukan untuk halaman index review
     */
	public function indexAction() 
	{
        /** Send this page url to the view */
        $this->view->cleanurl = $this->_cleanUrl;

        /** Get messages from CRUD process */
        $message = $this->_flash->getMessages();
        if (!empty($message)) { $this->view->message = $message; }
        
        /** Create table instance */
        $table_review = new Model_DbTable_Review;
        
        /** Set the variable initial value */
        $filter     = null;
        $new_search = FALSE;
        
        /** Get the filter params */
		if ($this->getRequest()->isPost()) {
			$filter = $_POST['filterPage'];
            /** If new search is commited then we set the $new_search to TRUE */
            $new_search = TRUE;
			switch ($filter) {
				case 0 : $param = null;
                         break;
                case 1 : $param = $_POST['filterTitle'];
						 break;
                case 2 : $param = $_POST['filterStatus'];
						 break;
			}
            $this->_paginator_sess->filter = $filter;
            $this->_paginator_sess->param  = $param;
        }
        
        /** Get the params from session and create paginator */
        $filter = $this->_paginator_sess->filter;
        $param  = $this->_paginator_sess->param;
        
        /** Return alert to view on filter selected */
        switch ($filter) {
            case 0 : $filter_alert = "Show all reviews";
                     break;
            case 1 : $filter_alert = "Reviews which title with keyword '" 
                        . $param . "'";
					 break;
            case 2 : ($param == '1') ? $state = 'Shown' : $state = 'Not Shown';
                     $filter_alert = "Reviews with '" . $state . "' status";
					 break;
        }
        $this->view->alert = $filter_alert;
        
        $select = $table_review->getQueryAll($filter, $param);
        
        /** Get page row setting and send to the paginator control */
        $page_row = $this->_getParam('filterPageRow');
        $this->view->row = $page_row;
        
		if ($page_row != null) {
    		$paginator = parent::setPaginator($select, $page_row);
        } else {
    		$paginator = parent::setPaginator($select);
        }

        /**
         * If this is a new search
         * then return the page number back to the 1st page
         */
        if ($new_search) { $paginator->setCurrentPageNumber(1); }
        
        /** Send data to the view */
		$this->view->paginator = $paginator;
	}
    
    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: form
     * Desc: Mengatur aksi yang dilakukan untuk halaman edit
     */
    public function editAction()
    {
        $review_id    = $this->_getParam('id');
        $form         = new Admin_Form_ReviewForm;
        $table_review = new Model_DbTable_Review;
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $title   = htmlspecialchars($_POST['reviewTitle'], ENT_QUOTES);
                $content = htmlspecialchars($_POST['reviewContent'], ENT_QUOTES);
                
                $data = array(
                    'review_title'   => $title,
                    'review_content' => $content,
                );

                $table_review->updateReview($data, $review_id);
                $this->loggingaction('review', 'edit', $review_id);
                $this->_flash->addMessage("1\Review Update Success!");
                $this->_redirect($this->view->rootUrl('/admin/review/'));
            }
        }
        
        $data = $table_review->getReviewById($review_id);
        $form->reviewTitle->setValue($this->view->HtmlDecode($data['review_title']));
        $form->reviewContent->setValue($this->view->HtmlDecode($data['review_content']));
        $this->view->form = $form;
    }
}
?>