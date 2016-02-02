<?php

/**
 * Model_DbTable_CategoryToPoi
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel category to poi
 *
 * @package DbTable Model
 */
class Model_DbTable_CategoryToPoi extends Zend_Db_Table_Abstract {

  protected $_cat    = 'category';
  protected $_name   = 'categorytopoi';
  protected $_catdes = 'categorydescription';
  protected $true    = "true";
  protected $false   = "false";

  /**
   * Fungsi untuk menginputkan data ke dalam tabel
   * 
   * @param integer $input
   * @param integer $language_id
   * @return array
   */
  public function insertCategoryToPoi($input, $language_id = 1) {
    $this->insert($input);
    $name = $this->getCategoryName($input['category_id'], $language_id);
    return $name;
  }

  public function deleteCategoryToPoi($cat_id, $poi_id) {
    $where = $this->getAdapter()->quoteInto('category_id = ?', $cat_id) .
            $this->getAdapter()->quoteInto(' AND poi_id = ?', $poi_id);
    $this->delete($where);
  }

  public function deleteAllCategoryByPoi($poi_id) {
    $where = $this->getAdapter()->quoteInto('poi_id = ?', $poi_id);
    $this->delete($where);
  }

  public function deleteAllPoiByCategory($category_id) {
    $where = $this->getAdapter()->quoteInto('category_id = ?', $category_id);
    $this->delete($where);
  }

  /**
   * Fungsi untuk mengambbil category_id berdasarkan poi_id dan language_id
   * yang diberikan

   * @param integer $poi_id
   * @param integer $language_id
   * @return array
   */
  public function getCategoryByPoiId($poi_id, $language_id) {
    $select = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name, array('category_id'))
            ->join($this->_catdes, "{$this->_catdes}.category_id = {$this->_name}.category_id ", array('name'))
            ->where("{$this->_catdes}.language_id = ?", $language_id)
            ->where("{$this->_name}.poi_id = ?", $poi_id);
    return $this->fetchAll($select);
  }

  /**
   * Fungsi untuk mengambbil category_id,image,category_name
   *  berdasarkan poi_id dan language_id
   * yang diberikan

   * @param integer $poi_id
   * @param integer $language_id
   * @return array
   */
  public function getCategoryImageByPoiId($poi_id, $language_id) {
    $select = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name, array('category_id'))
            ->join($this->_catdes, "{$this->_catdes}.category_id = {$this->_name}.category_id ", array('name'))
            ->join($this->_cat, "{$this->_cat}.category_id = {$this->_name}.category_id", array('image'))
            ->where("{$this->_catdes}.language_id = ?", $language_id)
            ->where("{$this->_cat}.parent_id > 0")
            ->where("{$this->_name}.poi_id = ?", $poi_id);
    return $this->fetchAll($select);
  }

  /**
   * Fungsi untuk mengambil data category_id berdasarkan poi_id yang diberikan
   * @param integer $poi_id
   * @return array
   */
  public function getCategoryIdByPoiId($poi_id) {
    $select = $this->select()
            ->from($this->_name, array('category_id'))
            ->where('poi_id = ?', $poi_id);
    return $this->fetchAll($select)->toArray();
  }

  /**
   * Fungsi untuk mengambil category name bersarkan poi_id dan language_id yang
   * diberikan
   *
   * @param integer $cat_id
   * @param integer $language_id
   * @return array
   */
  public function getCategoryName($cat_id, $language_id) {

    $query = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_catdes, array('name'))
            ->join($this->_name, "{$this->_catdes}.category_id = {$this->_name}.category_id "
                    , array(''))
            ->where("{$this->_name}.category_id = ?", $cat_id)
            ->where("{$this->_catdes}.language_id = ?", $language_id);
    $report = $this->fetchRow($query);
    $return = $report->toArray();
    return $return;
  }

  /**
   * Fungsi untuk mengambil semua data dari tabel categorydescription berdasarkan
   * poi_id dan language_id yang diberikan
   *
   * @param integer $poi_id
   * @param integer $lang_id
   * @return array
   */
  public function getAllByIdLang($poi_id, $lang_id) {
    $query = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name)
            ->join($this->_catdes, "{$this->_cat}.category_id = {$this->_catdes}.category_id")
            ->where("{$this->_name}.poi_id = ?", $poi_id)
            ->where("{$this->_catdes}.language_id = ?", $lang_id);
    return $this->fetchAll($query);
  }

  /**
   * Fungsi untuk mengecek apakah suatu poi_id dan category_id ada di tabel
   * categorytopoi
   * @param integer $poi_id
   * @param integer $cat_id
   * @return array
   */
  public function checkPoiCatId($poi_id, $cat_id) {
    $query = $this->select()
            ->from($this->_name, array('poi_id', 'category_id'))
            ->where('category_id = ?', $cat_id)
            ->where('poi_id = ?', $poi_id);
    $result = $this->fetchRow($query);
    if (count($result) > 0) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * Fungsi untuk mengambil jumlah category_id berdasarkan poi_id yang
   * diberikan
   *
   * @param integer $poi_id
   * @return array
   */
  public function countCategoryByPoiId($poi_id) {
    $select = $this->select()
            ->from(($this->_name), array('COUNT(category_id) AS amount'))
            ->where('poi_id = ?', $poi_id);
    $amount = $this->fetchAll($select)->toArray();
    return $amount[0]['amount'];
  }

}

?>