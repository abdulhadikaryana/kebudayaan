<?php

/**
 * NewsController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - news
 */
require_once 'Zend/Controller/Action.php';

class Admin_NewsController extends Library_Controller_Backend {

  /**
   * IS: -
   * FS: -
   * Desc: Inisiasi fungsi parent
   */
  public function init() {
    parent::init();
    $this->view->image_dir_type = 6;
  }

  /**
   * IS: Terdeklarasinya filter dan param di session, dan page_row
   * FS: Mengirimkan ke viewer: cleanUrl, message, filter_alert, page_row,
   *     year_list, dan paginator
   * Desc: Mengatur aksi yang dilakukan untuk halaman index news
   */
  public function indexAction() {
    /** Send this page url to the view */
    $this->view->cleanurl = $this->_cleanUrl;

//        notifikasi berhasil
    /** Get messages from CRUD process */
    $message = $this->_flash->getMessages();
    if (!empty($message)) {
      $this->view->message = $message;
    }

    /** Create table instance */
    $table_news     = new Model_DbTable_News;
    $table_category = new Model_DbTable_Category;

    /** Set the variable initial value */
    $filter     = null;
    $new_search = FALSE;

    /** Get the filter params */
    if ($this->getRequest()->isPost()) {
      $param_month                   = null;
      $filter                        = $_POST['filterPage'];
      /** If new search is commited then we set the $new_search to TRUE */
      $new_search                    = TRUE;
      $this->_paginator_sess->filter = $filter;
      switch ($filter) {
        case 0 : $param                        = null;
          break;
        case 1 : $param                        = $_POST['filterTitle'];
          break;
        case 2 : $param                        = $_POST['filterPoi'];
          break;
        case 3 : $param                        = $_POST['filterYear'];
          $param_month                  = $this->_getParam('filterMonth');
          break;
        case 4 : $param                        = $_POST['filterStatus'];
          break;
      }
      $this->_paginator_sess->param = $param;
      if ($param_month != null) {
        $this->_paginator_sess->param_month = $param_month;
      }
    }

    /** Get the params from session and create paginator */
    $filter      = $this->_paginator_sess->filter;
    $param       = $this->_paginator_sess->param;
    $param_month = $this->_paginator_sess->param_month;

    /** Return alert to view on filter selected */
    switch ($filter) {
      case 0 : $filter_alert      = "Show all news";
        break;
      case 1 : $filter_alert      = "News which title with keyword '" . $param
                . "'";
        break;
      case 2 : $filter_alert      = "News that related to '" . $param . "'";
        break;
      case 3 : $filter_alert      = "News that published on "
                . strftime("%B", strtotime($param_month . "/29/1985"))
                . " " . $param . "";
        break;
      case 4 :
        $filter_alert      = "News with '" . ucfirstfirst(strtolower($param)) . "' status";
        break;
    }
    $this->view->alert = $filter_alert;

    $select =
            $table_news->getQueryAllByLanguage($filter, $param, $param_month, 1, $this->_userInfo->canApprove ? null : $this->_userInfo->id);

    /** Get page row setting and send to the paginator control */
    $page_row        = $this->_getParam('filterPageRow');
    $this->view->row = $page_row;

    if ($page_row != null) {
      $paginator = parent::setPaginator($select, $page_row);
    } else {
      $paginator = parent::setPaginator($select);
    }

    /**
     * If this is a new search
     * then return the page number back to the 1st page
     */
    if ($new_search) {
      $paginator->setCurrentPageNumber(1);
    }

    /** Send data to the view */
    $this->view->userCanApprove = $this->_userInfo->canApprove;
    $this->view->year_list      = $table_news->getPublishYear();
    $this->view->paginator      = $paginator;
//        $category_data = $table_category->getAllWithDescByIdLang(1);
//        $this->view->all_category = $category_data;
  }

