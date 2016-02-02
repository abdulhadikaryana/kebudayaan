<?php
/**
 * Model_DbTable_TourismOperator
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel tourism operator
 *
 * @package DbTable Model
 */
class Model_DbTable_TourismOperator extends Zend_Db_Table_Abstract
{
    protected $_name = 'tourismoperator';
    protected $_ctt = 'classificationtotourismoperator';
    protected $_td = 'tourismoperatordescription';
    protected $_cd = 'classificationdirectory';
    protected $_dir = 'directory';
    protected $_cov = 'coveragearea';

    /**
     * Fungsi untuk memasukkan data input ke dalam tabel tourimoperator
     * @param integer $input
     * @return array
     */
    public function insertTourismOperator($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }

    /**
     * Fungsi untuk mengupdate data dalam tabel tourismoperator berdasarkan data
     * input dan tourismoperator_id yang diberikan
     * @param data $input
     * @param integer $tourism_id
     */
    public function updateTourismOperator($input,$tourism_id)
    {
        $where = $this->getAdapter()->quoteInto('tourismoperator_id = ?',$tourism_id);
        $this->update($input, $where);
    }

    /**
     * Fungsi untuk menghapus data dari tabel tourismoperator berdasarkan
     * tourismoperator_id yang diberikan
     * @param integer $tourism_id
     */
    public function deleteTourismOperator($tourism_id)
    {
        $where = $this->getAdapter()->quoteInto('tourismoperator_id = ?',$tourism_id);
        $this->delete($where);        
    }

    /** fungsi untuk mengembalikan query berdasarkan filter parameter
     * 0/semua data, 1/berdasarkan nama pada tourism op. description, 2/berdasar classification, 3/berdasar area
     * @return string 
    */
    public function getQueryAllByLang($type = 0,$param = null,$language_id = 1)
    {
        $select = $this->select()
                  ->setIntegrityCheck(false)
                  ->from(array('top' => $this->_name))
                  ->join(array('todes' => 'tourismoperatordescription'),'top.tourismoperator_id = todes.tourismoperator_id',array('name'))
                  ->where('todes.language_id = ?',$language_id);

        if($type == 1)
        {
            $select->where("todes.name LIKE '%".$param."%'");
        }
        elseif($type == 2)
        {
            $select->join(array('ctto' => 'classificationtotourismoperator'),'ctto.tourismoperator_id = top.tourismoperator_id');            
            $select->where('ctto.classification_id = ?',$param);
        }
        elseif($type == 3)
        {
            $select->where('top.area_id = ?',$param);
        }
        
        $select->order('top.area_id DESC');
        return $select;
    }
    
