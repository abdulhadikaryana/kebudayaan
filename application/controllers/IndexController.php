<?php

/**
 * IndexController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * halaman utama
 *
 * @package Front Controller
 */
class IndexController extends Budpar_Controller_Common {

    /**
     *
     * @var Model_DbTable_Figure
     */
    protected $figure;

    /**
     *
     * @var Model_DbTable_News
     */
    protected $news;

    public function init() {
        $this->figure = new Model_DbTable_Figure;
        $this->news = new Model_DbTable_News;
        parent::init();

        $this->view->useSidebar = 'main-sidebar';
    }

    /**
     * IS: -
     * FS: Mengirimkan ke viewer: destination, news, event, destSearchForm, 
     *     activitySearchForm, highlight, video
     * Desc: Fungsi untuk menampilkan halaman depan
     */
    public function indexAction() {
        $this->_helper->layout->setLayout('kebudayaan');

        // Model
        $destinationDb = new Model_DbTable_Destination;
        $eventDb = new Model_DbTable_Event;
        $highlightDb = new Model_DbTable_Highlight;
//    $videoModel = new Model_Video;
        $galleryModel = new Model_DbTable_Image;

        // Data
        $galleryHeader = $highlightDb->getGalleryHeader();
        $featured_culture = $destinationDb->getFeaturedCulture($this->_languageId, 4);

        //generate news
        $news = $this->news->getLastNews($this->_languageId, 4);

        $event = $eventDb->getFourClosestEvent($this->_languageId);

        $highlightMed = $highlightDb->getMainType(2, $this->_languageId);

//    $videos = $videoModel->getMostViewedVideos($startIndexVideo, $maxResultVideo);
        $latestImage = $galleryModel->getTenLastImage(1, false, true);
        $activeHeaders = $highlightDb->getActiveHeaders($this->_languageId);

        if (count($activeHeaders) == 0) {
            $activeHeaders = $highlightDb->getActiveHeaders();
        }

        $this->view->activeHeaders = $activeHeaders;


        // Passing ke view                
        $this->view->galleryHeader = $galleryHeader;
        $this->view->latestImage = $latestImage;
        $this->view->featured_culture = $featured_culture;
        $this->view->news = $news->toArray();
        $this->view->event = $event;

        $this->view->useFeaturedSlideshow = true;
        $this->view->featuredCulture = $featured_culture;
        $this->view->highlight = $highlightMed;
//    $this->view->videos = $videos;
        $this->view->languageID = $this->_languageId;
        $this->view->useGoogleExperiment = true;
        $this->view->langId = $this->_languageId;

        $this->view->homepage = true;


        $this->view->figures = $this->figure
                        ->findAll($this->_languageId, 2)->toArray();

        $this->view->headMeta()->appendName('keywords', join(', ', $this->_meta));
        $this->view->headMeta()->appendName('description', "kebudayaanindonesia.net adalah laman referensi kebudayaan Indonesia untuk mewujudkan bangsa Indonesia yang cerdas dan berbudaya");
    }

    public function aboutAction() {
        $this->view->nama = 'Sangkuriang Designers';
    }

    public function redirectAction() {
        
        $this->redirect('/');
    }

}
