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

        $figures = $this->figure->findAll();
        
        $this->view->figures = $figures;

        $this->view->menuTitle = $this->view->translate('Figure');

        $this->view->pageTitle = $this->view->translate('Figure');
        
        $this->view->count = count($figures);
    }

    public function detailAction() {

        $id = $this->_getParam('id');

        if (null != $id) {

            $figure = $this->figure->findWithDescription($id, $this->_languageId);

            if (null != $figure) {

                $this->view->figure = $figure->toArray();
            }
            else
                $this->_helper->redirector('index');
        }
        else
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