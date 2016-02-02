<?php
/**
 * PackageController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * paket wisata
 *
 * @package Front Controller
 */
class PackageController extends Budpar_Controller_Common
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
     * IS: -
     * FS: Mengirimkan ke viewer: package, customName
     * Desc: Fungsi untuk menampilkan daftar tour packages
     */
    public function indexAction()
    {
        // Model
        $packageDb = new Model_DbTable_Package;
        $sortBy = $this->_getParam('sortby');
        $sortOrder = $this->_getParam('sortorder', 'asc');
        // Data
        $package = $packageDb->getAllWithDesc(array('sort_by' => $sortBy,
                  'sort_order' => $sortOrder),$this->_languageId);
        $this->_generateSorter($sortBy, $sortOrder);
        
        $this->view->languageID = $this->_languageId;
        // View
        $this->view->package = parent::setPaginator($package);
        // id_page_package = 'package(s)'
        $this->view->customName = $this->view->translate('id_page_package');
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: package
     * Desc: Fungsi untuk menampilkan detail tour packages
     */
    public function detailAction()
    {
        // Param
        $id = $this->_getParam('id');

        // Model
        $packageDb = new Model_DbTable_Package;
        
        // Data
        $package = $packageDb->getAllWithDescById($id, $this->_languageId);

        // View
        $this->view->package = $package;
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: pageTitle
     * Desc: Fungsi untuk generate breadcrumb
     */
    protected function _generateBreadcrumb()
    {
        // id_menu_package = 'Tour Packages'
        $listTitle = $this->view->translate('id_menu_package');

        if($this->_hasParam('id')) {
            // Param
            $packageId = $this->_getParam('id');

            // Model
            $packageDescDb = new Model_DbTable_PackageDescription;

            // Data
            $packageTitle =
                $packageDescDb->getTitleById($packageId, $this->_languageId);
        }
        $texthomelink = $this->view->translate('id_menu_home');
        $links = null;
        switch ($this->_request->getActionName()) {
            case 'view':
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $listTitle => $this->view->baseUrl('package'),
                    $packageTitle => '',
                );
                $this->view->pageTitle = $packageTitle;
                break;
            case 'detail':
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $listTitle => $this->view->baseUrl('package'),
                    $packageTitle => '',
                );
                $this->view->pageTitle = $packageTitle;
                break;
            case 'index':
            default:
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $listTitle => '',
                );
                $this->view->pageTitle = $listTitle;
        }
        Zend_Registry::set('breadcrumb', $links);
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: nameSort, sortBy, sortOrder
     * Desc: Fungsi untuk generate sorter
     */
    private function _generateSorter($sortBy, $sortOrder)
    {
        // Model
        $sorter = new Model_Sorter;

        // Data
        $nameSort = $sorter->getSorter('name', $sortBy, $sortOrder);

        // View
        $this->view->nameSort = $nameSort;
        $this->view->sortBy = $sortBy;
        $this->view->sortOrder = strtolower($sortOrder);
    }
}