<?php
/**
 * Model_DbTable_Related
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel related
 *
 * @package DbTable Model
 */
class Model_DbTable_RelatedDescription extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = "relateddescription";
    protected $_related = "related";
    protected $_reltyp = "relatedtype";
    protected $_primary = 'id';

    /**
     * Fungsi untuk melakukan insert pada tabel related
     * @return array
     */
    public function insertRelated($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }

    
    public function insertDataRel($data){
        $this->insert($data);
    }

    /**
     * Fungsi untuk melakukan update pada tabel related
     * @return array
     */
    public function updateRelated($input,$related_id, $langId)
    {
        $where[] = $this->getAdapter()->quoteInto('id = ?',$related_id);
        $where[] = $this->getAdapter()->quoteInto('language_id = ?',$langId);
        $this->update($input, $where);
    }

    public function updateRelatedIndo($input, $related_id, $langId)
    {
        $where[] = $this->getAdapter()->quoteInto('id = ?',$related_id);
        $where[] = $this->getAdapter()->quoteInto('language_id = ?',$langId);
        $this->update($input, $where);

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
     * Fungsi untuk melakukan delete related indo pada tabel relateddescription
     * @return array
     */
     public function deleteRelatedIndo($related_id,$langId)
     {
        $where[] = $this->getAdapter()->quoteInto('id = ?',$related_id);
        $where[] = $this->getAdapter()->quoteInto('language_id = ?',$langId);
        $this->delete($where);
     }

    /**
     * Fungsi untuk mengambil semua data dari tabel related
     * @return array
     */
    public function getAll()
    {
        $query = $this->select()
                ->from($this->_name,array('id','title','description','link'))
                ->setIntegrityCheck(FALSE)
                ->join($this->_related,"{$this->_name}.id = {$this->_related}.id",array('jenisrelated'))
                ->order("{$this->_name}.id ASC")
                ->where("{$this->_name}.language_id = 2");
        //echo $query->__toString();
        return $this->fetchAll($query);
    }

    /**
     * Fungsi untuk menggenerate query dari tabel related
     * @return array
     */
    public function getQueryAll($type = null,$langId = 2)
    {
        $select = $this->select()
                ->from($this->_name,array('id','title','description','link'))
                ->setIntegrityCheck(FALSE)
                ->join($this->_related,"{$this->_name}.id = {$this->_related}.id",array('jenisrelated'))
                ->order("{$this->_name}.id DESC")
                ->where("{$this->_name}.language_id = ?", $langId);
        if((isset($type))&&($type>0))
        {
            $select->where('jenisrelated = ?',$type);
        }
        return $select;
        //echo $select;
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
                ->from($this->_name,array('id','title','description','link'))
                ->setIntegrityCheck(FALSE)
                ->join($this->_related,"{$this->_name}.id = {$this->_related}.id",array('jenisrelated'))
                ->where("{$this->_name}.language_id = 2")
                ->where("{$this->_related}.id = ?", $id);
        //echo $query->__toString();
        return $this->fetchRow($query);
    }

    public function getAllByIdLangNew($id,$langId)
    {
        $query = $this->select()
                ->from($this->_name,array('id','title','description','link'))
                ->setIntegrityCheck(FALSE)
                ->join($this->_related,"{$this->_name}.id = {$this->_related}.id",array('jenisrelated'))
                ->where("{$this->_name}.language_id = ?",$langId)
                ->where("{$this->_related}.id = ?", $id);
        //echo $query->__toString();
        return $this->fetchRow($query);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel related berdasarkan
     * jenisrelated yang diberikan
     * @param integer $type
     * @return array
     */
    public function getAllByType($type,$langId)
    {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name)
                ->join($this->_related,"{$this->_name}.id = {$this->_related}.id",array(''))
                ->join($this->_reltyp,"{$this->_related}.jenisrelated = {$this->_reltyp}.related_type",array(''))
                ->where("{$this->_related}.jenisrelated = ?", $type)
                ->where("{$this->_name}.language_id = ?", $langId);
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

    public function getAllTypeTwoTable($langId)
    {
        $query = $this->select()
                ->from($this->_name,array(''))
                ->setIntegrityCheck(false)
                ->join($this->_related,"{$this->_name}.id = {$this->_name}.id")
                ->join($this->_reltyp,"{$this->_related}.jenisrelated = {$this->_reltyp}.related_type")
                ->where("{$this->_name}.language_id = ?", $langId);
        //echo $query->__toString();
        return $this->fetchAll($query);
    }

    /**
     * Fungsi getAllButNotMainCategory untuk form select
     *
     * @param integer $langId language
     * @return array
     */
    public function getAllTypeDescIndo($top_label = "---Semua Kategori---",$langId = 2)
    {
        $category = $this->getAllTypeTwoTable($langId);

        $categoryValue[0] = $top_label;
        foreach ($category as $tempCategory)
        {

            $categoryValue[$tempCategory['related_type']] = $tempCategory['name'];
        }

        return $categoryValue;
    }

    public function checkDescIndo($id, $langid)
    {
        $query = $this->select()
                ->from($this->_name,array('description'))
                ->where('language_id = ?',$langid)
                ->where('id = ?',$id);
        $result = $this->fetchRow($query);

        $query2 = $this->select()
                ->from($this->_name,array('COUNT(language_id) AS count'))
                ->where('id = ?',$id);
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

    public function checkForIndo($id,$langId)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('id = ?', $id)
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

}
?>
