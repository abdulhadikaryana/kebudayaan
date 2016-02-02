<?php

/**
 * DestinationController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - destination
 */

require_once 'Zend/Controller/Action.php';



class Admin_DestinationController extends Library_Controller_Backend
{
  /**
   *
   * @var Model_DbTable_CultureVideo 
   */
  protected $table_cultureVideo;

  /**
   *
   * @var Zend_Session_Namespace
   */

  protected $filter;



  /**
   * IS: -
   * FS: -
   * Desc: Inisiasi fungsi parent
   */

  public function init()

  {

    $this->filter = new Zend_Session_Namespace('filter');

    parent::init();

  }



  /**
   * IS: Terdeklarasinya filter dan param di session, dan page_row
   * FS: Mengirimkan ke viewer: cleanUrl, message, page_row, paginator,
   *     all_area, all_category, filter_alert
   * Desc: Mengatur aksi yang dilakukan untuk halaman index
   */

  public function indexAction()
  {

    $tbl = new Model_DbTable_Destination();

    $tbl_categories = new Model_DbTable_Category();

    $pageNumber = $this->_getParam('page');

    if ($this->getRequest()->isPost()) {

      $post = $this->getRequest()->getPost();

      switch ($post['action']) {

        case 'delete':

          $cultures = $post['cultures'];

          foreach ($cultures as $id) {

            $culture = $tbl->find($id)->current();

            if (null != $culture) {

              if ($culture->status != 0) {

                $culture->setFromArray(array('status' => 0))->save();

                $this->loggingaction('Culture', 'Archive', $id, 1);

              } else {

//                $culture->delete();

//                $this->loggingaction('Culture', 'Delete', $id, 1);

              }

            }

          }

          $this->_helper->flashMessenger->

                  addMessage('Item kebudayaan berhasil dihapus.');

          break;

        case 'filter':

          $this->filter->culture = $post['filter'];

          break;

        case 'reset':

          $this->filter->unsetAll();

          break;



        case 'sort':

          $this->filter->culture = $post['filter'];

          if ($this->filter->culture['order'] == 'ASC') $this->filter->culture['order'] = 'DESC';

          else $this->filter->culture['order'] = 'ASC';

          break;

        default:

          break;

      }

      $this->_helper->redirector("index");

    }



    $data = $tbl->findAllWithDescription(1, $this->filter->culture);

    $statusesCount = $tbl->findStatusesCount();



    if (!$this->_userInfo->canApprove) {

      $data = $tbl->findAllWithDescription(1, $this->filter->culture, $this->_userInfo->id);

      $statusesCount = $tbl->findStatusesCount($this->_userInfo->id);

    }



    $cultures = Zend_Paginator::factory($data);

    $cultures->setItemCountPerPage(5);

    $cultures->setCurrentPageNumber($pageNumber);



    if (isset($this->filter->culture['row'])) {

      $cultures->setItemCountPerPage($this->filter->culture['row']);

    }



    $categories = $tbl_categories->getCategories();

    array_unshift($categories, 'Tampilkan Semua');



    $messages = $this->_helper->flashMessenger->getMessages();

    $this->view->categories = $categories;

    $this->view->statusesCount = $statusesCount;

    $this->view->filter = $this->filter->culture;

    $this->view->userInfo = $this->_userInfo;

    $this->view->messages = $messages;

    $this->view->cultures = $cultures;

  }



  /**
   * IS: -
   * FS: Mengirimkan ke viewer: form, gkey
   * Desc: Mengatur aksi yang dilakukan untuk halaman create
   */

  public function createAction()

