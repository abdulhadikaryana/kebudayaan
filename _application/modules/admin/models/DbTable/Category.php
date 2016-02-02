<?php
class Admin_Model_DbTable_Category extends Zend_Db_Table_Abstract
{
    protected $_name        = 'category';
    protected $_description = 'categorydescription';
    protected $_account     = 'admin_account';
    protected $_primary     = 'category_id';

    public function getParentCategory()
    {
        $query = $this->select()->setIntegrityCheck(false)
                ->from(array('cat' => $this->_name), array('cat.category_id','cat.name'))
                ->join(array('poi' => 'poi'), 'cat.category_id = poi.main_category', array('poi_count' => 'COUNT(poi.poi_id)'))
                ->where('cat.parent_id = 0')
                ->group(array('cat.name'))
        ;

        $result = $this->fetchAll($query);

        return (!empty($result)) ? $result->toArray() : null;
    }

    public function getSubCategory($id)
    {
        $query = $this->select()->setIntegrityCheck(false)
                ->from(array('cat' => $this->_name), array('cat.category_id','cat.name'))
                ->join(array('poi' => 'poi'), 'cat.category_id = poi.main_category', array('poi_count' => 'COUNT(poi.poi_id)'))
                ->where('cat.parent_id = ?', intval($id))
                ->group(array('cat.name'))
        ;

        $result = $this->fetchAll($query);

        return (!empty($result)) ? $result->toArray() : null;
    }
}