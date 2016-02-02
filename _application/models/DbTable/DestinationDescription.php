<?php



/**

 * Model_DbTable_DestinationDescription

 *

 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan

 * tabel destination description

 *

 * @package model

 */

class Model_DbTable_DestinationDescription extends Zend_Db_Table_Abstract {



  //deklarasi tabel yang digunakan dalam model destinationdescription

  protected $_name        = 'poidescription';

  protected $_desti       = 'poi';

  protected $_cattopoi    = 'categorytopoi';

  protected $_area        = 'area';

  protected $_atp         = 'areatopoi';

  protected $_cat         = 'category';

  protected $_article     = 'article';

  protected $_gallery     = 'gallery';

  protected $_articledesc = 'articledescription';

  protected $_primary     = array('poi_id', 'language_id');

  protected $true  = "true";

  protected $false = "false";



  public function getheaderimagebyid2($id, $languageId) {

    $query = $this->select()

            ->from($this->_name, array('header_image'))

            ->where("poi_id = ?", $id)

            ->where('language_id = ?', $languageId);

    //echo $query->__toString();

    return $this->fetchRow($query);

  }



  /**

   * Fungsi untuk mengambil semua data dari tabel poidescription

   * @return array

   */

  public function getAll() {

    $data = $this->select()

            ->from($this->_name);

    return $this->fetchAll($data);

  }



  /**

   * Fungsi untuk mengambil semua data dari tabel poidescription berdasarkan

   * poi_id yang diberikan

   *

   * @param integer $poi_id

   * @return array

   */

  public function getAllById($poi_id) {

    $data = $this->select()

            ->from($this->_name)

            ->where('poi_id = ?', $poi_id);

    return $this->fetchAll($data);

  }



  /**

   * Fungsi untuk mengambil semua data dari tabel poidescription berdasarkan

   * language_id yang diberikan

   *

   * @param ineteger $lang_id

   * @return array

   */

  public function getAllByLanguage($lang_id) {

    $data = $this->select()

            ->from($this->_name)

            ->where('language_id = ?', $lang_id);

    return $this->fetchAll($data);

  }



  /**

   * Fungsi untuk mengambil semua data dari tabel poidescription berdasarkan

   * poi_id dan language_id yang diberikan

   *

   * @param integer $poi_id

   * @param integer $lang_id

   * @return array

   */

  public function getAllByIdLang($poiId, $langId) {

    $query = $this->select()

            ->from($this->_name)

            ->where('poi_id = ?', $poiId)

            ->where('language_id = ?', $langId);



    $report = $this->fetchRow($query);

    $return = $report->toArray();



    return $return;

  }



  /**

   * Fungsi untuk mengambil semua data dari tabel poidescription berdasarkan

   * name yang diberikan

   *

   * @param string $name

   * @return array

   */

  public function getAllByName($name) {

    $data = $this->select()

            ->from($this->_name)

            ->where("name LIKE '%" . $name . "%'");

    return $this->fetchAll($data);

  }



  /**

   * Fungsi untuk mengambil data description dari tabel poidescription berdasarkan

   * poi_id yang diberikan

   *

   * @param integer $poi_id

   * @return array

   */

  public function getDescriptionById($poi_id, $lang_id) {

    $data = $this->select()

            ->from($this->_name, array('name', 'description'))

            ->where('poi_id = ?', $poi_id)

            ->where('language_id = ?', $lang_id);

    $report = $this->fetchRow($data);

    $return = $report->toArray();

    return $return;

  }



  /**

   * Fungsi untuk mengambil data whereToStay dari tabel poidescription

   * berdasarkan poi_id dan language_id yang diberikan

   * @param integer $poi_id

   * @param integer $lang_id

   * @return array

   */

  public function getWhereToStayByIdLang($poi_id, $lang_id) {

    $sql = $this->select()

            ->from($this->_name, array('whereToStay'))

            ->where('poi_id = ?', $poi_id)

            ->where('language_id = ?', $lang_id);

    $data = $this->fetchRow($sql);



    return $data['whereToStay'];

  }



  /**

   * Fungsi untuk mengambil data howToGetThere dari tabel poidescription

   * berdasarkan poi_id dan language_id yang diberikan

   *

   * @param integer $poi_id

   * @param integer $lang_id

   * @return array

   */

