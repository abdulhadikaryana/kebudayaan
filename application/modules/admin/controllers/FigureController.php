<?php



class Admin_FigureController extends Library_Controller_Backend

{

  const STATUS_ARCHIVED = 0;

  const STATUS_DRAFT = 1;

  const STATUS_PENDING = 2;

  const STATUS_PUBLISH = 3;

  const LANGUAGE_ID = 1;

  const LANGUAGE_EN = 2;



  /**

   *

   * @var Admin_Form_FigureForm

   */

  protected $form;

  /**

   *

   * @var Admin_Model_DbTable_Figure

   */

  protected $figure;

  /**

   * 

   * @var Admin_Model_DbTable_FigureDescription

   */

  protected $figure_description;

  /**

   * 

   * @var Zend_Session_Namespace

   */

  protected $filter_session;



  public function init()

  {

    $this->form = new Admin_Form_FigureForm();

    $this->figure = new Admin_Model_DbTable_Figure();

    $this->figure_description = new Admin_Model_DbTable_FigureDescription();

    $this->filter_session = new Zend_Session_Namespace('filter');



    $this->form->image->setDestination(UPLOAD_FOLDER . 'figure/');

    parent::init();

  }



  public function indexAction()

  {



    $pageNumber = $this->_getParam('page');



    if ($this->getRequest()->isPost()) {

      $post = $this->getRequest()->getPost();

      if (isset($post['action'])) {

        if ($post['action'] == 'delete') {

          $deletes = $post['figures'];

          foreach ($deletes as $key => $id) {

            $figure = $this->figure->find($id)->current();

            if (null != $figure) {

              if (self::STATUS_ARCHIVED != $figure->status) {

                $figure->setFromArray(array(

                    'status' => self::STATUS_ARCHIVED))->save();

                $this->loggingaction('Figure', 'Archive', $figure->id, self::LANGUAGE_ID);

              } else {

                $this->loggingaction('Figure', 'Delete', $figure->id, self::LANGUAGE_ID);

                $figure->delete();

              }

            }

          }

          $this->_helper->flashMessenger->addMessage(

                  'Figur Berhasil Dihapus.');

          $this->_helper->redirector('index');

        } else if ($post['action'] == 'restore') {

          $figures = $post['figures'];

          foreach ($figures as $index => $id) {

            $figure = $this->figure->find($id)->current();

            if (null != $figure) $figure->setFromArray(array(

                  'status' => self::STATUS_DRAFT))->save();

            $this->loggingaction('Figure', 'Restore', $figure->id, self::LANGUAGE_ID);

          }

          $this->_helper->flashMessenger->addMessage(

                  'Figur Berhasil Dimuat Ulang.');

          $this->_helper->redirector('index');

        } else if ($post['action'] == 'filter') {

          $this->filter_session->figure = $post['filter'];

          $this->_helper->redirector('index');

        } else if ($post['action'] == 'sort-name') {

          $filter = $post['filter'];

          $filter['sort'] = 'name';

          if ($filter['sort_order'] == 'ASC') $filter['sort_order'] = 'DESC';

          else $filter['sort_order'] = 'ASC';



          $this->filter_session->figure = $filter;

          $this->_helper->redirector('index');

        }else if ($post['action'] == 'sort-date') {

          $filter = $post['filter'];

          $filter['sort'] = 'date';



          if ($filter['sort_order'] == 'ASC') $filter['sort_order'] = 'DESC';

          else $filter['sort_order'] = 'ASC';



          $this->filter_session->figure = $filter;

          $this->_helper->redirector('index');

        } else if ($post['action'] == 'sort-viewer') {

          $filter = $post['filter'];

          $filter['sort'] = 'viewer';



          if ($filter['sort_order'] == 'ASC') $filter['sort_order'] = 'DESC';

          else $filter['sort_order'] = 'ASC';



          $this->filter_session->figure = $filter;

          $this->_helper->redirector('index');

        } else if ($post['action'] == 'reset') {

          $this->filter_session->unsetAll();

        }

      }

    }





    $data = $this->figure->findAll($this->filter_session->figure);

    $statusesCount = $this->figure->findStatusesCount();



    if (!$this->_userInfo->canApprove) {

      $data = $this->figure->findAll($this->filter_session->figure, $this->_userInfo->id);

      $statusesCount = $this->figure

              ->findStatusesCount($this->_userInfo->id);

    }

    $figures = Zend_Paginator::factory($data);

    $figures->setCurrentPageNumber($pageNumber);



    $figures->setItemCountPerPage(5);

    if (null != $this->filter_session->figure['row']) $figures->setItemCountPerPage($this->filter_session->figure['row']);





    $this->view->statusesCount = $statusesCount;

    $this->view->userInfo = $this->_userInfo;

    $this->view->filter = $this->filter_session->figure;

    $this->view->messages = $this->_flashMessenger->getMessages();

    $this->view->figures = $figures;

  }



