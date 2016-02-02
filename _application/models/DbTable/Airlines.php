<?php
/**
 * Model_DbTable_Airlines
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel airlines
 *
 * @package DbTable Model
 */
class Model_DbTable_Airlines extends Zend_Db_Table_Abstract
{
    /** The default table name */
    protected $_name = 'airlines';
    protected $_airdesc = 'airlinesdescription';
    protected $_airtel = 'airlinestelephone';
    protected $_primary = 'airline_id';

    /**
     * Fungsi untuk mengambil semua data telepon dari tabel airlinestelephone
     * dan membentuk array yang sesuai dengan kebutuhan viewer airline
     *
     * Sengaja di join untuk menghindari pembuatan model airlinetelephone
     *
     * @return array
     */
    public function getAllTelp()
    {
        $data = $this->select()
                ->from(array('air' => $this->_name), array())
                ->join(array('tel' => $this->_airtel), 
                        'air.airline_id=tel.airline_id')
                ->setIntegrityCheck(false);

        $result = $this->fetchAll($data);

        $old = '';
        for ($i = 0; $i < count($result); $i++)
        {
            if ($old == $result[$i]['airline_id']) 
            {
                $new[$result[$i]['airline_id']] .=
                    "<br />" . $result[$i]['telephone'];
            }
            else 
            {
                $new[$result[$i]['airline_id']] = $result[$i]['telephone'];
            }
            $old = $result[$i]['airline_id'];
        }
        
        return $new;
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel airlines dan
     * airlinesdescription berdasarkan language_id yang diberikan
     * 
     * @param integer $lang_id
     * @return array
     */
    public function getAllWithDesc($lang_id = 1)
    {
        $data = $this->select()
                ->from(array('air' => $this->_name))
                ->join(array('desc' => $this->_airdesc),
                    'desc.airline_id = air.airline_id')
                ->setIntegrityCheck(false)
                ->where('desc.language_id = ?', $lang_id);

        $result = $this->fetchAll($data);
        
        return $result;
    }

    /**
     * 
     */
    public function getAllQuery($filter = null, $param = null,$langId=1)
    {
        $query = $this->select()
                ->from($this->_name)
                ->join($this->_airdesc,"{$this->_airdesc}.airline_id = {$this->_name}.airline_id")
                ->join($this->_airtel,"{$this->_airtel}.airline_id = {$this->_name}.airline_id")
                ->setIntegrityCheck(false)
                ->where("{$this->_airdesc}.language_id = ?",$langId)
                ->group("{$this->_airdesc}.airline_id")
                ->order("{$this->_name}.airline_id ASC");
         if($filter == 1){$query->where("{$this->_airdesc}.name LIKE '%".$param."%'");}

        return $query;
    }
    
    /**
     * Fungsi untuk menghapus record dari basis data airlines sesuai masukan 
     * airline_id
     * 
     * @param int $airline_id
     */
    public function deleteAirline($airline_id)
    {
        $where = $this->getAdapter()->quoteInto('airline_id = ?',$airline_id);
        $this->delete($where);
    }

    /**
     * Fungsi untuk memasukkan record baru ke dalam basis data airlines
     * 
     * @param array $input
     * @return int
     */
    public function insertAirlines($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }

    /**
     * Fungsi untuk memutakhirkan record di basis data airlines sesuai masukan 
     * airline_id
     * 
     * @param array $input
     * @param int $airline_id
     */
    public function updateAirline($input,$airline_id)
    {
        $where = $this->getAdapter()->quoteInto('airline_id = ?',$airline_id);
        $this->update($input, $where);
    }

    /**
     * 
     */
    public function getAllQueryByIdLang($airlineId, $langId = 1)
    {
        $query = $this->select()
                ->from($this->_name)
                ->join($this->_airdesc,"{$this->_airdesc}.airline_id = {$this->_name}.airline_id")
                ->join($this->_airtel,"{$this->_airtel}.airline_id = {$this->_name}.airline_id")
                ->setIntegrityCheck(false)
                ->where("{$this->_name}.airline_id = ?", $airlineId)
                ->where("{$this->_airdesc}.language_id = ?", $langId)
                ->group("{$this->_airdesc}.airline_id");
        $data = $this->fetchRow($query);
        return $data;
    }
}
?>