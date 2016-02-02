<?php

/**
 * RelatedlinksController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - related links
 */
require_once 'Zend/Controller/Action.php';

class Admin_RelatedlinksindoController extends Library_Controller_Backend {

  /**
   * IS: -
   * FS: -
   * Desc: Inisiasi fungsi parent
   */
  public function init() {
    parent::init();
  }

  /**
   * IS: Terdeklarasinya filter dan param di session, dan page_row
   * FS: Mengirimkan ke viewer: cleanUrl, message, filter_alert, page_row,
   *     filterdata, dan paginator
   * Desc: Mengatur aksi yang dilakukan untuk halaman index related links
   */
  public function indexAction() {
    //variable initiation and instance creation
    $this->view->cleanurl = $this->_cleanUrl;
    $table_related = new Model_DbTable_Related;
    $table_reldesc = new Model_DbTable_RelatedDescription();
    $filter_data = $table_reldesc->getAllTypeDescIndo();
    $this->view->related_type = $filter_data;
    //get messages from CRUD process
    $message = $this->_flash->getMessages();
    if (!empty($message)) {
      $this->view->message = $message;
    }

    //set variable initial value
    $filter = null;
    $new_search = FALSE;

    //get params for the filter
    if ($this->getRequest()->isPost()) {
      $new_search = TRUE;
      $param = $_POST['filterType'];
      $this->_paginator_sess->param = $param;
    }

    //set paginator for list of destination data
    $param = $this->_paginator_sess->param;
    $select = $table_reldesc->getQueryAll($param, 2);

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

    //send variables to the view class
    $this->view->paginator = $paginator;

    /** Return alert to view on filter selected */
    if ($new_search or !empty($param)) {
      foreach ($filter_data as $key => $value) {
        $parent[$key] = $value;
      }
      $filter_alert = "Related links with '" . $parent[$param]
              . "' category";
      $this->view->alert = $filter_alert;
    }
  }

  /**
   * IS: -
   * FS: Mengirimkan ke viewer: form
   * Desc: Mengatur aksi yang dilakukan untuk halaman create
   */
  public function createAction() {
    $form = new Admin_Form_RelatedForm;
    $table_related = new Model_DbTable_Related;
    $table_reldesc = new Model_DbTable_RelatedDescription();
    if ($this->getRequest()->isPost()) {
      if ($form->isValid($_POST)) {
        $data = array(
            'jenisrelated' => $_POST['linkType'],
            'title' => $_POST['linkTitle'],
            'description' => $_POST['linkDescription'],
            'link' => $_POST['linkUrl'],
        );
        $related_id = $table_related->insertRelated($data);
        if (!empty($related_id)) {
          $data2 = array(
              'id' => $related_id,
              'language_id' => 2,
              'title' => $_POST['linkTitle'],
              'description' => $_POST['linkDescription'],
              'link' => $_POST['linkUrl'],
          );
          $table_reldesc->insertRelated($data2);


          $this->loggingaction('relatedlinksindo', 'create', $related_id);
          $this->_flash->addMessage('1\Related Links Indo Insert Success!');
        } else {
          $this->_flash->addMessage('2\Related Links Indo Insert Failed!');
        }
        $this->_redirect($this->view->rootUrl('/admin/relatedlinksindo/'));
      }
    }
    $this->view->form = $form;
    $this->view->langId = 2;
  }

  /**
   * IS: Parameter id terdeklarasi
   * FS: Mengirimkan ke viewer: form
   * Desc: Mengatur aksi yang dilakukan untuk halaman edit
   */
  public function editAction() {
    $related_id = $this->_getParam('id');
    $langId = $this->_getParam('lang');
    $form = new Admin_Form_RelatedForm;
    $table_related = new Model_DbTable_Related;
    $table_reldesc = new Model_DbTable_RelatedDescription();

    if ($this->getRequest()->isPost()) {
      if ($form->isValid($_POST)) {
        if ($langId == 2) {
          $data = array(
              'jenisrelated' => $_POST['linkType'],
          );
          $data2 = array(
              'language_id' => 2,
              'title' => $_POST['linkTitle'],
              'description' => $_POST['linkDescription'],
              'link' => $_POST['linkUrl'],
          );
          $table_related->updateRelated($data, $related_id);
          $table_reldesc->updateRelated($data2, $related_id, $langId);
        } elseif ($langId == 1) {
          $en = $table_reldesc->checkForIndo($related_id, 1);
          $data = array(
              'id' => $related_id,
              'language_id' => 1,
              'title' => $_POST['linkTitle'],
              'description' => $_POST['linkDescription'],
              'link' => $_POST['linkUrl'],
          );
          if ($en == false) {
            $table_reldesc->insertDataRel($data);
          } else {
            $table_reldesc->updateRelatedIndo($data, $related_id, 1);
          }
        }
        $this->loggingaction('relatedlinksindo', 'edit', $related_id);
        $this->_flash->addMessage('1\Related Links Indo Update Success!');
        $this->_redirect($this->view->rootUrl('/admin/relatedlinksindo/'));
      }
    }

    $related_data = $table_reldesc->getAllByIdLangNew($related_id, $langId);
    $form->linkType->setValue($related_data['jenisrelated']);
    $form->linkTitle->setValue($related_data['title']);
    $form->linkUrl->setValue($related_data['link']);
    $form->linkDescription->setValue($related_data['description']);
    $this->view->form = $form;
    $this->view->langId = $langId;
  }

}