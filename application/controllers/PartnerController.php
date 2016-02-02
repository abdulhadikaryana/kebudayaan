<?php
/**
 * NewsController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * news
 *
 * @package Front Controller
 */
class PartnerController extends Budpar_Controller_Common
{
    /**
     * IS: -
     * FS: -
     * Desc: Fungsi inisialisasi
     */
    public function init()
    {
        parent::init();
        
        $this->view->bigPageTitle = $this->view->translate('id_menu_partner');
        $this->view->bgClass = 'red';
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: news, menuTitle, pageTitle
     * Desc: Fungsi untuk menampilkan daftar news
     */
    public function indexAction()
    {
			$this->view->langId = $this->_languageId;
        $this->_helper->layout->setLayout('kebudayaan');
//        Model
        $partnerDb = new Model_DbTable_Partner;
        
//        Data
        $partner = $partnerDb->getAllWithDesc($this->_languageId);
        
        $this->view->headTitle()->prepend($this->view->translate('Partner'));
        
//        View
        $this->view->partner = parent::setPaginator($partner);
        $this->view->menuTitle = $this->view->translate('id_menu_partner');
        $this->view->pageTitle = $this->view->translate('id_page_partner');
    }

    /**
     * IS: Parameter id, title terdeklarasi
     * FS: Mengirimkan ke viewer: news, comments, commentForm
     * Desc: Fungsi untuk menampilkan detail news
     */
    public function detailAction()
    {
         $this->_helper->layout->setLayout('kebudayaan');
        $id = $this->_getParam('id');
        
        // Model
        $partnerDb = new Model_DbTable_Partner;
        $partner = $partnerDb->getAllWithDescById($id, $this->_languageId);
        
        
        $this->view->partner = $partner;
//       
    }



    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: pageTitle
     * Desc: Fungsi untuk generate breadcrumb
     */
    protected function _generateBreadcrumb()
    {
        // id_menu_news = 'News'
        $listTitle = $this->view->translate('id_menu_partner');

        if($this->_hasParam('id'))
        {            
            $id = $this->_getParam('id');            
            $partnerDb = new Model_DbTable_Partner;            
            $partner = $partnerDb->getAllWithDescById($id, $this->_languageId);
//            echo "<pre>";
//            print_r($partner);
            $detailTitle = $partner['name'];
        }
        $texthomelink = $this->view->translate('id_menu_home');
        $links = null;
        switch ($this->_request->getActionName())
        {
            case 'detail':
                $links = array(
                        $texthomelink => $this->view->baseUrl('/'),
                        $listTitle => $this->view->baseUrl('partner'),
                        $detailTitle => '',
                );
                $this->view->pageTitle = $detailTitle;
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
