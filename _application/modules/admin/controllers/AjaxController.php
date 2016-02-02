<?php
/**
 * Ajax Controller
 *
 * Kelas Controller untuk melakukan fungsi2 yang berkaitan dengan
 * ajax di CMS admin
 */
require_once 'Zend/Controller/Action.php';

class Admin_AjaxController extends Library_Controller_Backend
{
  /**
   * IS: -
   * FS: -
   * Desc: Inisiasi fungsi parent
   */
  public function init()
  {
    parent::init();
    $this->_helper->layout()->disableLayout();
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function getallareapoiAction()
  {
    $this->getResponse()->setHeader('Content-Type', 'text/xml');
    $area_id = $this->_getParam('areaid');
    $current_poi = $this->_getParam('poiid');
    $language_id = $this->_getParam('language');

    if (!isset($language_id)) {
      $language_id = 1;
    }

    $table_areatopoi = new Model_DbTable_AreaToPoi;
    $poi_list = $table_areatopoi->getAllPoiByAreaId($area_id, $language_id, $current_poi, 8);
    foreach ($poi_list as $value) {
      $data[$value['poi_id']] = htmlspecialchars($value['name'], ENT_QUOTES);
    }
    $this->view->data = $data;
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function getrelatedpoiAction()
  {
    $this->getResponse()->setHeader('Content-Type', 'text/xml');
    $poi_id = $this->_getparam('poiid');
    $language_id = $this->_getParam('languageId');
    if (!isset($language_id)) {
      $language_id = 1;
    }
    $table_relatedpoi = new Model_DbTable_RelatedPoi;
    $poi_list = $table_relatedpoi->getAllRelatedByPoiIdLangId($poi_id, $language_id);
    if (sizeof($poi_list) > 0) {
      $this->view->data = $poi_list;
    }
  }

  public function getRelatedArticlesAction()
  {
    
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function parentcategoryselectAction()
  {
    $language_id = 1;
    $tablecategory = new Model_DbTable_Category;
    $data = $tablecategory->getAllParentIdNameForSelectByLangId($language_id, false, '', TRUE);
    $this->view->test = $data;
    $dom_index = $this->_getParam('index');
    $poi_id = $this->_getParam('poi');
    $type = $this->_getParam('type');
    if (isset($type)) {
      if ($type == 'list') {
        $Category = new Zend_Form_Element_Select('CategoryParent' . $poi_id, $data);
      } else {
        $Category = new Zend_Form_Element_Select('CategoryParent', $data);
      }
    } else {
      $Category = new Zend_Form_Element_Select('CategoryParent', $data);
    }
    $Category->setAttrib('onchange', 'getChildCategory($(this).val(),' . $poi_id . ',' . $dom_index . ');');
    $Category->removeDecorator('HtmlTag');
    $Category->removeDecorator('DtDdWrapper');
    $Category->removeDecorator('Label');
    $this->view->selectbox = $Category;
  }

  public function parentcategoryselectindoAction()
  {
    $language_id = 2;
    $tablecategory = new Model_DbTable_Category;
    $data = $tablecategory->getAllParentIdNameForSelectByLangIdIndo($language_id, false, '', TRUE);
    $this->view->test = $data;
    $dom_index = $this->_getParam('index');
    $poi_id = $this->_getParam('poi');
    $type = $this->_getParam('type');
    if (isset($type)) {
      if ($type == 'list') {
        $Category = new Zend_Form_Element_Select('CategoryParent' . $poi_id, $data);
      } else {
        $Category = new Zend_Form_Element_Select('CategoryParent', $data);
      }
    } else {
      $Category = new Zend_Form_Element_Select('CategoryParent', $data);
    }
    $Category->setAttrib('onchange', 'getChildCategory($(this).val(),' . $poi_id . ',' . $dom_index . ');');
    $Category->removeDecorator('HtmlTag');
    $Category->removeDecorator('DtDdWrapper');
    $Category->removeDecorator('Label');
    $this->view->selectbox = $Category;
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function childcategoryselectAction()
  {
    $language_id = 1;
    $cat_id = $this->_getParam('catid');
    $tablecategory = new Model_DbTable_Category;
    $data = $tablecategory->getAllChildIdNameByParentIdLangId($cat_id, $language_id);
    $type = $this->_getParam('type');
    if (isset($type)) {
      $poi_id = $this->_getParam('poi');
      $index = $this->_getParam('index');
      if ($type == 'list') {
        $this->view->list = TRUE;
        $Category = new Zend_Form_Element_Select('CategoryChild' . $poi_id, $data);
        $save_btn = new Zend_Form_Element_Button('SaveCategory' . $poi_id, 'save');
        $save_btn->setAttrib('onclick', 'saveCategory(' . $poi_id . ',$("#CategoryChild' . $poi_id . '").val(),' . $index . ');');
        $save_btn->removeDecorator('HtmlTag');
        $save_btn->removeDecorator('DtDdWrapper');
        $save_btn->removeDecorator('Label');
        $save_btn->setAttrib('class', 'btn radius');
        $this->view->savebutton = $save_btn;
        $cancel_btn = new Zend_Form_Element_Button('CancelCategory' . $poi_id, 'cancel');
        $cancel_btn->setAttrib('onclick', 'CancelCategory(' . $index . ',' . $poi_id . ',' . $index . ')');
        $cancel_btn->removeDecorator('HtmlTag');
        $cancel_btn->removeDecorator('DtDdWrapper');
        $cancel_btn->removeDecorator('Label');
        $cancel_btn->setAttrib('class', 'btn radius');
        $this->view->cancelbutton = $cancel_btn;
      } else {
        $this->view->list = FALSE;
      }
    } else {
      $Category = new Zend_Form_Element_Select('CategoryChild', $data);
    }
    $Category->removeDecorator('HtmlTag');
    $Category->removeDecorator('DtDdWrapper');
    $Category->removeDecorator('Label');
    $this->view->selectbox = $Category;
    $this->view->category_id = $cat_id;
  }

  public function childcategoryselectindoAction()
  {
    $language_id = 2;
    $cat_id = $this->_getParam('catid');
    $tablecategory = new Model_DbTable_Category;
    $data = $tablecategory->getAllChildIdNameByParentIdLangId($cat_id, $language_id);
    $type = $this->_getParam('type');
    if (isset($type)) {
      $poi_id = $this->_getParam('poi');
      $index = $this->_getParam('index');
      if ($type == 'list') {
        $this->view->list = TRUE;
        $Category = new Zend_Form_Element_Select('CategoryChild' . $poi_id, $data);
        $save_btn = new Zend_Form_Element_Button('SaveCategory' . $poi_id, 'save');
        $save_btn->setAttrib('onclick', 'saveCategory(' . $poi_id . ',$("#CategoryChild' . $poi_id . '").val(),' . $index . ');');
        $save_btn->removeDecorator('HtmlTag');
        $save_btn->removeDecorator('DtDdWrapper');
        $save_btn->removeDecorator('Label');
        $save_btn->setAttrib('class', 'btn radius');
        $this->view->savebutton = $save_btn;
        $cancel_btn = new Zend_Form_Element_Button('CancelCategory' . $poi_id, 'cancel');
        $cancel_btn->setAttrib('onclick', 'CancelCategory(' . $index . ',' . $poi_id . ',' . $index . ')');
        $cancel_btn->removeDecorator('HtmlTag');
        $cancel_btn->removeDecorator('DtDdWrapper');
        $cancel_btn->removeDecorator('Label');
        $cancel_btn->setAttrib('class', 'btn radius');
        $this->view->cancelbutton = $cancel_btn;
      } else {
        $this->view->list = FALSE;
      }
    } else {
      $Category = new Zend_Form_Element_Select('CategoryChild', $data);
    }
    $Category->removeDecorator('HtmlTag');
    $Category->removeDecorator('DtDdWrapper');
    $Category->removeDecorator('Label');
    $this->view->selectbox = $Category;
    $this->view->category_id = $cat_id;
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function savecategorypoiAction()
  {
    $cat_id = $this->_getParam('catid');
    $poi_id = $this->_getParam('poi');

    $input = array('category_id' => $cat_id, 'poi_id'      => $poi_id);

    $table_category = new Model_DbTable_CategoryToPoi;

    if ($table_category->checkPoiCatId($poi_id, $cat_id)) {
      $this->view->double_check = FALSE;
    } else {
      $this->view->double_check = TRUE;
      $cat_name = $table_category->insertCategoryToPoi($input);
      $this->loggingaction('destination', 'edit', $poi_id);
      $this->view->cat_name = $cat_name;
      $this->view->poi_id = $poi_id;
      $this->view->cat_id = $cat_id;
    }
  }

  public function savecategorypoiforindoAction()
  {
    $cat_id = $this->_getParam('catid');
    $poi_id = $this->_getParam('poi');

    $input = array('category_id' => $cat_id, 'poi_id'      => $poi_id);

    $table_category = new Model_DbTable_CategoryToPoi;

    if ($table_category->checkPoiCatId($poi_id, $cat_id)) {
      $this->view->double_check = FALSE;
    } else {
      $this->view->double_check = TRUE;
      $cat_name = $table_category->insertCategoryToPoi($input, 2);
      $this->loggingaction('destination', 'edit', $poi_id);
      $this->view->cat_name = $cat_name;
      $this->view->poi_id = $poi_id;
      $this->view->cat_id = $cat_id;
    }
  }

  public function savecategorypoiIndoAction()
  {
    $cat_id = $this->_getParam('catid');
    $poi_id = $this->_getParam('poi');

    $input = array('category_id' => $cat_id, 'poi_id'      => $poi_id);

    $table_category = new Model_DbTable_CategoryToPoi;

    if ($table_category->checkPoiCatId($poi_id, $cat_id)) {
      $this->view->double_check = FALSE;
    } else {
      $this->view->double_check = TRUE;
      $cat_name = $table_category->insertCategoryToPoi($input);
      $this->loggingaction('destination', 'edit', $poi_id);
      $this->view->cat_name = $cat_name;
      $this->view->poi_id = $poi_id;
      $this->view->cat_id = $cat_id;
    }
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function deletecategorypoiAction()
  {
    $cat_id = $this->_getParam('catid');
    $poi_id = $this->_getParam('poi');
    $table_category = new Model_DbTable_CategoryToPoi;
    $table_category->deleteCategoryToPoi($cat_id, $poi_id);
    $this->loggingaction('destination', 'edit', $poi_id);
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function childareaselectAction()
  {
    //get param
    $area_id = $_POST['areaid'];
    $area_level = $_POST['arealevel'];
    if (isset($_POST['langid'])) {
      $lang_id = $_POST['langid'];
    } else {
      $lang_id = 1;
    }


    $coverage_area = $this->_getParam('coveragearea');
    //set data for select options
    $tablearea = new Model_DbTable_Area;
    $data = $tablearea->setChildAreaForSelectElement($area_id, $lang_id);
    if (sizeof($data) > 0) {
      if (isset($coverage_area)) {
        if ($area_level == 0) {
          $elementName = 'ProvinceCoverOptions';
          $functions = 'getAreaCover(this.value,1);';
          $default_option = 'Select Province';
        } elseif ($area_level == 1) {
          $elementName = 'AreaCoverOptions';
          $default_option = 'Select Area';
          $functions = '';
        }
        $temp = array(0          => $default_option);
        $area_data = $temp + $data;
        $data = array("multiOptions" => $area_data);
        $area_child = new Zend_Form_Element_Select($elementName, $data);
      } else {
        //creating elements
        if ($area_level == 0) {
          $elementName = 'ProvinceListOptions';
          $functions = "getAreaList(this.value,1," . $lang_id . ");";
          $default_option = 'Select Province';
        } elseif ($area_level == 1) {
          $elementName = 'AreaListOptions';
          $default_option = 'Select Area';
          $functions = '';
        }
        $temp = array(0          => $default_option);
        $area_data = $temp + $data;
        $data = array("multiOptions"         => $area_data);
        $area_child = new Zend_Form_Element_Select($elementName, $data);
      }
      $area_child->removeDecorator('HtmlTag');
      $area_child->removeDecorator('DtDdWrapper');
      $area_child->removeDecorator('Label');
      if (!empty($functions)) $area_child->setAttrib('onchange', $functions);
      $this->view->selectbox = $area_child;
    }
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function destinationdataAction()
  {
    $type = $this->_getParam('type');
    $poi_id = $this->_getParam('poiid');
    $this->view->type = $type;

    /* preparing table instance */
    $table_categorytopoi = new Model_DbTable_CategoryToPoi;
    $table_category = new Model_DbTable_Category;
    $table_destination = new Model_DbTable_Destination;
    $table_areatopoi = new Model_DbTable_AreaToPoi;
    /* get the main category */
    if ($type == 'category') {
      $main_category = $table_destination->getMainCategoryById($poi_id);
      $category_data = $table_categorytopoi->getCategoryByPoiId($poi_id, 1);
      $this->view->category_data = $category_data;
      $this->view->main_category = $main_category;
    } elseif ($type == 'area') {
      $areatopoi_data = $table_areatopoi->getPoiAreaId($poi_id);
      $this->view->area_data = $areatopoi_data;
    } elseif ($type == 'pusharea') {
      $this->getResponse()->setHeader('Content-Type', 'text/xml');
      $areatopoi_data = $table_areatopoi->getPoiAreaId($poi_id);
      $this->view->area_data = $areatopoi_data;
    } elseif ($type == 'pushcategory') {
      $this->getResponse()->setHeader('Content-Type', 'text/xml');
      $category_data = $table_categorytopoi->getCategoryIdByPoiId($poi_id);
      $this->view->category_data = $category_data;
    }
  }

  public function destinationdataindoAction()
  {
    $type = $this->_getParam('type');
    $poi_id = $this->_getParam('poiid');
    $this->view->type = $type;

    /* preparing table instance */
    $table_categorytopoi = new Model_DbTable_CategoryToPoi;
    $table_category = new Model_DbTable_Category;
    $table_destination = new Model_DbTable_Destination;
    $table_areatopoi = new Model_DbTable_AreaToPoi;
    /* get the main category */
    if ($type == 'category') {
      $main_category = $table_destination->getMainCategoryById($poi_id);
      $category_data = $table_categorytopoi->getCategoryByPoiId($poi_id, 2);
      $this->view->category_data = $category_data;
      $this->view->main_category = $main_category;
    } elseif ($type == 'area') {
      $areatopoi_data = $table_areatopoi->getPoiAreaId($poi_id);
      $this->view->area_data = $areatopoi_data;
    } elseif ($type == 'pusharea') {
      $this->getResponse()->setHeader('Content-Type', 'text/xml');
      $areatopoi_data = $table_areatopoi->getPoiAreaId($poi_id);
      $this->view->area_data = $areatopoi_data;
    } elseif ($type == 'pushcategory') {
      $this->getResponse()->setHeader('Content-Type', 'text/xml');
      $category_data = $table_categorytopoi->getCategoryIdByPoiId($poi_id);
      $this->view->category_data = $category_data;
    }
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function arearelatedpoiAction()
  {
    $areaID = $this->_getParam('areaid');
    $type = $this->_getParam('type');
    $languageID = $this->_getParam('language');
    if (!isset($languageID)) {
      $languageID = 1;
    }
    $table_areatopoi = new Model_DbTable_AreaToPoi;
    $poi_list = $table_areatopoi->getAllPoiByAreaId($areaID, $languageID);

    if (!empty($poi_list)) {
      foreach ($poi_list as $poi_id => $poi_data) {
        $data[$poi_data['poi_id']] = htmlspecialchars_decode($poi_data['name'], ENT_QUOTES);
      }

      $temp = array(0         => 'select Destination');
      $poi_data = $temp + $data;
      $data = array("multiOptions" => $poi_data);
      $poi_select = new Zend_Form_Element_Select('SelectPoi', $data);
      $poi_select->removeDecorator('HtmlTag');
      $poi_select->removeDecorator('DtDdWrapper');
      $poi_select->removeDecorator('Label');
      if (empty($type)) {
        $poi_select->setAttrib('onchange', 'getPoiCord($(this).val());');
      }
      $this->view->poi_select = $poi_select;
    } else {
      $this->view->poi_select = 'No Related Destination Found';
    }
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function poicoordinateAction()
  {
    $this->getResponse()->setHeader('Content-Type', 'text/xml');
    $poi_id = $this->_getParam('poiid');
    $table_destination = new Model_DbTable_Destination;
    $cord = $table_destination->getPoiCoordinate($poi_id);
    $this->view->cord = $cord;
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function tourismdataAction()
  {
    $tourism_id = $this->_getParam('tourismid');
    $this->getResponse()->setHeader('Content-Type', 'text/xml');
    $table_classtotourism = new Model_DbTable_ClassificationToTourismOperator;
    $class_list = $table_classtotourism->getallClassIdNameByTourismId($tourism_id);
    $this->view->class_list = $class_list;
  }

 

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function poiautocompleteAction()
  {
    $languageId = $this->_getParam('languageID');
    if (!isset($languageId)) {
      $languageId = 1;
    }
    $query = $this->_getParam('q');
    $table_destination = new Model_DbTable_Destination;
    $query_result = $table_destination->getAllByName($query, $languageId);
    $this->view->result = $query_result;
  }

  public function poiautocompleteindo2Action()
  {
    $query = $this->_getParam('q');
    $table_destination = new Model_DbTable_Destination;
    $query_result = $table_destination->getAllByName($query, 2);
    $this->view->result = $query_result;
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function nameautocompleteAction()
  {
    $query = $this->_getParam('q');
    $table_admin = new Model_DbTable_AdminAccount;
    $query_result = $table_admin->getAllByName($query);
    $this->view->result = $query_result;
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function checkpoinameAction()
  {
    $poi_name = $this->_getParam('poiname');
    $poi_name = $poi_name[0];
    $table_destination = new Model_DbTable_Destination;
    if ($table_destination->checkIfPoiNameExist($poi_name) > 0) {
      $this->view->result = $table_destination->getPoiIdByName($poi_name);
    } else {
      $this->view->result = 'error';
    }
  }

  public function checkpoinameindoAction()
  {
    $poi_name = $this->_getParam('poiname');
    $poi_name = $poi_name[0];
    $table_destination = new Model_DbTable_Destination;
    if ($table_destination->checkIfPoiNameExist($poi_name, 2) > 0) {
      $this->view->result = $table_destination->getPoiIdByName($poi_name, 2);
    } else {
      $this->view->result = 'error';
    }
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function checkpoinameindo2Action()
  {
    $poi_name = $this->_getParam('poiname');
    $poi_name = $poi_name[0];
    $table_destination = new Model_DbTable_Destination;
    if ($table_destination->checkIfPoiNameExist($poi_name, 2) > 0) {
      $this->view->result = $table_destination->getPoiIdByName($poi_name, 2);
    } else {
      $this->view->result = 'error';
    }
    $this->render('checkpoiname');
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function newspoilistAction()
  {
    $this->getResponse()->setHeader('Content-Type', 'text/xml');
    $news_id = $this->_getParam('newsId');
    $table_newstopoi = new Model_DbTable_PoiToNews;
    $poi_list = $table_newstopoi->getAllPoiByNewsId($news_id);
    $this->view->poi_list = $poi_list;
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  /**
   * IS:
   * FS:
   * Desc:
   */
  protected function make_thumb($src, $dest, $desired_width, $desired_height, $ext)
  {
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

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function poirelatedeventAction()
  {
    $this->getResponse()->setHeader('Content-Type', 'text/xml');
    $event_id = $this->_getParam('eventid');
    $table_poitoevent = new Model_DbTable_PoiToEvent;
    $poi_list = $table_poitoevent->getAllPoiNameByEventId($event_id);
    $this->view->poi_list = $poi_list;
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function poirelatedeventIndoAction()
  {
    $this->getResponse()->setHeader('Content-Type', 'text/xml');
    $event_id = $this->_getParam('eventid');
    $table_poitoevent = new Model_DbTable_PoiToEvent;
    $poi_list = $table_poitoevent->getAllPoiNameByEventId($event_id);
    $this->view->poi_list = $poi_list;
    $this->render('poirelatedevent');
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  public function imagebrowserAction()
  {
    $this->_helper->layout()->disableLayout();
    $type = $this->_getParam('type');
    if ($type == 'destination') $type = 'culture';
    $folder = $type . '/';

    // Handle image upload or display list of image based on type
    if ($this->getRequest()->isPost()) {
      $this->_helper->viewRenderer->setNoRender();
      $ftp = new Zend_File_Transfer_Adapter_Http();
      $file = pathinfo($ftp->getFileName());
      $ftp->setDestination(UPLOAD_FOLDER . $folder);
      $ftp->addFilter('Rename', UPLOAD_FOLDER . $folder . '/'
              . $file['filename'] . '_'
              . rand(1, 100) .'_'
              . time() . '.'
              . $file['extension']);
      $ftp->addValidator(new Zend_Validate_File_Extension('jpg,png'));
      $ftp->receive();
    } else {
      $pageNumber = $this->_getParam('page');
      $images_dir = UPLOAD_FOLDER . $folder;
      $image_files = $this->get_files($images_dir);
      $root_files = array();
      foreach ($image_files as $index => $files) {
        $root_files[$index] = UPLOAD_FOLDER . $folder . $files;
      }
      array_multisort(
              array_map('filemtime', $root_files), SORT_NUMERIC, SORT_DESC, $image_files
      );
      $paginator = Zend_Paginator::factory($image_files);
      $paginator->setItemCountPerPage(12);
      $paginator->setCurrentPageNumber($pageNumber);
      $paginator->setPageRange(5);
      $this->view->paginator = $paginator;
      $this->view->folder = $folder;
    }
  }

  /**
   * IS:
   * FS:
   * Desc:
   */
  protected function get_file_extension($file_name)
  {
    return substr(strrchr($file_name, '.'), 1);
  }

  /**
   * IS:
   * FS:
   * Desc: returning files from directory if the extensions is okay
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

  /** Delete Action */
  /**
   * IS: Activity/category ada
   * FS: Activity/category tidak ada
   * Desc: Fungsi untuk menghapus activity/category dari basis data
   */
  public function deleteactivityAction()
  {
    $activity_id = $this->_getParam('activityid');
    $table_category = new Model_DbTable_Category;
    $table_category_desc = new Model_DbTable_CategoryDescription;
    $table_categorytopoi = new Model_DbTable_CategoryToPoi;
    $table_category_desc->deleteCategory($activity_id);
    $table_categorytopoi->deleteAllPoiByCategory($activity_id);
    $table_category->deleteCategory($activity_id);
    $this->loggingaction('activity', 'delete', $activity_id);
    $this->_flash->addMessage("1\Activity Delete Success!");
  }

  public function deleteactivity2Action()
  {
    $activity_id = $this->_getParam('activityid');
    $table_category = new Model_DbTable_Category;
    $table_category_desc = new Model_DbTable_CategoryDescription;
    $table_categorytopoi = new Model_DbTable_CategoryToPoi;
    $table_category_desc->deleteCategory2($activity_id);

    $this->loggingaction('activity', 'delete', $activity_id);
    $this->_flash->addMessage("1\Activity Indonesian Translation Delete Success!");
  }

  public function deleteactivityenglishAction()
  {
    $activity_id = $this->_getParam('activityid');
    $table_category = new Model_DbTable_Category;
    $table_category_desc = new Model_DbTable_CategoryDescription;
    $table_categorytopoi = new Model_DbTable_CategoryToPoi;
    $table_category_desc->deleteCategoryEnglish($activity_id);

    $this->loggingaction('activity', 'delete', $activity_id);
    $this->_flash->addMessage("1\Activity English Translation Delete Success!");
  }


  /**
   * IS: Contact ada
   * FS: Contact tidak ada
   * Desc: Fungsi untuk menghapus contact dari basis data
   */
  public function deletecontactAction()
  {
    $contactId = $this->_getParam('contact_id');
    $contact = new Model_DbTable_Contact();
    $contact->deleteContact($contactId);
    $this->loggingaction('contact', 'delete', $contactId);
    $this->_flash->addMessage("1\Delete Contact Success!");
  }

  /**
   * IS: Event ada
   * FS: Event tidak ada
   * Desc: Fungsi untuk menghapus event dari basis data
   */
  public function deleteeventAction()
  {
    $event_id = $this->_getParam('eventid');
    $table_event = new Model_DbTable_Event;
    $table_event_desc = new Model_DbTable_EventDesc;
    $table_poitoevent = new Model_DbTable_PoiToEvent;
//    $table_poitoevent->deleteAllEvent($event_id);
//    $table_event_desc->deleteEvent($event_id);
//    $table_event->deleteEvent($event_id);
    $table_event->update(array("status" => Model_DbTable_Event::ARCHIVED), "event_id = $event_id");
    $this->loggingaction('event', 'delete', $event_id);
    $this->_flash->addMessage("1\Event Archived!");
  }

  public function deleteevent2Action()
  {
    $event_id = $this->_getParam('eventid');
    $table_event = new Model_DbTable_Event;
    $table_event_desc = new Model_DbTable_EventDesc;
    $table_poitoevent = new Model_DbTable_PoiToEvent;

    $table_event_desc->deleteEvent2($event_id);
    $this->loggingaction('event', 'delete', $event_id);
    $this->_flash->addMessage("1\Event English Translation Delete Success!");
  }

  public function deleteeventenglishAction()
  {
    $event_id = $this->_getParam('eventid');
    $table_event = new Model_DbTable_Event;
    $table_event_desc = new Model_DbTable_EventDesc;
    $table_poitoevent = new Model_DbTable_PoiToEvent;

    $table_event_desc->deleteEvent2($event_id, 1);
    $this->loggingaction('event', 'delete', $event_id);
    $this->_flash->addMessage("1\Event Indonesian Translation Delete Success!");
  }

  public function adddatadestAction($ppp)
  {
    
  }

  /**
   * IS: Highlight ada
   * FS: Highlight tidak ada
   * Desc: Fungsi untuk menghapus highlight dari basis data
   */
  public function deletehighlightAction()
  {
    $highlight_id = $this->_getParam('highlightid');
    $table_highlight = new Model_DbTable_Highlight;
    $table_highlight_desc = new Model_DbTable_HighlightDescription;
    $table_highlight->deleteHighlight($highlight_id);
    $table_highlight_desc->deleteHighlight($highlight_id);
    $this->loggingaction('highlight', 'delete', $highlight_id);
    $this->_flash->addMessage("1\Highlight Delete Success!");
  }

  public function deletehighlight2Action()
  {
    $highlight_id = $this->_getParam('highlightid');
    $table_highlight = new Model_DbTable_Highlight;
    $table_highlight_desc = new Model_DbTable_HighlightDescription;
    $table_highlight_desc->deleteHighlight2($highlight_id);
    $this->loggingaction('highlight', 'delete', $highlight_id);
    $this->_flash->addMessage("1\Highlight Indonesian Translation Delete Success!");
  }

  public function deletehighlightenglishAction()
  {
    $highlight_id = $this->_getParam('highlightid');
    $table_highlight = new Model_DbTable_Highlight;
    $table_highlight_desc = new Model_DbTable_HighlightDescription;
    $table_highlight_desc->deleteHighlightenglish($highlight_id);
    $this->loggingaction('highlight', 'delete', $highlight_id);
    $this->_flash->addMessage("1\Highlight Indonesian Translation Delete Success!");
  }
  /**
   * IS: News ada
   * FS: News tidak ada
   * Desc: Fungsi untuk menghapus news dari basis data
   */
  public function deletenewsAction()
  {
    $news_id = $this->_getParam('newsid');
    $table_news = new Model_DbTable_News;
    $table_news_description = new Model_DbTable_NewsDesc;
    $table_poitonews = new Model_DbTable_PoiToNews;
    /* deleting data */
//    $table_poitonews->deleteAllPoiNewsByNewsId($news_id);
//    $table_news_description->deleteNewsDescription($news_id);
//    $table_news->deleteNews($news_id);

    $table_news->update(array('status' => 'ARCHIVED'), "news_id = $news_id");
    $this->loggingaction('news', 'delete', $news_id);
    $this->_flash->addMessage("1\News archived!");
  }

  public function deletenews2Action()
  {
    $news_id = $this->_getParam('newsid');
    $table_news = new Model_DbTable_News;
    $table_news_description = new Model_DbTable_NewsDesc;
    $table_poitonews = new Model_DbTable_PoiToNews;
    /* deleting data */

    $table_news_description->deleteNewsDescription2($news_id);
    $this->loggingaction('news', 'delete', $news_id);
    $this->_flash->addMessage("1\News Delete Success!");
  }

  public function deletenewsenglishAction()
  {
    $news_id = $this->_getParam('newsid');
    $table_news = new Model_DbTable_News;
    $table_news_description = new Model_DbTable_NewsDesc;
    $table_poitonews = new Model_DbTable_PoiToNews;
    /* deleting data */

    $table_news_description->deleteNewsDescription2($news_id, 1);
    $this->loggingaction('news', 'delete', $news_id);
    $this->_flash->addMessage("1\News Delete Success!");
  }


  /**
   * IS: Region ada
   * FS: Region tidak ada
   * Desc: Fungsi untuk menghapus region/area dari basis data
   */
  public function deleteareaAction()
  {
    $area_id = $this->_getParam('areaid');
    $table_area = new Model_DbTable_Area;
    $table_areaToPoi = new Model_DbTable_AreaToPoi;
    $table_region = new Model_DbTable_Regional;
    $table_areaToPoi->deleteAllPoiByAreaId($area_id);
    $table_region->deleteArea($area_id);
    $table_area->deleteArea($area_id);
    $this->loggingaction('region', 'delete', $area_id);
    $this->_flash->addMessage("1\Region Delete Success!");
  }

  /**
   * IS: Role ada
   * FS: Role tidak ada
   * Desc: Fungsi untuk menghapus role dari basis data
   */
  public function deleteroleAction()
  {
    $role_id = $this->_getParam('role_id');
    $table_role = new Model_DbTable_AdminRole;
    $table_role->deleteRole($role_id);
    $this->loggingaction('role', 'delete', $role_id);
    $this->_flash->addMessage("1\Role Delete Success!");
  }

  /**
   * IS: Status contact tanpa flag
   * FS: Status contact berubah menjadi dengan flag
   * Desc: Fungsi untuk mengganti status contact (flag/no flag)
   */
  public function updateflagcontactAction()
  {
    $newflag = '1';
    $contactId = $this->_getParam('contact_id');
    $contact = new Model_DbTable_Contact();
    $data = array('flag' => $newflag);
    $contact->updateContact($data, $contactId);
    $this->loggingaction('contact', 'edit', $contactId);
    $this->_flash->addMessage("1\Contact Change Flag Success!");
  }

  /**
   * IS: Status contact dengan flag
   * FS: Status contact berubah menjadi tanpa flag
   * Desc: Fungsi untuk mengganti status contact (flag/no flag)
   */
  public function updateflagcontact1Action()
  {
    $newflag = '0';
    $contactId = $this->_getParam('contact_id');
    $contact = new Model_DbTable_Contact();
    $data = array('flag' => $newflag);
    $contact->updateContact($data, $contactId);
    $this->loggingaction('contact', 'edit', $contactId);
    $this->_flash->addMessage("1\Contact Change Flag Success!");
  }

  /**
   * IS: Status highlight shown atau not shown
   * FS: Status highlight berubah dari shown menjadi not shown atau sebaliknya
   * Desc: Fungsi untuk mengganti status highlight (shown/not shown)
   */
  public function hideshowhighlightAction()
  {
    $language_id = 1;
    $highlight_id = $this->_getParam('highlightid');
    $table_highlight = new Model_DbTable_Highlight;
    $status = $table_highlight->getFlagById($highlight_id);
    if ($status == 1) {
      $new_status = 0;
    } elseif ($status == 0) {
      $new_status = 1;
    }
    $data = array('flag' => $new_status);
    $table_highlight->updateHighlight($data, $highlight_id, $language_id);
    if ($new_status == 1) {
      $this->view->message = 'shown';
    } elseif ($new_status == 0) {
      $this->view->message = 'not shown';
    }
    $this->loggingaction('highlight', 'change status', $highlight_id, $language_id);
  }

  /**
   * IS: Status news published atau draft
   * FS: Status news berubah dari published menjadi draft atau sebaliknya
   * Desc: Fungsi untuk mengganti status news (published/draft)
   */
  public function hideshownewsAction()
  {
    $news_id = $this->_getParam('newsid');
    $table_news = new Model_DbTable_News;
    $status = $table_news->getStatusById($news_id);
    if ($status == 1) {
      $new_status = 0;
    } elseif ($status == 0) {
      $new_status = 1;
    }
    $data = array('showing' => $new_status);
    $table_news->updateNews($data, $news_id);
    if ($new_status == 1) {
      $this->view->message = 'published';
    } elseif ($new_status == 0) {
      $this->view->message = 'draft';
    }
    $this->loggingaction('news', 'change status', $news_id);
    $this->_flash->addMessage("1\News Status Change Success!");
  }

  /**
   * IS: Parent area id
   * FS: Mengirim data ke view berupa list kabupaten/kotamadya dari sebuah propinsi
   * Desc: Membuat list kabupaten/kotamadya dari sebuah propinsi - digunakan pada coverage area
   */
  public function getprovincechildAction()
  {
    $this->getResponse()->setHeader('Content-Type', 'text/xml');
    $parent_id = $this->_getParam('areaid');
    $table_area = new Model_DbTable_Area;
    $child_list = $table_area->getAllAreaChildIdNameByParent($parent_id);
    $this->view->data = $child_list;
  }

  public function imageuploadAction()
  {
    $step = $this->_getParam('step');
    $type = $this->_getParam('type');
    if (!isset($step)) {
      $step = 0;
    }
    switch ($type) {
      case 1: $uploaddir = UPLOAD_FOLDER . 'poi/header/';
        break;
      case 2: $uploaddir = UPLOAD_FOLDER . 'article/';
        break;
      case 3: $uploaddir = UPLOAD_FOLDER . 'event/';
        break;
      case 4: $uploaddir = UPLOAD_FOLDER . 'highlight/';
        break;
      case 5: $uploaddir = UPLOAD_FOLDER . 'category/';
        break;
      case 6: $uploaddir = UPLOAD_FOLDER . 'news/';
        break;
      case 7: $uploaddir = UPLOAD_FOLDER . 'airlines/';
        break;
      case 8: $uploaddir = UPLOAD_FOLDER . 'photoessay/';
        break;
    }

    $uploadfile = $uploaddir . basename($_FILES['imageheader']['name']);
    $thumbdir = $uploaddir . 'thumbnails/';
    $thumbfile = $thumbdir . basename($_FILES['imageheader']['name']);
    $extensions = $this->get_file_extension($_FILES['imageheader']['name']);

    //step 0 -- Check image exist
    if ($step == 0) {
      if ($_FILES['imageheader']['name'] == '') {
        $error = 'please enter a valid image name!';
      } else {
        if ($_FILES['imageheader']['size'] > 2000000) {
          $error = 'image upload failed! Limit Exceeded';
        } else {
          //if file already exist then send a confirmation dialog
          if (file_exists($uploadfile)) {
            $this->view->overwrite_dialog = TRUE;
            $error = 'WARNING! Theres image with same name do you want to overwrite the old one?';
            $step = 1;
          } else {
            if (move_uploaded_file($_FILES['imageheader']['tmp_name'], $uploadfile)) {
              $this->make_thumb($uploadfile, $thumbfile, 150, 130, strtolower($extensions));
              $message = 'Image Upload is Succeed!';
              $image_name = $_FILES['imageheader']['name'];
              $step = 2;
            } else {
              $error = 'image upload failed!';
              $step = 1;
            }
          }
        }
      }
    } elseif ($step == 1) {
      if (move_uploaded_file($_FILES['imageheader']['tmp_name'], $uploadfile)) {
        $this->make_thumb($uploadfile, $thumbfile, 150, 130, strtolower($extensions));
        $message = 'Image Upload is Succeed!';
        $image_name = $_FILES['imageheader']['name'];
        $step = 2;
      } else {
        $error = 'image upload failed!';
        $step = 1;
      }
    }

    $this->view->step = $step;
    $this->view->message = $message;
    $this->view->error = $error;
    $this->view->image_dir = $image_name;
  }

  public function deleteexistingfileAction()
  {
    $this->_helper->viewRenderer->setNoRender();
    $upload_folder = UPLOAD_FOLDER . 'documents/';
    $id = $_POST['id'];
    $table_file = new Model_DbTable_FileAttachments();
    $file = $table_file->find($id)->current()->toArray();
    $file_path = realpath($upload_folder . $file['name']);
    if (file_exists($file_path)) {
      unlink($file_path);
    }
    $table_file->delete("id = $id");
  }

  public function deleteexistingimageAction()
  {
    $this->_helper->viewRenderer->setNoRender();
    $upload_folder = UPLOAD_FOLDER . 'culture/';
    $id = $_POST['id'];
    $table_image = new Model_DbTable_Image();
    $image = $table_image->find($id)->current()->toArray();
    $file_path = realpath($upload_folder . $image['source']);
    if (file_exists($file_path)) {
      unlink($file_path);
    }
    $table_image->delete("gallery_id = $id");
  }

  public function deletevideolinkAction()
  {
    $this->_helper->viewRenderer->setNoRender();
    if ($this->getRequest()->isPost()
            && $this->getRequest()->isXMLHttpRequest()
            && ($id = $_POST['id']) != null) {
      $dbtable_videolink = new Model_DbTable_CultureVideo();
      $videolink = $dbtable_videolink->find($id)->current();
      if (!empty($videolink)) {
        $where = array('id = ?' => $videolink['id']);
        $dbtable_videolink->delete($where);
      }
    }
  }

  public function subcategoryAction()
  {
    $this->_helper->viewRenderer->setNoRender(true);
    $id = $this->_getParam('id');
  }

  public function selectprovinceAction()
  {
    $this->_helper->viewRenderer->setNoRender(true);

    $tbl_area = new Model_DbTable_Area();
    $island_id = $this->_getParam('island_id');
    $provinces = $tbl_area->getProvinces($island_id);
    $default = array("Select Province");
    $provinces = $default + $provinces;
    $select = $this->view->formSelect('', '', array('id' => 'select-province'), $provinces);
    echo $select;
  }

  public function selectregionAction()
  {
    $this->_helper->viewRenderer->setNoRender(true);
    $tbl_area = new Model_DbTable_Area();
    $tbl_culture = new Model_DbTable_Destination();

    $tbl_area = new Model_DbTable_Area();
    $province_id = $this->_getParam('province_id');
    $regions = $tbl_area->getRegions($province_id);
    $default = array("Select Region");
    $regions = $default + $regions;
    $select = $this->view->formSelect('', '', array('id' => 'select-region'), $regions);
    echo $select;
  }

  public function getrelatedcultureAction()
  {
    $this->_helper->viewRenderer->setNoRender(true);

    $area_id = $this->_getParam('id');

    echo $area_id;
  }

  public function getcoordinateofareaAction()
  {
    $this->_helper->viewRenderer->setNoRender(true);

    $areaId = $this->_getParam('areaId');

    $tbl_area = new Model_DbTable_Area();
    $coordinate = $tbl_area->getCoordinateById($areaId);

    echo json_encode($coordinate[0]);
  }

  public function uploadcultureAction()
  {
    $this->_helper->viewRenderer->setNoRender();
    $ftp = new Zend_File_Transfer_Adapter_Http();
    $ftp->setDestination(UPLOAD_FOLDER . 'culture/');
    $ftp->receive();
  }

  public function uploadnewsAction()
  {
    $this->_helper->viewRenderer->setNoRender();
    $ftp = new Zend_File_Transfer_Adapter_Http();
    $ftp->setDestination(UPLOAD_FOLDER . 'news/');
    $ftp->receive();
  }

  public function uploadeventAction()
  {
    $this->_helper->viewRenderer->setNoRender();
    $ftp = new Zend_File_Transfer_Adapter_Http();
    $ftp->setDestination(UPLOAD_FOLDER . 'event/');
    $ftp->receive();
  }

}