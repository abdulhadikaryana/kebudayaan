<?php
/**
 * UserController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - user
 */
require_once 'Zend/Controller/Action.php';

class Admin_UserController extends Library_Controller_Backend
{
  public function settingAction()
  {
    $form = new Admin_Form_UserForm();
    $tbl_account = new Admin_Model_DbTable_Account();
    $account = $tbl_account->find($this->_userInfo->id)->current();
    $form->populate($account->toArray());
    if ($this->getRequest()->isPost()) {
      $post = $this->getRequest()->getPost();
      if ($form->isValid($post)) {
        $data = array(
            'name'      => $form->getValue('name'),
            'email'     => $form->getValue('email'),
            'biography' => $form->getValue('biography')
        );
        if (null != $form->getValue('new_password')
                && null != $form->getValue('confirm_password')) {
          $data['password'] = md5($form->getValue('new_password'));
          $this->loggingaction('User', 'Change Password', null);
          $this->_helper->flashMessenger->addMessage('Kata sandi berhasil diubah.');
        }
        $account->setFromArray($data)->save();
        $this->loggingaction('User', 'Setting', null);
        $this->_helper->flashMessenger->addMessage('Akun berhasil disunting.');
        $this->_helper->redirector('index', 'index');
      }
    }

    $this->view->form = $form;
  }

}