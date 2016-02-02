<?php

/**
 * PageController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - static page
 */
require_once 'Zend/Controller/Action.php';

class Admin_PageController extends Library_Controller_Backend {

  /**
   * IS: -
   * FS: -
   * Desc: Inisiasi fungsi parent
   */
  public function init() {
    parent::init();
  }

  /**
   * IS: -
   * FS: Mengirimkan ke viewer: message dan paginator
   * Desc: Mengatur aksi yang dilakukan untuk halaman index page
   */
  public function indexAction() {
    //variable initiation and instance creation
    $language_id = 1;
    $table_page = new Model_DbTable_StaticContent;

    //get messages from CRUD process
    $message = $this->_flash->getMessages();
    if (!empty($message)) {
      $this->view->message = $message;
    }

    $select = $table_page->getSelectAllByLangId($language_id);
    $paginator = parent::setPaginator($select, 20);

    //send variables to the view class
    $this->view->paginator = $paginator;
  }

  /**
   * IS: Parameter id terdeklarasi
   * FS: Mengirimkan ke viewer: content, static_id
   * Desc: Mengatur aksi yang dilakukan untuk halaman edit
   */
  public function editAction() {
    $language_id = 1;
    $static_id = $this->_getParam('id');
    $table_static = new Model_DbTable_StaticContent;

    if ($this->getRequest()->isPost()) {
      $data = array('content' => $_POST['pageContent']);
      $table_static->updateStaticContent($data, $static_id);
      $this->loggingaction('page', 'edit', $static_id, $language_id);
      $this->_flash->addMessage('1\Page Update Success!');
      $this->_redirect($this->view->rootUrl('/admin/page/'));
    }


    $content = $table_static->getContentByLangId($static_id, $language_id);
    $this->view->content = $content[0]['content'];
    $this->view->static_id = $static_id;
  }

}