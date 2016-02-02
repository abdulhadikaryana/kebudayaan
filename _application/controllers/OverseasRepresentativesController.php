<?php
/**
 * OverseasRepresentativesController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * halaman overseas representatives
 *
 * @package Front Controller
 */
class OverseasRepresentativesController extends Budpar_Controller_Common
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
     * FS: Mengirimkan ke viewer: tourism, customName
     * Desc: Fungsi untuk menampilkan daftar overseas representatives
     */
    public function indexAction()
    {
        // Model
        $tourismOperDb = new Model_DbTable_TourismOperator;

        // Data
        // Tipe 6 = vito / overseas representatives
        $tourismOperQuery = 
            $tourismOperDb->getAllWithDescById('6', $this->_languageId);

        // View
        $this->view->tourism = parent::setPaginator($tourismOperQuery);

        // id_page_overseas = 'representative(s)'
        $this->view->customName = $this->view->translate('id_page_overseas');
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: pageTitle
     * Desc: Fungsi untuk generate breadcrumb
     */
    protected function _generateBreadcrumb()
    {
        $links = null;
        $texthomelink = $this->view->translate('id_menu_home');
        // id_title_overseas = 'Overseas Representatives'
        $title = $this->view->translate('id_title_overseas');
        $links = array(
            $texthomelink => $this->view->baseUrl('/'),
            $title => '',
        );
        $this->view->pageTitle = $title;

        Zend_Registry::set('breadcrumb', $links);
    }
}