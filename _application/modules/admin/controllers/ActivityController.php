<?php

/**
 * ActivityController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - activity
 */
require_once 'Zend/Controller/Action.php';

class Admin_ActivityController extends Library_Controller_Backend {

  /**
   * IS: -
   * FS: -
   * Desc: Inisiasi fungsi parent
   */
  public function init() {
    parent::init();
    $this->view->image_dir_type = 5;
  }

  /**
   * IS: Terdeklarasinya filter dan param di session, dan page_row
   * FS: Mengirimkan ke viewer: cleanUrl, message, page_row, filterdata,
   *     paginator, filter_alert
   * Desc: Mengatur aksi yang dilakukan untuk halaman index
   */
  public function indexAction() {
    //variable initiation and instance creation
    $language_id = 1;
    $this->view->cleanurl = $this->_cleanUrl;
    $paginatorfilter = new Zend_Session_Namespace('paginator');
    $table_category = new Model_DbTable_Category;
    /*     * $tes = new Model_DbTable_CategoryDescription();
      $es= $tes->checkDescIndo(85);
      print_r($es);* */
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
      $filter = $_POST['filterPage'];
      $new_search = TRUE;
      $this->_paginator_sess->filter = $filter;
      switch ($filter) {
        case 0 : $param = null;
        case 1 : $param = $_POST['filterTitle'];
          break;
        case 2 : $param = $_POST['filterParent'];
          break;
      }
      $this->_paginator_sess->param = $param;
    }

    //set paginator for list of destination data
    $filter = $this->_paginator_sess->filter;
    $param = $this->_paginator_sess->param;

    $select =
            $table_category->getQueryAllByLanguage($filter, $param, $language_id);

    //get pagerow setting and send to the paginator control
    $page_row = $this->_getParam('filterPageRow');
    $this->view->row = $page_row;

    if ($page_row != null) {
      $paginator = parent::setPaginator($select, $page_row);
    } else {
      $paginator = parent::setPaginator($select);
    }

    //send variables to the view class
    $filter_data = $table_category->getAllParentCategoryIdNameByLangId($language_id);
    $this->view->filterdata = $filter_data;
    $this->view->paginator = $paginator;

    /** Return alert to view on filter selected */
    switch ($filter) {
      case 0 : $filter_alert = "Show all activities";
        break;
      case 1 : $filter_alert = "Activities which name with keyword '"
                . $param . "'";
        break;
      case 2 : foreach ($filter_data as $category) {
          $parent[$category['category_id']] = $category['name'];
        }
        $filter_alert = "Activities which parent are '"
                . $parent[$param] . "'";
        break;
    }
    $this->view->alert = $filter_alert;
  }

  /**
   * IS: -
   * FS: Mengirimkan ke viewer: form
   * Desc: Mengatur aksi yang dilakukan untuk halaman create
   */
  public function createAction() {
    //set initial variable and instances
    $language_id = 1;
    $form = new Admin_Form_ActivityForm;
    $form->setCategoryParent($language_id);
    $table_category = new Model_DbTable_Category;
    $table_category_desc = new Model_DbTable_CategoryDescription;
    $table_categorytopoi = new Model_DbTable_CategoryToPoi;

    //if this is a POST request
    if ($this->getRequest()->isPost()) {
      if ($form->isValid($_POST)) {
        $data = array(
            'parent_id' => $_POST['categoryParent'],
            'image' => $_POST['categoryPicture'],
        );
        $activity_id = $table_category->insertCategory($data);

        if (!empty($activity_id)) {
          $data = array(
              'category_id' => $activity_id,
              'language_id' => $language_id,
              'name' => $_POST['categoryName'],
              'description' => $_POST['categoryDescription'],
          );
          $table_category_desc->insertCategory($data);

          $this->loggingaction('activity', 'create', $activity_id, $language_id);
          $this->_flash->addMessage('1\Activity Insert Success!');
        } else {
          $this->_flash->addMessage('2\Activity Insert Failed!');
        }
        $this->_redirect($this->view->rootUrl('/admin/activity/'));
      }
    }
    //send variables to the view
    $this->view->form = $form;
  }

  /**
   * IS: Parameter id terdeklarasi
   * FS: Mengirimkan ke viewer: form, parent
   * Desc: Mengatur aksi yang dilakukan untuk halaman edit
   */
  public function editAction() {
    $language_id = $this->_getParam('lang');
    $activity_id = $this->_getParam('id');
    $form = new Admin_Form_ActivityForm;
    $form->setCategoryParent($language_id);
    $table_category = new Model_DbTable_Category;
    $table_category_desc = new Model_DbTable_CategoryDescription;
    $table_categorytopoi = new Model_DbTable_CategoryToPoi;

    //if this is a POST request
    if ($this->getRequest()->isPost()) {
      if ($form->isValid($_POST)) {
        if ($language_id != 1) {

          $indo = $table_category_desc->checkForIndo($activity_id);
          if ($indo) {
            $data = array(
                'category_id' => $activity_id,
                'name' => $_POST['categoryName'],
                'description' => $_POST['categoryDescription'],
            );
            $table_category_desc->updateCategory($data, $activity_id, 2);
          } else {
            $data = array(
                'category_id' => $activity_id,
                'language_id' => $language_id,
                'name' => $_POST['categoryName'],
                'description' => $_POST['categoryDescription'],
            );
            $table_category_desc->insertCategory($data);
          }
        } else {
          $data = array(
              'parent_id' => $_POST['categoryParent'],
              'image' => $_POST['categoryPicture'],
          );
          $table_category->updateCategory($data, $activity_id);
          $data2 = array(
              'category_id' => $activity_id,
              'name' => $_POST['categoryName'],
              'description' => $_POST['categoryDescription'],
          );
          $table_category_desc->updateCategory($data2, $activity_id, 1);
        }
        $this->loggingaction('activity', 'edit', $activity_id, $language_id);
        $this->_flash->addMessage('1\Activity Update Success!');
        $this->_redirect($this->view->rootUrl('/admin/activity/'));
      }
    }

    //get the activity data
    if ($language_id != 1) {
      $indo = $table_category_desc->checkForIndo($activity_id);
      if ($indo) {
        $category_data = $table_category->getAllWithDescByIdLang($activity_id, $language_id);
      }
    } else {
      $category_data = $table_category->getAllWithDescByIdLang($activity_id, $language_id);
    }
    //set element value
    $form->categoryParent->setValue($category_data['parent_id']);
    $form->categoryName->setValue($category_data['name']);
    $form->categoryPicture->setValue($category_data['image']);
    $form->categoryDescription->setValue($category_data['description']);

    //send variables to the view
    $this->view->parent = $category_data['parent_id'];
    $this->view->form = $form;
    $this->view->langId = $language_id;
  }

}