<?php 
/**
 * RegionController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * photo essay
 */
 
 class Admin_PhotoessayController extends Library_Controller_Backend
 {
	public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        //variable initiation and instance creation
        $this->view->cleanurl = $this->_cleanUrl;
        $language_id = 1;
        $tablePhotoEssay  = new Model_DbTable_Photoessay;

        //get messages from CRUD process
        $message = $this->_flash->getMessages();
        if(!empty($message))
        {
            $this->view->message = $message;
        }

        $filterEssay = null;
        $new_search = FALSE;

        if ($this->getRequest()->isPost())
        {
            $filterEssay = $_POST['filterPage'];
            $new_search = TRUE;
            switch ($filter)
            {
                case 0 : $param = null;
                    break;
                case 1 : $param = $_POST['filterTitle'];
                    break;
            }
            $this->_paginator_sess->filter = $filterEssay;
            $this->_paginator_sess->param  = $param;
        }

        //get the params from session and create paginator
        $filter =  $this->_paginator_sess->filter;
        $param  =  $this->_paginator_sess->param;

        /** Return alert to view on filter selected */
        switch ($filter)
        {
            case 0 : $filter_alert = "Show all Photo Essay";
                break;
            case 1 : $filter_alert = "Photo Essay which title with keyword '"
                        . $param . "'";
                break;
        }
        $this->view->alert = $filter_alert;

        $select = $tablePhotoEssay->getQueryAllByLanguage($filter, $param, $language_id);

        //get pagerow setting and send to the paginator control
        $page_row = $this->_getParam('filterPageRow');
        $this->view->row = $page_row;

        if ($page_row != null)
        {
            $paginator = parent::setPaginator($select, $page_row);
        } else
        {
            $paginator = parent::setPaginator($select);
        }

        //if this is a new search then return the page number back to the 1st page
        if ($new_search)
        {
            $paginator->setCurrentPageNumber(1);
        }

        //send data to the view
        $this->view->paginator = $paginator;
    }
    
    public function createAction()
    {
		$form = new Admin_Form_PhotoessayForm;
		$tablePhotoessay = new Model_DbTable_Photoessay;
		$tableEssayCategory = new Model_DbTable_EssayCategory;
		$categoryList = $tableEssayCategory->getAll();
		
		$this->view->categoryList = $categoryList;
		$this->view->form = $form;

		$tUnixTime = time();
        date_default_timezone_set('Asia/Jakarta');
        $GMTMySqlString = date("Y-m-d", $tUnixTime);
        
		if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                $data = array(
                        'title' => htmlentities($_POST['photoessayTitle'], ENT_QUOTES),
                        'description' => htmlentities($_POST['photoessayDescription'], ENT_QUOTES),
                        'publishdate' => $GMTMySqlString,
                        'category' => $_POST['essay-category']
                );
                $lastInsertID = $tablePhotoessay->insertRow($data);
                $this->loggingaction('photoessay', 'create', $lastInsertID, 1);
                $this->_flash->addMessage("1\Photo Essay Created!");
				$this->_redirect($this->view->rootUrl('/admin/photoessay/'));
  			}
       	}
    }

    public function editAction()
    {
		$form = new Admin_Form_PhotoessayForm;
		$tablePhotoessay = new Model_DbTable_Photoessay;
		$tableEssayCategory = new Model_DbTable_EssayCategory;
		$categoryList = $tableEssayCategory->getAll();
		
		$this->view->categoryList = $categoryList;

		$id = $this->_getParam('id');
		
		if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                $data = array(
                        'title' => htmlentities($_POST['photoessayTitle'], ENT_QUOTES),
                        'description' => htmlentities($_POST['photoessayDescription'], ENT_QUOTES),
                        'category' => $_POST['essay-category']
                );
                $tablePhotoessay->updateRow($id, $data);
                $this->loggingaction('photoessay', 'update', $lastInsertID, 1);
                $this->_flash->addMessage("1\Photo Essay Updated!");
                $this->_redirect($this->view->rootUrl('/admin/photoessay/'));
  			}
       	}
		
		$data = $tablePhotoessay->getEssayByID($id);
		$form->photoessay_description->setValue(html_entity_decode($data['description'], ENT_QUOTES));
		$form->photoessay_title->setValue(html_entity_decode($data['title'], ENT_QUOTES));
		$this->view->selectedCategory = $data['category'];
		$this->view->editMode = TRUE;
		$this->view->form = $form;
    }
    
    public function imageAction()
    {
    	$id = $this->_getParam('id');
		$tableEssayImage = new Model_DbTable_Photoessayimage;
    	$tablePhotoEssay = new Model_DbTable_Photoessay;
    	$info = $tablePhotoEssay->getEssayByID($id);
		$imageList = $tableEssayImage->getImageByEssayID($id);
    	$this->view->title = $info['title'];
    	$this->view->essayID = $info['photoessay_id'];
		$this->view->imageList = $imageList;
    }

    public function addImageAction()
    {
    	$id = $this->_getParam('id');
    	$essayID = $this->_getParam('essay');
    	$form = new Admin_Form_EssayimageForm;
    	$tableImage = new Model_DbTable_Photoessayimage;
    	
		if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                $data = array(
                		'photoessay_id' => $essayID,
                        'sort_id' => $_POST['imageWeight'],
                        'description' => htmlentities($_POST['imageDescription'], ENT_QUOTES),
                        'file' => $_POST['imageFile']
                );
                
				$lastInsertID = $tableImage->insertRow($data);
                $this->loggingaction('photoessay image', 'add', $lastInsertID, 1);
                $this->_flash->addMessage("1\Image added!");
                $this->_redirect($this->view->rootUrl('/admin/photoessay/'));
  			}
       	}
       	
		$this->view->showFile = TRUE;
		$this->view->form = $form;
		$this->view->image_dir_type = 8;
    }
    
    public function editImageAction()
    {
    	$id = $this->_getParam('id');
    	$form = new Admin_Form_EssayimageForm;
    	$tableEssayImage = new Model_DbTable_Photoessayimage;

		if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {
                $data = array(
                        'sort_id' => $_POST['imageWeight'],
                        'description' => htmlentities($_POST['imageDescription'], ENT_QUOTES),
                );
                
				$tableEssayImage->updateRow($id, $data);
                $this->loggingaction('photoessay image', 'edit', $id, 1);
                $this->_flash->addMessage("1\Image description updated!");
                $this->_redirect($this->view->rootUrl('/admin/photoessay/'));
  			}
       	}
    	
		$imageInfo = $tableEssayImage->getImageByImageID($id);
		$form->image_description->setValue(html_entity_decode($imageInfo['description'], ENT_QUOTES));
		$form->image_weight->setValue($imageInfo['sort_id'], ENT_QUOTES);
		$this->view->form = $form;
    }
}