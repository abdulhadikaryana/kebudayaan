<?php
/**
 * CommentController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - comment
 */
require_once 'Zend/Controller/Action.php';

class Admin_CommentController extends Library_Controller_Backend
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
     * FS: Mengirimkan ke viewer: cleanUrl, message, page_row, filter, paginator
     * Desc: Mengatur aksi yang dilakukan untuk halaman list comment
     */
	public function indexAction() 
	{
        /** Send this page url to the view */
        $this->view->cleanurl = $this->_cleanUrl;

        /** Get messages from CRUD process */
        $message = $this->_flash->getMessages();
        if (!empty($message)) { $this->view->message = $message; }
        
        /** Create table instance */
        $table_comment = new Model_DbTable_Comment;
        
        /** Set the variable initial value */
        $new_search = FALSE;
        
        /** Get the filter params */
		if ($this->getRequest()->isPost()) {
            /** If new search is commited then we set the $new_search to TRUE */
            $new_search = TRUE;
            $this->_paginator_sess->filter = $_POST['filterPage'];
        } 
        
        /** Get the params from session and create paginator */
        $filter = $this->_paginator_sess->filter;
        ($filter == 0) ? $filter = 1 : $filter; 
        $select = $table_comment->getQueryAll($filter);
        
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
        if ($new_search)     
        { 
            $paginator->setCurrentPageNumber(1); 
        
        }
        
        /** Send data to the view */
        $this->view->filter    = array('filter' => $filter);
	$this->view->paginator = $paginator;
        $authorlist = $table_comment->getByAuthor(1);
        $this->view->author_list = $authorlist;
                
                
	}
    
    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: form
     * Desc: Mengatur aksi yang dilakukan untuk halaman edit comment
     */
    public function editAction()
    {
        $comment_id    = $this->_getParam('id');
        $form          = new Admin_Form_CommentForm;
        $table_comment = new Model_DbTable_Comment;
        $language_id   = 1;
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $content = htmlspecialchars($_POST['commentContent'], ENT_QUOTES);
                $data    = array('comment_content' => $content);
                $table_comment->updateComment($data, $comment_id);
                $this->loggingaction('comment', 'edit', $comment_id, $language_id);
                $this->_flash->addMessage("1\Comment Update Success!");
                $this->_redirect($this->view->rootUrl('/admin/comment'));
            }
           
          
        }
        $data = $table_comment->getCommentById($comment_id);
        $form->commentContent->setValue($this->view->HtmlDecode($data['comment_content']));
        $this->view->form = $form;
    }

    public function actionAction()
    {
        //form submit ke sini
        //di sini ditentukan aksi2 apa aja yg dilakukan
        //tergantung SUATU variabel: $_POST["actionnya"]
        $table_comment = new Model_DbTable_Comment;
        if ($_POST['actionnya'] && $_POST['comment_item'])
        {
            switch ($_POST['actionnya'])
            {
                case 'delete_selected':
                    $id = $_POST['comment_item'];
                    //print_r ($id);
                    foreach($id as $commentID)
                    {
                        $this->loggingaction('comment', 'delete', $commentID);
                        $this->_flash->addMessage("1\Comment Delete Success!");
                        $table_comment->deleteComment($commentID);
                    }
                    $this->_redirect($this->view->rootUrl('/admin/comment/'));
                    break;           
                case '':
                    $this->_redirect($this->view->rootUrl('/admin/comment/'));
            }
        }
    }
    

}
?>