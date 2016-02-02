<?php
/**
 * TourismOperatorController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * tourism operator dan travel directory
 *
 * @package Front Controller
 */
class TourismOperatorController extends Budpar_Controller_Destination
{
    /**
     * IS: -
     * FS: -
     * Desc: Fungsi inisialisasi
     */
    public function init()
    {
        parent::init();

        // View
        switch($this->_languageId)
        {
            case 1: $langLocale = 'en'; break;
            case 2: $langLocale = 'id'; break;
        }
        $this->view->languageID = $langLocale;

    }


    /**
     * IS: Parameter tourismId terdeklarasi
     * FS: Mengirimkan ke viewer: directory, pageTitle
     * Desc: Fungsi untuk menampilkan detail tourism operator
     */
    public function detailsingleAction()
    {

        //$this->_helper->viewRenderer->setNoRender(true); /* supaya tidak render view */
        $this->_helper->layout->setLayout('two-column');
        // Param
        $tourismId = $this->_getParam('tourismId');

        //echo $tourismId;
        $detail = new Model_DbTable_TourismOperator();
        $tourismDetail = $detail->getAllTourismDataByIdLang($tourismId,$this->_languageId);
        
        // Breadcrumb
        $this->_generateBreadcrumbdetails('tourismoperator');
        
        $this->view->tourismDetail = $tourismDetail;
    }


