<?php

/**

 * IndexController

 *

 * Controller untuk melakukan fungsi2 yang berkaitan dengan

 * admin - index

 */

require_once 'Zend/Controller/Action.php';



class Admin_IndexController

        extends Library_Controller_Backend

{

  /**

   * The default action - show the home page

   */

  private $adminDb;



  /**

   * IS: -

   * FS: -

   * Desc: Inisiasi fungsi parent

   */

  public function init()

  {

    parent::init();

    $this->adminDb = new Model_DbTable_Admin;

  }



  public function indexAction()

  {

//      params

      $limit = 3;

      

//      model

      $destinationDb = new Model_DbTable_Destination;

      $newsDb = new Model_DbTable_News;

      $eventDb = new Model_DbTable_Event;

      

//      data

      $latestculture = $destinationDb->getLatestPost($limit);

      $latestdraft = $destinationDb->getLatestDraft($limit);

      $latestnews = $newsDb->getLatestPost($limit);

      $latestnewsdraft = $newsDb->getLatestPost($limit);

      $latestevent = $eventDb->getLatestPost($limit);

      $latesteventdraft = $eventDb->getLatestDraft($limit);

      

      

      $messages = $this->_helper->flashMessenger->getMessages();

      

//      view

      $this->view->latestdraft = $latestdraft;

      $this->view->latestculture = $latestculture;

      $this->view->latestnews = $latestnews;

      $this->view->latestnewsdraft = $latestnewsdraft;

      $this->view->latestevent = $latestevent;

      $this->view->latesteventdraft = $latesteventdraft;

      $this->view->messages = $messages;

  }



    public function categoryAction()

    {

        $this->_helper->layout()->disableLayout();

        $this->_helper->viewRenderer->setNoRender();



        $model = new Admin_Model_DbTable_Category();

        $data = $model->getParentCategory();



        $jsonArray = array();

        $cat = array();

        $tot = array();

        foreach($data as $dat)

        {

            array_push($cat, $dat['name']);

            array_push($tot, array("cat", intval($dat['poi_count']), $dat['category_id']));

        }



        $jsonArray['category'] = $cat;

        $jsonArray['title'] = 'Total Budaya Per Kategori Utama';

        $jsonArray['total'] = $tot;

        $jsonArray['xLabel'] = 'Kategory';

        $jsonArray['yLabel'] = 'Jumlah';



        echo json_encode($jsonArray);

    }



    public function subcategoryAction()

    {

        $this->_helper->layout()->disableLayout();

        $this->_helper->viewRenderer->setNoRender();



        $id = $this->_getParam('id');



        $model = new Admin_Model_DbTable_Category();

        $data = $model->getSubCategory($id);



        if($data != null)

        {

            $jsonArray = array();

            $cat = array();

            $tot = array();

            foreach($data as $dat)

            {

                array_push($cat, $dat['name']);

                array_push($tot, array("", intval($dat['poi_count']), $dat['category_id']));

            }



            $jsonArray['category'] = $cat;

            $jsonArray['title'] = 'Total Budaya Per Sub Kategori Utama';

            $jsonArray['total'] = $tot;

            $jsonArray['xLabel'] = 'Kategory';

            $jsonArray['yLabel'] = 'Jumlah';



            echo json_encode($jsonArray);

        }

        else

        {

            echo json_encode(null);

        }

    }



    public function areaAction()

    {

        $this->_helper->layout()->disableLayout();

        $this->_helper->viewRenderer->setNoRender();



        $model = new Admin_Model_DbTable_Area();

        $data = $model->getParentArea();



        $jsonArray = array();

        $cat = array();

        $tot = array();

        foreach($data as $dat)

        {

            array_push($cat, $dat['name']);

            array_push($tot, array("area", intval($dat['count_category']), $dat['area_id']));

        }



        $jsonArray['category'] = $cat;

        $jsonArray['title'] = 'Total Budaya Per Area Utama';

        $jsonArray['total'] = $tot;

        $jsonArray['xLabel'] = 'Kategory';

        $jsonArray['yLabel'] = 'Jumlah';



        echo json_encode($jsonArray);

    }



    public function subareaAction()

    {

        $this->_helper->layout()->disableLayout();

        $this->_helper->viewRenderer->setNoRender();



        $id = $this->_getParam('id');



        $model = new Admin_Model_DbTable_Area();

        $data = $model->getSubArea($id);



        if($data != null)

        {

            $jsonArray = array();

            $cat = array();

            $tot = array();

            foreach($data as $dat)

            {

                array_push($cat, $dat['name']);

                array_push($tot, array("pie", intval($dat['count_category']), $dat['area_id']));

            }



            $jsonArray['category'] = $cat;

            $jsonArray['title'] = 'Total Budaya Per Sub Area Utama';

            $jsonArray['total'] = $tot;

            $jsonArray['xLabel'] = 'Kategory';

            $jsonArray['yLabel'] = 'Jumlah';



            echo json_encode($jsonArray);

        }

        else

        {

            echo json_encode(null);

        }

    }



    public function pieAction()

    {

        $this->_helper->layout()->disableLayout();

        $this->_helper->viewRenderer->setNoRender();



        $id = $this->_getParam('id');



        $model = new Admin_Model_DbTable_Area();

        $data = $model->getAreaForPie($id);

        $name = $model->getAreaName($id);



        if($data != null)

        {

            $sum = 0;

            foreach($data as $d)

            {

                $sum = $sum + intval($d['count_category']);

            }



            $jsonArray = array();

            $cat = array();

            $tot = array();

            foreach($data as $dat)

            {

//                array_push($cat, $dat['name']);

                $persen = (intval($dat['count_category']) * $sum) / 100;

                array_push($tot, array($dat['name'], $persen));

            }



//            $jsonArray['category'] = $cat;

            $jsonArray['title'] = 'Kebudayaan di provinsi ' . $name['name'];

            $jsonArray['total'] = $tot;

//            $jsonArray['xLabel'] = 'Kategory';

//            $jsonArray['yLabel'] = 'Jumlah';



            echo json_encode($jsonArray);

        }

        else

        {

            echo json_encode(null);

        }

    }



  public function loginAction()

  {

    $auth = Zend_Auth::getInstance();



    $this->_layout->setLayout('admin_login');



    $this->view->message = $this->_flashMessenger->getMessages();

    $form                = new Admin_Form_LoginForm;

    $form->setMethod('post')

            ->setAction($this->view->rootUrl('/admin/index/login'));

    $this->view->form    = $form;



    $flashMessenger = $this->_helper->getHelper('FlashMessenger');



    if ($this->getRequest()->isPost()) {

      $username = $this->_getParam('username');

      $password = md5($this->_getParam('password'));



      if ((empty($username)) || (empty($password))) {

        $flashMessenger->addMessage('Field Cannot Empty');

      } else {

        $db          = Zend_Db_Table::getDefaultAdapter();

        $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'admin_account', 'username', 'password');

        $authAdapter->setIdentity($username);

        $authAdapter->setCredential($password);

        $result      = $authAdapter->authenticate();

        if ($result->isValid()) {

          $auth    = Zend_Auth::getInstance();

          $storage = $auth->getStorage();

          $storage->write($authAdapter->getResultRowObject(array('admin_id', 'username', 'email', 'role_id')));

          $identity              = $auth->getIdentity();

          //set auth session expired

          $auth_sess             = new Zend_Session_Namespace($auth->getStorage()->getNamespace());

          $auth_sess->setExpirationSeconds(strtotime('30 day', 0));

          //store user information on session 

          Zend_Session:: namespaceUnset('userInfo');

          $userInfo              = new Zend_Session_Namespace('userInfo');

          $userInfo->id          = $identity->admin_id;

          $userInfo->name        = $identity->username;

          $userInfo->email       = $identity->email;

          $userInfo->role_id     = $identity->role_id;

          //set user allowed module list

          $table_adminAccount    = new Model_DbTable_AdminAccount;

          $module_list           = $table_adminAccount->getUserInformation($identity->admin_id);

          $userInfo->module_list = explode(',',

                                           $module_list['allowed_module']);

          $userInfo->canApprove  = in_array(47, $userInfo->module_list);

          //get module list from the database

          Zend_Session:: namespaceUnset('moduleList');

          $moduleList            = new Zend_Session_Namespace('moduleList');

          $table_module          = new Model_DbTable_AdminModule;

          $module                = $table_module->getAllModuleId();

          $moduleList->module    = $module;

          //redirecting to the dashboard

          $this->_redirect($this->view->rootUrl('/admin/index'));

        } else {

          $flashMessenger->addMessage('Login Failed');

        }

      }

    }

  }



  public function logoutAction()

  {

    $auth = Zend_Auth::getInstance();

    Zend_Session:: namespaceUnset('userInfo');

    Zend_Session:: namespaceUnset('moduleList');

    Zend_Session:: namespaceUnset('paginator');

    Zend_Session::forgetMe();

    $auth->getInstance();

    $auth->clearIdentity();

    $this->_redirect($this->view->rootUrl('/admin/index/login'));

  }



  public function createAction()

  {

    $tableCategory = new Model_DbTable_Category;

    $form          = new Admin_Form_CultureForm();



    if ($this->getRequest()->isPost()) {

      $post    = $this->getRequest()->getPost();

      echo "<pre>" . print_r($post, true) . "</pre>";

      $culture = $post['culture'];

      if (isset($culture['categories'])) {



        $categories = $culture['categories'];

        $form->category->clearMultiOptions();

        foreach ($categories as $id => $name) {

          $form->category->addMultiOption($id, $name);

        }

        $form->category->setValue($culture['category']);

      }

      if (isset($culture['area'])) {

        $area_list = $culture['area'];

        foreach ($area_list as $name => $area_id) {

          $element = new Zend_Form_Element_Hidden($name);

          $element->setValue($area_id);

          $element->setLabel($name);

          $element->setDecorators(array('ViewHelper', 'AreaInputHidden'));

          $form->area->addElement($element);

        }

      }

      if ($form->isValid($post)) {

        

      }

    }

    $this->view->form = $form;

  }


  public function bantuanAction() {
      header('Content-Type: application/pdf');
      header('Content-Disposition: attachment; filename="manual.pdf"');
      readfile(APPLICATION_PATH . DIRECTORY_SEPARATOR . '/sample.pdf');
 
      // disable layout and view
      $this->view->layout()->disableLayout();
      $this->_helper->viewRenderer->setNoRender(true);
  }



}