<?php

/**
 * HighlightController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - highlight
 */
require_once 'Zend/Controller/Action.php';

class Admin_HighlightController extends Library_Controller_Backend {

  /**
   * IS: -
   * FS: -
   * Desc: Inisiasi fungsi parent
   */
  public function init() {
    parent::init();
    $this->view->image_dir_type = 4;
    $this->filter = new Zend_Session_Namespace('filter');
  }

  /**
   * IS: Terdeklarasinya filter dan param di session, dan page_row
   * FS: Mengirimkan ke viewer: cleanUrl, message, filter_alert, page_row,
   *     dan paginator
   * Desc: Mengatur aksi yang dilakukan untuk halaman index highlight
   */
  public function indexAction() {
    //variable initiation and instance creation
    $this->view->cleanurl = $this->_cleanUrl;

    $table_highlight = new Model_DbTable_Highlight;

    $message = $this->_flash->getMessages();
    if (!empty($message)) {
      $this->view->message = $message;
    }

    $filter = null;
    $new_search = FALSE;   
    
    if ($this->getRequest()->isPost()) {
      $post = $this->getRequest()->getPost();                  
      $action = $post['action'];
      switch ($action) {
        case 'delete':
          if (isset($post['highlights'])) {
            $highlights = $post['highlights'];
            foreach ($highlights as $id) {
              $table_highlight->find($id)->current()->delete();
            }
            $this->_helper->flashMessenger->addMessage
                    ('Highlight berhasil dihapus.');
          }
          break;
        case 'filter':
          $this->filter->highlight = $post['filter'];
          break;        
        case 'reset':
          $this->filter->unsetAll();
          break;
        default:
          break;
      }
      $this->_helper->redirector('index');
    }

    $filter = $this->_paginator_sess->filter;
    $param = $this->_paginator_sess->param;
   
    
    $select = $table_highlight->getQueryAllByLang($this->filter->highlight);
    $data = $table_highlight->fetchAll($select);

    $paginator = Zend_Paginator::factory($data);
    $pageNumber = $this->_getParam('page');
    $paginator->setCurrentPageNumber($pageNumber);
    $paginator->setItemCountPerPage(5);
    if (isset($this->filter->highlight['row'])) {
      $paginator->setItemCountPerPage($this->filter->highlight['row']);
    }

    //get pagerow setting and send to the paginator control    
    $this->view->paginator = $paginator;
    $this->view->filter = $this->filter->highlight;
  }

  /**
   * IS: -
   * FS: Mengirimkan ke viewer: form
   * Desc: Mengatur aksi yang dilakukan untuk halaman create
   */
  public function createAction() {
    //variable and class initiation initiation
    $language_id = 1;
    $form = new Admin_Form_HighlightForm;
    $table_highlight = new Model_DbTable_Highlight;
    $table_highlight_desc = new Model_DbTable_HighlightDescription;
    //if this is a post request pages
    if ($this->getRequest()->isPost()) {
      if ($form->isValid($_POST)) {
        //set data for insert to the database
        $data = array(
            'type' => $_POST['highlightType'],
            'flag' => $_POST['highlightStatus'],
            'sort_order' => $_POST['highlightSortOrder'],
        );
        $highlight_id = $table_highlight->insertHighlight($data);
        if (!empty($highlight_id)) {
          //if it is a medium highlight then save the description
          $data = array();
          $type = $_POST['highlightType'];
          if ($type != 2 AND $type != 6) {
            $data = array(
                'highlight_id' => $highlight_id,
                'language_id' => $_POST['highlightLanguage'],
                'name' => $_POST['highlightName'],
				'description' => $_POST['highlightDescription'],
                'img_path' => $_POST['highlightImage'],
                'link_path' => $_POST['highlightLink'],
            );
          } elseif ($type == 2 OR $type == 6) {
            $data = array(
                'highlight_id' => $highlight_id,
                'language_id' => $_POST['highlightLanguage'],
                'name' => $_POST['highlightName'],
                'description' => $_POST['highlightDescription'],
                'img_path' => $_POST['highlightImage'],
                'link_path' => $_POST['highlightLink'],
            );
          }
          $table_highlight_desc->insertHighlight($data);
          $this->loggingaction('highlight', 'create', $highlight_id, $language_id);
          $this->_flash->addMessage('1\Menambah Highlight Berhasil!');
        } else {
          $this->_flash->addMessage('2\Menambah Highlight Gagal!');
        }
        $this->_redirect($this->view->rootUrl('/admin/highlight/'));
      }
    }
    $form->highlightSortOrder->setValue(0);
    $this->view->form = $form;
  }

