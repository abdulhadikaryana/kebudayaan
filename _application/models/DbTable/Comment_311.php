<?php
/**
 * Model_DbTable_ClassificationDirectory
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel classification directory
 *
 * @package DbTable Model
 */
class Model_DbTable_ClassificationDirectory extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'classificationdirectory';

    public function getAllForMenu()
    {
        $query = $this->select()
                ->from($this->_name);
        $report = $this->fetchAll($query);
        $value[0] = '---Select Type---';
        foreach ($report as $tempData)
        {

            $value[$tempData['classification_id']] = $tempData['name'];
        }
        return $value;
    }

    public function getAllForMenuWithCache()
    {
        // set up cache
        $cache = Zend_Registry::get('cache');

        $class = null;

        // dibedakan key cache tiap bahasa
        $key = 'classification' ;
        // cek apakah categori disimpan di dalam cache
        // jika belum simpan disana
        if (!($class = $cache->load($key)))
        {
            $class = $this->getAllForMenu();
            $cache->save($class, $key);
        }

        return $class;
    }

}
?>
