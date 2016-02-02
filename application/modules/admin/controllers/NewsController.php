<?php

class Admin_NewsController extends Library_Controller_Backend
{
  const STATUS_ARCHIVED = 0;
  const STATUS_DRAFT = 1;
  const STATUS_PENDING = 2;
  const STATUS_PUBLISH = 3;
  const LANGUAGE_ID = 1;
  const LANGUAGE_EN = 2;

  /**
   *
   * @var Admin_Model_DbTable_News
   */
  protected $news;
  /**
   *
   * @var Admin_Model_DbTable_NewsDescription
   */
  protected $newsDescription;
  /**
   *
   * @var Admin_Form_NewsForm
   */
  protected $form;
  /**
   *
   * @var Zend_Session_Namespace
   */
  protected $filter;

  public function init()
  {
    $this->news = new Admin_Model_DbTable_News();
    $this->newsDescription = new Admin_Model_DbTable_NewsDescription();
    $this->form = new Admin_Form_NewsForm();
    $this->filter = new Zend_Session_Namespace('filter');

    $this->form->image->setDestination(UPLOAD_FOLDER . 'news/');

    parent::init();
  }

  public function indexAction()
  {
    $pageNumber = $this->_getParam('page');
    if ($this->getRequest()->isPost()) {
      $post = $this->getRequest()->getPost();
      switch ($post['action']) {
        case 'delete':
          foreach ($post['news'] as $id) {
            $news = $this->news->find($id)->current();
            if ($news->status != self::STATUS_ARCHIVED) {
              $news->setFromArray(array(
                  'status' => self::STATUS_ARCHIVED))->save();
              $this->loggingaction('News', 'Archive', $news->id, self::LANGUAGE_ID);
            } else {
              $news->delete();
              $this->loggingaction('News', 'Delete', $news->id, self::LANGUAGE_ID);
            }
          }
          $this->_helper->flashMessenger->addMessage(
                  'Berita Berhasil Dihapus.');
          $this->_helper->redirector('index');
          break;
        case 'restore':
          foreach ($post['news'] as $id) {
            $news = $this->news->find($id)->current();
            if (null != $news) if ($news->status == self::STATUS_ARCHIVED) $news->setFromArray(array(
                    'status'                     => self::STATUS_DRAFT))->save();
            $this->loggingaction('News', 'Restore', $news->id, self::LANGUAGE_ID);
          }
          $this->_helper->flashMessenger->addMessage('News restored successfully.');
          $this->_helper->redirector('index');
          break;
        case 'filter':
          $this->filter->news = $post['filter'];
          break;
        case 'sort':
          $this->filter->news = $post['filter'];
          if ($this->filter->news['order'] == 'ASC') $this->filter->news['order'] = 'DESC';
          else $this->filter->news['order'] = 'ASC';
          break;
        case 'reset':
          $this->filter->unsetAll();
          break;
        default:
          break;
      }
    }

    $statusesCount = $this->news->findStatusesCount();
    $data = $this->news->findAllWithDescription(self::LANGUAGE_ID, $this->filter->news);
    if (!$this->_userInfo->canApprove) {
      $data = $this->news->findAllWithDescription(self::LANGUAGE_ID, $this->filter->news, $this->_userInfo->id);
      $statusesCount = $this->news->findStatusesCount($this->_userInfo->id);
    }

    $news = Zend_Paginator::factory($data);
    $news->setCurrentPageNumber($pageNumber);

    $news->setItemCountPerPage(5);
    if (null != $this->filter->news['row']) $news->setItemCountPerPage($this->filter->news['row']);

    $this->view->statusesCount = $statusesCount;
    $this->view->userInfo = $this->_userInfo;
    $this->view->filter = $this->filter->news;
    $this->view->news = $news;
    $this->view->messages = $this->_helper->flashMessenger
            ->getMessages();
  }

