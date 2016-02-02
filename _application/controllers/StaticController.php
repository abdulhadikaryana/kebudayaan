<?php
/**
 * StaticController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * halaman-halaman static
 *
 * @package Front Controller
 */
class StaticController extends Budpar_Controller_Common
{
    /**
     * IS: -
     * FS: -
     * Desc: Fungsi inisialisasi
     */
    public function init()
    {
        parent::init();
		
		$this->view->destinasi = $this->randomDestination();
	
		$this->view->activity = $this->randomActivity();
	
		$this->view->languageId = $this->_languageId;
    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk menampilkan informasi umum
     */
    public function glanceAction()
    {
	    $this->_helper->layout->setLayout('one-column');
        $this->_displayContent('glance', 'discover');       
        //$this->view->current = 'glance';
        $this->render('index');
    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk menampilkan informasi iklim
     */
    public function climateAction()
    {
	    $this->_helper->layout->setLayout('one-column');
        $this->_displayContent('climate', 'discover');
        $this->view->staticType = 'climate';
        $this->render('index');
    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk menampilkan informasi bahasa
     */
    public function languageAction()
    {
	    $this->_helper->layout->setLayout('one-column');
        $this->_displayContent('language', 'discover');
        $this->view->staticType = 'language';
        $this->render('index');

    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk menampilkan informasi flora fauna
     */
    public function florafaunaAction()
    {
	    $this->_helper->layout->setLayout('one-column');
        $this->_displayContent('florafauna', 'discover');
        $this->render('index');
    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk menampilkan informasi tentang masyarakat
     */
    public function peoplecultureAction()
    {
	    $this->_helper->layout->setLayout('one-column');
        $this->_displayContent('peopleculture', 'discover');
        $this->render('index');
    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk menampilkan informasi sejarah
     */
    public function historyAction()
    {
	    $this->_helper->layout->setLayout('one-column');
        $this->_displayContent('history', 'discover');
        $this->render('index');
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: island, province, staticType, menuType
     * Desc: Fungsi untuk menampilkan region list
     */
    public function regionListAction()
    {
	    $this->_helper->layout->setLayout('one-column');

		//$this->_displayContent('list', 'discover');
		
        // Model
        $areaDb = new Model_DbTable_Area;

        // Data
		$island = $areaDb->getAreaNameByParentLanguage(0, $this->_languageId);
		foreach ($island as $index => $islands) {
			$province[$index] = $areaDb->getAreaNameByParentLanguage($islands['area_id'],
                $this->_languageId);
		}

        // View
	    $this->view->island = $island;
	    $this->view->province = $province;
        $this->view->staticType = 'list';
        $this->view->menuType = 'discover';

        $this->render('index');

	}

    /**
     * IS: Parameter id terdeklarasi
     * FS: Mengirimkan ke viewer: pageTitle, areaType, region, staticType, 
     *     menuType
     * Desc: Fungsi untuk menampilkan detail region
     */
    public function regionDetailAction()
    {
	    $this->_helper->layout->setLayout('one-column');
        // Param
        $areaId = $this->_getParam('id');
        
        // Model
        $areaDb = new Model_DbTable_Area;
        $regionalDb = new Model_DbTable_Regional;

        // Data
        $areaType = $areaDb->getAreaTypeById($areaId);
        $region = $regionalDb->getAllByIdLang($areaId, $this->_languageId);
        $texthomelink = $this->view->translate('id_menu_home');
        // Breadcrumb
        $links = array(
            $texthomelink => $this->view->baseUrl('/'),
            $this->view->translate('id_static_list') =>
                $this->view->baseUrl('/discover-indonesia/region-list'),
            $region['area_name'] => '',
        );
        Zend_Registry::set('breadcrumb', $links);

	//if regional_description is empty, will be redirecting to regional list
	if($region['regional_description']){
	    // View
	    $this->view->pageTitle = $region['area_name'];
	    $this->view->areaType = $areaType;
	    $this->view->region = $region;
	    $this->view->staticType = 'list';
	    $this->view->menuType = 'discover';
	}
	else
	{
	    $this->_redirector->gotoUrl($this->view->baseUrl('/discover-indonesia/region-list/'));   
	}

        $this->view->staticType = 'list';
        $this->view->isdetail = true;
        $this->render('index');

    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk menampilkan informasi imigrasi
     */
    public function immigrationAction()
    {
        $this->_displayContent('immigration', 'travel');
        $this->render('index');
    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk menampilkan informasi perjalanan secara umum
     */
    public function generalAction()
    {
        $this->_displayContent('general', 'travel');
        $this->render('index');
    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk menampilkan informasi mengenai apa yang boleh dilakukan
     */
    public function doAction()
    {
        $this->_displayContent('do', 'travel');
        $this->render('index');
    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk menampilkan informasi mengenai hal-hal yg berkaitan dengan
     *       indonesian phrases
     */
    public function sayingAction()
    {
        $this->_displayContent('saying', 'travel');
		$this->render('index');
	}

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: staticType, menuType, foreign, customName
     * Desc: Fungsi untuk menampilkan informasi mengenai kedutaan besar negara2 lain
     *       di Indonesia. Foreign-Representative
     */
    public function foreignAction()
    {
        // Model
        $directoryDb = new Model_DbTable_Directory;

        // Data
        $foreignDirQuery = $directoryDb->getEmbassyOffice();

        // View
        $this->view->staticType = 'foreign';
        $this->view->menuType = 'travel';
        $this->view->foreign = parent::setPaginator($foreignDirQuery);
        // id_page_foreign = 'embassy(s)'
        $this->view->customName = $this->view->translate('id_page_foreign');

        // Render
        $this->render('foreign');
    }
    
    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk menampilkan informasi FAQ
     */
    public function faqAction()
    {
        $this->_displayContent('faq');
        $this->render('index');
    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk menampilkan informasi Terms Condition
     */
    public function termsAction()
    {
        $this->_displayContent('terms');
        $this->render('index');
    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk menampilkan informasi Terms Condition
     */
    public function sitemapAction()
    {
        $this->_displayContent('sitemap');
        $this->render('index');
    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk menampilkan informasi Privacy Policy
     */
    public function policyAction()
    {
        $this->_displayContent('policy');
        $this->render('index');
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: customName, telp, airline
     * Desc: Fungsi untuk menampilkan informasi Airlines
     */
    public function airlineAction()
    {
        $this->_displayContent('airline');

        // Model
        $airlineDb = new Model_DbTable_Airlines;

        // Data
        $airline = $airlineDb->getAllWithDesc($this->_languageId);
        $telp = $airlineDb->getAllTelp();

        // id_page_airline = 'airline(s)'
        $this->view->customName = $this->view->translate('id_page_airline');
        $this->view->telp = $telp;
        $this->view->airline = parent::setPaginator($airline, 3);
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
            case 'terms':
                $title = $this->view->translate('id_menu_terms');
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $title => $this->view->baseUrl('terms-and-conditions'),
                );
                $this->view->pageTitle = $title;
                break;
            case 'policy':
                $title = $this->view->translate('id_menu_policy');
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $title => $this->view->baseUrl('privacy-policy'),
                );
                $this->view->pageTitle = $title;
                break;
            case 'sitemap':
                $title = $this->view->translate('id_menu_sitemap');
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $title => $this->view->baseUrl('site-map'),
                );
                $this->view->pageTitle = $title;
                break;
            case 'glance':
            case 'region-list':
            case 'history':
            case 'language':            
            case 'florafauna':
            case 'climate':
            case 'peopleculture':
                // id_menu_colorful = 'Discover Indonesia'
                $title = $this->view->translate('id_menu_colorful');
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $title => $this->view->baseUrl('discover-indonesia'),
                );
                $this->view->pageTitle = $title;
                break;
            case 'faq':
                $title = $this->view->translate('id_menu_faqlong');
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $title => $this->view->baseUrl('frequently-asked-questions'),
                );
                $this->view->pageTitle = $title;
                break;
            case 'immigration':
            case 'general':
            case 'do':
            case 'saying':
            case 'foreign':
                // id_menu_visiting = 'Travel Information'
                $title = $this->view->translate('id_menu_visiting');
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $title => $this->view->baseUrl('travel-information'),
                );
                $this->view->pageTitle = $title;
                break;
            case 'airline':
                // id_menu_airline = 'Flight to Indonesia'
                $title = $this->view->translate('id_menu_airline');
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $title => '',
                );
                $this->view->pageTitle = $title;
                break;
            case 'index':
            default:
                $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    //$this->_listTitle => '',
                );
        }
        Zend_Registry::set('breadcrumb', $links);
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: staticType, menuType, staticContent
     * Desc: Fungsi yang digunakan untuk menampilkan content static
     *
     * @param $staticType tipe static (climate/currency) dari tabel
     * @param $menuType tipe menu/navigation (discover atau travel)
     */
    private function _displayContent($staticType = '', $menuType = '')
    {
        // Model
        $staticContentDb = new Model_DbTable_StaticContent;

        // Data
        $staticContent = 
            $staticContentDb->getContentByLangId($staticType,
                    $this->_languageId);

        // View
        $this->view->staticType = $staticType;
        $this->view->menuType = $menuType;
        $this->view->staticContent = $staticContent;
    }
    
    protected function randomDestination()
    {
	$db = new Model_DbTable_Destination();
	
	$data = $db->getRandomDestination(3,$this->_languageId);
	
	return $data;
    }
    
    protected function randomActivity()
    {
        // Model
        $categoryDb = new Model_DbTable_Category;

        // Data
        $activities = $categoryDb->randomCategory(3,$this->_languageId);
	
		return $activities;
    }
}