    /**
     * IS: Parameter tourismId terdeklarasi
     * FS: Mengirimkan ke viewer: directory, pageTitle
     * Desc: Fungsi untuk menampilkan detail tourism operator
     */
    public function detailAction()
    {

	$this->_helper->layout->setLayout('one-column');

        //$this->_helper->layout->disableLayout(); /* disable layout */
        //$this->_helper->viewRenderer->setNoRender(true); /* supaya tidak render view */
        
        //redirector url
        $getUrl = explode("/",$this->view->currentUrl());
        $newUrl = array_splice($getUrl,0,10);
        $url = implode("/",$newUrl);

        // Param
        $tourismId = $this->_getParam('tourismId');
        
        // Model
        $tourismOperatorDb = new Model_DbTable_TourismOperator;
        //echo $tourismId;
        // Data
        $directory = $tourismOperatorDb->getAllTourismDataByIdLang($tourismId,$this->_languageId);
        
        //print_r($directory);
        
        //if($directory['description'])
        //{
            // Breadcrumb
            $this->_generateDetailBreadcrumb($directory);
            
            // View
            $this->view->pageTitle = $this->_destTitle . ' - ' .$directory['langname'];
            $this->view->directory = $directory;            
        //}
        //else
        //{
        //    $this->_redirector->gotoUrl($url);
        //}
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: pageTitle
     * Desc: Fungsi untuk generate breadcrumb
     */
    protected function _generateBreadcrumbdetails($param)
    {
        $listTitle = $param;
        $texthomelink = $this->view->translate('id_menu_home');
        $links = array(
            $texthomelink => $this->view->baseUrl('/'),
            $listTitle => $this->view->baseUrl('detail'),
            //$newsTitle => '',
        );

        Zend_Registry::set('breadcrumb', $links);
    }

    /**
     * IS: Parameter sortby, sortorder, searchname, dan coverage terdeklarasi
     * FS: Mengirimkan ke viewer: pageTitle, sectionTitle, sectionContent, 
     *     searchName 
     * Desc: Fungsi untuk menampilkan list travel agent di destinasi
     */
    public function findtravelAction()
    {
	    $this->_helper->layout->setLayout('one-column');

        // Param
        $sortBy = $this->_getParam('sortby');
        $sortOrder = $this->_getParam('sortorder', 'asc');
        $searchName = $this->_getParam('searchname', '');
        $coverage = $this->_getParam('coverage', '');

        // Model
        $tourismOperatorDb = new Model_DbTable_TourismOperator;


        // untuk mengenerate koordinate google map
        $destinationDb = new Model_DbTable_Destination;
        $destination = $destinationDb->getAllByIdLang($this->_destId, $this->_languageId);
        $this->view->pointX = $destination['pointX'];
        $this->view->pointY = $destination['pointY'];


        // Data
        if( ! empty($coverage)) {
            $travel = $tourismOperatorDb->getTravelAgentById($this->_destId,3, $this->_languageId, array('sort_by' => $sortBy,'sort_order' => $sortOrder, 'search_name' => $searchName));
            $this->view->coverage = true;
        } else {
            $travel = $tourismOperatorDb->getTourismoperatorById($this->_destId,3, $this->_languageId, array('sort_by' => $sortBy,'sort_order' => $sortOrder, 'search_name' => $searchName));
        }
        $this->_generateSorter($sortBy, $sortOrder);

        if($this->_languageId!=2){
            $textfind = 'Find Travel Agent';
        }else{
            $textfind = 'Cari Agen Perjalanan';
        }
        // Breadcrumb
        $this->_generateFindBreadcrumb($textfind);

        if($this->_languageId!=2){
            $textsectitle = 'TRAVEL AGENT';
        }else{
            $textsectitle = 'AGEN PERJALANAN';
        }

        // Passing ke view
        $this->view->pageTitle = $this->_destTitle . ' - Travel Agent';
        $this->view->sectionTitle = $textsectitle;
        $this->view->viewCoverage = TRUE;
        $this->view->sectionContent = parent::setPaginator($travel);
        $this->view->searchName = $searchName;


        // Render
        $this->render('index');
        
    }

    /**
     * IS: Parameter sortby, sortorder, searchname terdeklarasi
     * FS: Mengirimkan ke viewer: pageTitle, sectionTitle, sectionContent, 
     *     searchName 
     * Desc: Fungsi untuk menampilkan list hotel di destinasi
     */
    public function findhotelAction()
    {

	    $this->_helper->layout->setLayout('one-column');

        // Param
/*        $sortBy = $this->_getParam('sortby');
        $sortOrder = $this->_getParam('sortorder', 'asc');
        $searchName = $this->_getParam('searchname', '');
*/        

        //default sorting by star(desc)
        // Param
        if($this->_getParam('sortby'))
        {
            $sortBy = $this->_getParam('sortby');
            $sortOrder = $this->_getParam('sortorder', 'asc');
            $searchName = $this->_getParam('searchname', '');
        }
        else
        {
            $sortBy = 'star';
            $sortOrder = 'desc';
            $searchName = $this->_getParam('searchname');;
        }

        // Model
        $tourismOperatorDb = new Model_DbTable_TourismOperator;


        // untuk mengenerate koordinate google map
        $destinationDb = new Model_DbTable_Destination;
        $destination = $destinationDb->getAllByIdLang($this->_destId, $this->_languageId);
        $this->view->pointX = $destination['pointX'];
        $this->view->pointY = $destination['pointY'];


        // Data
        $hotel = $tourismOperatorDb->getTourismoperatorById($this->_destId,1, $this->_languageId, array('sort_by' => $sortBy,'sort_order' => $sortOrder, 'search_name' => $searchName));

        $this->_generateSorter($sortBy, $sortOrder);

        if($this->_languageId!=2){
            $textfind = 'Find Hotel';
        }else{
            $textfind = 'Cari Hotel';
        }
        // Breadcrumb
        $this->_generateFindBreadcrumb($textfind);

        // Passing ke view
        $this->view->pageTitle = $this->_destTitle . ' - Hotel';
        $this->view->sectionTitle = 'HOTEL';
        $this->view->sectionContent = parent::setPaginator($hotel);
        $this->view->searchName = $searchName;

        // Render
        $this->render('index');
    }

    /**
     * IS: Parameter sortby, sortorder, searchname terdeklarasi
     * FS: Mengirimkan ke viewer: pageTitle, sectionTitle, sectionContent, 
     *     searchName 
     * Desc: Fungsi untuk menampilkan list restaurant di destinasi
     */
    public function findrestaurantAction()
    {

	    $this->_helper->layout->setLayout('one-column');

        // Param
        $sortBy = $this->_getParam('sortby');
        $sortOrder = $this->_getParam('sortorder', 'asc');
        $searchName = $this->_getParam('searchname', '');
        
        // Model
        $tourismOperatorDb = new Model_DbTable_TourismOperator;

        // untuk mengenerate koordinate google map
        $destinationDb = new Model_DbTable_Destination;
        $destination = $destinationDb->getAllByIdLang($this->_destId, $this->_languageId);
        $this->view->pointX = $destination['pointX'];
        $this->view->pointY = $destination['pointY'];


        // Data
        $restaurant = $tourismOperatorDb->getTourismoperatorById($this->_destId,
            2, $this->_languageId, array('sort_by' => $sortBy,
                  'sort_order' => $sortOrder, 'search_name' => $searchName));

        $this->_generateSorter($sortBy, $sortOrder);

        if($this->_languageId!=2){
            $textfind = 'Find Restaurant';
        }else{
            $textfind = 'Cari Restoran';
        }
        // Breadcrumb
        $this->_generateFindBreadcrumb($textfind);

        if($this->_languageId!=2){
            $textsectitle = 'RESTAURANT';
        }else{
            $textsectitle = 'RESTORAN';
        }

        // Passing ke view
        $this->view->pageTitle = $this->_destTitle . ' - Restaurant';
        $this->view->sectionTitle = $textsectitle;
        $this->view->sectionContent = parent::setPaginator($restaurant);
        $this->view->searchName = $searchName;

        // Render
        $this->render('index');
    }

    /**
     * IS: Parameter sortby, sortorder, searchname terdeklarasi
     * FS: Mengirimkan ke viewer: pageTitle, sectionTitle, sectionContent, 
     *     searchName 
     * Desc: Fungsi untuk menampilkan list souvenir di destinasi
     */
    public function findsouvenirAction()
    {

	    $this->_helper->layout->setLayout('one-column');

        // Param
        $sortBy = $this->_getParam('sortby');
        $sortOrder = $this->_getParam('sortorder', 'asc');
        $searchName = $this->_getParam('searchname', '');

        
        // Model
        $tourismOperatorDb = new Model_DbTable_TourismOperator;

        // untuk mengenerate koordinate google map
        $destinationDb = new Model_DbTable_Destination;
        $destination = $destinationDb->getAllByIdLang($this->_destId, $this->_languageId);
        $this->view->pointX = $destination['pointX'];
        $this->view->pointY = $destination['pointY'];


        // Data
        $souvenir = $tourismOperatorDb->getTourismoperatorById($this->_destId,
            4, $this->_languageId, array('sort_by' => $sortBy,
                  'sort_order' => $sortOrder, 'search_name' => $searchName));

        $this->_generateSorter($sortBy, $sortOrder);

        if($this->_languageId!=2){
            $textfind = 'Find Souvenir';
        }else{
            $textfind = 'Cari Suvenir';
        }
        // Breadcrumb
        $this->_generateFindBreadcrumb($textfind);

        if($this->_languageId!=2){
            $textsectitle = 'SOUVENIR';
        }else{
            $textsectitle = 'SUVENIR';
        }

        // Passing ke view
        $this->view->pageTitle = $this->_destTitle . ' - Souvenir';
        $this->view->sectionTitle = $textsectitle;
        $this->view->sectionContent = parent::setPaginator($souvenir);
        $this->view->searchName = $searchName;

        // Render
        $this->render('index');
    }

    /**
     * IS: Parameter type, name, location terdeklarasi
     * FS: Mengirimkan ke viewer: customName, directory 
     * Desc: Fungsi untuk menampilkan list hasil pencarian
     */
    public function searchAction()
    {
        // Param
        $type = $this->_getParam('type');
        $name = $this->_getParam('name');
        $location = $this->_getParam('location');

        // Model
        $directoryDb = new Model_DbTable_Directory;
        $classDirDb = new Model_DbTable_ClassificationDirectory;

        // Data
        $directoryQuery = $directoryDb->getSearch($type, $name, $location);
        $classDir = $classDirDb->getAllForMenu();

        // View
        $this->view->customName = $classDir[$type] . '(s)';
        $this->view->directory = parent::setPaginator($directoryQuery);
    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk generate breadcrumb
     */
    private function _generateFindBreadcrumb($title)
    {
        switch($this->_languageId)
        {
            case 1: $langLocale = 'en'; break;
            case 2: $langLocale = 'id'; break;
        }
        $texthomelink = $this->view->translate('id_menu_home');
        $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $this->_destTitle =>
                        $this->view->url(array('language' => $langLocale,
                            'destId' => $this->_destId,
                            'destTitle' => $this->_formatDestTitle,
                            'action' => 'index'), 'dest-action', true),
                    $title => '',
        );

        Zend_Registry::set('breadcrumb', $links);
    }

    /**
     * IS: Parameter type terdeklarasi
     * FS: -
     * Desc: Fungsi untuk generate breadcrumb
     */
    private function _generateDetailBreadcrumb($directory)
    {
        // Param
        $type = $this->_getParam('type');

        switch($type) {
            case 'findtravel':
                if($this->_languageId!=2){
                    $title = 'Find Travel';
                }else{
                   $title = 'Cari Travel';
                }   
                break;
            case 'findhotel':
                if($this->_languageId!=2){
                    $title = 'Find Hotel';
                }else{
                   $title = 'Cari Hotel';
                }
                break;
            case 'findrestaurant':
                if($this->_languageId!=2){
                    $title = 'Find Restaurant';
                }else{
                   $title = 'Cari Restoran';
                }
                break;
            case 'findsouvenir':
                if($this->_languageId!=2){
                    $title = 'Find Souvenir';
                }else{
                   $title = 'Cari Suvenir';
                }
                break;
        }
        $texthomelink = $this->view->translate('id_menu_home');
        $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $this->_destTitle =>
                        $this->view->url(array(
                            'destId' => $this->_destId,
                            'destTitle' => $this->_formatDestTitle,
                            'action' => 'index'), 'dest-action', true),
                    $title => $this->view->url(array(
                            'destId' => $this->_destId,
                            'destTitle' => $this->_formatDestTitle,
                            'action' => $type), 'dest-tourism', true),
                    $directory['langname'] => '',
        );

        Zend_Registry::set('breadcrumb', $links);
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: nameSort, starSort, sortBy, sortOrder
     * Desc: Fungsi untuk generate sorter
     */
    private function _generateSorter($sortBy, $sortOrder)
    {
        // Model
        $sorter = new Model_Sorter;

        // Data
        $nameSort = $sorter->getSorter('name', $sortBy, $sortOrder);
        $starSort = $sorter->getSorter('star', $sortBy, $sortOrder);

        // View
        $this->view->nameSort = $nameSort;
        $this->view->starSort = $starSort;
        $this->view->sortBy = $sortBy;
        $this->view->sortOrder = strtolower($sortOrder);
    }
}