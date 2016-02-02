<?php

/**
 * ImageController
 *
 * Controller untuk melakukan fungsi2 yang berkaitan dengan
 * admin - image
 */
require_once 'Zend/Controller/Action.php';

class Admin_ImageController extends Library_Controller_Backend {

  /**
   * IS: 
   * FS: 
   * Desc: Inisiasi fungsi parent
   */
  public function init() {
    parent::init();
  }

  /**
   * IS: Terdeklarasinya filter dan param di session, dan page_row 
   * FS: Mengirimkan ke viewer: cleanUrl, message, filter_alert, page_row, 
   *     dan paginator
   * Desc: Mengatur aksi yang dilakukan untuk halaman index image
   */
  public function indexAction() {
    //variable initiation and instance creation
    $this->view->cleanurl = $this->_cleanUrl;

    $table_gallery = new Model_DbTable_Image;

    $message = $this->_flash->getMessages();
    if (!empty($message)) {
      $this->view->message = $message;
    }

    $filter = null;
    $new_search = FALSE;
    if ($this->getRequest()->isPost()) {
      $filter = $_POST['filterPage'];
      $this->_paginator_sess->imagefilter = $filter;
      $new_search = TRUE;
      switch ($filter) {
        case 0 : $param = null;
          break;
        case 1 : $param = $_POST['filterTitle'];
          break;
        case 2 : $param = $_POST['filterPoi'];
          break;
      }
      $this->_paginator_sess->param = $param;
    }
    $filter = $this->_paginator_sess->imagefilter;
    $param = $this->_paginator_sess->param;

    /** Return alert to view on filter selected */
    switch ($filter) {
      case 0 : $filter_alert = "Show all images";
        break;
      case 1 : $filter_alert = "Images which name with keyword '" . $param
                . "'";
        break;
      case 2 : $filter_alert = "Images that related to '" . $param . "'";
        break;
    }
    $this->view->alert = $filter_alert;

    $select = $table_gallery->getQueryAllByLang($filter, $param);

    //get pagerow setting and send to the paginator control
    $page_row = $this->_getParam('filterPageRow');
    $this->view->row = $page_row;

    if ($page_row != null) {
      $paginator = parent::setPaginator($select, $page_row);
    } else {
      $paginator = parent::setPaginator($select);
    }

    if ($new_search) {
      $paginator->setCurrentPageNumber(1);
    }
    $this->view->paginator = $paginator;
  }

  /**
   * IS: -
   * FS: Mengirimkan ke viewer: form
   * Desc: Mengatur aksi yang dilakukan untuk halaman upload
   */
  public function uploadAction() {
    $form = new Admin_Form_ImageForm;
    $image_upload = FALSE;
    if ($this->getRequest()->isPost()) {
      if ($form->isValid($_POST)) {
        $uploaddir = UPLOAD_FOLDER . $_POST['ImageSelect'] . '/';
        $thumbdir = $uploaddir . 'thumbnails/';
        $uploadfile = $uploaddir . basename($_FILES['ImageUpload']['name']);
        $ext = array('jpg', 'png', 'gif', 'jpeg');
        $extensions = $this->get_file_extension($_FILES['ImageUpload']['name']);
        if (!file_exists($uploadfile)) {
          if ($_FILES['ImageUpload']['size'] <= 2000000) {
            if (in_array(strtolower($extensions), $ext)) {
              if (move_uploaded_file($_FILES['ImageUpload']['tmp_name'], $uploadfile)) {
                $this->_flash->addMessage("1\Image successfully uploaded to " . $_POST['ImageSelect'] . " directory!");
                $thumbfile = $thumbdir . basename($_FILES['ImageUpload']['name']);
                $this->make_thumb($uploadfile, $thumbfile, 150, 130, strtolower($extensions));
                $image_upload = TRUE;
              } else {
                $this->_flash->addMessage("2\Image Upload Failed!");
              }
            } else {
              $this->_flash->addMessage("2\Image Upload Failed! Extensions Error!");
            }
          } else {
            $this->_flash->addMessage("2\Image Upload Failed! Image Size Limit Exceeded!");
          }
        } else {
          $this->_flash->addMessage("2\Image Upload Failed! Image with that Name Already Exists!");
        }

        if ($image_upload == TRUE) {
          switch ($_POST['ImageSelect']) {
            case 'culture' : $image_type = 1;
              break;
            case 'news' : $image_type = 4;
              break;
          }
          $table_gallery = new Model_DbTable_Image;
          $input = array(
              'poi_id' => $_POST['poivalue'],
              'name' => $_POST['ImageName'],
              'source' => $_FILES['ImageUpload']['name'],
              'type' => $image_type
          );
          $gallery_id = $table_gallery->insertImage($input);
          $input = array(
              'gallery_id' => $gallery_id,
              'language_id' => 1,
              'name_language' => $_POST['ImageName'],
              'desc_language' => $_POST['ImageDescription'],
          );
          $table_gallerydesc = new Model_DbTable_ImageDescription;
          $table_gallerydesc->insertImageDescription($input);
          $this->loggingaction('image', 'create', $gallery_id);
          $this->_flash->addMessage('1\Image Insert Success!');
        } else {
          $this->_flash->addMessage('2\Image Insert Failed!');
        }
      }
      $this->_redirect($this->view->rootUrl('/admin/image/'));
    }
    $this->view->form = $form;
  }

