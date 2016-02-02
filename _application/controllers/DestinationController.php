<?php

/**
 * DestinationController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * halaman destinasi
 *
 * Code Convention:
 * - Jika penggunaan nama variabel 'destination' terlalu panjang bisa disingkat
 *   jadi 'dest'
 *
 * @package Front Controller
 */
class DestinationController extends Budpar_Controller_Destination {

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: imageGallery, areaDb
     * Desc: Fungsi inisialisasi
     */
    public function init() {
        parent::init();

        if ($this->_hasParam('destId')) {

            $imageDb = new Model_DbTable_Image;
            $imageGallery = $imageDb->getAllImageGalleryByPoiId($this->_destId);
            $this->view->imageGallery = $imageGallery;

            $fileAttachmentDb = new Model_DbTable_FileAttachments;
            $fileAttachments = $fileAttachmentDb->getByPoiId($this->_destId);
            $this->view->fileAttachments = $fileAttachments;
        }

        // Model Area untuk generate lokasi destinasi
        // View
        switch ($this->_languageId) {
            case 1: $langLocale = 'id';
                break;
            case 2: $langLocale = 'en';
                break;
        }
        $this->view->languageID = $langLocale;
        $this->view->areaDb = new Model_DbTable_Area;


        if (isset($this->_destId)) {
            // untuk mengenerate koordinate google map
            $destinationDb = new Model_DbTable_Destination;
            $destination = $destinationDb->getAllByIdLang($this->_destId, $this->_languageId);
            $this->view->pointX = $destination['pointX'];
            $this->view->pointY = $destination['pointY'];


            //realated link
            $linkModel = new Model_DbTable_RelatedArticlePoi();
            $this->view->related_link = $linkModel->getByPoiId($this->_destId, $this->_languageId);
        }

        $this->view->destId = $this->_destId;
        // parse google map key api to viewer
        $this->view->map_api = Zend_Registry::get('gmap_key2');

        $this->view->bigPageTitle = $this->view->translate('Culture');
        $this->view->bgClass = "yellow";
    }

