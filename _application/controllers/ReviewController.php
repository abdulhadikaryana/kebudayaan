<?php
/**
 * ReviewController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * review destinasi
 *
 * @package Front Controller
 */
class ReviewController extends Budpar_Controller_Destination
{
    /**
     * IS: -
     * FS: -
     * Desc: Fungsi inisialisasi
     */
    public function init()
    {
        parent::init();

        switch($this->_languageId)
        {
            case 1: $langLocale = 'en'; break;
            case 2: $langLocale = 'id'; break;
        }
        $this->view->languageID = $langLocale;

        // untuk mengenerate koordinate google map
        $destinationDb = new Model_DbTable_Destination;
        $destination = $destinationDb->getAllByIdLang($this->_getParam('destId'), $this->_languageId);
        $this->view->pointX = $destination['pointX'];
        $this->view->pointY = $destination['pointY'];
	
	//untuk menghitung page viewer
        $this->view->pageViewer = $this->countView($this->_getParam('destId'));
    }

    protected function countView($poi_id)
    {
	$db = new Model_DbTable_Destination();

	$data = $db->pageViewer($poi_id);
	return $data;
    }

    /**
     * IS: Parameter destId terdeklarasi
     * FS: Mengirimkan ke viewer: reviewExist, pageTitle, fb, reviews, username
     * Desc: Fungsi untuk menampilkan daftar review
     */
    public function indexAction()
    {

        $this->_helper->layout->setLayout('one-column');

        // Param
        $destId = $this->_getParam('destId');
        
        // Model
        $reviewDb = new Model_DbTable_Review;

        if($this->_sess->userId) {
            $reviewExist = $reviewDb->getByPoiAndUser($destId, $this->_sess->userId);
            if($reviewExist)
                $this->view->reviewExist = $reviewExist;
            $reviews = $reviewDb->getAllByPoiId($destId, $reviewExist['review_id']);
        } else {
            $reviews = $reviewDb->getAllByPoiId($destId);
        }

        // Breadcrumb
        $pageTitle = $this->view->translate('id_review');
        $texthomelink = $this->view->translate('id_menu_home');
        $links = array(
            $texthomelink => $this->view->baseUrl('/'),
            $this->_destTitle => $this->view->url(array(
                        'destId' => $this->_destId,
                        'destTitle' => $this->_formatDestTitle,
                        'action' => 'index'), 'dest-action', true),
            $pageTitle => '',
        );
        Zend_Registry::set('breadcrumb', $links);
        
        // View
        $this->view->pageTitle = $pageTitle;
        $this->view->fb = $this->_fb;
        $this->view->reviews = parent::setPaginator($reviews);
        $this->view->username = $this->_sess->username;
    }

    /**
     * IS: Parameter reviewId terdeklarasi
     * FS: Mengirimkan ke viewer: author, pageTitle, review, comments, 
     *     commentForm, enable, sessUserId
     * Desc: Fungsi untuk menampilkan detail review
     */
    public function detailAction()
    {

    	$this->_helper->layout->setLayout('one-column');

        // Variable
        $contentType = 3; // Untuk comment
        
        // Param
        $reviewId = $this->_getParam('reviewId');

        // Form
        $commentForm = new Form_CommentForm;
        $commentForm->setAttrib('action', $this->view->currentUrl());

        // Model
        $reviewDb = new Model_DbTable_Review;
        $commentDb = new Model_DbTable_Comment;

        // Request dari Comment Form
        if($this->getRequest()->isPost()) {
            if($commentForm->isValid($this->getRequest()->getPost())) {

                // Insert
                $commentId = $commentDb->insertComment($reviewId, $contentType,
                    $this->getRequest()->getPost(), $this->_sess->userId,
                    $this->_sess->fbname);

                // Reset form
                $commentForm->reset();

                // Redirect
                $this->_redirector->gotoUrl($this->view->currentUrl() .
                    '#comment-' . $commentId);
            }
        }

        // Data
        $review = $reviewDb->get($reviewId);



        $author = '';
        if($review['isfb']) {
            /*$fbInfo = $this->_fb->api_client->users_getInfo($review['username'],
                        array('name', 'pic_square'));*/
            $fbInfo = $this->_fb->api('/' . $review['username']);
            $author = $fbInfo['name'];
            //$this->view->fbImageUrl = $fbInfo[0]['pic_square'];
        } else {
            $author = $review['username'];
        }

        // Cek cookie thumb
        $enable = false;
        if ($this->_sess->userId //){
            AND ! isset($_COOKIE["thumb" . $reviewId . '_' . $this->_sess->userId])
            ){
            $enable = true;
        }

        $comments = $commentDb->getAllByContentType($reviewId, $contentType);

        // Breadcrumb
        $pageTitle = $review['review_title'];
        $this->_generateDetailBreadcrumb($pageTitle);


        // View
        $this->view->author = $author;
        $this->view->pageTitle = $pageTitle;
        $this->view->review = $review;
        $this->view->comments = $comments;
        $this->view->commentForm = $commentForm;
        $this->view->enable = $enable;
        $this->view->sessUserId = $this->_sess->userId;
    }