  {

//Creating instances: form, table

    $form = new Admin_Form_PoiForm;

    $form->draft->setLabel('Simpan Sebagai Draft');

    if ($this->_userInfo->canApprove) {

      $form->submit->setLabel('Terbitkan');

    } else {

      $form->submit->setLabel('Simpan Untuk Pratinjau');

    }



    $table_destination = new Model_DbTable_Destination;

    $table_destination_description = new Model_DbTable_DestinationDescription;

    $table_categorytopoi = new Model_DbTable_CategoryToPoi;

    $table_areatopoi = new Model_DbTable_AreaToPoi;

    $table_relatedpoi = new Model_DbTable_RelatedPoi;

    $table_related_article_poi = new Model_DbTable_RelatedArticlePoi();

    $this->table_cultureVideo = new Model_DbTable_CultureVideo();

//

    if ($this->getRequest()->isPost()) {

      if ($form->isValid($_POST)) {



        $status = Model_DbTable_Destination::DRAFT;

        if (isset($_POST['Submit'])) {

          if ($this->_userInfo->canApprove) $status = Model_DbTable_Destination::PUBLISH;

          else $status = Model_DbTable_Destination::PENDING;

        } else {

          $status = Model_DbTable_Destination::DRAFT;

        }



        $featured = 0;

        if ($this->getRequest()->getPost('Featured')) {

          $featured = $this->getRequest()->getPost('Featured');

        }



        $culture = array(

            'pointX'        => (float) $_POST['pointx'],

            'pointY'        => (float) $_POST['pointy'],

            'main_category' => $_POST['MainCategory'],

            'status'        => $status,

            'featured'      => $featured

        );



        if ($form->header_image->isUploaded()) {

          $file = pathinfo($form->header_image->getFileName());

          $form->header_image->addFilter('Rename', UPLOAD_FOLDER

                  . 'culture/'

                  . $file['filename'] . '_'

                  . time() . '.'

                  . $file['extension']);

          if ($form->header_image->receive()) {

            $culture['image'] = $form->header_image->getValue();

          }

        }

        $culture_id = $table_destination->insertPoi($culture);









        if (!empty($culture_id)) {





          $culture_description = array(

              'language_id' => 1,

              'poi_id'      => $culture_id,

              'name'        => $_POST['Name'],

              'description' => $_POST['Description'],

              'created_by'  => $this->_userInfo->id,

              'created_at'  => date('Y-m-d H:i:s')

          );



          $culture_description_id = $table_destination_description->insertPoiDescription($culture_description);



          $category_count = $this->_getParam('MaxCategory');

          $category_stack = array();

          for ($i = 0; $i <= $category_count; $i++) {

            if (!empty($_POST['catValue' . $i])) {

              array_push($category_stack, $_POST['catValue' . $i]);

            }

          }



          /* inserting data for categorytopoi table */

          foreach ($category_stack as $cat_id) {

            $category_poi = array(

                'category_id' => $cat_id,

                'poi_id'      => $culture_id,

            );

            $table_categorytopoi->insertCategoryToPoi($category_poi);

          }



          /* Preparing area data for table insert

           * Get area count and data */

          $area_count = $this->_getParam('MaxArea');



          $area_stack = array();

          for ($i = 0; $i <= $area_count; $i++) {

            if (!empty($_POST['areaValue' . $i])) {

              array_push($area_stack, $_POST['areaValue' . $i]);

            }

          }



          /* inserting to areatopoi table */

          foreach ($area_stack as $area_id) {

            $area_poi = array(

                'area_id' => $area_id,

                'poi_id'  => $culture_id,

            );

            $table_areatopoi->insertAreaToPoi($area_poi);

          }



          $relCtr = $_POST['relPoi_counter'];

          for ($i = 0; $i <= $relCtr; $i++) {

            if (!empty($_POST['relpoi' . $i])) {

              $data = array(

                  'poi_id'      => $culture_id,

                  'related_poi' => $_POST['relpoi' . $i]

              );

              $table_relatedpoi->insertRelatedPoi($data);

            }

          }



//          $counter berisi jumlah related article (link)

          $counter = $_POST['counterRelated'];

          for ($i = 1; $i <= $counter; $i++) {



            if (!empty($_POST['label' . $i]) AND !empty($_POST['link' . $i])) {

              $data = array('poi_id'      => $culture_id,

                  'label'       => $_POST['label' . $i],

                  'link'        => $_POST['link' . $i],

                  'language_id' => 1,

              );

              $table_related_article_poi->insertRelated($data);

            }

          }



          $this->handleInsertVideoLink($culture_id);

          $upload_dir = UPLOAD_FOLDER . 'documents/';

          $upload_image_dir = UPLOAD_FOLDER . 'culture/';

          $upload = new Zend_File_Transfer_Adapter_Http();

          $table_galery = new Model_DbTable_Image;

          $table_file = new Model_DbTable_FileAttachments();

          $files = $upload->getFileInfo();

          $i = 0;

          $j = 0;

          foreach ($files as $file => $info) {

            $info['destination'] = $upload_image_dir;

            if (strstr($file, 'files')) {

              $file = array(

                  'poi_id' => $culture_id,

                  'title'  => $_POST['titles'][$i],

                  'name'   => $info['name'],

                  'size'   => $info['size']

              );

              $table_file->insert($file);



              $upload->setDestination($upload_dir);

              $i++;

            } else if (strstr($file, 'images')) {

              $image = array(

                  'poi_id' => $culture_id,

                  'source' => $info['name'],

                  'name'   => $_POST['imageTitles'][$j],

              );

              $table_galery->insert($image);

              $upload->setDestination($upload_image_dir);

              $j++;

            }

            $upload->receive($info['name']);

          }



          $this->loggingaction('Culture', 'Create', $culture_id, 1);

          $this->_flash->addMessage('Item kebudayaan berhasil ditambahkan.');

        } else {

          $this->_flash->addMessage('Item kebudayaan gagal ditambahkan.');

        }



        $this->_redirect($this->view->rootUrl('/admin/culture/'));

      }

    }



    $this->view->form = $form;

  }



