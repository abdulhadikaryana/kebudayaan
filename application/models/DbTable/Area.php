<?php
/**
 * Model_DbTable_Area
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel area/region
 *
 * @package DbTable Model
 */
require_once 'Zend/Db/Table/Abstract.php';

class Model_DbTable_Area
        extends Zend_Db_Table_Abstract
{
  /** The default table name */
  protected $_name    = 'area';
  protected $_table   = 'areatopoi';
  protected $_reginf  = 'regionalinformation';
  protected $_primary = 'area_id';

  /**
   * Fungsi  untuk melakukan insert pada tabel area
   * 
   * @return integer
   */
  public function insertArea($input)
  {
    $this->insert($input);
    return $this->_db->lastInsertId();
  }

  /**
   * Fungsi  untuk melakukan update pada tabel area
   * 
   * @return integer
   */
  public function updateArea($area_id, $input)
  {
    $where = $this->getAdapter()->quoteInto('area_id = ?', $area_id);
    $this->update($input, $where);
  }

  /**
   * Fungsi  untuk melakukan delete pada tabel area
   * 
   * @return integer
   */
  public function deleteArea($area_id)
  {
    $where = $this->getAdapter()->quoteInto('area_id = ?', $area_id);
    $this->delete($where);
  }

  public function deleteArea2($area_id, $language_id)
  {
    $where = $this->getAdapter()->quoteInto('area_id = ?', $area_id) .
            $this->getAdapter()->quoteInto('language_id = ?',
                                           $language_id);
    $this->delete($where);
  }

  /**
   * Fungsi untuk mengambil semua data dari tabel area
   * 
   * @return array
   */
  public function getAll()
  {
    $query = $this->select()
            ->from($this->_name);
    return $this->fetchAll($query);
  }

  /**
   * Fungsi untuk mengambil semua data dari tabel area, dan regional info
   * 
   * @return array
   */
  public function getAllWithRegionalInfoById($area_id)
  {
    $select = $this->select()
            ->setIntegrityCheck(FALSE)
            ->from(array('a' => $this->_name))
            ->join(array('ri' => $this->_reginf),
                   'a.area_id = ri.area_id');
  }

  /**
   * Fungsi untuk mengambil data berdasarkan inputan parameter
   * 
   * @param integer $type
   * @param string $param
   * @param integer $language_id
   * @return array
   */
  public function getQueryAllByLanguage($filter, $param,
                                        $language_id = 1)
  {
    $select = $this->select()
            ->setIntegrityCheck(FALSE)
            ->from(array('a' => $this->_name))
            ->join(array('ri' => $this->_reginf),
                   'a.area_id = ri.area_id',
                   array('name' => 'area_name'))
            ->group('a.area_id');
    
    if (null != $filter) {
      if (null != $filter['name']) {
        $select->where("ri.area_name LIKE ?",
                "%{$filter['name']}%");
      }     
    }
        
    $select->order('area_id DESC');
    return $select;
  }

  /**
   * Fungsi untuk mengambil semua data dari tabel area berdasarkan area_id
   * yang diberikan
   *
   * @param integer $area_id
   * @return array
   */
  //edited
  public function getAllById($area_id, $language_id)
  {
    $query = $this->select()
            ->setIntegrityCheck(FALSE)
            ->from(array('a' => $this->_name))
            ->join(array('ri' => $this->_reginf),
                   'a.area_id = ri.area_id')
            ->where('ri.language_id = ?', $language_id)
            ->where('a.area_id = ?', $area_id);
    return $this->fetchRow($query);
  }

  /**
   * Fungsi untuk mengambil data name dari tabek area dan area_id dari tabel
   * areatopoi berdasarkan poi_id yang diberikan dan kemudian diurutkan
   * berdasarkan area_id dari yang terkecil
   *
   * @param integer $poiId
   * @return array
   */
  //edited
  public function getAllAreaByPoiId($poiId, $language_id = 1)
  {
    $query = $this->select()
            ->from(array('a' => $this->_name), array('area_type'))
            ->join(array('ri' => $this->_reginf),
                   'a.area_id = ri.area_id',
                   array('name' => 'area_name'))
            ->join(array('atp' => 'areatopoi'),
                   'atp.area_id = a.area_id', array('area_id'))
            ->where('atp.poi_id = ?', $poiId)
            ->where('ri.language_id = ?', $language_id)
            ->order('a.area_id ASC')
            ->setIntegrityCheck(false);
    return $this->fetchAll($query);
  }

  /**
   * Fungsi untuk mengambil semua data name dari tabel area berdasarkan name
   * yang diberikan
   *
   * @param string $name
   * @return array
   */
  //edited
  public function getAllByName($name, $language_id = 1)
  {
    $query = $this->select()
            ->setIntegrityCheck(FALSE)
            ->from(array('a' => $this->_name))
            ->join(array('ri' => $this->_reginf),
                   'a.area_id = ri.area_id',
                   array('name' => 'area_name'))
            ->where('a.poi_id = ?', $poiId)
            ->where('ri.language_id = ?', $language_id)
            ->where("ri.name LIKE '%" . $name . "%'");
    return $this->fetchAll($query);
  }

  /**
   * Fungsi untuk mengambil type area dari tabel area berdasarkan area_id
   * yang diberikan
   *
   * @param integer $areaId
   * @return array
   */
  public function getAreaTypeById($area_id)
  {
    if ($area_id > 0) {
      $query = $this->select()
              ->from($this->_name, array('area_type'))
              ->where('area_id = ?', $area_id)
              ->limit(1);
      $area_type = $this->fetchRow($query);
      return $area_type['area_type'];
    } else {
      return 0;
    }
  }

  /**
   * Fungsi untuk mengambil data pointX dari tabel area berdasarkan area_id
   * yang diberikan
   *
   * @param integer $areaId
   * @return array
   */
  public function getPointXById($areaId)
  {
    $query = $this->select()
            ->from($this->_name, array('pointX'))
            ->where('area_id = ?', $areaId);
    $return = $this->fetchRow($query);
    return $return;
  }

  /**
   * Fungsi untuk mengambil data pointY dari tabel area berdasarkan area_id
   * yang diberikan
   *
   * @param integer $areaId
   * @return array
   */
  public function getPointYById($areaId)
  {
    $query = $this->select()
            ->from($this->_name, array('pointY'))
            ->where('area_id = ?', $areaId);
    $return = $this->fetchRow($query);
    return $return;
  }

  /**
   * Fungsi untuk mengambil data name dari tabel area berdasarkan area_id
   * yang diberikan
   *
   * @param integer $areaId
   * @return array
   */
  //edited
  public function getNameById($areaId, $language_id = 1)
  {
    $query = $this->select()
            ->setIntegrityCheck(FALSE)
            ->from(array('a' => $this->_name))
            ->join(array('ri' => $this->_reginf),
                   'a.area_id = ri.area_id',
                   array('name'  => 'area_name'))
            ->where('ri.language_id = ?', $language_id)
            ->where('a.area_id = ?', $areaId);
    $return = $this->fetchRow($query);
    return $return;
  }

  /**
   * Fungsi untuk mengambil semua data area_id dan name yang merupakan propinsi
   * dan pulau
   *
   * @return array
   */
  //edited
  public function getAllIslandAndProvince($language_id = 1)
  {
    $query = $this->select()
            ->setIntegrityCheck(FALSE)
            ->from(array('a' => $this->_name), array('area_id'))
            ->join(array('ri' => $this->_reginf),
                   'a.area_id = ri.area_id',
                   array('name' => 'area_name'))
            ->where('ri.language_id = ?', $language_id)
            ->where('a.area_type < 2');
    return $this->fetchAll($query)->toArray();
  }

  /**
   * Fungsi untuk mengambil semua data dari tabel area yang merupakan parent
   * area (island)
   *
   * @return array
   */
  //edited
  public function getAllParentArea($column = null, $language_id = 1)
  {
    if ($column == null) {
      $query = $this->select()
              ->from(array('a' => $this->_name))
              ->where('parent_id = 0');
    } else {
      $query = $this->select()
              ->from(array('a' => $this->_name), $column)
              ->where('a.parent_id = 0');
    }

    $query->setIntegrityCheck(FALSE);
    $query->join(array('ri' => $this->_reginf),
                 'ri.area_id = a.area_id',
                 array('name' => 'area_name'));
    $query->where('ri.language_id = ?', $language_id);
    return $this->fetchAll($query)->toArray();
  }

  /**
   * Fungsi untuk mengambil data area_id dan name dari tabel area yang merupakan
   * propinsi
   * 
   * @return array
   */
  //edited
  public function getallAreaNameId($language_id = 1)
  {
    $query = $this->select()
            ->setIntegrityCheck(FALSE)
            ->from(array('a' => $this->_name), array('area_id'))
            ->join(array('ri' => $this->_reginf),
                   'a.area_id = ri.area_id',
                   array('name'  => 'area_name'))
            ->where('ri.language_id = ?', $language_id)
            ->where('a.area_type = 1');
    $return = $this->fetchAll($query);
    return $return;
  }

  /**
   * Fungsi untuk mendapatkan koordinat dari suatu area
   * digunakan di map
   *
   * @return array
   */
  public function getCoordinateById($areaId)
  {
    $query = $this->select()
            ->from('area', array('pointX', 'pointY', 'area_type'))
            ->where('area_id = ?', $areaId);

    return $this->fetchAll($query)->toArray();
  }

  /**
   * Fungsi untuk mengambil semua data parent_id berdasarkan area_id yang
   * diberikan
   *
   * @param integer $area_id
   * @return array
   */
  public function getParentIdByAreaId($area_id)
  {
    $select = $this->select()
            ->from($this->_name, array('parent_id'))
            ->where('area_id = ?', $area_id);
    $area_id = $this->fetchRow($select)->toArray();
    return $area_id['parent_id'];
  }

  /**
   * Fungsi untuk mengambil data area_id dan name dari tabel area yang
   * merupakan propinsi yang di kembalikan dalam value menu option
   * 
   * @return array
   */
  //edited
  public function setAreaForSelectElement($language_id = 1)
  {
    $select = $this->select()
            ->setIntegrityCheck(FALSE)
            ->from(array('a' => $this->_name), array('area_id'))
            ->join(array('ri' => $this->_reginf),
                   'a.area_id = ri.area_id',
                   array('name' => 'area_name'))
            ->where('ri.language_id = ?', $language_id)
            ->where('a.area_type = 0');
    $data  = $this->fetchAll($select);
    foreach ($data as $tmpArea) {
      $area_value[$tmpArea['area_id']] = $tmpArea['name'];
    }
    return $area_value;
  }

  /**
   * Fungsi untuk mengambil data area_id yg merupakan province yang paling 
   * pertama
   * 
   * @return array
   */
  public function getFirstProvince()
  {
    $select = $this->select()
            ->from($this->_name, array('area_id'))
            ->where('area_type > 0')
            ->order('area_id ASC')
            ->limit(1, 0);
    return $this->fetchAll($select);
  }

  /**
   * Fungsi untuk mmengambil data yang merupakan childarea
   * 
   * @param integer $parent_id
   * @return array
   */
  //edited
  public function setChildAreaForSelectElement($parent_id = null,
                                               $language_id = 1)
  {
    if ($parent_id == null) {
      $parent_id = $this->getFirstProvince();
      $parent_id = $parent_id[0]['area_id'];
    }
    $select    = $this->select()
            ->setIntegrityCheck(FALSE)
            ->from(array('a' => $this->_name), array('area_id'))
            ->join(array('ri' => $this->_reginf),
                   'a.area_id = ri.area_id',
                   array('name' => 'area_name'))
            ->where('ri.language_id = ?', $language_id)
            ->where('a.parent_id = ?', $parent_id);
    $data  = $this->fetchAll($select);
    foreach ($data as $tmpArea) {
      $area_value[$tmpArea['area_id']] = $tmpArea['name'];
    }
    return $area_value;
  }

  /**
   * Fungsi untuk mengambil semua data  area_id dan area_name berdasarkan
   * parent_id dan language_id yang diberikan
   * 
   * @param integer $parent
   * @param integer $langId
   * @return array
   */
  public function getAreaNameByParentLanguage($parent, $langId)
  {
    $query = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name, array('area_id'))
            ->join($this->_reginf,
                   "{$this->_reginf}.area_id = {$this->_name}.area_id"
                    , array('area_name'))
            ->where("{$this->_name}.parent_id = ?", $parent)
            ->where("{$this->_reginf}.language_id = ?", $langId);

    return $this->fetchAll($query);
  }

  /**
   * Fungsi untuk mendapatkan area id children berdasarkan area parent-nya
   *
   * @param integer $parent parent id area
   * @return array
   */
  public function getAllAreaIdChildByParent($parent, $language_id = 1)
  {
    $query = $this->select()
            ->setIntegrityCheck(false)
            ->from(array('a' => $this->_name), array('area_id'))
            ->join(array('ri' => $this->_reginf),
                   'a.area_id = ri.area_id',
                   array('name' => 'area_name'))
            ->where('ri.language_id = ?', $language_id)
            ->where('a.parent_id = ?', $parent);

    //echo $query->__toString();
    $result = $this->fetchAll($query);

    foreach ($result as $row) {
      $areaId[] = $row['area_id'];
    }

    return $areaId;
  }

  /**
   * 
   */
  function getAllAreaChildIdNameByParent($parent, $prefix = '',
                                         $language_id = 1)
  {
    $query = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name, array('area_id'))
            ->join($this->_reginf,
                   "{$this->_reginf}.area_id = {$this->_name}.area_id",
                   array('name'  => 'area_name'))
            ->where("{$this->_name}.parent_id = ?", $parent)
            ->where("{$this->_reginf}.language_id = ?", $language_id);
    $result = $this->fetchAll($query);
    foreach ($result as $key => $value) {
      $data[$key]['name']    = $prefix . $value['name'];
      $data[$key]['area_id'] = $value['area_id'];
    }
    return $data;
  }

  /**
   * 
   */
  function getAllAreaChildByParent($parent, $title = '',
                                   $language_id = 1)
  {
    $query = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name, array('area_id'))
            ->join($this->_reginf,
                   "{$this->_reginf}.area_id = {$this->_name}.area_id",
                   array('name' => 'area_name'))
            ->where("{$this->_name}.parent_id = ?", $parent)
            ->where("{$this->_reginf}.language_id = ?", $language_id);

    $result = $this->fetchAll($query);

    $data = array("" => "--" . $title . "--");
    foreach ($result as $row) {
      $data[$row['area_id']] = $row['name'];
    }

    return $data;
  }

  /**
   * 
   */
  public function getAllAreaChildList($areaId)
  {
    $areaList = array();

    $typeArea = $this->getAreaTypeById($areaId);

    //echo $typeArea . ' type ';

    if ($typeArea == 0) {

      $provinceList = $this->getAllAreaIdChildByParent($areaId);

      foreach ($provinceList as $index => $province) {
        $areaList[] = $province;

        $cityList = $this->getAllAreaIdChildByParent($province);

        foreach ($cityList as $index => $city) {
          $areaList[] = $city;
        }
      }

      $areaList[] = $areaId;
    } elseif ($typeArea == 1) {

      $cityList = $this->getAllAreaIdChildByParent($areaId);
      foreach ($cityList as $index => $city) {
        $areaList[] = $city;
      }

      $areaList[] = $areaId;
    } else {
      $areaList[] = $areaId; // masukkin diri dia sendiri
    }
    //echo "<pre>";
    //print_r($areaList);
    return $areaList;
  }

  /**
   * 
   */
  public function getCitiesByPoiId($poiId, $languageId)
  {
    // Variabel
    $areaList = array();
    $island = array();
    $city = array();
    $province = array();

    // Model
    $areaDb = new Model_DbTable_Area;

    // Data
    $result = $areaDb->getAllAreaByPoiId($poiId, $languageId); // Dapetin semua area dari poi
    // Kumpulkan mana yg masuk island, province dan city
    foreach ($result as $area) {
      if ($area['area_type'] == 0) {
        $island[] = $area['area_id'];
      } elseif ($area['area_type'] == 1) {
        $province[] = $area['area_id'];
      } elseif ($area['area_type'] == 2) {
        $city[] = $area['area_id'];
      }
    }

    // Jika city-nya ada, langsung diambil
    if (count($city) > 0) {
      $areaList = $city;
    } elseif (count($province) > 0) { // Jika provinsi ada, cari city-nya
      for ($i = 0; $i < count($province); $i++) {
        $areaCity = $areaDb->getAllAreaIdChildByParent($province[$i]);
        if (is_array($areaCity))
          $areaList = array_merge($areaList, $areaCity);
      }
    } elseif (count($island) > 0) { // Jika island ada, cari city-nya
      for ($i = 0; $i < count($island); $i++) {
        $areaProvince = $areaDb->getAllAreaIdChildByParent($island[$i]);
        for ($j = 0; $j < count($areaProvince); $j++) {
          $areaCity = $areaDb->getAllAreaIdChildByParent($areaProvince[$j]);
          if (is_array($areaCity))
            $areaList = array_merge($areaList, $areaCity);
        }
      }
    }

    return $areaList;
  }

  public function getIslands()
  {
    $select = $this->select()
            ->from($this->_name, array('area_id', 'name'))
            ->where('parent_id = ?', 0);

    $result = $this->getAdapter()->fetchPairs($select);
    return $result;
  }

  public function getProvinces($island_id)
  {
    $select = $this->select()
            ->from($this->_name, array('area_id', 'name'))
            ->where('parent_id = ?', $island_id);
    $result = $this->getAdapter()->fetchPairs($select);
    return $result;
  }

  public function getRegions($province_id)
  {
    $select = $this->select()
            ->from($this->_name, array('area_id', 'name'))
            ->where('parent_id = ?', $province_id);
    $result = $this->getAdapter()->fetchPairs($select);
    return $result;
  }
  
  public function getRelatedCulture($area_id) {
    $select = $this->select()->setIntegrityCheck(false)->from($this->_table)
            ->join('culture', $cond);
  }

}
