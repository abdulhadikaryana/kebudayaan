<?php
/**
 * Model_DbTable_AirlinesTelephone
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel telepon airlines
 *
 * @package DbTable Model
 */
class Model_DbTable_AirlinesTelephone extends Zend_Db_Table_Abstract
{
    /** The default table name */
    protected $_name = 'airlinestelephone';
    protected $_primary = 'airline_id';

    /**
     * Fungsi untuk menghapus record dari basis data airline telephone sesuai 
     * masukan airline_id
     * 
     * @param int $airline_id
     */
    public function deleteAirlineTelephone($airline_id)
    {
        $where = $this->getAdapter()->quoteInto('airline_id = ?',$airline_id);
        $this->delete($where);
    }

    /**
     * Fungsi untuk memasukkan record baru ke dalam basis data airline telephone
     * 
     * @param array $input
     * @return int
     */
    public function insertAirlinesTelp($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }

    /**
     * Fungsi untuk memutakhirkan record di basis data airline telephone sesuai
     * masukan airline_id
     * 
     * @param array $input
     * @param int $airline_id
     */
    public function updateAirlineTelp($input,$airline_id)
    {
        $where = $this->getAdapter()->quoteInto('airline_id = ?',$airline_id);
        $this->update($input, $where);
    }

    /**
     * 
     */
    public function getCountTelephoneById($airlineId)
    {
        $query = $this->select()
                ->from($this->_name,array('COUNT(telephone) AS count'))
                ->where('airline_id = ?', $airlineId);
        $count = $this->fetchRow($query);
        $return = $count->toArray();
        return $return['count'];
    }

    /**
     * 
     */
    public function getAllDataById($airlineId)
    {
        $query = $this->select()
                ->from($this->_name,array('telephone'))
                ->where('airline_id = ?', $airlineId);
        $count = $this->fetchAll($query);
        $return = $count->toArray();
        return $return;
    }

}
?>