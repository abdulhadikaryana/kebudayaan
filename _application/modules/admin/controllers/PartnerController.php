<?php
require_once 'Zend/Controller/Action.php';

class Admin_PartnerController
        extends Library_Controller_Backend
{
  /**
   *
   * @var Model_DbTable_Partner 
   */
  protected $_partner;
  /**
   * 
   * @var Model_DbTable_PartnerDescription
   */
  protected $_partnerDescription;

  public function init()
  {
    $this->_partner            = new Model_DbTable_Partner();
    $this->_partnerDescription = new Model_DbTable_PartnerDescription();
    $this->filter = new Zend_Session_Namespace('filter');
    parent::init();
  }

  public function indexAction()
  {
    if ($this->getRequest()->isPost()) {
      $post = $this->getRequest()->getPost();
      $action = $post['action'];
      switch ($action) {
          case 'delete':
            foreach ($post['partners'] as $index => $id) {
                $this->_partner->find($id)->current()->delete();
            }
            break;
          case 'filter':
            $this->filter->partner = $post['filter'];
            break;
          case 'reset':
            $this->filter->unsetAll();
            break;
      }                  
    }

    $partners             = $this->_partner->fetchAllWithTranslationStatus($this->filter->partner, 1);
    $partners_paginator   = Zend_Paginator::factory($partners);
    $this->view->partners = $partners_paginator;
    
    $messages = $this->_helper->flashMessenger->getMessages();
    $this->view->messages = $messages;
    
    $this->view->filter = $this->filter->partner;
  }

  public function addAction()
  {
    $form = new Admin_Form_PartnerForm();    
    if ($this->getRequest()->isPost()) {
      $formData = $this->getRequest()->getPost('partner');
      if ($form->isValid($formData)) {

        if ($form->logo->isUploaded())
          $form->logo->receive();

        $data = array(
            'name'      => $form->getValue('name'),
            'logo'      => $form->getValue('logo'),
            'website'   => $form->getValue('website'),
        );
        $partner_id = $this->_partner->insert($data);

        $data = array(
            'description' => $form->getValue('description'),
            'partner_id'  => $partner_id,
            'language_id' => Model_DbTable_PartnerDescription::LANG_ID
        );
        $this->_partnerDescription->insert($data);

        $this->_helper->redirector('index');
      }
    }
    $this->view->form = $form;
  }

  public function translateAction()
  {
    $id           = $this->_getParam('id');
    $isTranslated = $this->_partner->fetchWithDescription($id,
            Model_DbTable_PartnerDescription::LANG_EN);
    $partner      = $this->_partner->fetchRow(array('id = ?' => $id));

    if (null == $id || null == $partner || $isTranslated)
      $this->_helper->redirector('index');

    $form = new Admin_Form_PartnerForm();
    $form->populate($partner->toArray());
    $form->name->setAttrib('disabled', true);
    $form->logo->setAttrib('disabled', true);
    $form->website->setAttrib('disabled', true);

    if ($this->getRequest()->isPost()) {
      $post        = $this->getRequest()->getPost();
      $description = $post['partner']['description'];
      if ($form->description->isValid($description)) {
        $data = array(
            'partner_id'  => $id,
            'language_id' => Model_DbTable_PartnerDescription::LANG_EN,
            'description' => $description
        );
        $this->_partnerDescription->insert($data);
        $this->_helper->redirector('index');
      }
    }

    $this->view->logo = $partner->logo;
    $this->view->form = $form;
  }

  public function editAction()
  {
    $form = new Admin_Form_PartnerForm();    
    $id   = $this->_getParam('id');

    if ($id == null)
      $this->_helper->redirector('index');
    else {
      $partner = $this->_partner->fetchWithDescription($id,
              Model_DbTable_PartnerDescription::LANG_ID);
      if (null == $partner)
        $this->_helper->redirector('index');
    }
    $form->populate($partner->toArray());

    if ($this->getRequest()->isPost()) {
      $post    = $this->getRequest()->getPost();
      $partner = $post['partner'];
      if ($form->isValid($partner)) {

        $data = array(
            'name'        => $form->getValue('name'),
            'website'     => $form->getValue('website'),
        );
        if ($form->logo->isUploaded())
          if ($form->logo->receive())
            $data['logo'] = $form->logo->getFileName('logo', false);
        $where        = array('id = ?' => $id);
        $this->_partner->update($data, $where);


        $data = array(
            'description' => $form->getValue('description')
        );
        $where        = array(
            'partner_id = ?'  => $id,
            'language_id = ?' => Model_DbTable_PartnerDescription::LANG_ID
        );
        $this->_partnerDescription->update($data, $where);
        $this->_helper->redirector('index');
      }
    }

    $this->view->form = $form;
    $this->view->logo = $partner->logo;
  }

  public function edittranslationAction()
  {
    $id   = $this->_getParam('id');
    $form = new Admin_Form_PartnerForm();
    $form->submit->setLabel('Save');
    $form->name->setAttrib('disabled', true);
    $form->logo->setAttrib('disabled', true);
    $form->website->setAttrib('disabled', true);

    if (null == $id)
      $this->_helper->redirector('index');
    else {
      $partner = $this->_partner->fetchWithDescription($id,
              Model_DbTable_PartnerDescription::LANG_EN);
      if (null == $partner)
        $this->_helper->redirector('index');
    }

    $form->populate($partner->toArray());

    if ($this->getRequest()->isPost()) {
      $post        = $this->getRequest()->getPost();
      $description = $post['partner']['description'];
      if ($form->description->isValid($description)) {
        $data = array(
            'description' => $form->getValue('description')
        );
        $where        = array(
            'partner_id = ?'  => $id,
            'language_id = ?' => Model_DbTable_PartnerDescription::LANG_EN
        );
        $this->_partnerDescription->update($data, $where);
        $this->_helper->redirector('index');
      }
    }

    $this->view->logo = $partner->logo;
    $this->view->form = $form;
  }

  public function deleteAction()
  {
    $this->_helper->viewRenderer->setNorender();
    $id      = $this->_getParam('id');
    $lang    = $this->_getParam('lang');
    $partner = $this->_partner->find($id)->current();
    if ($id != null && $partner != null) {
      if ($lang != null) {
        $this->_partnerDescription->delete(array(
            'partner_id  = ?' => $id,
            'language_id = ?' => $lang
        ));
      }
      else
        $partner->delete();
    }
    $this->_helper->redirector('index');
  }

}