<?php
/**
 * CategoryController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan acategory
 *
 * @package Front Controller
 */
class CategoryController extends Budpar_Controller_Common
{
    /**
     * IS: -
     * FS: -
     * Desc: Fungsi inisialisasi
     */
    public function init()
    {
        parent::init();
        
        $this->view->bigPageTitle = $this->view->translate('Culture');
        $this->view->bgClass = "yellow";
    }
    
    /**
     * IS: -
     * FS: Mengirimkan ke viewer: activities
     * Desc: Fungsi untuk menampilkan daftar activities
     */
    public function indexAction()
    {
        // Set layout
        $this->_helper->layout->setLayout('one-column');
        
        // Model
        $categoryDb = new Model_DbTable_Category;        

        // Data
        $activities = $categoryDb->getListCategory($this->_languageId);

        // View
        $this->view->activities = $activities;
    }
    
    public function seeCategoryAction() {
        // Set layout
        $this->_helper->layout->setLayout('kebudayaan');
        
        // Param
        $categoryId = $this->_getParam('id');
        
        // Model
        $categoryDb = new Model_DbTable_Category;        
        
        // Data
        $category = $categoryDb->getAllWithDescByIdLang($categoryId, $this->_languageId);
        $subCategories = $categoryDb->getCategoryChildList($categoryId, $this->_languageId);
                
        // View        
        $this->view->category = $category;
        $this->view->subCategories = $subCategories;                
    }        

    /**
     * IS: Parameter id, sortby, dan sortorder terdeklarasi
     * FS: Mengirimkan ke viewer: pageTitle, category, destination, areaDb
     * Desc: Fungsi untuk menampilkan detail activity dan menampilkan destinasi2
     *       yang termasuk activity tersebut
     */
    public function detailAction()
    {
        // Set layout
        $this->_helper->layout->setLayout('kebudayaan');
        // Param
        $id = $this->_getParam('id');
        $sortBy = $this->_getParam('sortby');
        $sortOrder = $this->_getParam('sortorder', 'desc');
        $title = null;
        

        // Model
        $categoryDb = new Model_DbTable_Category;
        $destDescDb = new Model_DbTable_DestinationDescription;
        $areaDb = new Model_DbTable_Area;

        // Data
        $destinationQuery = $destDescDb->getSearch('', '', $id,$this->_languageId,
            array('sort_by' => $sortBy,
                  'sort_order' => $sortOrder));
        
        $category = $categoryDb->getByLangAndId($id, $this->_languageId);

        $this->_generateSorter($sortBy, $sortOrder);

        // View
        $this->view->pageTitle = $category['name'];
        $this->view->category = $category;
        $this->view->count = count($destinationQuery);
        $this->view->destination = $destinationQuery;
        // $this->view->destination = parent::setPaginator($destinationQuery);
        $this->view->areaDb = $areaDb;
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: pageTitle
     * Desc: Fungsi untuk generate breadcrumb
     */
    protected function _generateBreadcrumb()
    {
        
        if($this->_hasParam('id')) {
            // Param
            $categoryId = $this->_getParam('id');
            $parentCategoryTitle = null;
            $parentCategoryId = null;

            // Model
            $catDescDb = new Model_DbTable_CategoryDescription;

            // Data
            $activityTitle = $catDescDb->getNameByLang($categoryId, $this->_languageId);
            $activityTitle = $activityTitle['name'];
        }
        if($this->_hasParam('parentid')) {
            $parentCategoryId = $this->_getParam('parentid');
            
            // Model
            $catDescDb = new Model_DbTable_CategoryDescription;
            
            // Data
            $parentCategoryTitle = $catDescDb->getNameByLang($parentCategoryId, $this->_languageId);
            $parentCategoryTitle = $parentCategoryTitle['name'];
        }
        $texthomelink = $this->view->translate('id_menu_home');
        $links = null;
        switch ($this->_request->getActionName()) {
            case 'index':
            default:
                $title = $this->view->translate('Category');
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $title => '',
                );
                $this->view->pageTitle = $title;
                break;
            case 'detail':
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
//                    $parentCategoryTitle => $this->view->baseUrl('/category/see-category/' . $parentCategoryId),
                    $activityTitle => ''
                );
        }
        Zend_Registry::set('breadcrumb', $links);
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: nameSort, ratingSort, sortBy, sortOrder
     * Desc: Fungsi untuk generate sorter
     */
    private function _generateSorter($sortBy, $sortOrder)
    {
        // Model
        $sorter = new Model_Sorter;

        // Data
        $nameSort = $sorter->getSorter('name', $sortBy, $sortOrder);
        $ratingSort = $sorter->getSorter('rating', $sortBy, $sortOrder);

        // View
        $this->view->nameSort = $nameSort;
        $this->view->ratingSort = $ratingSort;
        $this->view->sortBy = $sortBy;
        $this->view->sortOrder = strtolower($sortOrder);
    }
}
?>