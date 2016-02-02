<?php
/**
 * AccountController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - account
 */
require_once 'Zend/Controller/Action.php';

class Admin_AccountController extends Library_Controller_Backend
{
  /**
   * IS: -
   * FS: -
   * Desc: Inisiasi fungsi parent
   */
  protected $filter;
  protected $form;
  protected $account;

  public function init()
  {
    $this->account = new Model_DbTable_AdminAccount();
    $this->filter = new Zend_Session_Namespace('filter');
    $this->form = new Admin_Form_AccountForm();

    parent::init();
  }

  /**
   * IS: Terdeklarasinya filter dan param di session, dan page_row 
   * FS: Mengirimkan ke viewer: cleanUrl, message, filter_alert, page_row, 
   *     count, role_list, dan paginator
   * Desc: Mengatur aksi yang dilakukan untuk halaman index
   */
  public function indexAction()
  {
    $pageNumber = $this->_getParam('page');
    $table_role = new Model_DbTable_AdminRole;
    $message = $this->_flash->getMessages();
    $this->view->cleanurl = $this->_cleanUrl;

//        $filter = null;
    $new_search = FALSE;

    if ($this->getRequest()->isPost()) {
      $post = $this->getRequest()->getPost();
      switch ($post['action']) {
        case 'delete':
          foreach ($post['account'] as $id) {
            $account = $this->account->find($id)->current();
            $account->delete();
            $this->loggingaction('Account', 'Delete', $account->id);
          }

          $this->_helper->flashMessenger->addMessage(
                  'Akun Berhasil Dihapus.');
          $this->_helper->redirector('index');
          break;

        case 'filter':
          $this->filter->account = $post['filter'];
          break;
        case 'sort':
          $this->filter->account = $post['filter'];
          if ($this->filter->account['order'] == 'ASC') $this->filter->account['order'] = 'DESC';
          else $this->filter->account['order'] = 'ASC';
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

    $select = $this->account->getAllQuery($this->filter->account, $param);
    $data = $this->account->fetchAll($select);
    $account = Zend_Paginator::factory($data);
    $account->setCurrentPageNumber($pageNumber);
    $account->setItemCountPerPage(5);
    if (null != $this->filter->account['row']) $account->setItemCountPerPage($this->filter->account['row']);
    $messages = $this->_helper->flashMessenger->getMessages();
    //get pagerow setting and send to the paginator control
    $page_row = $this->_getParam('filterPageRow');
    $this->view->row = $page_row;
    $this->view->account = $account;
    $this->view->messages = $messages;

    if ($page_row != null) {
      $paginator = parent::setPaginator($select, $page_row);
    } else {
      $paginator = parent::setPaginator($select);
    }

    //if this is a new search then return the page number back to the 1st page
    if ($new_search) {
      $paginator->setCurrentPageNumber(1);
    }



    $count = $table_role->getCountAll();

    $this->view->count = $count;
//        $this->view->rolelist = $role_list;
    $this->view->paginator = $paginator;
    $this->view->form = $this->form;
  }

  /**
   * IS: -
   * FS: Mengirimkan ke viewer: form
   * Desc: Mengatur aksi yang dilakukan untuk halaman create
   */
  public function createAction()
  {
    $form = new Admin_Form_AccountForm;
    $form->setRoleOption();
    $table_adminAccount = new Model_DbTable_AdminAccount;

    if ($this->getRequest()->isPost()) {
      if ($form->isValid($_POST)) {
        $data = array(
            'username'  => $_POST['adminUser'],
            'password'  => md5($_POST['adminPassword']),
            'email'     => $_POST['adminEmail'],
            'role_id'   => $_POST['adminRole'],
        );
        $account_id = $table_adminAccount->insertAccount($data);
        $this->loggingaction('account', 'create', $account_id);
        $this->_flash->addMessage('1\Insert Success!');
      } else {
        $this->_flash->addMessage('2\Insert Failed!');
      }
      $this->_redirect($this->view->rootUrl('/admin/account/'));
    }
    $this->view->form = $form;
  }

  /**
   * IS: Parameter id terdeklarasi
   * FS: Mengirimkan ke viewer: form
   * Desc: Mengatur aksi yang dilakukan untuk halaman edit
   */
  public function editAction()
  {
    $form = new Admin_Form_AccountForm;
    $form->setRoleOption();
    $admin_id = $this->_getParam('id');
    $acc = new Model_DbTable_AdminAccount();
    $data = $acc->getAllQueryById($admin_id);

    if ($this->getRequest()->isPost()) {
      if ($form->isValid($_POST)) {


        $data = array(
            'username' => $_POST['adminUser'],
            'password' => md5($_POST['adminPassword']),
            'email'    => $_POST['adminEmail'],
            'role_id'  => $_POST['adminRole'],
        );
        $acc->updateAccount($data, $admin_id);
        $this->loggingaction('account', 'edit', $admin_id);
        $this->_flash->addMessage('1\Update Success!');
      } else {
        $this->_flash->addMessage('2\Update Failed!');
      }
      $this->_redirect($this->view->rootUrl('/admin/account/'));
    }
    $form->adminRole->setValue($data['role_id']);
    $form->adminUser->setValue($data['username']);
    $form->adminEmail->setValue($data['email']);

    $this->view->form = $form;
  }

  public function deleteAction()
  {
    $this->_helper->viewRenderer->setNoRender();
    $id = $this->_getParam('id');
    if (null !== $id) {
      $account = $this->account->find($id)->current();
      if (null != $account) {
        $account->delete();
        $this->loggingaction('Account', 'Delete', null, null);
        $this->_helper->flashMessenger->addMessage
                ('Akun berhasil dihapus');
      }
    }

    $this->_helper->redirector('index');
  }

}