  /**
   * IS: Parameter id terdeklarasi
   * FS: Mengirimkan ke viewer: poi_id, form, gkey, header_image
   * Desc: Mengatur aksi yang dilakukan untuk halaman edit
   */

  public function editAction()

  {

    $culture_id = $this->_getParam('id');

    $language_id = $this->_getParam('lang');



    $table_destination = new Model_DbTable_Destination;

    $table_destination_description = new Model_DbTable_DestinationDescription;

    $table_category = new Model_DbTable_Category;

    $table_categorytopoi = new Model_DbTable_CategoryToPoi;

    $table_areatopoi = new Model_DbTable_AreaToPoi;

    $table_relatedpoi = new Model_DbTable_RelatedPoi;

    $this->table_cultureVideo = new Model_DbTable_CultureVideo();

    $form = new Admin_Form_PoiForm();



    $culture = null;

    $table_file = new Model_DbTable_FileAttachments();

    $table_gallery = new Model_DbTable_Image();



    $table_related_article_poi = new Model_DbTable_RelatedArticlePoi();



// get realated article data

// untuk menampilkan related link pada destinasi yang bersangkutan

    $ralated_poi = $table_related_article_poi->getByPoiId($culture_id, $language_id);

    $cultureVideos = $this->table_cultureVideo->findByCultureId($culture_id);



    $this->view->ralated_poi = $ralated_poi;

    $this->view->poi_id = $culture_id;

    $this->view->ralated_news = $ralated_poi;

    $this->view->cultureVideos = $cultureVideos;

    $this->view->files = $table_file->getByPoiId($culture_id);

    $this->view->images = $table_gallery->getByPoiId($culture_id);



    /* Update Process */

    if ($this->getRequest()->isPost()) {



      if ($form->isValid($_POST)) {



        $status = Model_DbTable_Destination::DRAFT;

        if (isset($_POST['Submit'])) if ($this->_userInfo->canApprove) $status = Model_DbTable_Destination::PUBLISH;

          else $status = Model_DbTable_Destination::PENDING;



        $culture = array(

            'pointX'        => $_POST['pointx'],

            'pointY'        => $_POST['pointy'],

            'main_category' => $_POST['MainCategory'],

            'featured'      => $_POST['Featured'],

            'status'        => $status,

        );



        if ($form->header_image->isUploaded()) {

          $file = pathinfo($form->header_image->getFileName());

          $form->header_image->addFilter('Rename', UPLOAD_FOLDER 

                  . 'culture/' 

                  . $file['filename'] . '_' 

                  . time() . '.' 

                  . $file['extension']);

          if ($form->header_image->receive()) {

            $culture['image'] = $form->header_image->getValue();

          }

        }



        $table_destination->updatePoi($culture, $culture_id);



        $culture_description = array(

            'poi_id'      => $culture_id,

            'name'        => $_POST['Name'],

            'description' => $_POST['Description'],

            'updated_by'  => $this->_userInfo->id,

            'updated_at'  => Date('Y-m-d H:i:s'),

        );





        $table_destination_description->UpdatePoiDescription($culture_description, $culture_id, 1);



        /* preparing data for categorytopoi table

         * Get category count and data */

        $category_count = $this->_getParam('MaxCategory');

        $category_stack = array();

        for ($i = 0; $i <= $category_count; $i++) {

          if (!empty($_POST['catValue' . $i])) {

            array_push($category_stack, $_POST['catValue' . $i]);

          }

        }



        /* inserting data for categorytopoi table */

        $category_list = $table_categorytopoi->getCategoryIdByPoiId($culture_id);

        /* convert to non associative array */

        $saved_category = array();

        foreach ($category_list as $temp_cat) {

          array_push($saved_category, $temp_cat['category_id']);

        }



        /* processing the data

          if the posted data not found on saved category id list then insert the data */

        foreach ($category_stack as $category_new) {

          if (!in_array($category_new, $saved_category)) {

            $category_poi = array(

                'category_id' => $category_new,

                'poi_id'      => $culture_id,

            );

            $table_categorytopoi->insertCategoryToPoi($category_poi);

          }

        }



        /* complement check, if the data on saved category list not found on posted category

          then delete that data on the database */

        foreach ($saved_category as $old_category) {

          if (!in_array($old_category, $category_stack)) {

            $table_categorytopoi->deleteCategoryToPoi($old_category, $culture_id);

          }

        }



        /* We do it the same way for processing the area data

         * First, we obtain the data from the database and then convert it

         * to a non assoc. array */

        $areatopoi_list = $table_areatopoi->getPoiAreaId($culture_id);

        $saved_area = array();

        foreach ($areatopoi_list as $temp_area) {

          array_push($saved_area, $temp_area['area_id']);

        }



        /* Obtain the list of the new area data posted from the form */

        $area_count = $this->_getParam('MaxArea');

        $area_stack = array();

        for ($i = 0; $i <= $area_count; $i++) {

          if (!empty($_POST['areaValue' . $i])) {

            array_push($area_stack, $_POST['areaValue' . $i]);

          }

        }



        /* Compare the new area list with the old area list

         *  if its not in the old area list then insert to the database */

        foreach ($area_stack as $new_area) {

          if (!in_array($new_area, $saved_area)) {

            $area_poi = array(

                'area_id' => $new_area,

                'poi_id'  => $culture_id,

            );

            $table_areatopoi->insertAreaToPoi($area_poi);

          }

        }



        /* Now we do the complement action

         * compare the old list with the new list,

         * delete if not found on the new list */

        foreach ($saved_area as $old_area) {

          if (!in_array($old_area, $area_stack)) {

            $table_areatopoi->deleteAreaToPoi($old_area, $culture_id);

          }

        }



        /* related poi data processing */

        $relpoi_stack = array();

        $relCtr = $_POST['relPoi_counter'];

        for ($i = 0; $i <= $relCtr; $i++) {

          if (!empty($_POST['relpoi' . $i])) {

            array_push($relpoi_stack, $_POST['relpoi' . $i]);

          }

        }



        $saved_relpoi = $table_relatedpoi->getAllRelatedByPoiIdLangId($culture_id, $language_id);

        $old_relpoi = array();

        if (sizeof($saved_relpoi) > 0) {

          foreach ($saved_relpoi as $value) {

            array_push($old_relpoi, $value['related_poi']);

          }

        }



        foreach ($relpoi_stack as $value) {

          if (!in_array($value, $old_relpoi)) {

            $data = array(

                'poi_id'      => $culture_id,

                'related_poi' => $value,

            );

            $table_relatedpoi->insertRelatedPoi($data);

          }

        }



        foreach ($old_relpoi as $value) {

          if (!in_array($value, $relpoi_stack)) {

            $table_relatedpoi->deleteSpecificRelatedPoi($culture_id, $value);

          }

        }







////$this->_helper->layout()->disableLayout();

////$this->_helper->viewRenderer->setNoRender(true);                



        /* update related article */

// this part add related

        if ($_POST['counterRelated'] > 0) {

          $counter = $_POST['counterRelated'];

          for ($i = 1; $i <= $counter; $i++) {

//cek existing data ke database

// if jika data link dan label yang dikirim dari viwer

// blm ada di database, maka akan di simpan

            if (isset($_POST['label' . $i])) {

              $cek = $table_related_article_poi->cek_existing($_POST['label' . $i], $_POST['link' . $i]);

              if (!$cek OR $cek == false) {

                $data = array('poi_id'      => $culture_id,

                    'label'       => $_POST['label' . $i],

                    'link'        => $_POST['link' . $i],

                    'language_id' => $language_id

                );

                $table_related_article_poi->insertRelated($data);

              }

            }

          }

        }



        $this->handleInsertVideoLink($culture_id);





        $upload_dir = UPLOAD_FOLDER . 'documents/';

        $upload_image_dir = UPLOAD_FOLDER . 'culture/';

        $upload = new Zend_File_Transfer_Adapter_Http();

        $files = $upload->getFileInfo();

        $i = 0;

        $j = 0;

        echo "<pre>" . print_r($files, true) . "</pre>";

        foreach ($files as $file => $info) {

          $info['destination'] = $upload_image_dir;

          if (strstr($file, 'files')) {

            $file = array(

                'poi_id' => $culture_id,

                'title'  => $_POST['titles'][$i],

                'name'   => $info['name'],

                'size'   => $info['size']

            );

            $table_file->insert($file);

            $upload->setDestination($upload_dir);

            $i++;

          } else if (strstr($file, 'images')) {

            $image = array(

                'poi_id' => $culture_id,

                'source' => $info['name'],

                'name'   => $_POST['imageTitles'][$j],

            );

            $table_gallery->insert($image);

            $upload->setDestination($upload_image_dir);

            $j++;

          }

          $upload->receive($info['name']);

        }



        if (isset($_POST['existingFiles'])) {

          $existingFiles = $_POST['existingFiles'];

          foreach ($existingFiles as $id => $file) {

            $data = array(

                'title' => $file['title']

            );

            $table_file->update($data, "id = $id");

          }

        }



        if (isset($_POST['existingImages'])) {

          $existingImages = $_POST['existingImages'];

          foreach ($existingImages as $id => $image) {

            $data = array(

                'name' => $image['name']

            );

            $table_gallery->update($data, "gallery_id = $id");

          }

        }



// part untuk menghapus data dari database

// bagian ini akan dijalankan apabila ada triger hapus

// delete dari viewer

        if ($_POST['counterDel'] > 0) {

          $counterDel = $_POST['counterDel'];



          for ($i = 1; $i <= $counterDel; $i++) {

//cek existing label and link in database

// if found, data will be removed

            if (isset($_POST['labeldel' . $i])) {

              $cek = $table_related_article_poi->cek_existing_forDel($_POST['labeldel' . $i], $_POST['linkdel' . $i]);

            }

          }

        }



//Send a success message via flashmessenger

        $this->loggingaction('destination', 'edit', $culture_id, $language_id);

        $this->_flash->addMessage('Sunting Kebudayaan Berhasil!');

//redirect to the destination list page

        $this->_redirect($this->view->rootUrl('/admin/culture/'));

      }

    }



    /* load data from the database preparing for view process */



    if (!$this->_userInfo->canApprove) {

      $form->submit->setLabel('Sunting Untuk Pratinjau');

      $form->draft->setLabel('Jadikan Sebagai Draft');

    } else {

      $form->submit->setLabel('Sunting');

    }





    if ($language_id == 1) {

      $culture = $table_destination->getAllByIdLang($culture_id, $language_id, false);

      $parent_category = $table_category->getparentCategoryId($culture['main_category']);

      $parent_area = $table_areatopoi->getPoiAreaId($culture_id);

      $related_poi = $table_relatedpoi->getAllRelatedByPoiIdLangId($culture_id, $language_id);

    } else {

      $indo = $table_destination_description->checkForIndo($culture_id);

      if ($indo) {

        $culture = $table_destination->getAllByIdLang($culture_id, $language_id);

      }

    }





    $checkSpecial = $table_destination->checkDestSpecialById($culture_id);

    $this->view->destSpecial = $checkSpecial;

//    $tesheader               = $table_destination_description->getheaderimagebyid2($culture_id, $language_id);



    if ($culture != null) {

      $form->name->setValue($this->view->HtmlDecode($culture['name']));

      $form->description->setValue($this->view->HtmlDecode($culture['description']));

      $form->Poi_x->setValue($culture['pointX']);

      $form->Poi_y->setValue($culture['pointY']);

      $form->featured->setChecked($culture['featured']);



      $this->view->header_image = $table_destination->find($culture_id)->current()->image;

    }



    /* check if this is a special destination, if it is, then checkbox value to true */

//    if ($table_destination->checkSpecialDestination($poi_id)) {

//      $form->SpecialDestination->setChecked(true);

//      $this->view->state_special = TRUE;

//    } else {

//      $form->SpecialDestination->setChecked(false);

//      $this->view->state_special = FALSE;

//    }



    /* send data image filename to the view */

//    /* set another value to the form element */

    $area_amount = $table_areatopoi->countAreaByPoiId($culture_id);

    $category_amount = $table_categorytopoi->countCategoryByPoiId($culture_id);

    $main_category = $table_destination->getMainCategoryById($culture_id);

    $form->Category_counter->setValue($category_amount);

    $form->Count_category->setValue($category_amount);

    $form->Main_category->setValue($main_category['main_category']);

    $form->Area_counter->setValue($area_amount);

    $form->Count_area->setValue($area_amount);



    /* send form to view class */

    $this->view->userCanApprove = $this->_userInfo->canApprove;

    $this->view->poi_id = $culture_id;

    $this->view->form = $form;

    $this->view->language_id = $language_id;

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

  protected function get_files($images_dir, $exts = array('jpg', 'jpeg', 'png', 'gif'))

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
   * FS: Mengirimkan ke viewer: image_files, page
   * Desc: Mengatur aksi yang dilakukan untuk image browser
   */

  public function imagebrowserAction()

  {

    $page = $this->_getParam('page');

    if (!isset($page)) {

      $page = 0;

    }

    $limit = 20;

    $this->_helper->layout()->disableLayout();

    $images_dir = UPLOAD_FOLDER . 'culture/';

    $thumbs_width = 200;

    $images_per_row = 3;

    $image_files = $this->get_files($images_dir);

    $this->view->image_files = $image_files;

    $this->view->page = $page;

  }



  protected function handleInsertVideoLink($poi_id)

  {

    if (isset($_POST['videos'])) {

      $videos = $_POST['videos'];

      $videos = array_combine($videos['title'], $videos['link']);

      foreach ($videos as $title => $link) {

        $data = array(

            'poi_id' => $poi_id,

            'title'  => $title,

            'link'   => $link

        );

        $this->table_cultureVideo->insert($data);

      }

    }

  }



  public function approveAction()

  {

    $this->_helper->viewRenderer->setNoRender();

    if ($this->_userInfo->canApprove) {

      $id = $this->getRequest()->getParam('id');

      if (null != $id) {

        $tbl_culture = new Model_DbTable_Destination();

        $tbl_culture->update(array(

            'status'      => Model_DbTable_Destination::PUBLISH,

            'approved_by' => $this->_userInfo->id,

            'approved_at' => date('Y-m-d H:i:s')

                ), "Poi_id = {$id}");

        $this->loggingaction('Culture', 'Approve', $id, 1);

        $this->_flash->addMessage('Berhasil disetujui');

      }

    }

    $this->_redirect($this->view->rootUrl('/admin/culture/'));

  }



  public function translateAction()

  {

    $culture_id = $this->_getParam('id');

    $form = new Form_TranslateForm();



    if ($this->getRequest()->isPost()) {

      if ($form->isValid($this->getRequest()->getPost())) {



        $post = $this->getRequest()->getPost();

        $table = new Model_DbTable_DestinationDescription();

        $data = array(

            'poi_id'      => $culture_id,

            'language_id' => 2,

            'name'        => $post['Name'],

            'description' => $post['Description'],

            'created_by'  => $this->_userInfo->id,

            'created_at'  => date('Y-m-d H:i:s'),

        );



        $table->insertPoiDescription($data);

        $this->loggingaction('Culture', 'Create', $culture_id, 2);

        $this->_flashMessenger->addMessage('Translasi Berhasil Dibuat.');

      }

      $this->_helper->redirector('index');

    }



    $this->view->form = $form;

  }



  public function edittranslationAction()

  {

    $form = new Form_TranslateForm();

    $desc = new Model_DbTable_DestinationDescription();

    $id = $this->_getParam('id');

    $description = $desc->getDescriptionById($id, 2);



    if ($this->getRequest()->isPost()) {

      $post = $this->getRequest()->getPost();

      if ($form->isValid($post)) {

        $data = array(

            'name'        => $post['Name'],

            'description' => $post['Description'],

            'updated_by'  => $this->_userInfo->id,

            'updated_at'  => date('Y-m-d H:i:s'),

        );

        $desc->updatePoiDescription($data, $id, 2);

        $this->loggingaction('Culture', 'Edit', $id, 2);

        $this->_flashMessenger->addMessage('Translation updated successfully');

      }

      $this->_helper->redirector('index');

    }





    $form->name->setValue($description['name']);

    $form->description->setValue($description['description']);

    $this->view->form = $form;

  }



  public function deleteAction()

  {

    $id = $this->_getParam('id');

    if (null != $id) {

      $tbl = new Model_DbTable_Destination();

      $culture = $tbl->find($id)->current();

      if (null != $culture) {

        if ($culture->status != 0) {

          $culture->setFromArray(array('status' => 0))->save();

          $this->loggingaction('Culture', 'Archive', $id, 1);

          $this->_helper->flashMessenger->addMessage

                  ('Kebudayaan dipindahkan ke arsip.');

        } else {

//          $culture->delete();

//          $this->loggingaction('Culture', 'Delete', $id, 1);

//          $this->_helper->flashMessenger->addMessage

//                  ('Berhasil dihapus');

          $this->_helper->flashMessenger->addMessage

                  ('Maaf fitur ini belum tersedia.');

        }

      }

    }

    $this->_helper->redirector('index');

  }



  public function deletetranslationAction()

  {

    $this->_helper->viewRenderer->setNoRender();

    $id = $this->_getParam('id');

    if (null != $id) {

      $tbl = new Model_DbTable_Destination();

      $tbl_description = new Model_DbTable_DestinationDescription;

      $culture = $tbl->find($id)->current();

      if (null != $culture) {

        $tbl_description->fetchRow(array(

            'poi_id = ?'      => $id,

            'language_id = ?' => 2))->delete();

        $this->loggingaction('Culture', 'Delete', $id, 2);

        $this->_helper->flashMessenger->addMessage('Translasi berhasil dihapus.');

      }

    }

    $this->_helper->redirector('index');

  }



}