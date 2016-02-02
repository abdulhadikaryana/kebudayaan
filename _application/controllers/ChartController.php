<?php

/**
 * ChartController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * chart atau grafik
 *
 * @package Front Controller
 */
class ChartController extends Budpar_Controller_Common {

    public function init() {
        parent::init();
    }
    
    public function indexAction() {
        $this->_helper->layout->setLayout('one-column');   
        
        $categoryDb = new Model_DbTable_Category;
        $categories = $categoryDb->getAllParentCategoryIdNameByLangId($this->_languageId);
        
        $this->view->categories = $categories;
    }

    public function categoryAction() {
        // AJAX
        if($this->_request->isXmlHttpRequest()){
            // Disable layout dan view
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            
            $category = new Model_Category;
            $result = $category->getMainCategoriesForChart($this->_languageId);                        
            
            $result['title'] = $this->view->translate('Total Culture per Main Category');
            $result['xLabel'] = $this->view->translate('Category');        
            $result['yLabel'] = $this->view->translate('Total');
            
            echo json_encode($result);
        }
        
    }
    
    public function subCategoryAction() {
        // AJAX
        if($this->_request->isXmlHttpRequest()){
            // Disable layout dan view
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            
            $parentCategoryId = $this->_getParam('parent_category');
            
            $categoryDb = new Model_DbTable_Category;
            $parentCategory = $categoryDb->getAllWithDescByIdLang($parentCategoryId, $this->_languageId);
            
            $category = new Model_Category;
            $result = $category->getSubCategoriesForChart($parentCategoryId, $this->_languageId);                        
                                    
            $result['title'] = $this->view->translate('Total Culture per Sub Category') . ' ' . $parentCategory['name'];
            $result['xLabel'] = $this->view->translate('Category');        
            $result['yLabel'] = $this->view->translate('Total');
            
            echo json_encode($result);
        }
    }            

    protected function _generateBreadcrumb() {

        $texthomelink = $this->view->translate('id_menu_home');
        $links = null;
        switch ($this->_request->getActionName()) {
            case 'index':
            default:
                $title = $this->view->translate('Culture Chart');
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $title => '',
                );
                $this->view->pageTitle = $title;
        }
        Zend_Registry::set('breadcrumb', $links);
    }
}