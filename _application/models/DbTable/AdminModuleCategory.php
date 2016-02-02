<?php
/**
 * Model_DbTable_AdminModuleCategory
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel kategori modul admin
 *
 * @package Model
 */
class Model_DbTable_AdminModuleCategory extends Zend_Db_Table_Abstract 
{
    /** The default table name */
    protected $_name = 'admin_module_category';
    protected $_primary = 'category_id';
    protected $_sequence = true;

    /**
     * 
     */
    public function getAllModuleCategory()
    {
        $select = $this->select()
                  ->from(array('amc'=>$this->_name));
        return $this->fetchAll($select);
    }
}