    protected function countView() {
        $db = new Model_DbTable_Destination();

        $data = $db->pageViewer($this->_destId);
        return $data;
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: pageTitle, sectionTitle, sectionContent
     * Desc: Fungsi untuk menampilkan halaman utama destinasi
     */
    public function indexAction() {
        $this->_helper->layout->setLayout('kebudayaan');

        // untuk menghitung page view
        $this->view->pageViewer = $this->countView();

        // Params
        $poi_id = $this->_getParam('destId');

        // Model
        $destinationDb = new Model_DbTable_Destination;
        $table_videos = new Model_DbTable_CultureVideo;
        $this->view->videos = $table_videos->findByCultureId($this->_destId);

        // Data
        if ($this->_languageId == 1) {
            $destination = $destinationDb->getAllByIdLang($this->_destId, $this->_languageId);
        } else {
            $destination = $destinationDb->getAllByIdLangForIndo($this->_destId, $this->_languageId);
        }

        $userInfo = new Zend_Session_Namespace('userInfo');
        if (isset($userInfo->id)) {
            $destination = $destinationDb->getAllByIdLang($this->_destId, $this->_languageId, false);
        }

        $author = $destinationDb->getAuthor($poi_id, $this->_languageId);
        // Related poi
        $relatedPoiDb = new Model_DbTable_RelatedPoi;
        $relatedPois = $relatedPoiDb->getAllRelatedByPoiIdLangId($this->_destId, $this->_languageId);
        $this->view->relatedPois = $relatedPois;

        $category = $destinationDb->getCategory($poi_id, $this->_languageId);
//    $related = $destinationDb->getRelatedCulture($poi_id,$this->_languageId);
        //if do not have a description, will be redirecting to list of destination
        if ($destination['description']) {

            $destination['description'] = $this->_replaceImageUrl($destination['description']);

            if (array_key_exists('text', $destination)) {
                $text = $destination['text'];
            } else {
                $text = '';
            }

            // Breadcrumb
            $texthomelink = $this->view->translate('id_menu_home');
            $links = array(
                $texthomelink => $this->view->baseUrl('/'),
                $this->_destTitle => '',
            );

            Zend_Registry::set('breadcrumb', $links);
            if(!empty($this->author['name'])){
                $this->view->author = $author['name'];
            }
            
//      $this->view->related = $related;
            $this->view->category = $category['name'];
            $this->view->pageTitle = $this->_destTitle;
            $this->view->textdescIndo = $text;
            $this->view->sectionTitle = $this->view->translate('id_poi_description');
            $this->view->sectionContent = $destination['description'];


            Zend_Registry::set('backlink', $this->view->currentUrl());

            // Render
            //$this->render('destination');
        } else {
            $this->_redirector->gotoUrl($this->view->baseUrl('/destination/search/'));
        }
    }

    /**
     * IS: Parameter name, activity, location, sortby, sortorder terdeklarasi
     * FS: Mengirimkan ke viewer: destination, areaDb, useHeaderImage, name
     * Desc: Fungsi untuk menampilkan halaman hasil pencarian
     */
    public function searchAction() {
        // Mengubah layout default jadi dua kolom
        $this->_helper->layout->setLayout('two-column');

        // Param
        $name = filter_var(strip_tags($this->_getParam('name')), FILTER_SANITIZE_SPECIAL_CHARS);
        $activity = $this->_getParam('activity');
        $location = $this->_getParam('location');
        $sortBy = $this->_getParam('sortby');
        $sortOrder = $this->_getParam('sortorder', 'desc');

        // Model
        $destinationDescDb = new Model_DbTable_DestinationDescription;

        // Data
        $destinationQuery = $destinationDescDb->getSearch(
                $name, $location, $activity, $this->_languageId, array('sort_by' => $sortBy,
            'sort_order' => $sortOrder));

        $this->_generateSorter($sortBy, $sortOrder);

        // View
        $this->view->destination = parent::setPaginator($destinationQuery);
        $this->view->areaDb = new Model_DbTable_Area;
        $this->view->useHeaderImage = false; // Tidak pake header image
        $this->view->name = $name;
        $this->view->langIId = $this->_languageId;
        if (!isset($name)) {
            $this->view->showall = TRUE;
        }
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: ajax, pageTitle, sectionTitle,sectionContent
     * Desc: Fungsi untuk menampilkan informasi mengenai bagaimana cara ke suatu
     *       destinasi
     */
    public function getthereAction() {
        $this->_helper->layout->setLayout('one-column');

        // untuk menghitung page view
        $this->view->pageViewer = $this->countView();

        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->view->ajax = true;
        }

        // Model
        $destDescDb = new Model_DbTable_DestinationDescription;

        // Data
        $getThere = $destDescDb->getHowToGetThereByIdLang($this->_destId, $this->_languageId);
        $getThere = $this->_replaceImageUrl($getThere);

        // Breadcrumb
        $pageTitle = $this->view->translate('id_poi_where');
        $this->_generateDescBreadcrumb($pageTitle);

        // Passing ke view
        $this->view->pageTitle = $this->_destTitle . ' - ' . $pageTitle;
        $this->view->sectionTitle = $pageTitle;
        $this->view->sectionContent = $this->view->HtmlDecode($getThere);

        if ($this->_request->isXmlHttpRequest())
            $this->render('detail');
        else
            $this->view->tab = 'getthere';
        $this->render('index');
        //$this->render('destination');
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: ajax, pageTitle, sectionTitle,sectionContent
     * Desc: Fungsi untuk menampilkan informasi get around lebih detail
     */
    public function getaroundAction() {
        $this->_helper->layout->setLayout('one-column');

        // untuk menghitung page view
        $this->view->pageViewer = $this->countView();


        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->view->ajax = true;
        }

        // Model
        $destDescDb = new Model_DbTable_DestinationDescription;

        // Data
        $toGetAround = $destDescDb->getHowToGetAroundByIdLang($this->_destId, $this->_languageId);
        $toGetAround = $this->_replaceImageUrl($toGetAround);

        // Breadcrumb
        $pageTitle = $this->view->translate('id_poi_around');
        $this->_generateDescBreadcrumb($pageTitle);

        // Passing ke view
        $this->view->pageTitle = $this->_destTitle . ' - ' . $pageTitle;
        $this->view->sectionTitle = $pageTitle;
        $this->view->sectionContent = $this->view->HtmlDecode($toGetAround);

        if ($this->_request->isXmlHttpRequest())
            $this->render('detail');
        else
            $this->view->tab = 'getaround';
        $this->render('index');
        //$this->render('destination');
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: ajax, pageTitle, sectionTitle,sectionContent
     * Desc: Fungsi untuk menampilkan informasi stay around lebih detail
     */
    public function tostayAction() {
        $this->_helper->layout->setLayout('one-column');

        // untuk menghitung page view
        $this->view->pageViewer = $this->countView();


        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->view->ajax = true;
        }

        // Model
        $destDescDb = new Model_DbTable_DestinationDescription;

        // Data
        $toStay = $destDescDb->getWhereToStayByIdLang($this->_destId, $this->_languageId);
        $toStay = $this->_replaceImageUrl($toStay);

        // Breadcrumb
        $pageTitle = $this->view->translate('id_poi_stay');
        $this->_generateDescBreadcrumb($pageTitle);

        // Passing ke view
        $this->view->pageTitle = $this->_destTitle . ' - ' . $pageTitle;
        $this->view->sectionTitle = $pageTitle;
        $this->view->sectionContent = $this->view->HtmlDecode($toStay);

        if ($this->_request->isXmlHttpRequest())
            $this->render('detail');
        else
            $this->view->tab = 'tostay';
        $this->render('index');
        //$this->render('destination');
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: ajax, pageTitle, sectionTitle,sectionContent
     * Desc: Fungsi untuk menampilkan informasi to eat secara mendetail
     */
    public function toeatAction() {
        $this->_helper->layout->setLayout('one-column');

        // untuk menghitung page view
        $this->view->pageViewer = $this->countView();


        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->view->ajax = true;
        }

        // Model
        $destDescDb = new Model_DbTable_DestinationDescription;

        // Data
        $toEat = $destDescDb->getWhereToEatByIdLang($this->_destId, $this->_languageId);
        $toEat = $this->_replaceImageUrl($toEat);

        // Breadcrumb
        $pageTitle = $this->view->translate('id_poi_eat');
        $this->_generateDescBreadcrumb($pageTitle);

        // Passing ke view
        $this->view->pageTitle = $this->_destTitle . ' - ' . $pageTitle;
        $this->view->sectionTitle = $pageTitle;
        $this->view->sectionContent = $this->view->HtmlDecode($toEat);

        if ($this->_request->isXmlHttpRequest())
            $this->render('detail');
        else
            $this->view->tab = 'toeat';
        $this->render('index');
        //$this->render('destination');
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: ajax, pageTitle, sectionTitle,sectionContent
     * Desc: Fungsi untuk menampilkan informasi to buy lebih detail
     */
    public function tobuyAction() {
        $this->_helper->layout->setLayout('one-column');

        // untuk menghitung page view
        $this->view->pageViewer = $this->countView();


        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->view->ajax = true;
        }

        // Model
        $destDescDb = new Model_DbTable_DestinationDescription;

        // Data
        $toBuy = $destDescDb->getWhatToBuyByIdLang($this->_destId, $this->_languageId);
        $toBuy = $this->_replaceImageUrl($toBuy);

        // Breadcrumb
        $pageTitle = $this->view->translate('id_poi_buy');
        $this->_generateDescBreadcrumb($pageTitle);

        // Passing ke view
        $this->view->pageTitle = $this->_destTitle . ' - ' . $pageTitle;
        $this->view->sectionTitle = $pageTitle;
        $this->view->sectionContent = $this->view->HtmlDecode($toBuy);

        if ($this->_request->isXmlHttpRequest())
            $this->render('detail');
        else
            $this->view->tab = 'tobuy';
        $this->render('index');
        //$this->render('destination');
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: ajax, pageTitle, sectionTitle,sectionContent
     * Desc: Fungsi untuk menampilkan informasi to do lebih spesifik
     */
    public function todoAction() {
        $this->_helper->layout->setLayout('one-column');

        // untuk menghitung page view
        $this->view->pageViewer = $this->countView();

        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->view->ajax = true;
        }

        // Model
        $destDescDb = new Model_DbTable_DestinationDescription;

        // Data
        $toDo = $destDescDb->getWhatToDoByIdLang($this->_destId, $this->_languageId);
        $toDo = $this->_replaceImageUrl($toDo);

        // Breadcrumb
        $pageTitle = $this->view->translate('id_poi_todo');
        $this->_generateDescBreadcrumb($pageTitle);

        // Passing ke view
        $this->view->pageTitle = $this->_destTitle . ' - ' . $pageTitle;
        $this->view->sectionTitle = $pageTitle;
        $this->view->sectionContent = $this->view->HtmlDecode($toDo);

        if ($this->_request->isXmlHttpRequest())
            $this->render('detail');
        else
            $this->view->tab = 'todo';
        $this->render('index');
        //$this->render('destination');
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: ajax, pageTitle, sectionTitle,sectionContent
     * Desc: Fungsi untuk menampilkan informasi tips
     */
    public function tipsAction() {
        $this->_helper->layout->setLayout('one-column');

        // untuk menghitung page view
        $this->view->pageViewer = $this->countView();

        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->view->ajax = true;
        }

        // Model
        $destDescDb = new Model_DbTable_DestinationDescription;

        // Data
        $tips = $destDescDb->getTipsByIdLang($this->_destId, $this->_languageId);
        $tips = $this->_replaceImageUrl($tips);

        // Breadcrumb
        $pageTitle = $this->view->translate('id_poi_tips');
        $this->_generateDescBreadcrumb($pageTitle);

        // Passing ke view
        $this->view->pageTitle = $this->_destTitle . ' - ' . $pageTitle;
        $this->view->sectionTitle = $pageTitle;
        $this->view->sectionContent = $this->view->HtmlDecode($tips);

        if ($this->_request->isXmlHttpRequest())
            $this->render('detail');
        else
            $this->view->tab = 'tips';
        $this->render('index');
        //$this->render('destination');
    }

    /*
     * _paginator function
     * untuk fungsi paginasi halaman
     * @param  = database_result
     * @param = display per_page
     * @param = rage number link e.g : 4 link after current
     */

    private function _paginator($data, $per_page, $num_link = 4) {

        if (count($data) > 0) {
            /** Get the page number , default 1 */
            $page = $this->_getParam('page', 1);

            /** Object of Zend_Paginator */
            $paginator = Zend_Paginator::factory($data);

            /** Set the number of counts in a page */
            $paginator->setItemCountPerPage($per_page);

            $paginator->setPageRange($num_link);

            /*
             * Set the current page number */
            $paginator->setCurrentPageNumber($page);

            return $paginator;
        }
    }

    /**
     * IS: -
     * FS: -
     * Desc: -
     */
    public function galleryAction() {
        //param
        $destId = $this->_getParam('destId');
        $destTitle = $this->_getParam('destTitle');

        // terbaru
        $this->_helper->layout->setLayout('one-column');


        $imageDb = new Model_DbTable_Image;
        $imageGallery = $imageDb->pageGallery($this->_destId);


        $this->view->imageGallery = $this->_paginator($imageGallery, 1);

        $this->view->prevUrl = $this->view->baseUrl('/destination/' . $destId . '/' . $destTitle);

        $this->render('gallery-new');
    }

    protected function generatePrevUrl() {
        $current_url = $this->view->currentUrl();
        $x = substr($current_url, 7);

        $url = explode("/", $x);
        $splice_url = array_splice($url, 0, 5);
        $prev_url = implode("/", $splice_url);

        return $prev_url;
    }

    public function pagegalleryAction() {
        //$this->_helper->layout()->disableLayout();
        //$this->_helper->viewRenderer->setNoRender(true); /* supaya tidak render view */
        $this->_helper->layout->setLayout('one-column');


        $imageDb = new Model_DbTable_Image;
        //$imageGallery = $imageDb->pagingGallery($offset,$poi_id);
        $imageGallery = $imageDb->pageGallery($this->_destId);
        $this->view->imageGallery = $this->_paginator($imageGallery, 1);


        //$page = ($this->_getParam('page') < 1) ? 1 : $this->_getParam('page');
        //$this->view->imageGallery = $this->queryGallery(($page - 1),$this->_destId);
        //$this->view->page = $page;
        $this->view->languageId = $this->_languageId;
        $this->view->prevUrl = $this->generatePrevUrl();
        $this->render('gallery-new');
    }

    protected function queryGallery($offset, $poi_id) {
        $imageDb = new Model_DbTable_Image;
        $imageGallery = $imageDb->pagingGallery($offset, $poi_id);

        return $imageGallery;
    }

    public function postsAction() {
        $this->_helper->layout->setLayout('kebudayaan');
        $sortBy = $this->_getParam('sortby');
        $sortOrder = $this->_getParam('sortorder', 'desc');
        $destTitle = $this->_getParam('destTitle');

        $texthomelink = $this->view->translate('id_menu_home');
        $title = $this->view->translate('Culture');
        $links = array(
            $texthomelink => $this->view->baseUrl('/'),
            $title => '',
        );
        $this->view->pageTitle = $title;


        Zend_Registry::set('breadcrumb', $links);


        $cultureDb = new Model_DbTable_Destination;
        $culture = $cultureDb->getAllPublished($this->_languageId);

        $this->view->pageTitle = $this->view->translate('Culture');
        $this->view->culture = $culture;
        $this->view->count = count($culture);
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: pageTitle
     * Desc: Fungsi untuk generate breadcrumb
     */
    protected function _generateBreadcrumb() {
        // Breadcrumb
        $links = null;

    switch ($this->_request->getActionName()) {
      case 'search':
        if (isset($name)) {
          $title = 'Search Destination Result';
        } else {
          if ($this->_languageId == 1) {
            $title = 'Destinations in Indonesia List';
          } else {
            $title = 'Daftar Destinasi di Indonesia';
          }
        }
        if ($this->_languageId == 1) {
          $hometextlink = 'Home';
        } else {
          $hometextlink = 'Beranda';
        }
        $links        = array(
            $hometextlink          => $this->view->baseUrl('/'),
            $title                 => '',
        );
        $this->view->pageTitle = $title;
        break;
          
    }
    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk melakukan replace url image     
     *  
     * @param string $text content dari basis data
     * @return string
     */
    private function _replaceImageUrl($text) {
        $text = str_replace("http://203.211.140.227/public/media/images/upload/", $this->view->imageUrl('/upload/'), $text);
        $text = str_replace("../../../../public/media/images", $this->view->imageUrl(), $text);
        //$text = str_replace( "../..", $this->view->imageUrl(), $text);

        return $text;
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: nameSort, ratingSort, sortBy, sortOrder
     * Desc: Fungsi untuk generate sorter
     */
    private function _generateSorter($sortBy, $sortOrder) {
        // Model
        $sorter = new Model_Sorter;

        // Data
        $nameSort = $sorter->getSorter('name', $sortBy, $sortOrder);
        $ratingSort = $sorter->getSorter('rating', $sortBy, $sortOrder);

        // View
        $this->view->nameSort = $nameSort;
        $this->view->ratingSort = $ratingSort;
        $this->view->sortBy = $sortBy;
        $this->view->sortOrder = strtolower($sortOrder);
    }

    public function rssAction() {
        // Tidak pake layout
        $this->_helper->layout->disableLayout();

        // Model
        $destDb = new Model_DbTable_Destination();
        $lang_id = $this->_languageId;

        // Data
        $destQuery = $destDb->getAllWithDescForRss($lang_id, 10);
        $dest = $destDb->fetchAll($destQuery);

        // Start building XML untuk RSS
        for ($i = 0; $i < count($dest); $i++) {
            $string = $dest[$i]['name'];
            $string = str_replace('“', ' ', $string);
            $string = str_replace('”', ' ', $string);
            $string = str_replace('�', ' ', $string);
            $string = str_replace('�', ' ', $string);
            $dest[$i]['name'] = $this->xmlEntities(htmlentities($string, ENT_QUOTES));

            $string = $dest[$i]['description'];
            $string = str_replace('“', ' ', $string);
            $string = str_replace('”', ' ', $string);
            $string = str_replace('�', ' ', $string);
            $string = str_replace('�', ' ', $string);
            $dest[$i]['description'] = $this->xmlEntities(htmlentities($string, ENT_QUOTES));
        }

        $this->view->data = $dest;
    }

    protected function xmlEntities($str) {
        $xml = array('&#34;', '&#38;', '&#38;', '&#60;', '&#62;', '&#160;', '&#161;', '&#162;', '&#163;', '&#164;', '&#165;', '&#166;', '&#167;', '&#168;', '&#169;', '&#170;', '&#171;', '&#172;', '&#173;', '&#174;', '&#175;', '&#176;', '&#177;', '&#178;', '&#179;', '&#180;', '&#181;', '&#182;', '&#183;', '&#184;', '&#185;', '&#186;', '&#187;', '&#188;', '&#189;', '&#190;', '&#191;', '&#192;', '&#193;', '&#194;', '&#195;', '&#196;', '&#197;', '&#198;', '&#199;', '&#200;', '&#201;', '&#202;', '&#203;', '&#204;', '&#205;', '&#206;', '&#207;', '&#208;', '&#209;', '&#210;', '&#211;', '&#212;', '&#213;', '&#214;', '&#215;', '&#216;', '&#217;', '&#218;', '&#219;', '&#220;', '&#221;', '&#222;', '&#223;', '&#224;', '&#225;', '&#226;', '&#227;', '&#228;', '&#229;', '&#230;', '&#231;', '&#232;', '&#233;', '&#234;', '&#235;', '&#236;', '&#237;', '&#238;', '&#239;', '&#240;', '&#241;', '&#242;', '&#243;', '&#244;', '&#245;', '&#246;', '&#247;', '&#248;', '&#249;', '&#250;', '&#251;', '&#252;', '&#253;', '&#254;', '&#255;');
        $html = array('&quot;', '&amp;', '&amp;', '&lt;', '&gt;', '&nbsp;', '&iexcl;', '&cent;', '&pound;', '&curren;', '&yen;', '&brvbar;', '&sect;', '&uml;', '&copy;', '&ordf;', '&laquo;', '&not;', '&shy;', '&reg;', '&macr;', '&deg;', '&plusmn;', '&sup2;', '&sup3;', '&acute;', '&micro;', '&para;', '&middot;', '&cedil;', '&sup1;', '&ordm;', '&raquo;', '&frac14;', '&frac12;', '&frac34;', '&iquest;', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;', '&AElig;', '&Ccedil;', '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;', '&ETH;', '&Ntilde;', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;', '&Ouml;', '&times;', '&Oslash;', '&Ugrave;', '&Uacute;', '&Ucirc;', '&Uuml;', '&Yacute;', '&THORN;', '&szlig;', '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;', '&ecirc;', '&euml;', '&igrave;', '&iacute;', '&icirc;', '&iuml;', '&eth;', '&ntilde;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&divide;', '&oslash;', '&ugrave;', '&uacute;', '&ucirc;', '&uuml;', '&yacute;', '&thorn;', '&yuml;');
        $str = str_replace($html, $xml, $str);
        $str = str_ireplace($html, $xml, $str);
        return $str;
    }

}