  public function getHowToGetThereByIdLang($poi_id, $lang_id) {

    $sql = $this->select()

            ->setIntegrityCheck(false)

            ->from($this->_name, array('howToGetThere'))

            ->where('poi_id = ?', $poi_id)

            ->where('language_id = ?', $lang_id);

    $report = $this->fetchRow($sql);

    if (count($report)) {

      $return = $report->toArray();

    }

    return $return['howToGetThere'];

  }



  /**

   * Fungsi untuk mengambil data howToGetAround dari tabel poidescription

   * berdasarkan poi_id dan language_id yang diberikan

   *

   * @param integer $poi_id

   * @param integer $lang_id

   * @return array

   */

  public function getHowToGetAroundByIdLang($poi_id, $lang_id) {

    $sql = $this->select()

            ->setIntegrityCheck(false)

            ->from($this->_name, array('howToGetAround'))

            ->where('poi_id = ?', $poi_id)

            ->where('language_id = ?', $lang_id);

    $data = $this->fetchRow($sql);

    return $data['howToGetAround'];

  }



  /**

   * Fungsi untuk mengambil data whereToEat dari tabel poidescription

   * berdasarkan poi_id dan language_id yang diberikan

   *

   * @param integer $poi_id

   * @param integer $lang_id

   * @return array

   */

  public function getWhereToEatByIdLang($poi_id, $lang_id) {

    $sql = $this->select()

            ->setIntegrityCheck(false)

            ->from($this->_name, array('whereToEat'))

            ->where('poi_id = ?', $poi_id)

            ->where('language_id = ?', $lang_id);

    $data = $this->fetchRow($sql);

    return $data['whereToEat'];

  }



  /**

   * Fungsi untuk mengambil data whatToBuy dari tabel poidescription

   * berdasarkan poi_id dan language_id yang diberikan

   *

   * @param integer $poi_id

   * @param integer $lang_id

   * @return array

   */

  public function getWhatToBuyByIdLang($poi_id, $lang_id) {

    $sql = $this->select()

            ->setIntegrityCheck(false)

            ->from($this->_name, array('whatToBuy'))

            ->where('poi_id = ?', $poi_id)

            ->where('language_id = ?', $lang_id);

    $data = $this->fetchRow($sql);

    return $data['whatToBuy'];

  }



  /**

   * Fungsi untuk mengambil data whatToDo dari tabel poidescription

   * berdasarkan poi_id dan language_id yang diberikan

   *

   * @param integer $poi_id

   * @param integer $lang_id

   * @return array

   */

  public function getWhatToDoByIdLang($poi_id, $lang_id) {

    $sql = $this->select()

            ->setIntegrityCheck(false)

            ->from($this->_name, array('whatToDo'))

            ->where('poi_id = ?', $poi_id)

            ->where('language_id = ?', $lang_id);

    $data = $this->fetchRow($sql);



    return $data['whatToDo'];

  }



  /**

   * Fungsi untuk mengambil data tips dari tabel poidescription

   * berdasarkan poi_id dan language_id yang diberikan

   *

   * @param integer $poi_id

   * @param integer $lang_id

   * @return array

   */

  public function getTipsByIdLang($poi_id, $lang_id) {

    $sql = $this->select()

            ->setIntegrityCheck(false)

            ->from($this->_name, array('tips'))

            ->where('poi_id = ?', $poi_id)

            ->where('language_id = ?', $lang_id);

    $data = $this->fetchRow($sql);



    return $data['tips'];

  }



  /**

   * Fungsi untuk mengambil data language dari tabel poidescription berdasarkan

   * poi_id yang diberikan

   *

   * @param integer $poi_id

   * @return array

   */

  public function getLanguageById($poi_id) {

    $data = $this->select()

            ->from($this->_name, array('language_id'))

            ->where('poi_id = ?', $poi_id);

    return $this->fetchAll($data);

  }



  /**

   * Fungsi untuk mengambil semua data related destination berdasarkan area_id

   * dan poi_id yang diberikan

   *

   * @param integer $area_id

   * @param integer $poi_id

   * @return array

   */

  public function getRelatedDestination($poi_id) {

    $query = $this->select()

            ->from($this->_name, array(''))

            ->join($this->_atp, "{$this->_atp}.poi_id = {$this->_name}.poi_id", array(''))

            ->join($this->_area, "{$this->_area}.area_id = {$this->_atp}.area_id", array('name'))

            ->setIntegrityCheck(false)

            ->where("{$this->_area}.area_type > 1")

            ->where("{$this->_atp}.poi_id = ?", $poi_id)

            ->where

            ->limit(4, 0)

            ->order('RAND()');

    $query->group("{$this->_area}.area_id");

    $report = $this->fetchAll($query);

    $return = $report->toArray();

    return $return;

  }



