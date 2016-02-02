<?php
/**
 * RoleController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - role
 */
require_once 'Zend/Controller/Action.php';

class Admin_RoleController extends Library_Controller_Backend
{
    /**
     * IS: -
     * FS: -
     * Desc: Inisiasi fungsi parent
     */
    protected $filter;
    protected $role;
    

    public function init()
    {
        $this->filter = new Zend_Session_Namespace('filter');
        $this->role = new Model_DbTable_AdminRole();
        parent::init();        
    }
    
    /**
     * IS: Terdeklarasinya page_row 
     * FS: Mengirimkan ke viewer: cleanUrl, message, page_row, dan paginator
     * Desc: Mengatur aksi yang dilakukan untuk halaman index role
     */
    public function indexAction()
    {
        /** Send this page url to the view */
        $this->view->cleanurl = $this->_cleanUrl;

        /** Get messages from CRUD process */
        $message = $this->_flash->getMessages();
        if (!empty($message)) {
            $this->view->message = $message;
        }
        
        /** Create table instance */
        $select     = $this->role->getQueryAll();
        $pageNumber = $this->_getParam('page');
        
        /** Get page row setting and send to the paginator control */
        if ($this->getRequest()->isPost()) {
        $post = $this->getRequest()->getPost();
        switch ($post['action']) {
        case 'filter':
          $this->filter->role          = $post['filter'];
          break;
        case 'sort':
          $this->filter->role          = $post['filter'];
          if ($this->filter->role['order'] == 'ASC')
            $this->filter->role['order'] = 'DESC';
          else
            $this->filter->role['order'] = 'ASC';
          break;
        case 'reset':
          $this->filter->unsetAll();
          break;
        default:
          break;
            }
        }
        
        
        $page_row = $this->_getParam('filterPageRow');
        $role = Zend_Paginator::factory($select);
        $role->setCurrentPageNumber($pageNumber);
        $role->setItemCountPerPage(5);
        if(null != $this->filter->role['row'])
            $role->setItemCountPerPage($this->filter->role['row']);
        $this->view->row = $page_row;
        
		if ($page_row != null) {
    		$paginator = parent::setPaginator($select, $page_row);
        } else {
    		$paginator = parent::setPaginator($select);
        }
        
        /** Send data to the view */
		$this->view->paginator = $paginator;
                $this->view->role = $role;
    }
    
    /**
     * IS: -
     * FS: Mengirimkan ke viewer: treeData
     * Desc: Mengatur aksi yang dilakukan untuk halaman create
     */
    public function createAction()
    {
        /** creating instances and get data from the database */
        $table_adminModule_Category = new Model_DbTable_AdminModuleCategory;
        $table_adminModule          = new Model_DbTable_AdminModule;
        $table_adminRole            = new Model_DbTable_AdminRole;
        $data = null;
        
        /** if this is a post request */
        if ($this->getRequest()->isPost()) {
            $data = array(
                'role_name' => htmlspecialchars($_POST['roleName'], ENT_QUOTES),
                'allowed_module' => $_POST['allowedModule']
            );
            $role_id = $table_adminRole->insertRole($data);
            $this->loggingaction('role', 'create', $role_id);
            if (!empty($role_id)) {
                $this->_flash->addMessage('1\Role Insert Success!');              
            } else {
                $this->_flash->addMessage('2\Role Insert Failed!');              
            }
            $this->_redirect($this->view->rootUrl('/admin/role/'));
        }

        /** set view variables */
        $this->view->treeData = 
            $this->generateTree($table_adminModule, $table_adminModule_Category);
    }
    
    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: name, checked, treeData
     * Desc: Mengatur aksi yang dilakukan untuk halaman edit
     */
    public function editAction()
    {
        /** creating instances and get data from the database */
        
        $role_id = $this->_getParam('id');
        $table_adminModule_Category = new Model_DbTable_AdminModuleCategory;
        $table_adminModule          = new Model_DbTable_AdminModule;
        $table_adminRole            = new Model_DbTable_AdminRole;
        
        /** if this is a post request */
        if ($this->getRequest()->isPost()) {
           
            $data = array(
                'role_name' => htmlspecialchars($_POST['roleName'], ENT_QUOTES),
                'allowed_module' => $_POST['allowedModule'],
            );
            $table_adminRole->updateRole($data, $role_id);
            $this->loggingaction('role', 'edit', $role_id);
            $this->_flash->addMessage('1\Role Update Success!');
            $this->_redirect($this->view->rootUrl('/admin/role/'));
            
            
        }

        /** set view variables */
        $data = $table_adminRole->getRoleById($role_id);
        $this->view->name     = $data['role_name'];
        $this->view->checked  = explode(',', $data['allowed_module']);
        $this->view->treeData = 
            $this->generateTree($table_adminModule, $table_adminModule_Category);
    }
    
    /**
     * IS: -
     * FS: -
     * Desc: Mengembalikan 'isi' tree role admin yang dapat dipilih
     */
    protected function generateTree(Model_DbTable_AdminModule $table_adminModule, Model_DbTable_AdminModuleCategory $table_adminModule_Category)
    {
        $exception = "contact";
        $treeCategory = $table_adminModule_Category->getAllModuleCategory();
        $treeModule   = $table_adminModule->getAllModule($exception);
        $data         = array();
        
        /** if category data is not empty */
        if (!empty($treeCategory)) {
            /** refining data and form a tree in array */
            $treeDataList = array();
            /** convert the tree module to ASSOC array */
            foreach ($treeCategory as $value) {
                $treeDataList[$value['category_id']]['name'] = $value['category_name'];
            }
            
            $temp = array();
            if (!empty($treeModule)) {
                foreach ($treeModule as $value) {
                   $treeDataList[$value['category_id']]['modules'][$value['module_id']] = $value->toArray();
                }
            }
        }
        return $treeDataList;
    }
    
    public function deleteAction()
    {
      $this->_helper->viewRenderer->setNoRender();
      $id = $this->_getParam('id');
      if (null !== $id) {
        $role = $this->role->find($id)->current();
        if (null != $role) {
          $role->delete();
          $this->loggingaction('Role', 'Delete', null, null);
          $this->_helper->flashMessenger->addMessage
                  ('Role berhasil dihapus');
        }
      }

      $this->_helper->redirector('index');
    }
}