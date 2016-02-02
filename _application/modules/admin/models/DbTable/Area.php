<?php
class Admin_Model_DbTable_Area extends Zend_Db_Table_Abstract
{
    protected $_name        = 'area';
    protected $_account     = 'admin_account';
    protected $_primary     = 'area_id';

    public function getParentArea()
    {
        $query = $this->select()->setIntegrityCheck(false)
                ->from(array('area' => $this->_name), array('area.area_id', 'area.name'))
                ->join(array('areatopoi' => 'areatopoi'), 'area.area_id = areatopoi.area_id', array())
                ->join(array('cp' => 'categorytopoi'), 'areatopoi.poi_id = cp.poi_id', array())
                ->join(array('cat' => 'category'), 'cp.category_id = cat.category_id', array('count_category' => 'COUNT(cat.category_id)'))
                ->where('area.parent_id = 0')
                ->group(array('area.area_id', 'area.name'))
        ;

        $result = $this->fetchAll($query);

        return (!empty($result)) ? $result->toArray() : null;
    }

    public function getSubArea($id)
    {
        $query = $this->select()->setIntegrityCheck(false)
            ->from(array('area' => $this->_name), array('area.area_id', 'area.name'))
            ->join(array('areatopoi' => 'areatopoi'), 'area.area_id = areatopoi.area_id', array())
            ->join(array('cp' => 'categorytopoi'), 'areatopoi.poi_id = cp.poi_id', array())
            ->join(array('cat' => 'category'), 'cp.category_id = cat.category_id', array('count_category' => 'COUNT(cat.category_id)'))
            ->where('area.parent_id = ?', $id)
            ->group(array('area.area_id', 'area.name'))
        ;

        $result = $this->fetchAll($query);

        return (!empty($result)) ? $result->toArray() : null;
    }

    public function getAreaForPie($id)
    {
        $query = $this->select()->setIntegrityCheck(false)
            ->from(array('area' => $this->_name), array())
            ->join(array('areatopoi' => 'areatopoi'), 'area.area_id = areatopoi.area_id', array())
            ->join(array('cp' => 'categorytopoi'), 'areatopoi.poi_id = cp.poi_id', array())
            ->join(array('cat' => 'category'), 'cp.category_id = cat.category_id',
                    array('cat.category_id', 'cat.name', 'count_category' => 'COUNT(cat.category_id)'))
            ->where('area.area_id = ?', $id)
            ->group(array('cat.category_id', 'cat.name'))
        ;

        $result = $this->fetchAll($query);

        return (!empty($result)) ? $result->toArray() : null;
    }

    public function getAreaName($id)
    {
        $query = $this->select()->setIntegrityCheck(false)
            ->from($this->_name, array($this->_name.".name"))
            ->where($this->_name.'.area_id = ?', $id)
        ;

        $result = $this->fetchRow($query);
        return (!empty($result)) ? $result->toArray() : null;
    }
}