  /**
   * IS: Parameter id terdeklarasi
   * FS: Mengirimkan ke viewer: form, poi_id, image
   * Desc: Mengatur aksi yang dilakukan untuk halaman edit
   */
  public function editAction() {
    $form = new Admin_Form_ImageForm;
    $gallery_id = $this->_getParam('id');
    $tableImage = new Model_DbTable_Image;
    $tableImageDescription = new Model_DbTable_ImageDescription;
    $this->view->state_edit = TRUE;

    if ($this->getRequest()->isPost()) {
      if ($form->isValid($_POST)) {
        $old_source = $tableImage->getImageSource($gallery_id);
        $old_type = $tableImage->getImageType($gallery_id);

        switch ($_POST['ImageSelect']) {
          case 'poi' : $new_type = 1;
            break;
          case 'news' : $new_type = 2;
            break;
        }

        switch ($old_type) {
          case 1: $old_dir = 'culture';
            break;
          case 4: $old_dir = 'news';
            break;
        }

        $image_upload = FALSE;
        $olduploaddir = UPLOAD_FOLDER . $old_dir . '/';
        $uploaddir = UPLOAD_FOLDER . $_POST['ImageSelect'] . '/';
        $oldthumbdir = $olduploaddir . 'thumbnails/';
        $thumbdir = $uploaddir . 'thumbnails/';
        $uploadfile = $uploaddir . basename($_FILES['ImageUpload']['name']);
        $ext = array('jpg', 'png', 'gif', 'jpeg');
        $extensions = $this->get_file_extension($_FILES['ImageUpload']['name']);
        $update_status = TRUE;
        if ($_FILES['ImageUpload']['name'] != '') {
          if (!file_exists($uploadfile)) {
            if ($_FILES['ImageUpload']['size'] <= 2000000) {
              if (in_array(strtolower($extensions), $ext)) {
                if (move_uploaded_file($_FILES['ImageUpload']['tmp_name'], $uploadfile)) {
                  $this->_flash->addMessage("1\Image successfully uploaded to " . $_POST['ImageSelect'] . " directory!");
                  $image_upload = TRUE;
                  $thumbfile = $thumbdir . basename($_FILES['ImageUpload']['name']);
                  $this->make_thumb($uploadfile, $thumbfile, 150, 130, strtolower($extensions));
                  if ($old_source != basename($_FILES['ImageUpload']['name'])) {
                    if (file_exists($uploaddir . $old_source)) {
                      unlink($uploaddir . $old_source);
                      unlink($uploaddir . '/thumbnails/' . $old_source);
                    }
                  }
                } else {
                  $this->_flash->addMessage("2\Image Upload Failed!");
                  $update_status = FALSE;
                }
              } else {
                $this->_flash->addMessage("2\Image Upload Failed! Extensions Error!, Update Canceled");
                $update_status = FALSE;
              }
            } else {
              $this->_flash->addMessage("2\Image Upload Failed! Image Size Limit Exceeded, Update Canceled");
              $update_status = FALSE;
            }
          } else {
            $this->_flash->addMessage("2\Image Upload Failed! Image with that Name Already Exists!, Update Canceled");
            $update_status = FALSE;
          }
        } else {
          if ($old_type != $new_type) {
            $uploadfile = $uploaddir . $old_source;
            $olduploadfile = $olduploaddir . $old_source;
            if (!file_exists($uploadfile)) {
              $thumbfile = $thumbdir . $old_source;
              $oldthumbfile = $oldthumbdir . $old_source;
              rename($olduploadfile, $uploadfile);
              rename($oldthumbfile, $thumbfile);
            } else {
              $this->_flash->addMessage("2\Image Upload Failed! Image with that Name Already Exists!");
            }
          }
        }

        switch ($_POST['ImageSelect']) {
          case 'culture' : $image_type = 1;
            break;
          case 'news' : $image_type = 2;
            break;
        }

        $table_gallery = new Model_DbTable_Image;

        if ($update_status) {
          if ($_FILES['ImageUpload']['name'] != '') {
            $new_image = $_FILES['ImageUpload']['name'];
          } else {
            $new_image = $old_source;
          }

          $input = array(
              'poi_id' => $_POST['poivalue'],
              'name' => $_POST['ImageName'],
              'source' => $new_image,
              'type' => $image_type
          );
          $table_gallery->updateImage($input, $gallery_id);
          $input = array(
              'gallery_id' => $gallery_id,
              'language_id' => 1,
              'name_language' => $_POST['ImageName'],
              'desc_language' => $_POST['ImageDescription'],
          );
          $table_gallerydesc = new Model_DbTable_ImageDescription;
          $table_gallerydesc->updateImageDescription($input, $gallery_id);
          $this->loggingaction('image', 'edit', $gallery_id);
          $this->_flash->addMessage("1\Image Update Success!");
        }
      }
      $this->_redirect($this->view->rootUrl('/admin/image/'));
    }

    $data = $tableImage->getImageByIdLang($gallery_id);
    switch ($data['type']) {
      case 0 : $type_value = 'culture';
        break;
      case 1 : $type_value = 'culture';
        break;
      case 2 : $type_value = 'news';
        break;
    }

    if ($data['poi_id'] > 0) {
      $poi_name = $this->view->poiName($data['poi_id']);
    }
    $form->image_name->setValue($data['name_language']);
    $form->image_poi->setValue($poi_name);
    $form->image_description->setValue($data['desc_language']);
    $form->image_type->setValue($type_value);
    $image = $this->view->imageUrl('/upload/' . $type_value . '/thumbnails/' . $data['source']);
    $this->view->poi_id = $data['poi_id'];
    $this->view->image = $image;
    $this->view->form = $form;
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
   * Desc: Mengatur aksi untuk membuat thumbnail
   */
  protected function make_thumb($src, $dest, $desired_width, $desired_height, $ext) {
    /* read the source image */
    if (($ext == 'jpg') || ($ext == 'jpeg')) {
      $source_image = imagecreatefromjpeg($src);
    } elseif ($ext == 'gif') {
      $source_image = imagecreatefromgif($src);
    } elseif ($ext == 'png') {
      $source_image = imagecreatefrompng($src);
    }

    $width = imagesx($source_image);
    $height = imagesy($source_image);
    /* find the "desired height" of this thumbnail, relative to the desired width  */
    //$desired_height = floor($height*($desired_width/$width));
    /* create a new, "virtual" image */
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
    /* copy source image at a resized size */
    imagecopyresized($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
    /* create the physical thumbnail image to its destination */

    if (($ext == 'jpg') || ($ext == 'jpeg')) {
      imagejpeg($virtual_image, $dest);
    } elseif ($ext == 'gif') {
      imagegif($virtual_image, $dest);
    } elseif ($ext == 'png') {
      imagepng($virtual_image, $dest);
    }
  }

}