  public function createAction()
  {
    $this->form->submit->setLabel('Terbitkan');
    $this->form->draft->setLabel('Simpan sebagai draft');
    if (!$this->_userInfo->canApprove) $this->form->submit->setLabel('Simpan untuk pratinjau');

    if ($this->getRequest()->isPost()) {
      $post = $this->getRequest()->getPost();
      $formData = $post['news'];

      if ($this->form->isValid($formData)) {

        $status = self::STATUS_DRAFT;
        if (isset($formData['submit'])) if ($this->_userInfo->canApprove) $status = self::STATUS_PUBLISH;
          else $status = self::STATUS_PENDING;

        $data = array(
            'created_by'   => $this->_userInfo->id,
            'created_at'   => date('Y-m-d H:i:s'),
            'status'       => $status,
            'publish_date' => date('Y-m-d', strtotime($this->form->getValue('publish_date'))),
        );

        if ($this->form->image->isUploaded()) {
          $file = pathinfo($this->form->image->getFileName());
          $this->form->image->addFilter('Rename', UPLOAD_FOLDER
                  . 'news/'
                  . $file['filename'] . '_'
                  . time() . '.'
                  . $file['extension']);
          if ($this->form->image->receive()) {
            $data['image'] = $this->form->getValue('image');
          }
        }


        $news_id = $this->news->insert($data);

        $data = array(
            'news_id'     => $news_id,
            'language_id' => self::LANGUAGE_ID,
            'title'       => $this->form->getValue('title'),
            'content'     => $this->form->getValue('content')
        );

        $this->newsDescription->insert($data);

        $this->loggingaction('News', 'Create', $news_id, self::LANGUAGE_ID);
        $this->_helper->flashMessenger
                ->addMessage('News inserted successfully.');
        $this->_helper->redirector('index');
      }
    }


    $this->view->form = $this->form;
  }

  public function updateAction()
  {
    $this->form->submit->setLabel('Publish');
    $this->form->draft->setLabel('Save as draft');
    if (!$this->_userInfo->canApprove) $this->form->submit->setLabel('Save and submit for review');

    $id = $this->_getParam('id');
    $news = $this->news->findWithDescription($id, self::LANGUAGE_ID);

    $this->form->populate($news->toArray());
    $this->form->publish_date->setValue(date('d-m-Y', strtotime($news->publish_date)));

    if ($this->getRequest()->isPost()) {
      $post = $this->getRequest()->getPost();
      $formData = $post['news'];
      if ($this->form->isValid($formData)) {

        $status = self::STATUS_DRAFT;
        if (isset($formData['submit'])) if ($this->_userInfo->canApprove) $status = self::STATUS_PUBLISH;
          else $status = self::STATUS_PENDING;

        $publish_date = date('Y-m-d', strtotime($this->form->getValue('publish_date')));

        $data = array(
            'updated_by'   => $this->_userInfo->id,
            'updated_at'   => date('Y-m-d H:i:s'),
            'publish_date' => $publish_date,
            'status'       => $status);

        if ($this->form->image->isUploaded()) {
          $file = pathinfo($this->form->image->getFileName());
          $this->form->image->addFilter('Rename', UPLOAD_FOLDER
                  . 'news/'
                  . $file['filename'] . '_'
                  . time() . '.'
                  . $file['extension']);
          if ($this->form->image->receive()) {
            $data['image'] = $this->form->getValue('image');
          }
        }

        $this->news->update($data, array('id = ?' => $id));

        $data = array(
            'title'   => $this->form->getValue('title'),
            'content' => $this->form->getValue('content'));

        $this->newsDescription->update($data, array(
            'news_id = ?'     => $id,
            'language_id = ?' => self::LANGUAGE_ID));

        $this->loggingaction('News', 'Update', $id, self::LANGUAGE_ID);
        $this->_helper->flashMessenger->addMessage('News updated successfully.');
        $this->_helper->redirector('index');
      }
    }

    if (null != $news->image) {
      if (file_exists(UPLOAD_FOLDER . 'news/' . $news->image)) {
        $image = $this->view->imageUrl('upload/news/' . $news->image);

        $this->view->image = $image;
      }
    }

    $this->view->form = $this->form;
  }

  public function deleteAction()
  {
    $id = $this->_getParam('id');
    $news = $this->news->find($id)->current();

    if ($news->status != self::STATUS_ARCHIVED) {
      $news->setFromArray(array('status' => self::STATUS_ARCHIVED))->
              save();
      $this->loggingaction('News', 'Archive', $id, self::LANGUAGE_ID);
      $this->_helper->flashMessenger->addMessage('News archived successfully.');
    } else {
      $news->delete();
      $this->loggingaction('News', 'Delete', $id, self::LANGUAGE_ID);
      $this->_helper->flashMessenger->addMessage('News deleted successfully.');
    }
    $this->_helper->redirector('index');
  }

