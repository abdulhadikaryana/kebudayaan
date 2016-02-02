<?php
/**
 * Model_DbTable_PoiToPackage
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel poi to package
 *
 * @package DbTable Model
 */
class Model_DbTable_PoiToPackage extends Zend_Db_Table_Abstract
{
    protected $_name = 'poitopackage';    
    
    public function deleteAllPackageByPoiId($poi_id)
    {
        $where = $this->getAdapter()->quoteInto('poi_id = ?',$poi_id);
        $this->delete($where);
    }
}