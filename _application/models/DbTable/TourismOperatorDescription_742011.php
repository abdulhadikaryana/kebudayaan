<?php
/**
 * Model_DbTable_TourismOperator
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel tourism operator
 *
 * @package DbTable Model
 */
class Model_DbTable_TourismOperatorDescription extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'tourismoperatordescription';

    /**
     * Fungsi untuk memasukkan semua data ke dalam tabel tourismoperatordescription
     * @param data $input
     * @return array
     */
    public function insertTourismOperatorDescription($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }

    public function checkForIndo($catId,$langId=2)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('tourismoperator_id = ?', $catId)
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
     * Fungsi untuk mengupdate data dari tabel tourismoperatordescription
     * berdasarkan tourismoperraor_id yang diberikan
     * @param data $input
     * @param integer $tourism_id
     */
    public function updateTourismOperatorDescription($input,$tourism_id)
    {
        $where = $this->getAdapter()->quoteInto('tourismoperator_id = ?',$tourism_id).$this->getAdapter()->quoteInto('AND language_id = ?',$input['language_id']);
        $this->update($input, $where);
    }

    /**
     * Fungsi untuk menghapus data dari tabel tourismoperatordescription
     * berdasarkan tourismoperaotr_id yang diberikan
     * @param integer $tourism_id
     */
    public function deleteTourismOperatorDescription($tourism_id)
    {
        $where = $this->getAdapter()->quoteInto('tourismoperator_id = ?',$tourism_id);
        $this->delete($where);
    }

    public function deleteTourismOperatorDescription2($tourism_id,$language_id = 2)
    {
        $where = $this->getAdapter()->quoteInto('tourismoperator_id = ?',$tourism_id).
                 $this->getAdapter()->quoteInto('AND language_id = ?',$language_id);
        $this->delete($where);
    }

    public function checkDescIndo($catId)
    {
        $query = $this->select()
                ->from($this->_name,array('description'))
                ->where('language_id = 2')
                ->where('tourismoperator_id = ?',$catId);
        $result = $this->fetchRow($query);

        $query2 = $this->select()
                ->from($this->_name,array('COUNT(language_id) AS count'))
                ->where('tourismoperator_id = ?',$catId);
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