  public function approveAction()
  {
    $id = $this->_getParam('id');
    if (null != $id && $this->_userInfo->canApprove) {
      $news = $this->news->find($id)->current();
      if (null != $news && $news->status == self::STATUS_PENDING) {
        $news->setFromArray(array(
            'status'      => self::STATUS_PUBLISH,
            'approved_by' => $this->_userInfo->id,
            'approved_at' => date('Y-m-d H:i:s')
        ))->save();
        $this->loggingaction('News', 'Approve', $id, self::LANGUAGE_ID);
        $this->_helper->flashMessenger->addMessage('News approved successfully.');
      }
    }
    $this->_helper->redirector('index');
  }

  public function createtranslationAction()
  {
    $id = $this->_getParam('id');
    $this->form->publish_date->setAttrib('disabled', true)
            ->setRequired(false);
    $this->form->image->setAttrib('disabled', true);
    $this->form->draft->setAttrib('disabled', true)
            ->setLabel('Draft');
    $this->form->submit->setLabel('Save');

    $news = $this->news->find($id)->current();

    $this->form->populate($news->toArray());
    $this->form->publish_date->setValue(date('d-m-Y', strtotime($news->publish_date)));

    if ($this->getRequest()->isPost()) {
      $post = $this->getRequest()->getPost();
      if ($this->form->title->isValid($post['news']['title'])
              & $this->form->content->isValid($post['news']['content'])) {
        $data = array(
            'news_id'     => $news->id,
            'language_id' => self::LANGUAGE_EN,
            'title'       => $this->form->getValue('title'),
            'content'     => $this->form->getValue('content')
        );
        $this->newsDescription->insert($data);
        $this->loggingaction('News', 'Create', $id, self::LANGUAGE_EN);
        $this->_helper->flashMessenger->addMessage(
                'News translation created successfully.');
        $this->_helper->redirector('index');
      }
    }


    if (null != $news->image) {
      if (file_exists(UPLOAD_FOLDER . 'news/' . $news->image)) $this->view->image = $this->view
                ->imageUrl('upload/news/' . $news->image);
    }

    $this->view->form = $this->form;
  }

  public function deletetranslationAction()
  {
    $id = $this->_getParam('id');
    $this->newsDescription->fetchRow(array(
        'news_id = ?'     => $id,
        'language_id = ?' => self::LANGUAGE_EN))->delete();

    $this->loggingaction('News', 'Delete', $id, self::LANGUAGE_EN);
    $this->_helper->flashMessenger->addMessage(
            'News translation deleted successfully.');
    $this->_helper->redirector('index');
  }

  public function updatetranslationAction()
  {
    $this->form->draft->setAttrib('disabled', true)
            ->setLabel('Draft');
    $this->form->submit->setLabel('Save');

    $id = $this->_getParam('id');
    $this->form->publish_date->setAttrib('disabled', true)
            ->setRequired(false);
    $this->form->image->setAttrib('disabled', true);
    $news = $this->news->findWithDescription($id, self::LANGUAGE_EN);
    $this->form->populate($news->toArray());
    $this->form->publish_date->setValue(date('d-m-Y', strtotime($news->publish_date)));

    if ($this->getRequest()->isPost()) {
      $post = $this->getRequest()->getPost();
      $title = $post['news']['title'];
      $content = $post['news']['content'];
      if ($this->form->title->isValid($title)
              & $this->form->content->isValid($content)) {
        $data = array(
            'title'   => $this->form->getValue('title'),
            'content' => $this->form->getValue('content')
        );
        $this->newsDescription->update($data, array(
            'news_id = ?'     => $id,
            'language_id = ?' => self::LANGUAGE_EN));

        $this->loggingaction('News', 'Update', $id, self::LANGUAGE_EN);
        $this->_helper->flashMessenger
                ->addMessage('News translation updated successfully.');
        $this->_helper->redirector('index');
      }
    }

    if (null != $news->image) {
      if (file_exists(UPLOAD_FOLDER . 'news/' . $news->image)) $this->view->image = $this->view
                ->imageUrl('upload/news/' . $news->image);
    }
    $this->view->form = $this->form;
  }

  public function restoreAction()
  {
    $id = $this->_getParam('id');
    $news = $this->news->find($id)->current();
    if (null != $news && $news->status == self::STATUS_ARCHIVED) $news->setFromArray(array('status' => self::STATUS_DRAFT))->save();

    $this->loggingaction('News', 'Restore', $news->id, self::LANGUAGE_ID);
    $this->_helper->flashMessenger->addMessage('News restored successfully.');
    $this->_helper->redirector('index');
  }

}