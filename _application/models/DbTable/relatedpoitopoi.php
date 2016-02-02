<?php
/**
 * Model_DbTable_RelatedPoiToPoi
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel related poi to poi
 *
 * @package DbTable Model
 */
class Model_DbTable_RelatedPoiToPoi extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'relatedpoi';
    protected $_poi = 'poi';
    protected $_poides = 'poidescription';
    
    public function getAllPoiId()
    {
        $query = $this->select()
                ->from($this->_name,array(''))
                ->from($this->_poi,array('poi_id'));
        $data = $this->fetchAll($query);
        $return = $data->toArray();
        return $return;
    }

    /**
     * Fungsi untuk mengambil destinasi terkait dari tabel related poi
     * yang diambil secara acak dan diambil sebanyak 5 destinasi
     * @param integer $poi
     * @return array
     */
    

}
?>