  public function createAction()

  {

    $this->form->submit->setLabel('Simpan Untuk Pratinjau');

    if ($this->_userInfo->canApprove) $this->form->submit->setLabel('Terbitkan');

    $this->form->draft->setLabel('Simpan Sebagai Draft');



    if ($this->getRequest()->isPost()) {

      $post = $this->getRequest()->getPost();

      $formData = $post['figure'];



      if ($this->form->isValid($formData)) {



        $status = self::STATUS_DRAFT;

        if (isset($formData['submit'])) {

          if ($this->_userInfo->canApprove) $status = self::STATUS_PUBLISH;

          else $status = self::STATUS_PENDING;

        }



        $data = array(

            'name'       => $this->form->getValue('name'),

            'created_by' => $this->_userInfo->id,

            'created_at' => Date('Y-m-d H:i:s'),

            'status'     => $status

        );

        if ($this->form->image->isUploaded()) {

          $filename = pathinfo($this->form->image->getFileName());

          $this->form->image->addFilter('Rename', UPLOAD_FOLDER

                  . 'figure/'

                  . $filename['filename'] . '_'

                  . time() . '.'

                  . $filename['extension']);

          if ($this->form->image->receive()) {

            $data['image'] = $this->form->getValue('image');

          }

        }

        $figure_id = $this->figure->insert($data);



        $data = array(

            'figure_id'   => $figure_id,

            'language_id' => 1,

            'description' => $this->form->getValue('description')

        );

        $this->figure_description->insert($data);



        $this->loggingaction('Figure', 'Create', $figure_id, self::LANGUAGE_ID);

        $this->_flashMessenger->addMessage('Figur Berhasil Ditambahkan.');

        $this->_redirector->direct('index');

      }

    }

    $this->view->form = $this->form;

  }



  public function updateAction()

  {

    $this->form->draft->setLabel('Simpan Sebagai Draft');

    $this->form->submit->setLabel('Simpan Untuk Pratinjau');

    if ($this->_userInfo->canApprove) $this->form->submit->setLabel('Simpan dan Terbitkan');



    $id = $this->_getParam('id');

    if (null != $id) {

      $figure = $this->figure->findWithDescription($id, 1);

      if (null != $figure) {

        $this->form->populate($figure->toArray());

      } else {

        $this->_redirector->direct('index');

      }

    } else {

      $this->_redirector->direct('index');

    }



    if ($this->getRequest()->isPost()) {

      $post = $this->getRequest()->getPost();

      $formData = $post['figure'];

      if ($this->form->isValid($formData)) {



        $status = self::STATUS_DRAFT;

        if (isset($formData['submit'])) {

          if ($this->_userInfo->canApprove) $status = self::STATUS_PUBLISH;

          else $status = self::STATUS_PENDING;

        }



        $data = array(

            'name'       => $this->form->getValue('name'),

            'updated_by' => $this->_userInfo->id,

            'updated_at' => Date('Y-m-d H:i:s'),

            'status'     => $status

        );



        if ($this->form->image->isUploaded()) {

          $filename = pathinfo($this->form->image->getFileName());

          $this->form->image->addFilter('Rename', UPLOAD_FOLDER

                  . 'figure/'

                  . $filename['filename'] . '_'

                  . time() . '.'

                  . $filename['extension']);

          if ($this->form->image->receive()) {

            $data['image'] = $this->form->getValue('image');

          }

        }

        $this->figure->update($data, array(

            'id = ?' => $id));


        $data = array(

            'description' => $this->form->getValue('description')

        );



        $this->figure_description->update($data, array(

            'figure_id = ?'   => $id,

            'language_id = ?' => 1));



        $this->loggingaction('Figure', 'Update', $id,

                self::LANGUAGE_ID);

        $this->_flashMessenger->addMessage('Figur Berhasil Disunting.');

        $this->_redirector->direct('index');

      }

    }



    if (null != $figure->image) {

      if (file_exists(UPLOAD_FOLDER . 'figure/' . $figure->image)) {

        $this->view->image = $figure->image;

      }

    }



    $this->view->form = $this->form;

  }



