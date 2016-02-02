<?php
/**
 * MaterialController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * material untuk promosi
 *
 * @package Front Controller
 */
class MaterialController extends Budpar_Controller_Common
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
     * FS: Mengirimkan ke viewer: material, customName
     * Desc: Fungsi untuk menampilkan daftar promotional materials
     */
    public function indexAction()
    {
        $materialDb = new Model_DbTable_Material;
        $material = $materialDb->getAllWithDesc($this->_languageId);

        $this->view->material = parent::setPaginator($material);
        // id_page_material = 'material(s)'
        $this->view->customName = $this->view->translate('id_page_material');
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: material, materialLink
     * Desc: Fungsi untuk menampilkan detail promotional materials
     */
    public function detailAction()
    {
        // Param
        $id = $this->_getParam('id');

        // Model
        $materialDb = new Model_DbTable_Material;
        $materialLinkDb = new Model_DbTable_MaterialLink;
        
        // Data
        $material = $materialDb->getAllWithDescById($id, $this->_languageId);
        $materialLink = $materialLinkDb->getAllById($id);

        // View
        $this->view->material = $material;
        $this->view->materialLink = $materialLink;
    }

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: pageTitle
     * Desc: Fungsi untuk generate breadcrumb
     */
    protected function _generateBreadcrumb()
    {
        // id_menu_material = 'Promotion Materials'
        $listTitle = $this->view->translate('id_menu_material');

        if($this->_hasParam('id')) {
            // Param
            $materialId = $this->_getParam('id');

            // Model
            $materialDescDb = new Model_DbTable_MaterialDescription;

            // Data
            $materialTitle =
                $materialDescDb->getTitleById($materialId, $this->_languageId);
        }
        $texthomelink = $this->view->translate('id_menu_home');
        $links = null;
        switch ($this->_request->getActionName()) {
            case 'view':
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $listTitle => $this->view->baseUrl('material'),
                    $materialTitle => '',
                );
                $this->view->pageTitle = $materialTitle;
                break;
            case 'detail':
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $listTitle => $this->view->baseUrl('material'),
                    $materialTitle => '',
                );
                $this->view->pageTitle = $materialTitle;
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
}