  /**
   * IS: Parameter id terdeklarasi
   * FS: Mengirimkan ke viewer: form, highlightType
   * Desc: Mengatur aksi yang dilakukan untuk halaman edit
   */
  public function editAction() {
    $language_id = $this->_getParam('lang');
    $highlight_id = $this->_getParam('id');
    $form = new Admin_Form_HighlightForm;
    $table_highlight = new Model_DbTable_Highlight;
    $table_highlight_desc = new Model_DbTable_HighlightDescription;
    $highlight_data = null;

    //if this is a post request pages
    if ($this->getRequest()->isPost()) {
      if ($form->isValid($_POST)) {	
        //set data for insert to the database
        if ($language_id != 1) {
          $indo = $table_highlight_desc->checkForIndo($highlight_id);
          if ($indo) {
            $data3 = array(
                'highlight_id' => $highlight_id,
                'language_id' => $language_id,
                'name' => $_POST['highlightName'],
                'description' => $_POST['highlightDescription'],
                'img_path' => $_POST['highlightImage'],
                'link_path' => $_POST['highlightLink'],
            );
            $table_highlight_desc->updateHighlight($data3, $highlight_id, $language_id);
          } else {
            $data3 = array(
                'highlight_id' => $highlight_id,
                'language_id' => $language_id,
                'name' => $_POST['highlightName'],
                'description' => $_POST['highlightDescription'],
                'img_path' => $_POST['highlightImage'],
                'link_path' => $_POST['highlightLink'],
            );
            $table_highlight_desc->insertHighlight($data3);
          }
        } else {
          $data = array(
              'type' => $_POST['highlightType'],
              'path_image' => $_POST['highlightImage'],
              'flag' => $_POST['highlightStatus'],
              'link' => $_POST['highlightLink'],
              'sort_order' => $_POST['highlightSortOrder'],
          );
          $table_highlight->updateHighlight($data, $highlight_id);

          //if it is a medium highlight then save the description
          $type = $_POST['highlightType'];
          if ($type != 2 AND $type != 6) {
            $data = array(
                'language_id' => $language_id,
                'name' => $_POST['highlightName'],
				'description' => $_POST['highlightDescription'],
                'img_path' => $_POST['highlightImage'],
                'link_path' => $_POST['highlightLink'],
            );
          } elseif ($type == 2 OR $type == 6) {
            $data = array(
                'language_id' => $language_id,
                'name' => $_POST['highlightName'],
                'description' => $_POST['highlightDescription'],
                'img_path' => $_POST['highlightImage'],
                'link_path' => $_POST['highlightLink'],
            );
          }
          $table_highlight_desc->updateHighlight($data, $highlight_id, $language_id);
        }
        $this->loggingaction('highlight', 'edit', $highlight_id, $language_id);
        $this->_flash->addMessage('1\Sunting Highlight Berhasil!');
        $this->_redirect($this->view->rootUrl('/admin/highlight/'));
      }
    }

//    if ($language_id != 1) {
//      $indo = $table_highlight_desc->checkForIndo($highlight_id);
//      if ($indo) {
//        $highlight_data = $table_highlight->getAllWithDesc($highlight_id, $language_id);
//      }
//    } else {
      $highlight_data = $table_highlight->getAllWithDesc($highlight_id, $language_id);
//    }

    //set every element value
//        if($highlight_data != null)
//        {
    $form->highlightImage->setValue($highlight_data['path_image']);
    $form->highlightType->setValue($highlight_data['type']);
    $form->highlightLink->setValue($highlight_data['link_path']);
    $form->highlightName->setValue($highlight_data['name']);
    $form->highlightSortOrder->setValue($highlight_data['sort_order']);
    $form->highlightDescription->setValue($highlight_data['description']);
    $form->highlightStatus->setValue($highlight_data['flag']);
    $form->highlightImage->setValue($highlight_data['img_path']);
    $this->view->highlightType = $highlight_data['type'];
    $this->view->form = $form;
    $this->view->stateEdit = true;
    $this->view->language_id = $language_id;
    $this->view->highlight_type = $highlight_data['type'];
    $this->view->image = $highlight_data['img_path'];
//        }
  }
  
  public function deleteAction()
  {
	$id = $this->_getParam('id');
	$table_highlight = new Model_DbTable_Highlight;
    $table_highlight_desc = new Model_DbTable_HighlightDescription;
	
	$data = $table_highlight->deleteById($id);
	$data2 = $table_highlight_desc->deleteHighlight($id);
	
	$this->_redirect($this->view->rootUrl('/admin/highlight/'));
  }

}