<?php
/**
 * MapController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * map/peta Indonesia
 *
 * @package Front Controller
 */
class MapController extends Budpar_Controller_Common
{
    /**
     * IS: -
     * FS: -
     * Desc: Fungsi inisialisasi
     */
    public function init()
    {
        parent::init();
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: pageTitle, mapLocationForm, mapDestForm, poi,
     *     categoriesParent
     * Desc: Fungsi untuk menampilkan peta
     */
    public function indexAction()
    {
        $this->_helper->layout->setLayout('one-column');
        
        // Param
        if($this->_hasParam('id')) {
            $this->view->id = $this->_getParam('id');
            //echo $this->view->id . ' tes';
        }
        // Form
        $mapLocationForm = new Form_MapLocationForm;
        $mapDestForm = new Form_MapDestForm;
        $mapCategoryForm = new Form_MapCategoryForm;

        // Model
        $destDescDb = new Model_DbTable_DestinationDescription;
        $categoryDb = new Model_DbTable_Category;        
        $categoryModel = new Model_Category;

        // Data		
        $categoriesParent = $categoryDb->getAllCategoryIdNameByLangId($this->_languageId);		
        $poiResult = $destDescDb->getAllForMap($this->_languageId);        

        // View
        $this->view->pageTitle = $this->view->translate('Culture Map');
        $this->view->mapLocationForm = $mapLocationForm;
        $this->view->mapDestForm = $mapDestForm;
        $this->view->mapCategoryForm = $mapCategoryForm;
        $this->view->poi = $poiResult;		
        $this->view->categoriesParent = $categoriesParent;        
    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk menampilkan detail map
     */
    public function viewAction()
    {
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: pageTitle
     * Desc: Fungsi untuk generate breadcrumb
     */
    protected function _generateBreadcrumb()
    {
        $texthomelink = $this->view->translate('id_menu_home');
        $links = null;
        switch ($this->_request->getActionName()) {
            case 'index':
            default:
                $title = $this->view->translate('Culture Map');
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $title => '',
                );
                $this->view->pageTitle = $title;
        }
        Zend_Registry::set('breadcrumb', $links);
    }
}