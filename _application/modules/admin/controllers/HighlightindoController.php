<?php

/**
 * HighlightController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - highlight
 */
require_once 'Zend/Controller/Action.php';

class Admin_HighlightindoController extends Library_Controller_Backend {

  /**
   * IS: -
   * FS: -
   * Desc: Inisiasi fungsi parent
   */
  public function init() {
    parent::init();
    $this->view->image_dir_type = 4;
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
      $filter = $_POST['filterPage'];
      $this->_paginator_sess->filter = $filter;
      $new_search = TRUE;
      switch ($filter) {
        case 0 : $param = null;
        case 1 : $param = $_POST['filterType'];
          break;
        case 2 : $param = $_POST['filterName'];
          break;
      }
      $this->_paginator_sess->param = $param;
    }

    $filter = $this->_paginator_sess->filter;
    $param = $this->_paginator_sess->param;

    /** Return alert to view on filter selected */
    switch ($filter) {
      case 0 : $filter_alert = "Show all highlights";
        break;
      case 1 : switch ($param) {
          case 3 : $tipe = "Header";
            break;
          case 2 : $tipe = "Cluster";
            break;
          case 1 : $tipe = "Medium";
            break;
          case 4 : $tipe = "Small";
            break;
          case 5 : $tipe = "Gallery Header";
            break;
          case 6 : $tipe = "User Review";
            break;
        }
        $filter_alert = $tipe . " highlights";
        break;
      case 2 : $filter_alert = "Highlights which name with keyword '"
                . $param . "'";
        break;
    }
    $this->view->alert = $filter_alert;

    $select = $table_highlight->getQueryAllByLang($filter, $param, 2);

    //get pagerow setting and send to the paginator control
    $page_row = $this->_getParam('filterPageRow');
    $this->view->row = $page_row;

    if ($page_row != null) {
      $paginator = parent::setPaginator($select, $page_row);
    } else {
      $paginator = parent::setPaginator($select);
    }

    if ($new_search) {
      $paginator->setCurrentPageNumber(1);
    }
    $this->view->paginator = $paginator;
  }

  /**
   * IS: -
   * FS: Mengirimkan ke viewer: form
   * Desc: Mengatur aksi yang dilakukan untuk halaman create
   */
  public function createAction() {
    //variable and class initiation initiation
    $language_id = 2;
    $form = new Admin_Form_HighlightForm;
    $table_highlight = new Model_DbTable_Highlight;
    $table_highlight_desc = new Model_DbTable_HighlightDescription;
    //if this is a post request pages
    if ($this->getRequest()->isPost()) {
      if ($form->isValid($_POST)) {
        //set data for insert to the database
        $data = array(
            'type' => $_POST['highlightType'],
            'path_image' => $_POST['highlightImage'],
            'flag' => $_POST['highlightStatus'],
            'link' => $_POST['highlightLink'],
            'sort_order' => $_POST['highlightSortOrder'],
        );
        $highlight_id = $table_highlight->insertHighlight($data);

        if (!empty($highlight_id)) {
          //if it is a medium highlight then save the description
          $type = $_POST['highlightType'];
          if ($type != 2 AND $type != 6) {
            $data = array(
                'highlight_id' => $highlight_id,
                'language_id' => $language_id,
                'name' => $_POST['highlightName'],
                'img_path' => $_POST['highlightImage'],
                'link_path' => $_POST['highlightLink'],
            );
          } elseif ($type == 2 OR $type == 6) {
            $data = array(
                'highlight_id' => $highlight_id,
                'language_id' => $language_id,
                'name' => $_POST['highlightName'],
                'description' => $_POST['highlightDescription'],
                'img_path' => $_POST['highlightImage'],
                'link_path' => $_POST['highlightLink'],
            );
          }
          $table_highlight_desc->insertHighlight($data);
          $this->loggingaction('highlight', 'create', $highlight_id, $language_id);
          $this->_flash->addMessage('1\Highlight Insert Success!');
        } else {
          $this->_flash->addMessage('2\Highlight Insert Failed!');
        }
        $this->_redirect($this->view->rootUrl('/admin/highlightindo/'));
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
        if ($language_id == 1) {
          $indo = $table_highlight_desc->checkForIndo($highlight_id, $language_id);
          if ($indo) {
            $data3 = array(
                'highlight_id' => $highlight_id,
                'language_id' => $language_id,
                'name' => $_POST['highlightName'],
                'description' => $_POST['highlightDescription'],
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
        $this->_flash->addMessage('1\Highlight Update Success!');
        $this->_redirect($this->view->rootUrl('/admin/highlightindo/'));
      }
    }

    if ($language_id == 1) {
      $indo = $table_highlight_desc->checkForIndo($highlight_id, $language_id);
      if ($indo) {
        $highlight_data = $table_highlight->getAllWithDesc($highlight_id, $language_id);
      }
    } else {
      $highlight_data = $table_highlight->getAllWithDesc($highlight_id, $language_id);
    }

    //set every element value
    $form->highlightImage->setValue($highlight_data['path_image']);
    $form->highlightType->setValue($highlight_data['type']);
    $form->highlightLink->setValue($highlight_data['link_path']);
    $form->highlightName->setValue($highlight_data['name']);
    $form->highlightSortOrder->setValue($highlight_data['sort_order']);
    $form->highlightDescription->setValue($highlight_data['description']);
    $form->highlightStatus->setValue($highlight_data['flag']);
    $this->view->highlightType = $highlight_data['type'];
    $this->view->form = $form;
    $this->view->language_id = $language_id;
    $this->view->highlight_type = $highlight_data['type'];
    $this->view->image = $highlight_data['img_path'];
  }

}