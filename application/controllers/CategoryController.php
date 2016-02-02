<?php

/**
 * CategoryController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan acategory
 *
 * @package Front Controller
 */
class CategoryController extends Budpar_Controller_Common {

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi inisialisasi
     */
    public function init() {
        parent::init();

        $this->view->bigPageTitle = $this->view->translate('Culture');
        $this->view->bgClass = "yellow";
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: activities
     * Desc: Fungsi untuk menampilkan daftar activities
     */
    public function indexAction() {
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


        $this->view->headTitle()->prepend($category['name']);
        $this->view->subCategories = $subCategories;
        $this->view->langId = $this->_languageId;

        array_unshift($this->_meta, $category['name'], "kategori kebudayaan", "kategori budaya");
        $this->view->headMeta()->appendName('keywords', join(', ', $this->_meta));
        $this->view->headMeta()->appendName('description', "Kebudayaan Indonesia - Laman referensi kebudayaan Indonesia. Turut mewujudkan bangsa Indonesia yang cerdas dan berbudaya");
    }

    /**
     * IS: Parameter id, sortby, dan sortorder terdeklarasi
     * FS: Mengirimkan ke viewer: pageTitle, category, destination, areaDb
     * Desc: Fungsi untuk menampilkan detail activity dan menampilkan destinasi2
     *       yang termasuk activity tersebut
     */
    public function detailAction() {
        // Set layout
        $this->_helper->layout->setLayout('kebudayaan');
        // Param
        $id = $this->_getParam('id');
        $sortBy = $this->_getParam('sortby');
        $sortOrder = $this->_getParam('sortorder', 'desc');
        $page = $this->_getParam('page');
        $title = null;


        // Model
        $categoryDb = new Model_DbTable_Category;
        $destDescDb = new Model_DbTable_DestinationDescription;
        $areaDb = new Model_DbTable_Area;

        // Data
        $destinationQuery = $destDescDb->getSearch('', '', $id, $this->_languageId, array('sort_by' => $sortBy,
            'sort_order' => $sortOrder));

        $paginator = Zend_Paginator::factory($destinationQuery);
        $paginator->setItemCountPerPage(8);
        $paginator->setCurrentPageNumber($page);

        $category = $categoryDb->getByLangAndId($id, $this->_languageId);

        $this->view->headTitle()->prepend($category['name']);

        $this->view->category = $category;
        $this->view->paginator = $paginator;
        $this->view->culture_chunk = array_chunk(iterator_to_array($paginator), 2);
        $this->view->languageId = $this->_languageId;
        $this->view->languageID = $this->_languageId;
        $this->view->langId = $this->_languageId;

        $this->view->getImg = function($file) {
            return UPLOAD_FOLDER . $FILE;
        };

        array_unshift($this->_meta, $category['name'], "kategori kebudayaan", "kategori budaya");
        $this->view->headMeta()->appendName('keywords', join(', ', $this->_meta));
        $this->view->headMeta()->appendName('description', "Kebudayaan Indonesia - Laman referensi kebudayaan Indonesia. Turut mewujudkan bangsa Indonesia yang cerdas dan berbudaya");
        $this->view->headLink()->headLink(array(
            'rel' => 'canonical',
            'href' => Zend_Controller_Front::getInstance()->getRequest()->getScheme() . '://' . Zend_Controller_Front::getInstance()->getRequest()->getHttpHost() . $this->view->url(array(
                'id' => $category['category_id'],
                'slug' => $this->view->makeUrlFormat($category['name'])
                    ), $this->_languageId == 1 ? 'subkategori' : 'subcategory', true)
                ), 'PREPEND');
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: pageTitle
     * Desc: Fungsi untuk generate breadcrumb
     */
    protected function _generateBreadcrumb() {

        if ($this->_hasParam('id')) {
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
        if ($this->_hasParam('parentid')) {
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

}

?>
