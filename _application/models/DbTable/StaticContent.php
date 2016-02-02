<?php
/**
 * Model_DbTable_StaticContent
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel static content
 *
 * @package DbTable Model
 */
class Model_DbTable_StaticContent extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'staticcontent';

    /**
     * Fungsi untuk melakukan update static content 
     * @return array
     */
    public function updateStaticContent($input,$static_id,$langId = 1)
    {
        $where = $this->getAdapter()->quoteInto('static_id = ?',$static_id).
                 $this->getAdapter()->quoteInto('AND language_id = ?',$langId);
        $this->update($input, $where);
    }
    
    /**
     * Fungsi untuk menggenerate select untuk mengambil semua data 
     * pada tabel static content
     * @return array
     */
    public function getSelectAllByLangId($language_id)
    {
        $select = $this->select()
                  ->from($this->_name)
                  ->where('language_id = ?',$language_id);
        return $select;
    }
    
    
    /**
     * Fungsi untuk mengambil data content dari tabel staticcontent berdasarkan
     * static_id dan language_id yang diberikan
     * @param integer $langId
     * @param integer $staticId
     * @return array
     */
    public function getContentByLangId($staticId, $langId = 1)
    {
        $query = $this->select()
                ->from($this->_name,array('title', 'content'))
                ->where("static_id LIKE '%".$staticId."%'")
                ->where('language_id = ?', $langId);
        return $this->fetchAll($query);
    }
}
?>