  /**

   * Fungsi untuk mendapatkan area_id dari sebuah destination

   *

   * @param integer $poi

   * @return array

   */

  public function getAreaIdByPoi($poi) {

    $query = $this->select()

            ->from($this->_name, array(''))

            ->join($this->_atp, "{$this->_atp}.poi_id = {$this->_name}.poi_id", array('area_id'))

            ->join($this->_area, "{$this->_area}.area_id = {$this->_atp}.area_id", array(''))

            ->setIntegrityCheck(false)

            ->where("{$this->_name}.poi_id = ?", $poi)

            ->where("{$this->_area}.area_type = 1");

    $return = $this->fetchRow($query);

    return $return['area_id'];

  }



  /**

   * Fungsi untuk mendapatkan special destination berdasarkan poi_id dalam satu

   * @param integer $poi

   * @return array

   */

  public function checkDestinationIsSpecialPlaceByPoi($poi, $langId) {

    $data = $this->getAreaIdByPoi($poi);



    if (count($data) > 0) {

      $query = $this->select()

              ->from($this->_name, array('poi_id', 'name', 'header_image'))

              ->join($this->_desti, "{$this->_desti}.poi_id = {$this->_name}.poi_id"

                      , array(''))

              ->join($this->_atp, "{$this->_atp}.poi_id = {$this->_desti}.poi_id", array(''))

              ->setIntegrityCheck(false)

              ->where("{$this->_atp}.area_id = ?", $data)

              ->where("{$this->_atp}.poi_id != ?", $poi)

              ->where("{$this->_name}.language_id = ?", $langId)

              ->where("{$this->_desti}.special = 1")

              ->where("{$this->_desti}.status = 1")

              ->order('RAND()');

      $query->group("{$this->_atp}.poi_id");

      $return = $this->fetchAll($query);

      return $return;

    }



    return array();

  }



  public function checkDestinationIsPopularByPoi($poi, $langId) {

    $data = $this->getAreaIdByPoi($poi);



    if (count($data) > 0) {

      $query = $this->select()

              ->from($this->_name, array('poi_id', 'name', 'header_image'))

              ->join($this->_desti, "{$this->_desti}.poi_id = {$this->_name}.poi_id"

                      , array(''))

              ->join($this->_atp, "{$this->_atp}.poi_id = {$this->_desti}.poi_id", array(''))

              ->setIntegrityCheck(false)

              ->where("{$this->_atp}.area_id = ?", $data)

              ->where("{$this->_atp}.poi_id != ?", $poi)

              ->where("{$this->_name}.language_id = ?", $langId)

              ->where("{$this->_desti}.popular = 1")

              ->where("{$this->_desti}.status = 1")

              ->order('RAND()');

      $query->group("{$this->_atp}.poi_id");

      $return = $this->fetchAll($query);



      return $return;

    }



    return array();

  }



  /**

   * Fungsi untuk mendapatkan nama dan poi_id dari destinasi yang masih satu area

   * @param integer $poi

   * @return array



    public function getNameRelatedDestinationByPoiAreaId($poi,$langId) {

    $areaId = $this->getAreaIdByPoi($poi);



    if(count($areaId) > 0) {

    $query = $this->select()

    ->from($this->_name,array('poi_id','name'))

    ->join($this->_atp,"{$this->_atp}.poi_id = {$this->_name}.poi_id",array(''))

    ->setIntegrityCheck(false)

    ->where("{$this->_atp}.area_id = ?", $areaId)

    ->where("{$this->_atp}.poi_id != ?", $poi)

    ->where("{$this->_name}.language_id = ?", $langId)

    ->order('RAND()');

    $query->group("{$this->_atp}.poi_id");

    $return = $this->fetchAll($query);

    return $return;

    }



    return array();

    } */



  /**

   * Fungsi untuk mendapatkan semua destinasi yang masih satu area dengan destinasi inputan

   * yang diambil secara acak dan diambil sebanyak 5 destinasi

   * @param integer $poi

   * @return array

   */

