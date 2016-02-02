<?php

/**
 * TourpackageController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - tour packages
 */
require_once 'Zend/Controller/Action.php';

class Admin_TourpackageindoController extends Library_Controller_Backend {

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
   *     dan paginator
   * Desc: Mengatur aksi yang dilakukan untuk halaman index tour packages
   */
  public function indexAction() {
    //variable initiation and instance creation
    $language_id = 2;
    $this->view->cleanurl = $this->_cleanUrl;
    $table_package = new Model_DbTable_Package;

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
      }
      $this->_paginator_sess->param = $param;
    }

    //set paginator for list of destination data
    $filter = $this->_paginator_sess->filter;
    $param = $this->_paginator_sess->param;

    /** Return alert to view on filter selected */
    switch ($filter) {
      case 0 : $filter_alert = "Show all tour packages";
        break;
      case 1 : $filter_alert = "Tour packages which name with keyword '"
                . $param . "'";
        break;
    }
    $this->view->alert = $filter_alert;

    $select = $table_package->getQueryAllByLanguage($filter, $param, $language_id);

    //get pagerow setting and send to the paginator control
    $page_row = $this->_getParam('filterPageRow');
    $this->view->row = $page_row;

    if ($page_row != null) {
      $paginator = parent::setPaginator($select, $page_row);
    } else {
      $paginator = parent::setPaginator($select);
    }

    //send variables to the view class
    $this->view->paginator = $paginator;
  }

  /**
   * IS: -
   * FS: Mengirimkan ke viewer: form
   * Desc: Mengatur aksi yang dilakukan untuk halaman create
   */
  public function createAction() {
    $language_id = 2;
    $form = new Admin_Form_TourpackageForm;
    $table_package = new Model_DbTable_Package;
    $table_package_desc = new Model_DbTable_PackageDescription;

    if ($this->getRequest()->isPost()) {
      if ($form->isValid($_POST)) {
        $data = array(
            'contact' => htmlspecialchars($_POST['packContact'], ENT_QUOTES),
            'website' => htmlspecialchars($_POST['packWebsite'], ENT_QUOTES),
        );
        $package_id = $table_package->insertPackage($data);
        if (!empty($package_id)) {
          $data = array(
              'package_id' => $package_id,
              'language_id' => $language_id,
              'title' => htmlspecialchars($_POST['packTitle'], ENT_QUOTES),
              'description' => htmlspecialchars($_POST['packDescription'], ENT_QUOTES),
          );
          $table_package_desc->insertPackage($data, $package_id, $language_id);


          $this->loggingaction('tourpackages', 'create', $package_id, $language_id);
          $this->_flash->addMessage("1\Tour Package Insert Success!");
        } else {
          $this->_flash->addMessage("2\Tour Package Insert Failed!");
        }
        $this->_redirect($this->view->rootUrl('/admin/tourpackageindo/'));
      }
    }
    $this->view->form = $form;
  }

  /**
   * IS: Parameter id terdeklarasi
   * FS: Mengirimkan ke viewer: form
   * Desc: Mengatur aksi yang dilakukan untuk halaman edit
   */
  public function editAction() {
    $language_id = $this->_getParam('lang');
    $package_id = $this->_getParam('id');
    $form = new Admin_Form_TourpackageForm;
    $table_package = new Model_DbTable_Package;
    $table_package_desc = new Model_DbTable_PackageDescription;

    if ($this->getRequest()->isPost()) {
      if ($form->isValid($_POST)) {
        if ($language_id == 1) {
          $indo = $table_package_desc->checkForIndo($package_id, 1);
          if ($indo) {
            $data = array(
                'package_id' => $package_id,
                'language_id' => $language_id,
                'title' => htmlspecialchars($_POST['packTitle'], ENT_QUOTES),
                'description' => htmlspecialchars($_POST['packDescription'], ENT_QUOTES),
            );
            $table_package_desc->updatePackage($data, $package_id, $language_id);
          } else {
            $data = array(
                'package_id' => $package_id,
                'language_id' => $language_id,
                'title' => htmlspecialchars($_POST['packTitle'], ENT_QUOTES),
                'description' => htmlspecialchars($_POST['packDescription'], ENT_QUOTES),
            );
            $table_package_desc->insertPackage($data);
          }
        } else {
          $data = array(
              'contact' => htmlspecialchars($_POST['packContact'], ENT_QUOTES),
              'website' => htmlspecialchars($_POST['packWebsite'], ENT_QUOTES),
          );
          $table_package->updatePackage($data, $package_id);

          $data = array(
              'package_id' => $package_id,
              'language_id' => $language_id,
              'title' => htmlspecialchars($_POST['packTitle'], ENT_QUOTES),
              'description' => htmlspecialchars($_POST['packDescription'], ENT_QUOTES),
          );
          $table_package_desc->updatePackage($data, $package_id, $language_id);
        }
        $this->loggingaction('tourpackages', 'edit', $package_id, $language_id);
        $this->_flash->addMessage("1\Tour Package Update Success");
        $this->_redirect($this->view->rootUrl('/admin/tourpackageindo/'));
      }
    }

    if ($language_id == 1) {
      $indo = $table_package_desc->checkForIndo($package_id, 1);
      if ($indo) {
        $package_data = $table_package->getAllWithDescById($package_id, $language_id);
      }
    } else {
      $package_data = $table_package->getAllWithDescById($package_id, $language_id);
    }


    //set element value
    $form->packTitle->setValue($this->view->HtmlDecode($package_data['title']));
    $form->packContact->setValue($this->view->HtmlDecode($package_data['contact']));
    $form->packWebsite->setValue($this->view->HtmlDecode($package_data['website']));
    $form->packDescription->setValue($this->view->HtmlDecode($package_data['description']));
    //send variables to the view
    $this->view->form = $form;
    $this->view->language_id = $language_id;
  }

}