  /**
   * IS: -
   * FS: Mengirimkan ke viewer: form
   * Desc: Mengatur aksi yang dilakukan untuk halaman create
   */
  public function createAction() {
    $language_id                = 1;
    $form                       = new Admin_Form_NewsForm;
    $table_news                 = new Model_DbTable_News;
    $table_newsDesc             = new Model_DbTable_NewsDesc;
    $table_PoiToNews            = new Model_DbTable_PoiToNews;
    $table_related_article_news = new Model_DbTable_RelatedArticleNews;

    if ($this->_userInfo->canApprove) {
      $form->submit->setLabel('Publish');
    } else {
      $form->submit->setLabel('Submit for review');
    }

    if ($this->getRequest()->isPost()) {
      if ($form->isValid($_POST)) {

        /** Preparing the date insert */
        $tUnixTime          = time();
        date_default_timezone_set('Asia/Jakarta');
        $GMTMySqlString     = date("Y-m-d H:i:s", $tUnixTime);
        $GMTMySqlTimeString = date("H:i:s", $tUnixTime);
        $publish_date       =
                $_POST['newsPublishDate'] . ' ' . $GMTMySqlTimeString;

        $status = Model_DbTable_News::DRAFT;
        if ($this->getRequest()->getPost('action') == 'Publish'
                || $this->getRequest()->getPost('action') == 'Submit for review') {
          if ($this->_userInfo->canApprove) {
            $status = Model_DbTable_News::PUBLISH;
          } else {
            $status = Model_DbTable_News::PENDING;
          }
        }

        $data = array(
            'news_date'    => $GMTMySqlString,
            'publish_date' => $publish_date,
            'status'       => $status,
            'created_by'   => $this->_userInfo->id,
        );

        if ($form->image->isUploaded()) {
          $form->image->setDestination(UPLOAD_FOLDER . 'news/');
          if ($form->image->receive()) {
            $data['picture'] = $form->image->getFileName('image', false);
          }
        }

        $news_id = $table_news->insertNews($data);

        if (!empty($news_id)) {
          $title   = preg_replace("/'/", "&#39;", $_POST['newsTitle']);
          $content = preg_replace("/'/", "&#39;", $_POST['newsContent']);

          $data = array(
              'news_id'     => $news_id,
              'language_id' => $language_id,
              'title'       => $title,
              'content'     => $content,
          );
          $table_newsDesc->insertNewsDescription($data);


          $poi_count = $_POST['PoiCounter'];
          $poi_stack = array();
          for ($i = 0; $i < $poi_count; $i++) {
            if (!empty($_POST['poiValue' . $i])) {
              array_push($poi_stack, $_POST['poiValue' . $i]);
            }
          }
          foreach ($poi_stack as $poi_id) {
            $data = array(
                'poi_id'  => $poi_id,
                'news_id' => $news_id,
            );
            $table_PoiToNews->insertPoiNews($data);
          }


          /* insert data to related_article_news */

          //$counter berisi jumlah related article (link)
          $counter = $_POST['counterRelated'];

          // kemudian lakukan penyimpanan data related article
          // sesuai dengan jumlah related article (link)
          // yg dikirimkand dari viewer
          for ($i = 1; $i <= $counter; $i++) {

            if (!empty($_POST['label' . $i]) AND !empty($_POST['link' . $i])) {
              $data = array('news_id'     => $news_id,
                  'label'       => $_POST['label' . $i],
                  'link'        => $_POST['link' . $i],
                  'language_id' => 1
              );
              //insert into table
              $table_related_article_news->insertRelated($data);
            }
          }

          $this->loggingaction('news', 'create', $news_id, $language_id);
          $this->_flash->addMessage("1\News Insert Success!");
        } else {
          $this->_flash->addMessage("2\News Insert Failed!");
        }
        $this->_redirect($this->view->rootUrl('/admin/news/'));
      }
    }
    $this->view->form = $form;
  }