  public function getRelatedDestinationByPoi($poi, $langId) {

    $special = $this->checkDestinationIsSpecialPlaceByPoi($poi, $langId);

    $popular = $this->checkDestinationIsPopularByPoi($poi, $langId);

    // $generalPoi = $this->getNameRelatedDestinationByPoiAreaId($poi,$langId);



    $spe = count($special);

    $pop = count($popular);

    if (count($special > 0) OR count($generalPoi) > 0) {

      if ($special != null) {

        if ($spe > 5) {

          foreach ($special as $tempNameSpecial) {

            $name[$tempNameSpecial['poi_id']] = $tempNameSpecial['name'];

          }

        } else {

          foreach ($special as $tempNameSpecial) {

            $name[$tempNameSpecial['poi_id']] = $tempNameSpecial['name'];

          }



          foreach ($popular as $tempNamePopular) {

            if (count($name) > 4) {

              break;

            }

            $name[$tempNamePopular['poi_id']] = $tempNamePopular['name'];

          }

        }

      } else {

        if ($pop != null) {

          foreach ($popular as $tempNamePopular) {

            if (count($name) > 4) {

              break;

            }

            $name[$tempNamePopular['poi_id']] = $tempNamePopular['name'];

          }

        }

      }

      return $name;

    } else {

      return array();

    }

  }



  public function getRelatedDestinationForData($poi, $langId) {

    $special = $this->checkDestinationIsSpecialPlaceByPoi($poi, $langId);

    $popular = $this->checkDestinationIsPopularByPoi($poi, $langId);

    // $generalPoi = $this->getNameRelatedDestinationByPoiAreaId($poi,$langId);



    $spe = count($special);

    $pop = count($popular);

    if (count($special > 0) OR count($generalPoi) > 0) {

      if ($special != null) {

        if ($spe > 5) {

          foreach ($special as $tempNameSpecial) {

            $name[$tempNameSpecial['poi_id']] = $tempNameSpecial['name'];

          }

        } else {

          foreach ($special as $tempNameSpecial) {

            $name[$tempNameSpecial['poi_id']] = $tempNameSpecial['name'];

          }



          foreach ($popular as $tempNamePopular) {

            $name[$tempNamePopular['poi_id']] = $tempNamePopular['name'];

          }

        }

      } else {

        if ($pop != null) {

          foreach ($popular as $tempNamePopular) {

            $name[$tempNamePopular['poi_id']] = $tempNamePopular['name'];

          }

        }

      }

      return $name;

    } else {

      return array();

    }

  }



  /**

   * Fungsi untuk mengambil semua data article yang masih satu destinasi

   * @param integer $poiId

   * @param integer $langId

   * @return array

   */

  public function getRelatedArticleByPoiLang($poiId, $langId) {

    $query = $this->select()

            ->from($this->_name, array(''))

            ->join($this->_article, "{$this->_article}.poi_id = {$this->_name}.poi_id"

                    , array(''))

            ->join($this->_articledesc, "{$this->_article}.article_id = {$this->_articledesc}.article_id", array('article_id', 'title'))

            ->setIntegrityCheck(false)

            ->where("{$this->_articledesc}.language_id = ?", $langId)

            ->where("{$this->_name}.poi_id = ?", $poiId)

            ->order("{$this->_article}.sort_order ASC");

    $query->group("{$this->_article}.article_id");

    $return = $this->fetchAll($query);

    return $return;

  }



  public function deletePoiDescription($poi_id) {

    $where = $this->getAdapter()->quoteInto('poi_id = ?', $poi_id);

    $this->delete($where);

  }



  public function deletePoiDescription2($poi_id, $language_id = 2) {

    $where = $this->getAdapter()->quoteInto('poi_id = ?', $poi_id) .

            $this->getAdapter()->quoteInto(' AND language_id = ?', $language_id);

    $this->delete($where);

  }



  public function insertPoiDescription($input) {

    $this->insert($input);

  }



  public function checkForEnglish($catId) {

    $query  = $this->select()

            ->from($this->_name)

            ->where('poi_id = ?', $catId)

            ->where('language_id = 1');

    $report = $this->fetchRow($query);

    if ($report != null) {

      return true;

    } else {

      return false;

    }

  }



  public function checkForIndo($catId) {

    $query  = $this->select()

            ->from($this->_name)

            ->where('poi_id = ?', $catId)

            ->where('language_id = 2');

    $report = $this->fetchRow($query);

    if ($report != null) {

      return true;

    } else {

      return false;

    }

  }