    /**
     * IS: Parameter destId terdeklarasi
     * FS: Mengirimkan ke viewer: form, pageTitle
     * Desc: Fungsi untuk menambah review
     */
    public function addAction()
    {
    	$this->_helper->layout->setLayout('one-column');


        // Param
        $destId = $this->_getParam('destId');

        // Cek otorisasi
        if ($this->_sess->userId) {
            // Model
            $reviewDb = new Model_DbTable_Review;

            $existReview = $reviewDb->getByPoiIdUserId($destId, $this->_sess->userId);

            if (count($existReview) AND ! empty($existReview['review_content'])) {
                
                $this->_redirectToReview('index');
            } else {
                // Form
                $form = new Form_ReviewForm;
                $form->addAttribs(
                    array(
                        'action' => $this->view->url(array('action' => 'add'))
                    )
                );

                if(empty($existReview['review_content'])
                    AND ! empty($existReview['rate'])) {
                    $review = $reviewDb->get($existReview['review_id']);
                    $form->populate($review->toArray());
                }


                //// Request dari Form
                if($this->getRequest()->isPost()) {
                    if($form->isValid($this->getRequest()->getPost())) {
                        ////$this->_helper->layout()->disableLayout();
                        ////$this->_helper->viewRenderer->setNoRender(true); /* supaya tidak render view */


                        // Insert
                        $reviewId = $reviewDb->insertReview($destId, $this->_sess->userId,$this->_sess->fbname, $this->getRequest()->getPost());
                        //echo $this->_sess->fbname;
                        //print_r($_POST);
                
                        // Reset form
                        $form->reset();
                
                        // Redirect
                        $this->_redirectToReview('detail', $reviewId);
                    }
                }

                // Breadcrumb
                $pageTitle = $this->view->translate('id_add_review');
                $this->_generateDetailBreadcrumb($pageTitle);

                // View
                $this->view->pageTitle = $pageTitle;
                $this->view->form = $form;


                $this->render('form');
            }

        } else {
            $this->_redirectToReview('index');
        } // end if cek session
    }

    /**
     * IS: Parameter destId dan reviewId terdeklarasi
     * FS: Mengirimkan ke viewer: form, pageTitle
     * Desc: Fungsi untuk edit review
     */
    public function editAction()
    {

    	$this->_helper->layout->setLayout('one-column');
        
        // Param
        $destId = $this->_getParam('destId');
        $reviewId = $this->_getParam('reviewId');

        // Cek otorisasi
        if ($this->_sess->userId) {

            // Form
            $form = new Form_ReviewForm;
            $form->addAttribs(
                array(
                    'action' => $this->view->url(array('action' => 'edit'))
                )
            );

            // Model
            $reviewDb = new Model_DbTable_Review;

            // Request dari Form
            if($this->getRequest()->isPost()) {
                if($form->isValid($this->getRequest()->getPost())) {
                    $reviewDb->editReview($destId, $this->_sess->userId,
                        $this->getRequest()->getPost());

                        $this->_redirectToReview('detail', $reviewId);
                } else {
                    $form->populate($this->getRequest()->getPost());
                }
            } else {
                // Data
                $review = $reviewDb->get($reviewId);
                if($this->_sess->userId != $review['user_id']) {
                    $this->_redirectToReview('index');
                }
                $form->populate($review->toArray());
            }

            // Breadcrumb
            $pageTitle = $this->view->translate('id_edit_review');
            $this->_generateDetailBreadcrumb($pageTitle);
            
            // View
            $this->view->pageTitle = $pageTitle;
            $this->view->form = $form;

            $this->render('form');
        } else {
            $this->_redirectToReview('index');
        }
    }

    /**
     * IS: -
     * FS: -
     * Desc: Fungsi untuk generate breadcrumb
     */
    private function _generateDetailBreadcrumb($pageTitle)
    {
         switch($this->_languageId)
        {
            case 1: $langLocale = 'en'; break;
            case 2: $langLocale = 'id'; break;
        }
        $texthomelink = $this->view->translate('id_menu_home');
        $links = array(
                    $texthomelink => $this->view->baseUrl('/'),
                    $this->_destTitle => $this->view->url(array(
                                'language' => $langLocale,
                                'destId' => $this->_destId,
                                'destTitle' => $this->_formatDestTitle,
                                'action' => 'index'), 'dest-action', true),
                    $this->view->translate('id_review') =>
                            $this->view->url(array(
                                'language' => $langLocale,
                                'destId' => $this->_destId,
                                'destTitle' => $this->_formatDestTitle,
                                'action' => 'index'), 'dest-review', true),
                    $pageTitle => ''
        );
        Zend_Registry::set('breadcrumb', $links);
    }

    /**
     * IS: Parameter action terdeklarasi
     * FS: -
     * Desc: Fungsi untuk redirect ke halaman list review
     */
    private function _redirectToReview($action, $reviewId = 1)
    {
        switch($this->_languageId)
        {
            case 1: $langLocale = 'en'; break;
            case 2: $langLocale = 'id'; break;
        }
        if($action == 'index') {
            $this->_redirector->setGotoRoute(array(
                'language' => $langLocale,
                'destId' => $this->_destId,
                'destTitle' => $this->_formatDestTitle,
                'action' => 'index'), 'dest-review', true);
        } elseif($action == 'detail') {
            echo $this->_destId . '-edan';
             $this->_redirector->setGotoRoute(array(
                'language' => $langLocale,
                'destId' => $this->_destId,
                'destTitle' => $this->_formatDestTitle,
                'reviewId' => $reviewId,
                'action' => 'detail'), 'dest-review', true);
        }
    }
}