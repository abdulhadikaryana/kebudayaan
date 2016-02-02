<?php
require_once 'Zend/Controller/Action.php';

class Admin_PollingController
        extends Library_Controller_Backend
{
  /**
   *
   * @var Model_DbTable_Polling
   */
  protected $tbl_polling;
  /**
   *
   * @var Model_DbTable_Answer
   */
  protected $tbl_answer;
  /**
   *
   * @var Admin_Form_PollingForm
   */
  protected $form;

  public function init()
  {
    $this->tbl_polling = new Model_DbTable_Polling();
    $this->tbl_answer  = new Model_DbTable_Answer();
    $this->form        = new Admin_Form_PollingForm();
    parent::init();
  }

  public function indexAction()
  {
    $pageNumber           = $this->_getParam('page');
    $currentPolling = $this->_getParam('currentPolling');

    if ($this->getRequest()->isPost()) {
      $post = $this->getRequest()->getPost();
      if (!empty($post['delete'])) {
        foreach ($post['delete'] as $key => $id) {
          $this->tbl_polling->find($id)->current()->delete();
        }
      }
    }

    if (null == $currentPolling) {
      $active_polling = $this->tbl_polling->getActivePolling();
      if (sizeof($active_polling)) {
        $currentPolling = $active_polling->polling_id;
      }
    }

    if (null != $currentPolling) {
      $result                           = $this->tbl_answer->getAllWithResult($currentPolling);
      $this->view->currentPollingResult = $result->toArray();
    }

    $polling               = $this->tbl_polling->getAll();
    $paginator             = Zend_Paginator::factory($polling);
    $paginator->setCurrentPageNumber($pageNumber);
    $this->view->paginator = $paginator;
  }

  public function createAction()
  {
    if ($this->getRequest()->isPost()) {
      $polling = $this->getRequest()->getPost('polling');
      if ($this->form->isValid($polling)) {
        if ($polling['status'] == 1)
          $this->tbl_polling->update(array("showstatus = 0"));

        $polling_id = $this->tbl_polling->insert(array(
            'question'   => $polling['question'],
            'showstatus' => $polling['showstatus']
                ));
        foreach ($polling['answer'] as $key => $answer) {
          $this->tbl_answer->insert(array(
              'polling_id'      => $polling_id,
              'answer'          => $answer
          ));
        }
        $this->_helper->redirector('index');
      }
    }
    $this->view->form = $this->form;
  }

  public function editAction()
  {
    $polling_id     = $this->_getParam('id');
    $polling        = $this->tbl_polling->find($polling_id)->current();
    $pollingAnswers = $this->tbl_answer->getAnswersName($polling_id);

    if (empty($polling))
      $this->_helper->redirector('index');

    $this->form->populate($polling->toArray());
    $this->form->answerSubForm->populate($pollingAnswers);

    if ($this->getRequest()->isPost()) {
      $polling = $this->getRequest()->getPost('polling');
      if ($this->form->isValid($polling)) {
        if ($polling['showstatus'] == 1) {
          $this->tbl_polling->update(array('showstatus' => 0), '');
        }
        $this->tbl_polling->update(array(
            'question'   => $polling['question'],
            'showstatus' => $polling['showstatus']
                ), "polling_id = {$polling_id}");
        $this->tbl_answer->delete("polling_id = {$polling_id}");
        foreach ($polling['answer'] as $key => $answer) {
          $data = array(
              'polling_id' => $polling_id,
              'answer'     => $answer
          );
          $this->tbl_answer->insert($data);
        }
        $this->_helper->redirector('index');
      }
    }

    $this->view->form = $this->form;
  }

  public function deleteAction()
  {
    $this->_helper->viewRenderer->setNoRender(true);
    $id  = $this->_getParam('id');
    $row = $this->tbl_polling->find($id)->current();
    if (!empty($row)) {
      $row->delete();
    }
    $this->_helper->redirector('index');
  }

  public function activateAction()
  {
    $id  = $this->_getParam('id');
    $row = $this->tbl_polling->find($id)->current();
    if (!empty($row)) {
      $this->tbl_polling->update(array('showstatus' => 0), '');
      $row->setFromArray(array('showstatus' => 1))->save();
    }
    $this->_helper->redirector('index');
  }

  public function deactivateAction()
  {
    $id  = $this->_getParam('id');
    $row = $this->tbl_polling->find($id)->current();
    if (!empty($row)) {
      $row->setFromArray(array('showstatus' => 0))->save();
    }
    $this->_helper->redirector('index');
  }

}