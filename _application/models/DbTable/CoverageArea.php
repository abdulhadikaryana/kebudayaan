<?php
/**
 * Model_DbTable_CoverageArea
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel coverage area
 *
 * @package DbTable Model
 */
class Model_DbTable_CoverageArea extends Zend_Db_Table_Abstract
{
    protected $_name = 'coveragearea';
    protected $_ctt = 'classificationtotourismoperator';
    protected $_td = 'tourismoperatordescription';
    protected $_to = 'tourismoperator';
    
    public function insertCoverageArea($input)
    {
        $this->insert($input);
    }
    
    public function deleteCoverageByTourismId($tourism_id)
    {
        $where = $this->getAdapter()->quoteInto('tourismoperator_id = ?',$tourismoperator_id);
        $this->delete($where);
    }
    
    public function deleteCoverageByAreaId($area_id)
    {
        $where = $this->getAdapter()->quoteInto('area_id = ?',$area_id);
        $this->delete($where);
    }
    
    public function deleteSpecificCoverage($tourism_id,$area_id)
    {
        $select = $this->getAdapter()->quoteInto('area_id = ?',$area_id).
                 $this->getAdapter()->quoteInto(' AND tourismoperator_id = ?',$tourism_id);
        $this->delete($select);
    }
    
    public function getAllAreaByTourismId($tourism_id,$language_id = 1)
    {
        $select = $this->select()
                 ->setIntegrityCheck(FALSE)
                 ->from(array('ca' => $this->_name),array('area_id'))
                 ->join(array('ri' => 'regionalinformation'),'ca.area_id = ri.area_id',array('area_name'))
                 ->where('ca.tourismoperator_id = ?',$tourism_id)
                 ->where('ri.language_id = ?',$language_id);
        return $this->fetchAll($select)->toArray();
    }

    public function getTourismoperatorById($poiId, $classification_id,
        $languageId, $sortingOptions = null)
    {
		$areaDb = new Model_DbTable_Area;
		$areaList = $areaDb->getCitiesByPoiId($poiId, $languageId);

        $query = $this->select()
                ->from($this->_name)
                ->join($this->_to,"{$this->_to}.tourismoperator_id = {$this->_name}.tourismoperator_id")
                ->join($this->_ctt,"{$this->_ctt}.tourismoperator_id = {$this->_name}.tourismoperator_id", array('classification_id'))
                ->join($this->_td,
                    "{$this->_td}.tourismoperator_id = {$this->_name}.tourismoperator_id",
                     array('name AS nama', 'description'))
                ->setIntegrityCheck(false)
                ->where("{$this->_td}.language_id = ?", $languageId)
                ->where("{$this->_ctt}.classification_id = ?", $classification_id)
                ->where("{$this->_name}.area_id IN (?)", $areaList);

       $sortBy = $this->_getSortBy($sortingOptions['sort_by'],
                                    $sortingOptions['sort_order']);

       $query->order($sortBy);

       //echo $query->__toString();

       return $query;
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
        else
            $sortBy = "{$this->_td}.name";

        return $sortBy . ' ' . $sortOrder;
    }
}