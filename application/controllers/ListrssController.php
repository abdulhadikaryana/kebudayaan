<?php
/**
 * SearchController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * search
 *
 * @package Front Controller
 */
class ListrssController extends Budpar_Controller_Common
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
     * IS: Parameter search terdeklarasi
     * FS: Mengirimkan ke viewer: searchkey, param
     * Desc: Fungsi untuk menampilkan daftar hasil search
     */
    public function indexAction()
    {
        $this->view->langId = $this->_languageId;
    }
    
    /**
     * IS: -
     * FS: Mengirimkan ke viewer: pageTitle
     * Desc: Fungsi untuk generate breadcrumb
     */
    protected function _generateBreadcrumb()
    {
        $listTitle = 'List Rss Page';
        
        $links = null;
        switch ($this->_request->getActionName()) {
            case 'detail':
                $links = array(
                    'Home' => $this->view->baseUrl('/'),
                    $listTitle => $this->view->baseUrl('listrss'),
                    $newsTitle => '',
                );
                $this->view->pageTitle = $newsTitle;
                break;
            case 'index':
            default:
                $links = array(
                    'Home' => $this->view->baseUrl('/'),
                    $listTitle => '',
                );
                $this->view->pageTitle = $listTitle;
        }
        Zend_Registry::set('breadcrumb', $links);
    }
}