    /** fungsi untuk mengembalikan query berdasarkan filter parameter
     * 0/semua data, 1/berdasarkan nama pada tourism op. description, 2/berdasar classification, 3/berdasar area
     * @return string 
    */
    public function getQueryVitoByLang($type = 0,$param = null,$language_id = 1)
    {
        $select = $this->select()
                  ->setIntegrityCheck(false)
                  ->from(array('top' => $this->_name))
                  ->join(array('todes' => 'tourismoperatordescription'),'top.tourismoperator_id = todes.tourismoperator_id',array('name'))
                  ->where('todes.language_id = ?',$language_id)
                  ->join(array('ctto' => 'classificationtotourismoperator'),'ctto.tourismoperator_id = top.tourismoperator_id')            
                  ->where('ctto.classification_id = 6');

        if($type == 1)
        {
            $select->where("todes.name LIKE '%".$param."%'");
        }
        elseif($type == 2)
        {
            $select->where('top.area_id = ?',$param);
        }
        
        $select->order('top.area_id DESC');
        return $select;
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel tourismoperator
     * @return array
     */
    public function getAll()
    {
        $data = $this->select()
                ->from($this->_name);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel tourismoperator berdasarkan
     * tourismoperator_id yang diberikan
     * 
     * @param integer $id
     * @return array
     */
    public function getAllById($id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('tourismoperator_id = ?', $id);
        return $this->fetchRow($data);
    }

    /**
     * Fungsi untuk mengambil semua data berdasarkan tourismoperator_id dan
     * language_id yang diberikan
     * @param integer $tourism_id
     * @param integer $language_id
     * @return array
     */
    public function getAllTourismDataByIdLang($tourism_id, $language_id)
    {
        $data = $this->select()
                ->setIntegrityCheck(FALSE)
                ->from(array('to' => $this->_name))
                ->join(array('tod' => 'tourismoperatordescription'),'tod.tourismoperator_id = to.tourismoperator_id',array('language_id','langname' => 'name','description','language_id','name'))
                ->where('to.tourismoperator_id = ?',$tourism_id)
                ->where('tod.language_id = ?',$language_id);
        //echo $data->__toString();
        return $this->fetchRow($data);                
    }

//    public function getAllQueryByTourId($tourismoperator_id, $language_id){
//        $query = $this->select()
//                ->setIntegrityCheck(false)
//                ->from($this->_name)
//                ->join($this->_td,"{$this->_name}.tourismoperator_id = {$this->_td}.tourismoperator_id",array('name','description'))
//                ->where("{$this->_name}.tourismoperator_id = ?", $tourismoperator_id)
//                ->where("{$this->_l}");
//    }

    /**
     * Fungsi untuk mengambil semua data dari tabel tourismoperator berdasarkan
     * tourismoperator_id yang diberikan
     * @param integer $id
     * @return array
     */
    public function getAllExId($id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('tourismoperator_id != ?', $id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel tourismoperator berdasarkan
     * area_id yang diberikan
     * @param integer $area_id
     * @return array
     */
    public function getAllByArea($area_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('area_id = ?', $area_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel tourismoperator berdasarkan
     * tourismoperator_id dan area_id yang diberikan
     * @param integer $tourism_id
     * @param integer $area_id
     * @return array
     */
    public function getAllByIdArea($tourism_id, $area_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('tourismoperator_id = ?', $tourism_id)
                ->where('area_id = ?', $area_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsu untuk mengambil semua data dari tabel tourismoperator berdssarkan
     * name yang diberikan
     * @param string $name
     * @return array
     */
    public function getAllByName($name)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where("name LIKE '%" . $name . "%'");
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data name dari tabel tourismoperator 
     * @return array
     */
    public function getAllName()
    {
        $data = $this->select()
                ->from($this->_name,array('name'));
        return $this->fetchAll($data);
    }

    public function getTourismoperatorById($poiId, $classification_id, 
        $languageId, $sortingOptions = null)
    {
		$areaDb = new Model_DbTable_Area;
		$areaList = $areaDb->getCitiesByPoiId($poiId, $languageId);

        $query = $this->select()
                ->from($this->_name)
                ->join($this->_ctt,"{$this->_ctt}.tourismoperator_id = {$this->_name}.tourismoperator_id",array('classification_id'))
                ->join($this->_td,
                    "{$this->_td}.tourismoperator_id = {$this->_name}.tourismoperator_id",
                     array('name AS nama', 'description'))
                ->setIntegrityCheck(false)
                ->where("{$this->_td}.language_id = ?", $languageId)
                ->where("{$this->_ctt}.classification_id = ?", $classification_id)
                ->where("{$this->_name}.area_id IN (?)", $areaList);
                
       if( ! empty($sortingOptions['search_name'])) {
           $query->where("{$this->_td}.name LIKE ?", '%'.$sortingOptions['search_name'].'%');
       }

       $sortBy = $this->_getSortBy($sortingOptions['sort_by'],
                                    $sortingOptions['sort_order']);

       $query->order($sortBy);

       //echo $query->__toString();
       
       return $query;
    }

    public function getTravelAgentById($poiId, $classification_id,
        $languageId, $sortingOptions = null)
    {

		$areaDb = new Model_DbTable_Area;
		$areaList = $areaDb->getCitiesByPoiId($poiId, $languageId);

        $query = $this->select()
                ->from($this->_name)
                ->join($this->_ctt,"{$this->_ctt}.tourismoperator_id = {$this->_name}.tourismoperator_id",array('classification_id'))
                ->join($this->_td,
                    "{$this->_td}.tourismoperator_id = {$this->_name}.tourismoperator_id",
                     array('name AS nama', 'description'))
                ->join($this->_cov, "{$this->_cov}.tourismoperator_id = {$this->_name}.tourismoperator_id", array())
                ->setIntegrityCheck(false)
                ->where("{$this->_td}.language_id = ?", $languageId)
                ->where("{$this->_ctt}.classification_id = ?", $classification_id)
                ->where("{$this->_cov}.area_id IN (?)", $areaList)
                ->group("{$this->_name}.tourismoperator_id");
                
        //echo $query->__toString();

        return $query;
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel tourismoperator dan
     * tourismoperatordescription berdasarkan language_id dan
     * classification_id yang diberikan
     * @param integer $classification_id
     * @param integer $lang_id
     * @return array
     */
    public function getAllWithDescById($classification_id, $lang_id = 1)
    {
        $data = $this->select()
                ->from(array('tod' => $this->_td))
                ->join(array('to' => $this->_name), 
                        'tod.tourismoperator_id = to.tourismoperator_id')
                ->join(array('ctt' => $this->_ctt), 
                        'to.tourismoperator_id = ctt.tourismoperator_id')
                ->setIntegrityCheck(false)
                ->where('ctt.classification_id = ?', $classification_id)
                ->where('tod.language_id = ?', $lang_id);

        $result = $this->fetchAll($data);

        return $result;
    }

    /**
     * Fungsi untuk mendukung sorting
     *
     * @param string $sort field sorting
     * @param string $sortOrder urutan sorting
     *
     * @return string gabungan antara $sort dan $sortOrder
     */
    private function _getSortBy($sort = 'name',
        $sortOrder = 'DESC')
    {
        if ($sortOrder == '') {
            $sortOrder = 'DESC';
        }

        $sortBy = '';

        if($sort == 'name')
            $sortBy = "{$this->_td}.name";
        elseif($sort == 'star')
            $sortBy = "{$this->_name}.star";
        else
            $sortBy = "{$this->_td}.name";

        return $sortBy . ' ' . $sortOrder;
    }

}
?>
