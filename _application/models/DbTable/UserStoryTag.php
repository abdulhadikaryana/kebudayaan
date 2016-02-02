<?php
/**
 * Model_DbTable_UserStoryTag
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel user story tags
 *
 * @package DbTable Model
 */

class Model_DbTable_UserStoryTag extends Zend_Db_Table_Abstract
{

    //put your code here
    protected $_name = 'userstorytag';
    protected $_userstory = 'userstory';
    protected $_userstorycontent = 'userstorycontent';
    protected $_contributor = 'userstorycontributor';
    protected $_primary = array('id');


    public function insertStoryTags($story_id,$object_id,$object_type,$lang_id){
        
        $data = array(
                    'userstory_id'     =>$story_id,
                    'object_id'   =>$object_id,
                    'object_type'   =>$object_type,
                    'language_id'=>$lang_id
                );
        
        $this->insert($data);
        
    }

    public function getTag($story_id,$lang_id)
    {
        $query = $this->select()
                ->from($this->_name,array('id','userstory_id','object_id','object_type'))
                ->where("{$this->_name}.userstory_id = ?",$story_id)
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
    
    public function removeTag($tagId)
    {
       $where = $this->getAdapter()->quoteInto('id = ?', $tagId);
       $this->delete($where);
    }



    public function getLastId()
    {
        $data = $this->select()
                ->from($this->_name,array('id'))
                ->order("{$this->_name}.id DESC")
                ->limit(1);
                
        $result = $this->fetchRow($data);
        
        if(count($result))
        {
            return  $result;
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


    /*
    untuk mendapatkan content berdasarkan tags id
    */
    public function getByTagId($tag_id,$tag_type,$lang_id)
    {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name)
                ->join($this->_userstory,"{$this->_userstory}.id = {$this->_name}.userstory_id",array('id','user_id','approved','DAY(date) AS tanggal','MONTH(date) AS bulan','YEAR(date) AS tahun','category','viewed','rating'))
                ->join($this->_userstorycontent,"{$this->_userstorycontent}.userstory_id = {$this->_userstory}.id",array('title','content','language_id'))
                ->join($this->_contributor,"{$this->_contributor}.id = {$this->_userstory}.user_id",array('nama','contact','foto','email'))
                ->where("{$this->_name}.object_id = ?",$tag_id)
                ->where("{$this->_name}.object_type = ?",$tag_type)
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

}
?>
