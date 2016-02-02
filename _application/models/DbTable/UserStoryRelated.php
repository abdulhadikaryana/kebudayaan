<?php
/**
 * Model_DbTable_UserStoryRelated
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel user story realted
 *
 * @package DbTable Model
 */

class Model_DbTable_UserStoryRelated extends Zend_Db_Table_Abstract
{

    //put your code here
    protected $_name = 'userstoryrelated';
    protected $_userstory = 'userstory';
    protected $_userstorycontent = 'userstorycontent';
    protected $_contributor = 'userstorycontributor';
    protected $_category = 'userstorycategory';
    protected $_primary = array('id');

    public function insertRealatedStory($userstoryId,$userstory_categoryId,$langId){
        
        $data = array(
                'userstory_id'     =>$userstoryId,
                'userstorycategory_id'   =>$userstory_categoryId,
                'language_id'=>$langId
            );
        
        $this->insert($data);
    }

    //hanya menampilkan category yang mempunyai artikel
    public function selectCatHasContent($lang_id)
    {
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('userstorycategory_id'))
                ->join($this->_category,"{$this->_category}.id = {$this->_name}.userstorycategory_id",array('id as id_category','title'))
                ->where("{$this->_category}.language_id = ?",$lang_id)->group('title');

        $result = $this->fetchAll($data);

        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }
    }
    
    public function getByUserStoryId($userstoryId,$lang_id)
    {
        $query = $this->select()
                ->from($this->_name,array('id','userstorycategory_id'))
                ->where("{$this->_name}.userstory_id = ?",$userstoryId)
                ->where("{$this->_name}.language_id = ?",$lang_id);

        $result = $this->fetchAll($query);
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }                
    }
    
    /*
        get last id
        param = userstory_id
    */
    public function getLastId($userstory_id)
    {
        $query = $this->select()
                ->from($this->_name,array('id','userstorycategory_id'))
                ->where("{$this->_name}.userstory_id = ?",$userstory_id)
                ->order("id DESC")
                ->limit(1);

        $result = $this->fetchRow($query);
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }                        
    }


    /*
        remove relasi antara userstory dan userstory_category
    */
    public function removeRelatedContent($related_id)
    {
       $where = $this->getAdapter()->quoteInto('id = ?', $related_id);
       $this->delete($where);
    }


    /* Fungsi untuk menampilkan userstory content berdasarkan userstory category*/
    public function select_content($category_id){
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name)
                ->join($this->_userstory,"{$this->_userstory}.id = {$this->_name}.userstory_id",array('id','user_id','approved','DAY(date) AS tanggal','MONTH(date) AS bulan','YEAR(date) AS tahun','category','viewed','rating','post_thumbnail'))
                ->join($this->_userstorycontent,"{$this->_userstorycontent}.userstory_id = {$this->_userstory}.id",array('title','content','language_id'))
                ->join($this->_contributor,"{$this->_contributor}.id = {$this->_userstory}.user_id",array('nama','contact','foto','email'))
                ->where("{$this->_name}.userstorycategory_id = ?",$category_id);
                
        $result = $this->fetchAll($data);
        
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }
    }

    /*
        remove field berdasarkan userstory_id
    */
    public function deleteField($userstory_id)
    {
       $where = $this->getAdapter()->quoteInto('userstory_id = ?', $userstory_id);
       $this->delete($where);
    }
    
}
?>