  /**

   * Fungsi untuk mengupdate data pada tabel poidescription

   * @param array $data

   * @param integer $poi_id

   * @param integer $lang_id

   */

  public function updatePoiDescription($data, $poi_id, $lang_id) {

    $where = $this->getAdapter()->quoteInto('language_id = ?', $lang_id) .

            $this->getAdapter()->quoteInto(' AND poi_id = ?', $poi_id);

    $this->update($data, $where);

  }



  /**

   * Fungsi untuk mengecek ada tidaknya name dari tabel poidescription

   * berdasarkan name dan language_id yang diberikan

   *

   * @param string $name

   * @param integer $language_id

   * @return array

   */

  public function CheckPoiName($name, $language_id) {

    $nul   = 0;

    $query = $this->select()

            ->from($this->_name, array('name'))

            ->where("name LIKE '%" . $name . "%'")

            ->where('language_id = ?', $language_id);

    $report = $this->fetchAll($query);

    $return = $report->toArray();

    $count  = count($report);



    if ($count == $nul) {

      return $this->false;

    } else {

      return $this->true;

    }

  }



  /**

   * Fungsi untuk mengambil name dari tabel poidescription berdasarkan name dan

   * language_id yang diberikan

   *

   * @param string $name

   * @param integer $lang_id

   * @return array

   */

  public function getNameByString($name, $lang_id) {

    $query = $this->select()

            ->from($this->_name, array('name'))

            ->where("name LIKE '%" . $name . "%'")

            ->where('language_id = ?', $lang_id);

    $return = $this->fetchAll($query);

    return $return;

  }



  /**

   * Fungsi untuk mengambil semua data yang digunakan untuk map

   *

   * @param integer $langId

   * @return array

   */

  public function getAllForMap($langId) {

    $query = $this->select()

            ->setIntegrityCheck(false)

            ->from($this->_name, array('description', 'name AS descname'))

            ->join($this->_desti, "{$this->_name}.poi_id = {$this->_desti}.poi_id", array('poi_id', 'pointX', 'pointY',

                'popular', 'main_category'))

            ->join($this->_cattopoi, "{$this->_name}.poi_id = {$this->_cattopoi}.poi_id", array('category_id'))

            ->where("{$this->_name}.language_id = ?", $langId)

            ->where("{$this->_name}.description IS NOT NULL");



    //echo $query->__toString();

    return $this->fetchAll($query)->toArray();

  }



  /**

   * Fungsi search untuk destinasi di halaman home

   * @param integer $lang

   * @param string $nameDesc

   * @param string $areaName

   * @param integer $categoryId

   * @return array

   */

  public function getSearch($nameDesc = '', $areaName = '', $categoryId = 0, $lang, $sortingOptions = null) {



    // baseline query

    $query = $this->select()

            ->setIntegrityCheck(false)

            ->from($this->_name, array('poi_id', 'poiName' => 'name', 'tagline', 'description'))

            ->join($this->_atp, "{$this->_atp}.poi_id = {$this->_name}.poi_id", array('area_id'))

            ->join($this->_area, "{$this->_area}.area_id = {$this->_atp}.area_id", array(''))

            ->join(array('ri' => 'regionalinformation'), "{$this->_area}.area_id = ri.area_id", array())

            ->join($this->_cattopoi, "{$this->_cattopoi}.poi_id = {$this->_name}.poi_id", array(''))

            ->join($this->_cat, "{$this->_cat}.category_id = {$this->_cattopoi}.category_id", array('category_id'))

            ->join('categorydescription', 'categorydescription.category_id = category.category_id', array('name'))

            ->join($this->_desti, "{$this->_desti}.poi_id = {$this->_name}.poi_id", array('(poi.totalrate/poi.totalrater) AS rating', 'totalrater'))

            ->joinLeft($this->_gallery, "{$this->_gallery}.poi_id = {$this->_cattopoi}.poi_id", array('galleryname' => 'name', 'source'))

            ->where("{$this->_name}.language_id = ?", $lang)

            ->where("categorydescription.language_id = ?", $lang)

            ->where("{$this->_desti}.status = ?", Model_DbTable_Destination::PUBLISH);



    // Cek parameter dan gunakan paramter jika tidak kosong

    if (!empty($nameDesc)) {

      $where  = $this->getAdapter()->quoteInto(

              "( {$this->_name}.name LIKE ?", '%' . $nameDesc . '%');

      $query->where($where);

      $where2 = $this->getAdapter()->quoteInto(

              "ri.area_name LIKE ? )", '%' . $nameDesc . '%');

      $query->orwhere($where2);

    } elseif (empty($nameDesc) || ($sortingOptions == null)) {

      //$query->order("{$this->_desti}.special DESC");

      //$query->order("{$this->_name}.name ASC");

    }

    if (!empty($areaName)) {

      $where = $this->getAdapter()->quoteInto(

              "{$this->_area}.name LIKE ?", '%' . $areaName . '%');

      $query->where($where);

    }

    if ($categoryId > 0) {

      $where = $this->getAdapter()->quoteInto(

              "{$this->_cattopoi}.category_id = ?", $categoryId);

      $query->where($where);

    }



    $query->group("{$this->_name}.poi_id");



    // Parameter sorting

    $sortBy = $this->_getSortBy($sortingOptions['sort_by'], $sortingOptions['sort_order']);



    $query->order($sortBy);

    if ($sortingOptions['sort_by'] == '') {

      $query->order("{$this->_name}.name ASC");

    }

    //$query->order($sortBy);

//    echo $query->__toString();

    $result = $this->fetchAll($query)->toArray();

    return $result;

  }



