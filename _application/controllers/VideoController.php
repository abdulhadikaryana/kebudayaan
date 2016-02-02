<?php
/**
 * VideoController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan video
 *
 * @package Front Controller
 */
class VideoController extends Budpar_Controller_Common
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
     * IS: Parameter page terdeklarasi
     * FS: Mengirimkan ke viewer: video, itemPerPage, current, totalItems
     * Desc: Fungsi untuk menampilkan daftar video
     */
    public function indexAction()
    {
        // Param
        $page = ($this->_hasParam('page')) ? $this->_getParam('page') : 1;

        // Variable
        $maxResult = 8;
        $startIndex = ($page - 1) * ($maxResult - 1) + 1;

        // Model
        $videoModel = new Model_Video();

        // Data
        $videos = $videoModel->getMostViewedVideos($startIndex, $maxResult);
        $totalFeeds = $videoModel->getTotalFeeds();

        // View
        $this->view->videos = $videos;
        $this->view->itemPerPage = $maxResult;
        $this->view->current = $page;
        $this->view->totalItems = $totalFeeds;

        if($this->_request->isXmlHttpRequest()){
            $this->_helper->layout()->disableLayout();
            $this->render('list');
        }
        
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
        
        switch ($this->_request->getActionName()) {
            case 'index':
            default:
                $title = $this->view->translate('id_menu_video');
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $title => '',
                );
                $this->view->pageTitle = $title;
        }
        Zend_Registry::set('breadcrumb', $links);
    }
}
?>