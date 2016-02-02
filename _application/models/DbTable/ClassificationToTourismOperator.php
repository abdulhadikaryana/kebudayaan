<?php
/**
 * Model_DbTable_ClassificationToTourismOperator
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel classification to tourism operator
 *
 * @package DbTable Model
 */
class Model_DbTable_ClassificationToTourismOperator extends Zend_Db_Table_Abstract
{
    protected $_name = 'classificationtotourismoperator';
    protected $_tourism = 'tourismoperator';

    /**
     * Fungsi untuk memasukkan data ke dalam tabel classificationtotourismoperator
     * 
     * @param data $input
     */
    public function insertClassificationTourism($input)
    {
        $this->insert($input);
    }

    /**
     * Fungsi untuk menghapus data di tabel berdasarkan class_id dan tourism_id
     * yang diberikan
     * 
     * @param integer $class_id
     * @param integer $tourism_id
     */
    public function deleteClassificationTourism($classId,$tourismId)
    {
        $where = $this->getAdapter()->quoteInto('classification_id = ?',$classId).
        $this->getAdapter()->quoteInto(' AND tourismoperator_id = ?',$tourismId);
        $this->delete($where);
    }

    /**
     * Fungsi untuk menghapus data berdasarkan tourismoperator_id yang diberikan
     * @param integer $tourism_id
     */
    public function deleteAllClassByTourismId($tourismId)
    {
        $where = $this->getAdapter()->quoteInto('tourismoperator_id = ?',$tourismId);
        $this->delete($where);
    }

    /**
     * Fungsi untuk mendapatkan jumlah data yang mempuyai tourismoperator_id
     * seperti yang diberikan
     * 
     * @param integer $tourism_id
     * @return integer
     */
    public function countClassByTourismId($tourism_id)
    {
        $select = $this->select()
                  ->from($this->_name,array('COUNT(classification_id) AS amount'))
                  ->where('tourismoperator_id = ?',$tourism_id);
        $result = $this->fetchRow($select)->toArray();
        return $result['amount'];
    }
    /**
     * Fungsi untuk mengambil data classification_id berdasarkan
     * tourismoperator_id yang diberikan
     * @param integer $tourism_id
     * @return array
     */
    public function getAllClassByTourismId($tourism_id)
    {
        $select = $this->select()
                  ->from($this->_name,array('class' => 'classification_id'))
                  ->where('tourismoperator_id = ?', $tourism_id);
        return $this->fetchAll($select)->toArray();
    }

    public function getAllClassIDByPoiId($poiId, $languageId)
    {
        $areaDb = new Model_DbTable_Area;
        $areaList = $areaDb->getCitiesByPoiId($poiId, $languageId);

        if(count($areaList) > 0) {
            $query = $this->select()
                    ->from($this->_name, array('classification_id'))
                    ->join($this->_tourism,
                        "{$this->_tourism}.tourismoperator_id = {$this->_name}.tourismoperator_id",
                         array())
                    ->setIntegrityCheck(false)
                    ->where("{$this->_tourism}.area_id IN (?)", $areaList);
            return $this->fetchAll($query)->toArray();
        }

        return array();
       //echo $query->__toString();

    }

    /**
     * Fungsi untuk mengubah bentuk array dari hasil output method
     * getAllClassByTourismId
     * 
     * @param integer $tourismId
     * @return array
     */
    public function getAllClassIDByPoiIdForForm($poiId, $languageId)
    {
        $tourism = $this->getAllClassIDByPoiId($poiId, $languageId);
        if($tourism != false)
        {
            $tourismRow = array();
            foreach($tourism as $row) {
                $tourismRow[] = $row['classification_id'];
            }
    
            return $tourismRow;
        }
    }

    /**
     * Fungsi untuk mengambil data classification_id dan name berdasarkan
     * tourismoperator_id yang diberikan
     * @param integer $tourism_id
     * @return array
     */
    public function getallClassIdNameByTourismId($tourism_id)
    {
        $select = $this->select()
                  ->setIntegrityCheck(FALSE)
                  ->from(array('ctto' => $this->_name),array('class' => 'classification_id'))
                  ->join(array('class' =>'classificationdirectory'),'class.classification_id = ctto.classification_id','name')
                  ->where('tourismoperator_id = ?', $tourism_id);
        return $this->fetchAll($select)->toArray();
    }

}