  /**

   * Fungsi untuk mengambil poi_id,name,tagline,description dari tabel poiescription

   * serta pointX,pointY,dan popular dari tabel poi berdasarkan language_id

   * dan nama yang diberikan

   *

   * @param integer $lang

   * @param string $name

   * @return array

   */

  public function getSearchByName($name, $languageId) {



    // baseline query

    $query = $this->select()

            ->setIntegrityCheck(false)

            ->from($this->_name, array('poi_id', 'name AS poi_name', 'description'))

            ->join($this->_desti, "{$this->_desti}.poi_id = {$this->_name}.poi_id", array('pointX', 'pointY', 'special'))

            ->where("{$this->_name}.language_id = ?", $languageId)

            ->order("{$this->_desti}.special")

            ->group("{$this->_name}.poi_id");



    $where = $this->getAdapter()->quoteInto(

            "{$this->_name}.name LIKE ?", '%' . $name . '%');

    $query->where($where);



    return $this->fetchAll($query);

  }



  public function getAllByCategoryList($categoryId, $languageId) {

    $categoryDb = new Model_DbTable_Category;



    // Cek apakah si kategori punya sub kategori, jika tidak maka set

    // isinya ke kategori dia sendiri

    $childList = $categoryDb->getCategoryChildListForForm($categoryId, $languageId);

    if (empty($childList))

      $childList = $categoryId;



    $query = $this->select()

            ->setIntegrityCheck(false)

            ->from($this->_name, array('poi_id', 'poi_name' => 'name', 'description'))

            ->join($this->_desti, "{$this->_desti}.poi_id = {$this->_name}.poi_id", array('pointX', 'pointY', 'special'))

            ->join($this->_cattopoi, "{$this->_cattopoi}.poi_id = {$this->_name}.poi_id", array(''))

            ->where("{$this->_name}.language_id = ?", $languageId)

            ->where("{$this->_cattopoi}.category_id IN (?)", $childList)

            ->group("{$this->_name}.poi_id");



    //echo $query->__toString();

    $data = $this->fetchAll($query);



    if (count($data)) {

      return $data->toArray();

    }

  }



  public function getAllByAreaList($areaId, $languageId) {

    $areaDb   = new Model_DbTable_Area;

    $areaList = $areaDb->getAllAreaChildList($areaId);



    if (count($areaList)) {

      $query = $this->select()

              ->setIntegrityCheck(false)

              ->from($this->_name, array('poi_id', 'poi_name' => 'name', 'description'))

              ->join($this->_desti, "{$this->_desti}.poi_id = {$this->_name}.poi_id", array('pointX', 'pointY', 'special'))

              ->join($this->_atp, "{$this->_atp}.poi_id = {$this->_name}.poi_id", array(''))

              ->where("{$this->_name}.language_id = ?", $languageId)

              ->where("{$this->_atp}.area_id IN (?)", $areaList)

              ->order("{$this->_desti}.special")

              ->group("{$this->_name}.poi_id");



      //echo $query->__toString();

      $data = $this->fetchAll($query);



      if (count($data)) {

        return $data->toArray();

      }

    }



    return array();

  }



