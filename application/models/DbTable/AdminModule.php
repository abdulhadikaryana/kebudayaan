<?php
/**
 * Model_DbTable_AdminModule
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel modul admin
 *
 * @package Model
 */
class Model_DbTable_AdminModule extends Zend_Db_Table_Abstract 
{
    /** The default table name */
    protected $_name = 'admin_module';
    protected $_primary = 'module_id';
    protected $_sequence = true;

    /**
     * 
     */
    public function getAllModule($exception)
    {
        $select = $this->select()
                  ->from($this->_name)
                  ->where("{$this->_name}.module_name != ?",$exception)
                  ->order('module_name ASC');
                  echo $select;
        return $this->fetchAll($select);
    }
    
    /**
     * 
     */
    public function getAllModuleId()
    {
        $select = $this->select()
                  ->from(array('ar'=>$this->_name),array('module_id','module_name','action_name'))
                  ->order('module_name ASC');
                  //echo $select;
        $moduleId = $this->fetchAll($select)->toArray();
        $ctr = 0;
        foreach ($moduleId as $value)
        {
            $result[$ctr]['id'] = $value['module_id'];
            $result[$ctr]['controller'] = $value['module_name'];
            $result[$ctr]['action'] = $value['action_name'];
            $ctr++;
        }
        return $result;
    }
}