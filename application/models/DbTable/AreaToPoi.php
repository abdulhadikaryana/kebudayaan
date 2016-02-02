<?php
/**
 * Model_DbTable_AreaToPoi
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel areatopoi
 *
 * @package DbTable Model
 */
require_once 'Zend/Db/Table/Abstract.php';

class Model_DbTable_AreaToPoi extends Zend_Db_Table_Abstract
{
    /** The default table name */
    protected $_name = 'areatopoi';
    protected $_area = 'area';

    /**
     * Fungsi untuk memasukkan data ke dalam tabel areatopoi
     * 
     * @param array $input
     */
    public function insertAreaToPoi($input)
    {
        $this->insert($input);
    }

    /**
     * Fungsi untuk menghapus data dari tabel areatopoi berdasarkan area_id
     * dan poi_id yang diberikan
     * 
     * @param integer $area_id
     * @param integer $poi_id
     */
    public function deleteAreaToPoi($area_id, $poi_id)
    {
        $where = $this->getAdapter()->quoteInto('area_id = ?', $area_id).
        $this->getAdapter()->quoteInto(' AND poi_id = ?', $poi_id);
        $this->delete($where);        
    }

    /**
     * Fungsi untuk menghapus data dari tabel areatopoi berdasarkan poi_id
     * yang diberikan
     * 
     * @param integer $poi_id
     */
    public function deleteAllAreaByPoi($poi_id)
    {
        $where = $this->getAdapter()->quoteInto('poi_id = ?', $poi_id);
        $this->delete($where);        
    }

    /**
     * Fungsi untuk menghapus semua data dari tabel areatopoi berdasarkan area_id
     * yang diberikan
     * 
     * @param integer $area_id
     */
    public function deleteAllPoiByAreaId($area_id)
    {
        $where = $this->getAdapter()->quoteInto('area_id = ?', $area_id);
        $this->delete($where);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel areatopoi berdasarkan area_id
     * yang diberikan
     * 
     * @param integer $area_id
     * @return array
     */
    public function getAllPoiByAreaId($area_id,$language_id = 1,$current_poi = null, $limit = null)
    {
        $select = $this->select()
                  ->setIntegrityCheck(FALSE)
                  ->from(array('atp' => $this->_name),array('poi_id'))
                  ->join('poi','atp.poi_id = poi.poi_id')
                  ->join('poidescription','poi.poi_id = poidescription.poi_id',array('name'))
                  ->where('poidescription.language_id = ?',$language_id)
                  ->where('area_id = ?',$area_id);
          if($current_poi != null)
          {
              $select->where('poi.poi_id <> ?',$current_poi);
          }
          if(null != $limit) {
            $select->limit($limit);
          }
        return $this->fetchAll($select)->toArray();          
    }

    /**
     * Fungsi untuk mengambil data poi_id dari tabel areatopoi dan name dari
     * tabel poi berdasarkan area_id dan poi_id yang diberikan
     * 
     * @param integer $area_id
     * @param integer $poi_id
     * @return array
     */
    public function getAllPoiByAreaIdExPoi($area_id,$poi_id)
    {
        $select = $this->select()
                  ->setIntegrityCheck(FALSE)
                  ->from(array('atp' => $this->_name),array('poi_id'))
                  ->join('poi','atp.poi_id = poi.poi_id',array('name'))
                  ->where('atp.poi_id <> ?',$poi_id)
                  ->where('atp.area_id = ?',$area_id);
        return $this->fetchAll($select)->toArray();          
    }    

    /**
     * Fungsi untuk mendapatkan area_id berdasarkan poi_id yang diberikan
     * 
     * @param integer $poi_id
     * @return array
     */
    public function getPoiAreaId($poi_id)
    {
        $select = $this->select()
                  ->from(($this->_name),array('area_id'))
                  ->where('poi_id = ?',$poi_id)
                  ->order('poi_id ASC');
         return $this->fetchAll($select)->toArray(); 
    }

    /**
     * 
     */
    public function getProvinceByPoiId($poiId)
    {
         $select = $this->select()
                  ->from($this->_name, array('area_id'))
                  ->join($this->_area,
                      "{$this->_area}.area_id = {$this->_name}.area_id")
                  ->where("{$this->_name}.poi_id = ?", $poiId)
                  ->where("{$this->_area}.area_type = ?", 1)
                  ->setIntegrityCheck(false);

         $data = $this->fetchRow($select);

         return $data['area_id'];
    }
	
	/**
     * Fungsi untuk mendapatkan area_id dan typenya berdasarkan poi_id yang 
     * diberikan
     * 
     * @param integer $poi_id
     * @return array
     */
    public function getAreaIdType($poi_id)
    {
        $select = $this->select()
                  ->setIntegrityCheck(FALSE)
                  ->from(array('atp' => $this->_name),array('area_id'))
                  ->join('area','atp.area_id = area.area_id',array('area_type'))
                  ->where('poi_id = ?',$poi_id)
                  ->order('poi_id ASC');
         return $this->fetchAll($select)->toArray(); 
    }

    /**
     * Fungsi untuk mendapatkan id area kabupaten dari suatu destinasi
     * 
     * @param integer $poiId poi Id
     * @return array
     */
    public function getCityByPoiId($poiId)
    {
        $select = $this->select()
                  ->from($this->_name, array('area_id'))
                  ->join($this->_area, 
                      "{$this->_area}.area_id = {$this->_name}.area_id",
                      array())
                  ->where("{$this->_name}.poi_id = ?", $poiId)
                  ->where("{$this->_area}.area_type = ?", 2);

        //echo $select->__toString();
        $data = $this->fetchAll($select);

        $newData = array();
        foreach($data as $row) {
            $newData[] = $row['area_id'];
        }

        return $newData;
    }

    /**
     * Fungsi untuk mengambil data area_id dari tabel areatopoi dan semua data di
     * tabel area berdasarkan poi_id dan type yang diberikan
     * 
     * @param integer $poi_id
     * @param integer $special
     * @return <type>
     */
    public function getPoiAreaIdProvince($poi_id,$special = 0)
    {
        $select = $this->select()
                  ->setIntegrityCheck(FALSE)
                  ->from(array('atp' => $this->_name),array('area_id'))
                  ->join(array('a' => 'area'),'atp.area_id = a.area_id',array())
                  ->where('atp.poi_id = ?',$poi_id)
                  ->where('a.area_type > 0')
                  ->order('atp.poi_id ASC');
         if($special == 1)
         {
            $select->join(array('p' => 'poi'),'atp.poi_id = p.poi_id',array());
            $select->where('p.special = 1');
         }
         return $this->fetchAll($select)->toArray(); 
    }

    /**
     * Fungsi untuk mendapatkan jumlah data area_id berdasarkan poi_id yang
     * diberikan
     * 
     * @param integer $poi_id
     * @return integer
     */
    public function countAreaByPoiId($poi_id)
    {
        $select = $this->select()
                  ->from(($this->_name),array('COUNT(area_id) AS amount'))
                  ->where('poi_id = ?',$poi_id);
        $amount = $this->fetchAll($select)->toArray();                        
        return $amount[0]['amount'];
    }

    /**
	 *
	 */
	public function getAreaType($poi_id)
	{
		$data = $this->getAreaIdType($poi_id);
		if ($data != NULL)
		{
			$type = 0;
			foreach($data as $row)
			{
				if ($row['area_type']>$type)
				{
					$type = $row['area_type'];
					$id = $row['area_id'];
				}
			}
			return array ('area_id' => $id, 'area_type' => $type);
		}
		else 
		{
			return false;
		}
	}
}