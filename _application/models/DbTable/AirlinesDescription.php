<?php
/**
 * Model_DbTable_AirlinesDescription
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel deskripsi airlines
 *
 * @package DbTable Model
 */
class Model_DbTable_AirlinesDescription extends Zend_Db_Table_Abstract
{
    /** The default table name */
    protected $_name = 'airlinesdescription';
    protected $_primary = 'airline_id';

    /**
     * Fungsi untuk menghapus record dari basis data airline description sesuai
     * masukan airline_id
     * 
     * @param int $airline_id
     */
    public function deleteAirlineDescription($airline_id)
    {
        $where = $this->getAdapter()->quoteInto('airline_id = ?',$airline_id);
        $this->delete($where);
    }

    public function deleteAirlineDescription2($airline_id, $language_id = 2)
    {
        $where = $this->getAdapter()->quoteInto('airline_id = ?',$airline_id).
                $this->getAdapter()->quoteInto(' AND language_id = ?', $language_id);
        $this->delete($where);
    }

    /**
     * Fungsi untuk memasukkan record baru ke dalam basis data airline 
     * description
     * 
     * @param array $input
     * @return int
     */
    public function insertAirlinesDesc($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }

    public function checkForIndo($catId,$langId=2)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('airline_id = ?', $catId)
                ->where('language_id = ?',$langId);
        $report = $this->fetchRow($query);
        if($report!=null)
            {
                return true;
        }else
            {
            return false;
        }
    }

    /**
     * Fungsi untuk memutakhirkan record di basis data airline description 
     * sesuai masukan airline_id
     * 
     * @param array $input
     * @param int $airline_id
     */
    public function updateAirlineDesc($input,$airline_id,$language_id)
    {
         $where = $this->getAdapter()->quoteInto('airline_id = ?',$airline_id).
                 $this->getAdapter()->quoteInto(' AND language_id = ?', $language_id);
        $this->update($input, $where);
    }

    public function checkDescIndo($catId)
    {
        $query = $this->select()
                ->from($this->_name,array('description'))
                ->where('language_id = 2')
                ->where('airline_id = ?',$catId);
        $result = $this->fetchRow($query);

        $query2 = $this->select()
                ->from($this->_name,array('COUNT(language_id) AS count'))
                ->where('airline_id = ?',$catId);
        $result2 = $this->fetchRow($query2);

        if($result2['count'] > '1')
        {
            if($result['description']==' ')
            {
                return false;
            }else
            {
                return true;
            }
        }
        else
        {
            return false;
        }
    }
    
}
?>