  /**

   *

   * @param  $poi_id

   * @param integer $language_id

   * @return array

   */

  public function getPoiNameByIdLangId($poi_id, $language_id = 1) {

    $query = $this->select()

            ->from($this->_name, array('name'))

            ->where('poi_id = ?', $poi_id)

            ->where('language_id = ?', $language_id);

    $name = $this->fetchRow($query);

    return $name['name'];

  }



  public function getNameTaglineByIdLangId($poi_id, $language_id = 1) {

    $select = $this->select()

            ->from($this->_name, array('name', 'tagline'))

            ->where('poi_id = ?', $poi_id)

            ->where('language_id = ?', $language_id);

    return $this->fetchRow($select);

  }



  public function getNameById($poiId, $language_id = 1) {

    $data = $this->select()

            ->from($this->_name, array('name'))

            ->where('poi_id = ?', $poiId)

            ->where('language_id = ?', $language_id);

    $report = $this->fetchRow($data);

    //$return = $report->toArray();

    return $report['name'];

  }



  public function getTaglineById2($poiId, $language_id = 1) {

    $data = $this->select()

            ->from($this->_name, array('tagline'))

            ->where('poi_id = ?', $poiId)

            ->where('language_id = ?', $language_id);

    $report = $this->fetchRow($data);

    //$return = $report->toArray();

    return $report['tagline'];

  }



  /**

   * Fungsi untuk mendukung sorting

   *

   * @param string $sort field sorting

   * @param string $sortOrder urutan sorting

   *

   * @return string gabungan antara $sort dan $sortOrder

   */

  private function _getSortBy($sort = 'special', $sortOrder = 'DESC') {

    if ($sortOrder == '') {

      $sortOrder = 'DESC';

    }



    $sortBy = '';



    if ($sort == 'name')

      $sortBy = "poiName";

    else if ($sort == 'rating')

      $sortBy = "({$this->_desti}.totalrate/{$this->_desti}.totalrater)";

    else if ($sort == 'featured')

      $sortBy = "{$this->_desti}.special";

    else if ($sort == 'priority')

      $sortBy = "{$this->_desti}.priority";

    else

      $sortBy = "{$this->_desti}.priority";

    return $sortBy . ' ' . $sortOrder;

  }



  public function checkDescIndo($poiId) {

    $query = $this->select()

            ->from($this->_name, array('description'))

            ->where('language_id = 2')

            ->where('poi_id = ?', $poiId);

    $result = $this->fetchRow($query);



    $query2 = $this->select()

            ->from($this->_name, array('COUNT(language_id) AS count'))

            ->where('poi_id = ?', $poiId);

    $result2 = $this->fetchRow($query2);



    if ($result2['count'] > '1') {

      if ($result['description'] == ' ') {

        return false;

      } else {

        return true;

      }

    } else {

      return false;

    }

  }



  public function checkDescEnglish($poiId) {

    $query = $this->select()

            ->from($this->_name, array('description'))

            ->where('language_id = 1')

            ->where('poi_id = ?', $poiId);

    $result = $this->fetchRow($query);



    $query2 = $this->select()

            ->from($this->_name, array('COUNT(language_id) AS count'))

            ->where('poi_id = ?', $poiId);

    $result2 = $this->fetchRow($query2);



    if ($result2['count'] > '1') {

      if ($result['description'] == ' ') {

        return false;

      } else {

        return true;

      }

    } else {

      return false;

    }

  }



  //get destination description by id

  public function getDestById($poi_id) {

    $query = $this->select()

            ->from($this->_name, array('poi_id', 'language_id', 'name', 'description'))

            ->where("{$this->_name}.poi_id = ?", $poi_id)

            //->distinct('event_id');

            ->group('poi_id');



    $result = $this->fetchAll($query);

    if (count($result)) {

      //$destination = '';

      //foreach($result as $row)

      //{

      //   $destination .= $row->name .'<br />';

      //}



      return $result;

    } else {

      return NULL;

    }

  }



  //get destination description by id

  public function getDestName($poi_id, $lang_id) {

    $query = $this->select()

            ->from($this->_name, array('poi_id', 'language_id', 'name'))

            ->where("{$this->_name}.poi_id = ?", $poi_id)

            ->where("{$this->_name}.language_id = ?", $lang_id);

    //->group('poi_id');



    $result = $this->fetchRow($query);

    if (count($result)) {

      return $result;

    } else {

      return NULL;

    }

  }



}



?>