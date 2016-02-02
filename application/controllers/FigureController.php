<?php

class FigureController extends Budpar_Controller_Common {

    /**

     *

     * @var Model_DbTable_Figure

     */
    protected $figure;

    public function init() {

        $this->figure = new Model_DbTable_Figure();

        parent::init();



        $this->view->bigPageTitle = $this->view->translate('Figure');

        $this->view->bgClass = "orange";
    }

    public function indexAction() {

        $this->_helper->layout->setLayout('kebudayaan');

        $pageNumber = $this->_getParam('page');

        $figures = $this->figure->findAll($this->_languageId);

        $pageNumber = $this->_getParam('page');

        $paginator = Zend_Paginator::factory($figures);

        $paginator->setItemCountPerPage(8);

        $paginator->setCurrentPageNumber($pageNumber);

        $this->view->pageTitle = $this->view->translate('Figure');
        $this->view->paginator = $paginator;
        $this->view->figure_chunk = array_chunk(iterator_to_array($paginator), 2);
        $this->view->langId = $this->_languageId;

        array_unshift($this->_meta, "sosok kebudayaan");
        $this->view->headMeta()->appendName('keywords', join(', ', $this->_meta));
        $this->view->headMeta()->appendName('description', "Kebudayaan Indonesia - Laman referensi kebudayaan Indonesia. Turut mewujudkan bangsa Indonesia yang cerdas dan berbudaya");
        $this->view->headLink()->headLink(array(
            'rel' => 'canonical',
            'href' => Zend_Controller_Front::getInstance()->getRequest()->getScheme() . '://' . Zend_Controller_Front::getInstance()->getRequest()->getHttpHost() . $this->view->url(array(), $this->_languageId == 1 ? 'sosok' : 'figure', true)
                ), 'PREPEND');
        //untuk menghitung view
        $this->view->pageViewer = $this->countView();
    }

    protected function countView() {
        $db = new Model_DbTable_Destination();

        $data = $db->pageViewer($this->_destId);
        return $data;
    }

    public function detailAction() {

        $this->_helper->layout->setLayout('kebudayaan');
        $this->view->langId = $this->_languageId;

        $id = $this->_getParam('id');

        if (null != $id) {

            $figure = $this->figure->findWithDescription($id, $this->_languageId);

            if (null != $figure) {

                $this->view->figure = $figure->toArray();

                array_unshift($this->_meta, $figure['name'], "sosok kebudayaan");
                $this->view->headMeta()->appendName('keywords', join(', ', $this->_meta));
                $this->view->headMeta()->appendName('description', "Kebudayaan Indonesia - Laman referensi kebudayaan Indonesia. Turut mewujudkan bangsa Indonesia yang cerdas dan berbudaya");
            } else
                $this->_helper->redirector('index');
        } else
            $this->_helper->redirector('index');
    }

    /**

     * IS: Parameter id terdeklarasi

     * FS: Mengirimkan ke viewer: pageTitle

     * Desc: Fungsi untuk generate breadcrumb

     */
    protected function _generateBreadcrumb() {

        // id_menu_news = 'News'

        $listTitle = $this->view->translate('Figure');



        if ($this->_hasParam('id')) {

            // Param

            $id = $this->_getParam('id');



            // Model

            $db = new Model_DbTable_Figure;



            // Data

            $figure = $db->findWithDescription($id, $this->_languageId);

            $title = $figure['name'];
        }

        $texthomelink = $this->view->translate('id_menu_home');

        $links = null;

        switch ($this->_request->getActionName()) {

            case 'detail':

                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $listTitle => $this->view->baseUrl('figure'),
                    $title => '',
                );

                $this->view->pageTitle = $title;

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
