<?php

require_once 'Zend/Controller/Action.php';

class Admin_GalleryController extends Library_Controller_Backend {

    /**
     *
     * @var Model_DbTable_Partner 
     */
    protected $_db;

    /**
     * 
     * @var Model_DbTable_PartnerDescription
     */
    protected $_partnerDescription;

    public function init() {
        $this->_db = new Admin_Model_DbTable_ImgGallery();
        $this->filter = new Zend_Session_Namespace('filter');
        parent::init();
    }

    public function indexAction() {
        $pageNumber = $this->_getParam('page');
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            $action = $post['action'];
            switch ($action) {
                case 'delete':
                    foreach ($post['images'] as $index => $id) {
                        $image = $this->_db->find($id)->current();
                        $filename = IMAGE_FOLDER . 'upload/gallery/' . $image->image;
                        if (file_exists($filename))
                            unlink($filename);
                        $image->delete();
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

        $images = $this->_db->fetchAllWithFilter($this->filter->partner);
        $paginator = Zend_Paginator::factory($images);
        $paginator->setItemCountPerPage(5);
        $paginator->setCurrentPageNumber($pageNumber);

        $this->view->images = $paginator;

        $messages = $this->_helper->flashMessenger->getMessages();
        $this->view->messages = $messages;

        $this->view->filter = $this->filter->partner;
    }

    public function addAction() {
        $form = new Admin_Form_GalleryForm();
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost('gallery');
            if ($form->isValid($formData)) {
                if ($form->image->isUploaded())
                    $form->image->receive();
                $data = array(
                    'source' => $form->getValue('source'),
                    'caption' => $form->getValue('caption'),
                    'caption_en' => $form->getValue('caption_en'),
                    'image' => $form->getValue('image'),
                    'created_by' => $this->_userInfo->id,
                    'created_at' => date('Y-m-d H:i:s')
                );
                $this->_db->insert($data);
                $this->_helper->redirector('index');
            }
        }
        $this->view->form = $form;
    }

    public function editAction() {
        $form = new Admin_Form_GalleryForm();
        $id = $this->_getParam('id');

        if ($id == null)
            $this->_helper->redirector('index');
        else {
            $image = $this->_db->find($id)->current();
            if (null == $image)
                $this->_helper->redirector('index');
        }
        $form->populate($image->toArray());

        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost('gallery');
            if ($form->isValid($post)) {
                $data = array(
                    'source' => $form->getValue('source'),
                    'caption' => $form->getValue('caption'),
                    'caption_en' => $form->getValue('caption_en'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->_userInfo->id,
                );
                if ($form->image->isUploaded())
                    if ($form->image->receive())
                        $data['image'] = $form->getValue("image");

                $this->_db->update($data, array("id = ?" => $id));
                $this->_helper->redirector('index');
            }
        }

        $this->view->form = $form;
        $this->view->image = $image->image;
    }

    public function deleteAction() {
        $this->_helper->viewRenderer->setNorender();
        $id = $this->_getParam('id');
        $image = $this->_db->find($id)->current();
        if ($image) {
            $filename = IMAGE_FOLDER . 'upload/gallery/' . $image->image;
            if (file_exists($filename))
                unlink($filename);
            $image->delete();
        }
        $this->_helper->redirector('index');
    }

}
