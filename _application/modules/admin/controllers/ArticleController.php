
<?php

class Admin_ArticleController
        extends Library_Controller_Backend
{
  const STATUS_ARCHIVED    = 0;
  const STATUS_DRAFT       = 1;
  const STATUS_PENDING     = 2;
  const STATUS_PUBLISHED   = 3;
  const LANGUAGE_ID        = 1;
  const LANGUAGE_EN        = 2;

  /**
   *
   * @var Admin_Form_ArticleForm
   */
  protected $_form;
  /**
   *
   * @var Admin_Model_DbTable_Article
   */
  protected $_article;
  /**
   *
   * @var Admin_Model_DbTable_ArticleDescription
   */
  protected $_description;
  /**
   *
   * @var Zend_Session_Namespace
   */
  protected $_filter;

  public function init()
  {
    $this->_form        = new Admin_Form_ArticleForm();
    $this->_article     = new Admin_Model_DbTable_Article();
    $this->_description = new Admin_Model_DbTable_ArticleDescription();
    $this->_filter      = new Zend_Session_Namespace('filter');
    parent::init();
  }

  public function indexAction()
  {
    if ($this->getRequest()->isPost()) {
      $post = $this->getRequest()->getPost();
      if ($post['action'] == 'delete') {
        if (isset($post['deletes'])) {
          $deletes = $post['deletes'];
          foreach ($deletes as $index => $article_id) {
            $article = $this->_article->fetchRow(array(
                'id = ?' => $article_id
                    ));
            if (null != $article)
              $article->delete();
          }
        }
      }else if ($post['action'] == 'filter') {
        $this->_filter->article = $post['filter'];
        $this->_helper->redirector('index');
      } else if ($post['action'] == 'reset') {
        $this->_filter->unsetAll();
      }
    }

    $user_id = null;
    if (!$this->_userInfo->canApprove)
      $user_id = $this->_userInfo->id;

    $data = $this->_article->findAll($user_id, $this->_filter->article);

    $messages   = $this->_helper->flashMessenger->getMessages();
    $paginator  = Zend_Paginator::factory($data);
    $pageNumber = $this->_getParam('page');
    $paginator->setItemCountPerPage(5);
    $paginator->setCurrentPageNumber($pageNumber);


    $this->view->messages       = $messages;
    $this->view->filter         = $this->_filter->article;
    $this->view->userCanApprove = $this->_userInfo->canApprove;
    $this->view->paginator      = $paginator;
  }

  public function createAction()
  {
    $this->_form->submit->setLabel('Publish');
    $this->_form->draft->setLabel('Draft');


    if ($this->getRequest()->isPost()) {
      $post = $this->getRequest()->getPost();
      $data = $post['article'];
      if ($this->_form->isValid($data)) {

        $status = self::STATUS_ARCHIVED;
        if (isset($data['draft'])) {
          $status = self::STATUS_DRAFT;
        } else if (isset($data['submit'])) {
          if ($this->_userInfo->canApprove) {
            $status = self::STATUS_PUBLISHED;
          } else {
            $status = self::STATUS_PENDING;
          }
        }

        $this->_form->image->receive();

        $data = array(
            'name'       => $this->_form->getValue('name'),
            'image'      => $this->_form->getValue('image'),
            'created_by' => $this->_userInfo->id,
            'created_at' => Date('Y-m-d H:i:s'),
            'status'     => $status
        );

        $article_id = $this->_article->insert($data);
        $data       = array(
            'article_id'  => $article_id,
            'language_id' => self::LANGUAGE_ID,
            'description' => $this->_form->getValue('description')
        );
        $this->_description->insert($data);

        $this->_flashMessenger
                ->addMessage('Article created successfully.');
        $this->_helper->_redirector('index');
      }
    }

    $this->view->form = $this->_form;
  }

  public function updateAction()
  {
    $id = $this->_getParam('id');
    $this->_form->image->setRequired(false);
    $this->_form->draft->setLabel('Save as draft');
    $this->_form->submit->setLabel('Save and publish');

    if (!$this->_userInfo->canApprove)
      $this->_form->submit->setLabel('Save and submit for review');

    if (null != $id) {
      $article = $this->_article->fetchWithDescription($id,
              self::LANGUAGE_ID);
      if (null != $article)
        $this->_form->populate($article->toArray());
      else
        $this->_helper->redirector('index');
    } else
      $this->_helper->redirector('index');

    if ($this->getRequest()->isPost()) {
      $post = $this->getRequest()->getPost();
      $data = $post['article'];
      if ($this->_form->isValid($data)) {

        $status = self::STATUS_ARCHIVED;
        if (isset($data['draft'])) {
          $status = self::STATUS_DRAFT;
        } else if (isset($data['submit'])) {
          if ($this->_userInfo->canApprove) {
            $status = self::STATUS_PUBLISHED;
          } else {
            $status = self::STATUS_PENDING;
          }
        }

        $data = array(
            'name'       => $this->_form->getValue('name'),
            'updated_by' => $this->_userInfo->id,
            'updated_at' => Date('Y-m-d H:i:s'),
            'status'     => $status
        );

        if ($this->_form->image->isUploaded()) {
          if ($this->_form->image->receive())
            $data['image'] = $this->_form->getValue('image');
        }

        $this->_article->update($data, array('id = ?' => $id));

        $data = array(
            'description' => $this->_form->getValue('description')
        );
        $this->_description->update($data,
                array(
            'article_id = ?'  => $id,
            'language_id = ?' => self::LANGUAGE_ID));

        $this->_flashMessenger
                ->addMessage('Article updated successfully.');
        $this->_helper->redirector('index');
      }
    }

    if (null != $article->image) {
      if (file_exists(UPLOAD_FOLDER . 'article/' . $article->image)) {
        $this->view->image = 'upload/article/' . $article->image;
      }
    }

    $this->view->form = $this->_form;
  }

  public function deleteAction()
  {
    $this->_helper->viewRenderer->setNoRender();
    $id = $this->_getParam('id');
    if (null != $id) {
      $article = $this->_article->fetchRow(array(
          'id = ?' => $id));
      if (null != $article) {
        if ($article->status != self::STATUS_ARCHIVED) {
          $article->setFromArray(array(
              'status' => self::STATUS_ARCHIVED
          ))->save();
          $this->_flashMessenger->addMessage('Article archived.');
        } else {
          $article->delete();
          $this->_flashMessenger
                  ->addMessage('Article deleted successfully.');
        }
      }
    }
    $this->_helper->redirector('index');
  }

  public function approveAction()
  {
    $this->_helper->viewRenderer->setNoRender();
    $id = $this->_getParam('id');
    if (null != $id && $this->_userInfo->canApprove) {
      $article = $this->_article->fetchRow(array('id = ?' => $id));
      if (null != $article
              && $article->status == self::STATUS_PENDING) {

        $data = array(
            'status'      => self::STATUS_PUBLISHED,
            'approved_by' => $this->_userInfo->id,
            'approved_at' => Date('Y-m-d H:i:s')
        );
        $article->setFromArray($data)->save();
      }
    }
    $this->_helper->redirector('index');
  }

  public function translateAction()
  {
    $id = $this->_getParam('id');
    $this->_form->draft
            ->setLabel('Save as draft')
            ->setAttrib('disabled', true);
    $this->_form->submit->setLabel('Save');
    $this->_form->image->setRequired(false)
            ->setAttrib('disabled', true);
    $this->_form->name->setRequired(false)
            ->setAttrib('disabled', true);

    if (null != $id) {
      $article = $this->_article->fetchWithDescription($id,
              self::LANGUAGE_EN);
      if (null != $article) {
//        $this->_helper->redirector('$action', '$controller',
//                '$module', '$params');
        $this->_helper->redirector('index');
      } else {
        $article = $this->_article->fetchRow(array('id = ?' => $id));
        $this->_form->populate($article->toArray());
      }
    } else
      $this->_helper->redirector('index');

    if ($this->getRequest()->isPost()) {
      $post        = $this->getRequest()->getPost();
      $description = $post['article']['description'];
      if ($this->_form->description->isValid($description)) {
        $data = array(
            'article_id'  => $id,
            'language_id' => self::LANGUAGE_EN,
            'description' => $description
        );
        $this->_description->insert($data);

        $this->_flashMessenger
                ->addMessage('Article translation created successfully.');
        $this->_helper->redirector('index');
      }
    }

    if (null != $article->image) {
      if (file_exists(UPLOAD_FOLDER . 'article/' . $article->image)) {
        $this->view->image = 'upload/article/' . $article->image;
      }
    }
    $this->view->form  = $this->_form;
  }

  public function deletetranslationAction()
  {
    $this->_helper->viewRenderer->setNoRender();
    $id = $this->_getParam('id');
    if (null != $id) {
      $article = $this->_article->fetchWithDescription($id,
              self::LANGUAGE_EN);
      if (null != $article) {
        $decription = $this->_description->fetchRow(array(
            'article_id = ?'  => $id,
            'language_id = ?' => self::LANGUAGE_EN
                ));
        if (null != $decription) {
          $decription->delete();
          $this->_flashMessenger
                  ->addMessage('Article translation deleted successfully.');
        }
      }
    }
    $this->_helper->redirector('index');
  }

  public function edittranslationAction()
  {
    $id = $this->_getParam('id');
    $this->_form->name->setRequired(false)
            ->setAttrib('disabled', true);
    $this->_form->image->setRequired(false)
            ->setAttrib('disabled', true);
    $this->_form->draft->setLabel('Save as draft')
            ->setAttrib('disabled', true);
    $this->_form->submit->setLabel('Save');

    if (null != $id) {
      $article = $this->_article->fetchWithDescription($id,
              self::LANGUAGE_EN);
      if (null != $article) {
        $this->_form->populate($article->toArray());
      } else
        $this->_helper->redirector('index');
    } else
      $this->_helper->redirector('index');

    if ($this->getRequest()->isPost()) {
      $post        = $this->getRequest()->getPost();
      $description = $post['article']['description'];
      if ($this->_form->description->isValid($description)) {
        $data = array(
            'description' => $description
        );
        $this->_description->update($data,
                array(
            'article_id = ?'  => $id,
            'language_id = ?' => self::LANGUAGE_EN));

        $this->_flashMessenger
                ->addMessage('Article translation saved successfully.');
        $this->_helper->redirector('index');
      }
    }


    if (null != $article->image) {
      if (file_exists(UPLOAD_FOLDER . 'article/' . $article->image)) {
        $this->view->image = 'upload/article/' . $article->image;
      }
    }
    $this->view->form  = $this->_form;
  }

}