  public function deleteAction()

  {

    $id = $this->_getParam('id');

    if (null != $id) {

      $figure = $this->figure->find($id)->current();

      if (null != $figure) {

        if ($figure->status != self::STATUS_ARCHIVED) {

          $figure->setFromArray(array(

              'status' => self::STATUS_ARCHIVED))->save();

          $this->_flashMessenger->addMessage(

                  'Figur Telah Diarsipkan.');

          $this->loggingaction('Figure', 'Archive', $figure->id, self::LANGUAGE_ID);

        } else {

          $figure->delete();

          $this->loggingaction('Figure', 'Delete', $figure->id, self::LANGUAGE_ID);

          $this->_flashMessenger->addMessage(

                  'Figur Berhasil Dihapus.');

        }

      }

    }

    $this->_redirector->direct('index');

  }



  public function translateAction()

  {

    $id = $this->_getParam('id');

    $this->form->image->setAttrib('disabled', true);

    $this->form->name->setRequired(false)

            ->setAttrib('disabled', true);

    $this->form->draft->setAttrib('disabled', true);

    $this->form->submit->setLabel('Save');



    if (null != $id) {

      // check if there is translation exists

      $figure = $this->figure->findWithDescription($id, self::LANGUAGE_EN);

      if (null != $figure) {

        // direct to index if translation exists

        $this->_helper->flashMessenger->addMessage(

                'Oppps..Sory, translation for this 

                  figure is already exists.');

        $this->_redirector->direct('index');

      } else {

        $figure = $this->figure->find($id)->current();

        $this->form->populate($figure->toArray());

      }

    } else {

      $this->_helper->redirector('index');

    }



    if ($this->getRequest()->isPost()) {

      $post = $this->getRequest()->getPost();

      $description = $post['figure']['description'];

      if ($this->form->description->isValid($description)) {

        $data = array(

            'figure_id'   => $figure->id,

            'language_id' => self::LANGUAGE_EN,

            'description' => $this->form->getValue('description')

        );



        $this->figure_description->insert($data);

        $this->loggingaction('Figure', 'Create', $id, self::LANGUAGE_EN);

        $this->_helper->flashMessenger->addMessage(

                'Figure translation saved successfully.');

        $this->_helper->redirector('index');

      }

    }



    if (null != $figure->image) {

      if (file_exists(UPLOAD_FOLDER . 'figure/' . $figure->image)) {

        $this->view->image = $figure->image;

      }

    }



    $this->view->form = $this->form;

  }



  public function deletetranslationAction()

  {

    $this->_helper->viewRenderer->setNoRender();

    $id = $this->_getParam('id');

    // Redirect to index if there's no id.

    if (null == $id) $this->_helper->redirector('index');

    $figure = $this->figure->findWithDescription($id, self::LANGUAGE_EN);

    // Redirect to index if the figure hasn't translated

    if (null == $figure) $this->_helper->redirector('index');



    $this->figure_description->delete(array(

        'figure_id = ?'   => $id,

        'language_id = ?' => self::LANGUAGE_EN));



    $this->loggingaction('Figure', 'Delete', $id, self::LANGUAGE_EN);

    $this->_helper->flashMessenger->addMessage(

            'Translasi Figur Berhasil Dihapus.');

    $this->_helper->redirector('index');

  }



  public function updatetranslationAction()

  {

    $id = $this->_getParam('id');

    $this->form->draft->setAttrib('disabled', true);

    $this->form->name->setAttrib('disabled', true)

            ->setRequired(false);

    $this->form->image->setAttrib('disabled', true);

    $this->form->submit->setLabel('Save');



    // redirect them if there's no id specified

    if (null == $id) $this->_helper->redirector('index');



    // redirect to index if the figure doesn't have translation yet

    // otherwise display the form

    $figure = $this->figure->findWithDescription($id, self::LANGUAGE_EN);

    if (null == $figure) $this->_helper->redirector('index');

    else {

      $this->form->populate($figure->toArray());

    }



    // Handle post request

    if ($this->getRequest()->isPost()) {

      $post = $this->getRequest()->getPost();

      $description = $post['figure']['description'];

      if ($this->form->description->isValid($description)) {

        $data = array(

            'description' => $description);

        $this->figure_description->update($data, array(

            'figure_id = ?'   => $id,

            'language_id = ?' => self::LANGUAGE_EN));



        $this->loggingaction('Figure', 'Update', $id, self::LANGUAGE_EN);

        $this->_helper->flashMessenger(

                'Translasi Figur Berhasil Disunting.');

        $this->_helper->redirector('index');

      }

    }



    // display figure image if available

    if (null != $figure->image

            && file_exists(UPLOAD_FOLDER . 'figure/' . $figure->image)) {

      $this->view->image = $figure->image;

    }

    $this->view->form = $this->form;

  }



  public function restoreAction()

  {

    $id = $this->_getParam('id');



    // We don't want to render view

    $this->_helper->viewRenderer->setNoRender();



    // Redirect if there's no id specified

    if (null == $id) $this->_helper->redirector('index');



    // Retrieve figure's data from database

    $figure = $this->figure->find($id)->current();



    // Redirect if the figure doesn't exists

    if (null == $figure) $this->_helper->redirector('index');



    // Redirect if the existing figure's status isn't archived

    if (self::STATUS_ARCHIVED != $figure->status) $this->_helper->redirector('index');



    // Change figure's status to draft

    $figure->setFromArray(array(

        'status' => self::STATUS_DRAFT))->save();



    $this->loggingaction('Figure', 'Restore', $id, self::LANGUAGE_ID);



    $this->_helper->flashMessenger->addMessage('Figur Berhasil Dimuat Ulang.');



    $this->_helper->redirector('index');

  }



  public function approveAction()

  {

    $id = $this->_getParam('id');

    // Redirect if there's no id specified

    if (null == $id) $this->_helper->redirector('index');



    $figure = $this->figure->find($id)->current();



    // Redirect if the figure doesn't exists

    if (null == $figure) $this->_helper->redirector('index');



    // Redirect if the figure is already approved

    if (self::STATUS_PENDING != $figure->status) $this->_helper->redirector('index');



    // Redirect if the user can't approve

    if (!$this->_userInfo->canApprove) $this->_helper->redirector('index');



    // Publish the pending figure

    $figure->setFromArray(array(

        'status'      => self::STATUS_PUBLISH,

        'approved_by' => $this->_userInfo->id,

        'approved_at' => Date('Y-m-d H:i:s')

    ))->save();



    $this->loggingaction('Figure', 'Approve', $id, self::LANGUAGE_ID);



    $this->_helper->flashMessenger->addMessage(

            'Figur Berhasil Disetujui.');

    $this->_helper->redirector('index');

  }



}