  /**
   * IS: Parameter id terdeklarasi
   * FS: Mengirimkan ke viewer: form, image, require_image, news_id
   * Desc: Mengatur aksi yang dilakukan untuk halaman edit
   */
  public function editAction() {
    $language_id                = $this->_getParam('lang');
    $news_id                    = $this->_getParam('id');
    $form                       = new Admin_Form_NewsForm;
    $table_news                 = new Model_DbTable_News;
    $table_newsDesc             = new Model_DbTable_NewsDesc;
    $table_poitonews            = new Model_DbTable_PoiToNews;
    $table_related_article_news = new Model_DbTable_RelatedArticleNews;

    if ($this->_userInfo->canApprove) {
      $form->submit->setLabel('Update');
    } else {
      $form->submit->setLabel('Update for review');
    }

    // untuk menampilkan list related link article yang berhubungan dengan
    // content news
    $related_news = $table_related_article_news->getByNewsId($news_id, $language_id);

    $this->view->edit         = 1;
    $this->view->ralated_news = $related_news;
    $this->view->news_id      = $news_id;

    //echo count($related_news);

    if ($this->getRequest()->isPost()) {
      if ($form->isValid($_POST)) {

        $status = Model_DbTable_News::DRAFT;
        if ($this->getRequest()->getPost('action') == 'Update'
                || $this->getRequest()->getPost('action') == 'Update for review') {
          if ($this->_userInfo->canApprove) {
            $status = Model_DbTable_News::PUBLISH;
          } else {
            $status = Model_DbTable_News::PENDING;
          }
        }
        /** Preparing the date insert */
        if ($language_id != 1) {
          $indo = $table_newsDesc->checkForIndo($news_id);
          if ($indo) {
            $title   = preg_replace("/'/", "&#39;", $_POST['newsTitle']);
            $content = preg_replace("/'/", "&#39;", $_POST['newsContent']);

            $data = array(
                'news_id'     => $news_id,
                'language_id' => $language_id,
                'title'       => $title,
                'content'     => $content,
            );
            $table_newsDesc->updateNewsDescription($data, $news_id, $language_id);
          } else {
            $title   = preg_replace("/'/", "&#39;", $_POST['newsTitle']);
            $content = preg_replace("/'/", "&#39;", $_POST['newsContent']);

            $data = array(
                'news_id'     => $news_id,
                'language_id' => $language_id,
                'title'       => $title,
                'content'     => $content,
            );

            $table_newsDesc->insertNewsDescription($data);
          }
        } else {
          $tUnixTime          = time();
          date_default_timezone_set('Asia/Jakarta');
          $GMTMySqlString     = date("Y-m-d H:i:s", $tUnixTime);
          $GMTMySqlTimeString = date("H:i:s", $tUnixTime);
          $publish_date       = $_POST['newsPublishDate'] . ' ' . $GMTMySqlTimeString;

          $data = array(
              'updated_at' => $GMTMySqlString,
              'updated_by' => $this->_userInfo->id,
              'status'     => $status
          );

          if ($form->image->isUploaded()) {
            $form->image->setDestination(UPLOAD_FOLDER . 'news/');
            if ($form->image->receive()) {
              $data['picture'] = $form->image->getFileName('image', false);
            }
          }

          $table_news->updateNews($data, $news_id);

          $title   = preg_replace("/'/", "&#39;", $_POST['newsTitle']);
          $content = preg_replace("/'/", "&#39;", $_POST['newsContent']);

          $data = array(
              'title'   => $title,
              'content' => $content,
          );
          $table_newsDesc->updateNewsDescription($data, $news_id, $language_id);

          $poi_count = $_POST['PoiCounter'];
          $poi_stack = array();
          for ($i = 0; $i < $poi_count; $i++) {
            if (!empty($_POST['poiValue' . $i])) {
              array_push($poi_stack, $_POST['poiValue' . $i]);
            }
          }

          /**
           * Get related poi list from the database
           * and convert to a NON ASSOC Array
           */
          $poi_list  =
                  $table_poitonews->getAllPoiByNewsId($news_id, $language_id);
          $saved_poi = array();
          if (!empty($poi_list)) {
            foreach ($poi_list as $temp) {
              array_push($saved_poi, $temp['poi_id']);
            }
          }

          /**
           * Check from the post list, compare with saved poi;
           * if not exist then insert the new poi
           */
          foreach ($poi_stack as $poi_id) {
            if (!in_array($poi_id, $saved_poi)) {
              $data = array(
                  'poi_id'  => $poi_id,
                  'news_id' => $news_id,
              );
              $table_poitonews->insertPoiNews($data);
            }
          }

          /**
           * Do the complementary process,
           * if the old poi did not exist in the new list
           * then delete the old one
           */
          foreach ($saved_poi as $old_poi) {
            if (!in_array($old_poi, $poi_stack)) {
              $table_poitonews->deletePoiNews($news_id, $old_poi);
            }
          }
        }


        /* update related article */
        // this part add related
        if ($_POST['counterRelated'] > 0) {
          $counter = $_POST['counterRelated'];
          for ($i = 1; $i <= $counter; $i++) {
            //cek existing data ke database
            // if jika data link dan label yang dikirim dari viwer
            // blm ada di database, maka akan di simpan
            if (isset($_POST['label' . $i])) {
              $cek = $table_related_article_news->cek_existing($_POST['label' . $i], $_POST['link' . $i], $language_id);
              //print_r($cek);
              if (!$cek) {
                // echo $_POST['label'.$i];
                $data = array('news_id'     => $news_id,
                    'label'       => $_POST['label' . $i],
                    'link'        => $_POST['link' . $i],
                    'language_id' => $language_id,
                );

                $table_related_article_news->insertRelated($data);
              }
            }
          }
        }

        // part untuk menghapus data dari database
        // bagian inin akan dijalankan apabila ada request
        // delete dari viewer
        if ($_POST['counterDel'] > 0) {
          $counterDel = $_POST['counterDel'];

          for ($i = 1; $i <= $counterDel; $i++) {

            if (isset($_POST['labeldel' . $i])) {
              // cek terlebih dahulu ke database
              // jika data yang sesuai dengan data yg dikirmkan ada
              // maka lakukan penghapusan
              $cek = $table_related_article_news->cek_existing_forDel($_POST['labeldel' . $i], $_POST['linkdel' . $i], $language_id);
            }
          }
        }


        $this->loggingaction('news', 'edit', $news_id, $language_id);
        $this->_flash->addMessage("1\News Update Success!");
        $this->_redirect($this->view->rootUrl('/admin/news/'));
      }
    }


    //$this->_helper->layout->disableLayout(); /* disable layout */
    //$this->_helper->viewRenderer->setNoRender(true); /* supaya tidak render view */


    $image = $table_news->getPictureById($news_id);

    if ($image == '') {
      $this->view->require_image = TRUE;
    } else {
      $this->view->image = $image;
    }

    if ($language_id != 1) {
      $indo = $table_newsDesc->checkForIndo($news_id);
      if ($indo) {
        $data = $table_news->getAllWithDescById($news_id, $language_id);
      } else {
        $data = $table_news->getAllWithDescById($news_id, 1);
      }
    } else {
      $data = $table_news->getAllWithDescById($news_id, $language_id);
    }

    //print_r($data);
    //echo $data['publish_date']; 

    $news_count = $table_poitonews->countPoiNewsByNewsId($news_id);
    $date       = explode(' ', $data['publish_date']);


    if ($language_id == 1) {
      $form->newsTitle->setValue($data['title']);
      $form->newsContent->setValue($data['content']);
    }

    if ($language_id == 2) {
      $news = $table_news->getAllWithDescById($news_id, $language_id);
      if (isset($news)) {
        $form->newsTitle->setValue($news['title']);
        $form->newsContent->setValue($news['content']);
      }
    }

    $this->view->picture = $data['picture'];

    $form->newsPublishDate->setValue($date[0]);
    $form->PoiCounter->setValue($news_count);
    $this->view->langId  = $this->_getParam('lang');
    $this->view->form    = $form;
    $this->view->news_id = $news_id;
  }

