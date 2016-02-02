<?php

/**
 * ArticleController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - attraction
 */
class Admin_ArticleController
        extends Library_Controller_Backend
{
  /**
   * IS: -
   * FS: -
   * Desc: Inisiasi fungsi parent
   */
  public function init()
  {
    parent::init();
    $this->view->image_dir_type = 2;
  }

  /**
   * IS: Terdeklarasinya filter dan param di session, dan page_row
   * FS: Mengirimkan ke viewer: cleanUrl, message, filter_alert, page_row,
   *     paginator
   * Desc: Mengatur aksi yang dilakukan untuk halaman index
   */
  public function indexAction()
  {
    //variable initiation and instance creation
    $this->view->cleanurl = $this->_cleanUrl;

    //get messages from CRUD process
    $message = $this->_flash->getMessages();
    if (!empty($message)) {
      $this->view->message = $message;
    }

    //create table instances
    $table_article = new Model_DbTable_Article;
    /*     * $tes = new Model_DbTable_ArticleDescription();
      $es= $tes->checkDescIndo(33);
      print_r($es);
     *///set variable initial value
    $filter        = null;
    $new_search    = FALSE;

    //get params for the filter
    if ($this->getRequest()->isPost()) {
      $filter                        = $_POST['filterPage'];
      $new_search                    = TRUE;
      $this->_paginator_sess->filter = $filter;
      switch ($filter) {
        case 0 : $param                        = null;
        case 1 : $param                        = $this->_getParam('filterTitle');
          break;
        case 2 : $param                        = $this->_getParam('filterPoi');
          break;
      }
      $this->_paginator_sess->param = $param;
    }

    //get the params from session and create paginator
    $filter = $this->_paginator_sess->filter;
    $param  = $this->_paginator_sess->param;

    /** Return alert to view on filter selected */
    switch ($filter) {
      case 0 : $filter_alert      = "Show all attractions";
        break;
      case 1 : $filter_alert      = "Attractions which title with keyword '"
                . $param . "'";
        break;
      case 2 : $filter_alert      = "Attractions that related to '" . $param
                . "'";
        break;
    }
    $this->view->alert = $filter_alert;

    $select = $table_article->getQueryAllByLang(
            $filter, $param, 1,
            $this->_userInfo->canApprove ? null :
                    $this->_userInfo->id
    );

    //get pagerow setting and send to the paginator control
    $page_row        = $this->_getParam('filterPageRow');
    $this->view->row = $page_row;

    if ($page_row != null) {
      $paginator = parent::setPaginator($select, $page_row);
    } else {
      $paginator = parent::setPaginator($select);
    }

    //if this is a new search then return the page number back to the 1st page
    if ($new_search) {
      $paginator->setCurrentPageNumber(1);
    }

    $this->view->userCanApprove = $this->_userInfo->canApprove;
    $this->view->paginator      = $paginator;
  }

  /**
   * IS: -
   * FS: Mengirimkan ke viewer: form
   * Desc: Mengatur aksi yang dilakukan untuk halaman create
   */
  public function createAction()
  {
    $form = new Admin_Form_ArticleForm(array('languageId' => 1));
    $form->draft->setLabel('Draft');

    $table_article                    = new Model_DbTable_Article;
    $table_article_description        = new Model_DbTable_ArticleDescription;
    $table_related_article_attraction = new Model_DbTable_RelatedArticleAttraction();

    if ($this->_userInfo->canApprove) {
      $form->submit->setLabel('Publish');
    } else {
      $form->submit->setLabel('Submit for review');
    }

    if ($this->getRequest()->isPost()) {
      if ($form->isValid($_POST)) {
        if ($_POST['ArticleMainImage'] == '') {
          $this->_flash->addMessage('3\Warning: Data is saved without image!');
        }
        //if theres an image uploaded
        else {
          $main_image = preg_replace("/'/", "&#39;",
                                     $_POST['ArticleMainImage']);
        }

        $status = Model_DbTable_Article::DRAFT;
        if ($this->getRequest()->getPost('action') == "Publish"
                || $this->getRequest()->getPost('action') == "Submit for review") {
          if ($this->_userInfo->canApprove) {
            $status = Model_DbTable_Article::PUBLISH;
          } else {
            $status = Model_DbTable_Article::PENDING;
          }
        }

        $data = array(
            'status'     => $status,
            'main_image' => $main_image,
            'sort_order' => $_POST['articleSortOrder'],
            'category'   => $_POST['category'],
            'created_by' => $this->_userInfo->id,
            'created_at' => date("Y-m-d H:i:s")
        );

        $article_id = $table_article->insertArticle($data);

        if (!empty($article_id)) {
          $title   = preg_replace("/'/", "&#39;",
                                  $_POST['ArticleTitle']);
          $content = preg_replace("/'/", "&#39;",
                                  $_POST['ArticleContent']);

          $data = array(
              'article_id'  => $article_id,
              'language_id' => 1,
              'title'       => $title,
              'content'     => $content,
          );
          $table_article_description->insertArticleDescription($data);

          /* inserting to related_article_poi */
          //counter related article poi
          $counter = $_POST['counterRelated'];

          for ($i = 1; $i <= $counter; $i++) {
            if (!empty($_POST['label' . $i]) AND !empty($_POST['link' . $i])) {
              $data = array('article_id'  => $article_id,
                  'label'       => $_POST['label' . $i],
                  'link'        => $_POST['link' . $i],
                  'language_id' => 1,
              );
              //insert into table
              $table_related_article_attraction->insertRelated($data);
            }
          }

          $this->loggingaction('Article', 'create', $article_id);
          $this->_flash->addMessage('1\Article Insert Success!');
        } else {
          $this->_flash->addMessage('2\Article Insert Failed!');
        }
        $this->_redirect($this->view->rootUrl('/admin/article/'));
      }
    }
    $this->view->languageID = 1;
    $this->view->form       = $form;
  }

  /**
   * IS: Parameter id terdeklarasi
   * FS: Mengirimkan ke viewer: form, rel_poi, poi_id
   * Desc: Mengatur aksi yang dilakukan untuk halaman edit
   */
  public function editAction()
  {
    $langId = $this->_getParam('lang');
    //print_r($langId);
    $form   = new Admin_Form_ArticleForm(array(
                'languageId' => 1
            ));

    $form->draft->setLabel('Draft');
    if ($this->_userInfo->canApprove) {
      $form->submit->setLabel('Update');
    } else {
      $form->submit->setLabel('Update for review');
    }

    $table_article                    = new Model_DbTable_Article;
    $table_article_description        = new Model_DbTable_ArticleDescription;
    $article_id                       = $this->_getParam('id');
    $table_related_article_attraction = new Model_DbTable_RelatedArticleAttraction();


    /* set form element value */
    if ($this->getRequest()->isPost()) {
      if ($form->isValid($_POST)) {
        $title   = preg_replace("/'/", "&#39;", $_POST['ArticleTitle']);
        $content = preg_replace("/'/", "&#39;",
                                $_POST['ArticleContent']);

        if ($langId != 1) {
          $indo = $table_article_description->checkForIndo($article_id);
          if ($indo == null) {
            $data = array(
                'article_id'  => $article_id,
                'language_id' => $langId,
                'title'       => $title,
                'content'     => $content,
            );
            $table_article_description->insertArticleDescription($data);
          } else {
            $data = array(
                'article_id'  => $article_id,
                'language_id' => 2,
                'title'       => $title,
                'content'     => $content,
            );
            $table_article_description->updateArticleDescription($data,
                                                                 $article_id,
                                                                 $langId);
          }
        } else {
          if ($_POST['ArticleMainImage'] == '') {
            $this->_flash->addMessage('3\Warning: Data is saved without image!');
          }
          //if theres an image uploaded
          else {
            $main_image = preg_replace("/'/", "&#39;",
                                       $_POST['ArticleMainImage']);
          }

          $status = Model_DbTable_Article::DRAFT;
          if ($this->getRequest()->getPost('action') == 'Update'
                  || $this->getRequest()->getPost('action') == 'Update for review') {
            if ($this->_userInfo->canApprove) {
              $status = Model_DbTable_Article::PUBLISH;
            } else {
              $status = Model_DbTable_Article::PENDING;
            }
          }

          $data = array(
              'status'     => $status,
              'main_image' => $main_image,
              'sort_order' => $_POST['articleSortOrder'],
              'category'   => $_POST['category'],
              'updated_by' => $this->_userInfo->id,
              'updated_at' => date('Y-m-d H:i:s')
          );
          $table_article->updateArticle($data, $article_id);

          $data = array(
              'article_id'  => $article_id,
              'language_id' => 1,
              'title'       => $title,
              'content'     => $content,
          );
          $table_article_description->updateArticleDescription($data,
                                                               $article_id,
                                                               $langId);
        }

        //$this->_helper->layout()->disableLayout();
        //$this->_helper->viewRenderer->setNoRender(true);

        /* update related article */
        //param
        // this part add related
        if ($_POST['counterRelated'] > 0) {
          $counter = $_POST['counterRelated'];
          for ($i = 1; $i <= $counter; $i++) {
            //echo $_POST['link'.$i];
            //cek existing label and link in database
            // if $cek having value = false, then data will be saved
            if (isset($_POST['label' . $i])) {
              $cek = $table_related_article_attraction->cek_existing($_POST['label' . $i],
                                                                     $_POST['link' . $i]);
              if (!$cek OR $cek == false) {
                $data = array('article_id'  => $article_id,
                    'label'       => $_POST['label' . $i],
                    'link'        => $_POST['link' . $i],
                    'language_id' => $language_id,
                );
                $table_related_article_attraction->insertRelated($data);
              }
            }
          }
        }


        //here part delete related, (if there are request)
        if ($_POST['counterDel'] > 0) {
          $counterDel = $_POST['counterDel'];

          for ($i = 1; $i <= $counterDel; $i++) {
            //cek existing label and link in database
            // if found, data will be removed
            if (isset($_POST['labeldel' . $i])) {
              $cek = $table_related_article_attraction->cek_existing_forDel($_POST['labeldel' . $i],
                                                                            $_POST['linkdel' . $i]);
            }
          }
        }

        $this->loggingaction('attraction', 'edit', $article_id);
        $this->_flash->addMessage('1\Article Update Success!');
        $this->_redirect($this->view->rootUrl('/admin/article/'));
      }
    }


    $new_translate = false;
    if ($langId != 1) {
      $indo = $table_article_description->checkForIndo($article_id);
      if ($indo) {
        $data = $table_article->getAllWithDescByLanguageId($article_id,
                                                           $langId);

        $form->article_poi_id->setValue($data['poi_id']);
        $form->article_status->setValue($data['status']);
        $form->articleSortOrder->setValue($data['sort_order']);
        $form->article_main_image->setValue($data['main_image']);
        $form->article_title->setValue(html_entity_decode($data['title']));
        $form->article_content->setValue(html_entity_decode($data['content']));
        $form->category_select->setValue($data['category']);
        $this->view->rel_poi = $data['poi_id'];
        $this->view->poi_id  = $data['poi_id'];
      }
    } else {
      $data = $table_article->getAllWithDescByLanguageId($article_id,
                                                         $langId);

      $form->article_poi_id->setValue($data['poi_id']);
      $form->article_status->setValue($data['status']);
      $form->articleSortOrder->setValue($data['sort_order']);
      $form->article_main_image->setValue($data['main_image']);
      $form->article_title->setValue(html_entity_decode($data['title']));
      $form->article_content->setValue($data['content']);
      $form->category_select->setValue($data['category']);
      $this->view->rel_poi = $data['poi_id'];
      $this->view->poi_id  = $data['poi_id'];
    }

    //get realated article data
    // @param =  article_id
    $ralated_article             = $table_related_article_attraction->getByArticleId($article_id,
                                                                                     $langId);
    $this->view->edit            = 1;
    $this->view->ralated_article = $ralated_article;
    $this->view->article_id      = $article_id;


    $this->view->languageID = 2;

    $this->view->form      = $form;
    $this->view->langid_id = $langId;
  }

  public function actionrelatedAction()
  {
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);

    //model
    $table_related_article_attraction = new Model_DbTable_RelatedArticleAttraction();

    $action = $_POST['action'];
    if ($action == "add") {
      
    } elseif ($action == "delete") {
      $data['result'] = $table_related_article_attraction->delRelated($_POST['related_id']);
    }

    echo json_encode($data);
  }

  public function cekAction()
  {
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);

    $table_related_article_attraction = new Model_DbTable_RelatedArticleAttraction();
    $ralated_article                  = $table_related_article_attraction->getByArticleId2(68);

    //print_r($ralated_article);

    $label   = "bandungs";
    $link    = "http://www.c.com.indo";
    $counter = 1;
    foreach ($ralated_article as $key => $row) {
      //if (!in_array($row['label'], $os)) {
      //    echo $value;
      //    
      //    //$key = array_search($value, $os);
      //    //array_splice($os, $key,1);
      //}

      if ($row['label'] == $label AND $row['link'] == $link) {
        //echo 'ada';
        break;
      } else {
        if ($counter <= 1) {
          echo 'ga';
          $counter++;
        }
        //echo $key;
        //break;
      }
      //echo $row['link'] .'<br />';
    }






    $link = array('http://www.c.com', 'http://www.c.com.indo');
    $label = array('a', 'bbb');

    //$res_db = count($ralated_article);
    //
        //$data = array("bandung","cimahi");
    //$data2 = array("http://www.c.com.indo","http://www.c.com.net");
    //foreach($ralated_article as $row)
    //{
    //    //if (in_array($row->label, $data) AND in_array($row->link, $data2)) {
    //    //    //echo $row->label .' - ';
    //    //    //echo $row->link.'<br />';
    //    //    
    //    //}
    //}
    //
        //$os = array("Mac", "NT", "Irix", "Linux");
    //
        //$b = array("Mac","Ubuntu");
    ////
    //foreach($b as $key=>$value)
    //{
    //    if (!in_array($value, $os)) {
    //        echo $value;
    //        
    //        //$key = array_search($value, $os);
    //        //array_splice($os, $key,1);
    //    }
    //    
    //}
    //print_r($os);
  }

  /**
   * IS: Nama file terdeklarasi
   * FS: File extention terdeklarasi
   * Desc: Mengembalikan file extention untuk berkas gambar
   */
  protected function get_file_extension($file_name)
  {
    return substr(strrchr($file_name, '.'), 1);
  }

  /**
   * IS: -
   * FS: -
   * Desc: Mengembalikan file-file dari direktori tertentu
   */
  protected function get_files($images_dir,
                               $exts = array('jpg', 'jpeg', 'png', 'gif'))
  {
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
  public function imagebrowserAction()
  {
    $this->_helper->layout()->disableLayout();
    $page = $this->_getParam('page');
    if (!isset($page)) {
      $page           = 0;
    }
    $limit          = 20;
    $images_dir     = UPLOAD_FOLDER . 'article/';
    $thumbs_width   = 200;
    $images_per_row = 3;
    $image_files    = $this->get_files($images_dir);

    if (count($image_files)) {
      $start = $page * 15;
      $top   = $start + 15;
      for ($i = $start; $i < $top; $i++) {
        $source_url     = $this->view->serverUrl() . $this->view->imageUrl('/upload/poi/' . $image_files[$i]);
        $thumbnails_url = $this->view->serverUrl() . $this->view->imageUrl('/upload/poi/thumbnails/' . $image_files[$i]);
        echo '<div class="photo-link smoothbox"><img width="100px" height="100px" src="' . $thumbnails_url . '" onclick="FileBrowserDialogue.mySubmit($(this));" /></div>';
      }
      if ($page > 0) {
        $prev = $page - 1;
        echo "<a style='float:left; margin-top: 30px;' href='" . $this->view->rootUrl("/admin/destination/imagebrowser/page/" . $prev) . "'>prev</a>";
      }

      $next = $page + 1;
      if ($next * 15 <= sizeof($image_files)) {
        echo "<br/><a style='float:left; margin-left:50px; margin-top: 30px;' href='" . $this->view->rootUrl("/admin/destination/imagebrowser/page/" . $next) . "'>next</a><br/>";
      }
    } else {
      echo '<p>There are no images in this gallery.</p>';
    }
  }

  public function approveAction()
  {
    $this->_helper->viewRenderer->setNoRender(true);
    if ($this->_userInfo->canApprove) {
      $id      = $this->_getParam('id');
      $dbTable = new Model_DbTable_Article();
      $dbTable->fetchRow("article_id = {$id}")->setFromArray(array(
          "status" => Model_DbTable_Article::PUBLISH
      ))->save();
      $this->_helper->flashMessenger->addMessage("Approved successfully");
    }
    $this->_helper->redirector("index");
  }

  public function choosedirAction()
  {
    $this->_helper->viewRenderer->setNoRender(true);
  }

}