<?php
/**
 * Model_DbTable_Related
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel related
 *
 * @package DbTable Model
 */
class Model_DbTable_Related extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = "related";
    protected $_reltyp = "relatedtype";
    
    /**
     * Fungsi untuk melakukan insert pada tabel related
     * @return array
     */
    public function insertRelated($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }

    public function getDataByRelId($id){
        $query = $this->select()
                ->from($this->_name,array('id','title','description','link'))
                ->where('id = ?', $id);
        return $this->fetchRow($query);
    }

    /**
     * Fungsi untuk melakukan update pada tabel related
     * @return array
     */
    public function updateRelated($input,$related_id)
    {
        $where = $this->getAdapter()->quoteInto('id = ?',$related_id);
        $this->update($input, $where);            
    }
    /**
     * fungsi untuk edit related type pada tabel related
     * 
     */
     public function updateTypeRelated()
     {
        
     }

    /**
     * Fungsi untuk melakukan delete pada tabel related
     * @return array
     */
    public function deleteRelated($related_id)
    {
        $where = $this->getAdapter()->quoteInto('id = ?',$related_id);
        $this->delete($where);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel related
     * @return array
     */
    public function getAll()
    {
        $query = $this->select()
                ->from($this->_name)
                ->order('id ASC');
        return $this->fetchAll($query);
    }
    
    /**
     * Fungsi untuk menggenerate query dari tabel related
     * @return array
     */
    public function getQueryAll($type = null)
    {
        $select = $this->select()
                  ->from($this->_name)
                  ->order('id DESC');
        if((isset($type))&&($type>0))
        {
            $select->where('jenisrelated = ?',$type);
        }
       // echo $select->__toString();
        return $select;
        //
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel related berdasarkan id yang
     * diberikan
     * 
     * @param integer $id
     * @return array
     */
    public function getAllById($id)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('id = ?', $id);
        //echo $query->__toString();
        return $this->fetchRow($query);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel related berdasarkan
     * jenisrelated yang diberikan
     * @param integer $type
     * @return array
     */
    public function getAllByType($type)
    {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name)
                ->join($this->_reltyp,"{$this->_name}.jenisrelated = {$this->_reltyp}.related_type",array(''))
                ->where("{$this->_reltyp}.related_type = ?", $type);
        return $this->fetchAll($query);
    }


    /**
     * Fungsi untuk mengambil jumlah data yang ada di tabel related
     * @return array
     */
    public function countAll()
    {
        $query = $this->select()
                ->from($this->_name,array('COUNT *'));
        return $this->fetchAll($query);
    }

    public function getAllTypeTwoTable()
    {
        $query = $this->select()
                ->from($this->_name,array(''))
                ->setIntegrityCheck(false)
                ->join($this->_reltyp,"{$this->_name}.jenisrelated = {$this->_reltyp}.related_type");
        //echo $query->__toString();
        return $this->fetchAll($query);
    }

    /**
     * Fungsi getAllButNotMainCategory untuk form select
     *
     * @param integer $langId language
     * @return array
     */
    public function getAllTypeDesc($top_label = "---All Categories---")
    {
        $category = $this->getAllTypeTwoTable();

        $categoryValue[0] = $top_label;
        foreach ($category as $tempCategory) {

            $categoryValue[$tempCategory['related_type']] = $tempCategory['name'];
        }

        return $categoryValue;
    }

}
?>