  /**
   * IS: Nama file terdeklarasi
   * FS: File extention terdeklarasi
   * Desc: Mengembalikan file extention untuk berkas gambar
   */
  protected function get_file_extension($file_name) {
    return substr(strrchr($file_name, '.'), 1);
  }

  /**
   * IS: -
   * FS: -
   * Desc: Mengembalikan file-file dari direktori tertentu
   */
  protected function get_files($images_dir, $exts = array('jpg', 'jpeg', 'png', 'gif')) {
    $files = array();
    if ($handle = opendir($images_dir)) {
      while (false !== ($file = readdir($handle))) {
        $extension = strtolower($this->get_file_extension($file));
        if ($extension && in_array($extension, $exts)) {
          $files[] = $file;
        }
      }
      closedir($handle);
    }
    return $files;
  }

  /**
   * IS: Parameter page terdeklarasi
   * FS: -
   * Desc: Mengatur aksi yang dilakukan untuk image browser
   */
  public function imagebrowserAction() {
    $this->_helper->layout()->disableLayout();
    $page = $this->_getParam('page');
    if (!isset($page)) {
      $page           = 0;
    }
    $limit          = 20;
    $images_dir     = UPLOAD_FOLDER . 'news/';
    $thumbs_width   = 200;
    $images_per_row = 3;
    $image_files    = $this->get_files($images_dir);

    if (count($image_files)) {
      $start = $page * 15;
      $top   = $start + 15;
      for ($i = $start; $i < $top; $i++) {
        $source_url     = $this->view->serverUrl() . $this->view->imageUrl('/upload/news/')
                . $image_files[$i];
        $thumbnails_url = $this->view->serverUrl()
                . $this->view->imageUrl('/upload/news/thumbnails/')
                . $image_files[$i];
        echo '<div class="photo-link smoothbox"><img width="100px" height="100px" src="'
        . $thumbnails_url
        . '" onclick="FileBrowserDialogue.mySubmit($(this));" /></div>';
      }
      if ($page > 0) {
        $prev = $page - 1;
        echo "<a style='float:left; margin-top: 30px;' href='"
        . $this->view->rootUrl("/admin/news/imagebrowser/page/")
        . $prev . "'>prev</a>";
      }

      $next = $page + 1;
      if ($next * 15 <= sizeof($image_files)) {
        echo "<br/><a style='float:left; margin-left:50px; margin-top: 30px;' href='"
        . $this->view->rootUrl("/admin/news/imagebrowser/page/")
        . $next . "'>next</a><br/>";
      }
    } else {
      echo '<p>There are no images in this gallery.</p>';
    }
  }

  public function approveAction() {
    $this->_helper->viewRenderer->setNoRender(true);
    if ($this->_userInfo->canApprove) {
      $tbl_news = new Model_DbTable_News();
      $id       = $this->_getParam('id');
      $data     = array(
          "status" => Model_DbTable_News::PUBLISH
      );
      $tbl_news->fetchRow(array(
          "news_id = ?" => $id
      ))->setFromArray($data)->save();
      $this->_flashMessenger->addMessage('News approved successfully');
    }
    $this->_helper->redirector('index');
  }

}

?>