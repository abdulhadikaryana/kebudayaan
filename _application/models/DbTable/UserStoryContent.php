<?php
/**
 * Model_DbTable_UserStoryContent
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel user story content
 *
 * @package DbTable Model
 */

class Model_DbTable_UserStoryContent extends Zend_Db_Table_Abstract
{

    //put your code here
    protected $_name = 'userstorycontent';
    protected $_userstory = 'userstory';
    protected $_contributor = 'userstorycontributor';
    protected $_primary = array('id');

    public function insertStoryContent($userstory_id,$title,$content,$lang_id){
        
        $data = array(
                    'userstory_id'     =>$userstory_id,
                    'title'   =>$title,
                    'content'   =>$content,
                    'language_id'=>$lang_id,
                );
        
        $this->insert($data);
        
    }


    public function selectAllData($userstory_id){
        $data = $this->select()
                ->from($this->_name,array('id','userstory_id','title','content','language_id'))
                ->where("{$this->_name}.userstory_id = ?",$userstory_id);
                
                //->where("{$this->_name}.approved = ?",$approved);

        $result = $this->fetchRow($data);
        
        if(count($result))
        {
            
            
            return $result;
        }
        else
        {
            return NULL;
        }
    }


    public function getById($id,$lang_id){
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id as content_id','userstory_id','title','short_content','content','language_id'))
                ->join($this->_userstory,"{$this->_userstory}.id = {$this->_name}.userstory_id")
                ->join($this->_contributor,"{$this->_contributor}.id = {$this->_userstory}.user_id")
                ->where("{$this->_name}.userstory_id = ?",$id)
                ->where("{$this->_name}.language_id = ?",$lang_id);

        $result = $this->fetchRow($data);
        
        if(count($result) > 0)
        {
            return $result;
        }
        else
        {
            return NULL;
        }
        
    }

    /*
    * detail userstroy content yang bertipe photoessay
    */
    public function phottoessayContent($userstory_id,$lang_id){
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id as content_id','userstory_id','title','short_content','content','language_id'))
                ->join($this->_userstory,"{$this->_userstory}.id = {$this->_name}.userstory_id")
                ->where("{$this->_name}.userstory_id = ?",$userstory_id)
                ->where("{$this->_name}.language_id = ?",$lang_id);
            
        $result = $this->fetchRow($data);
        
        if(count($result) > 0)
        {
            return $result;
        }
        else
        {
            return NULL;
        }
        
    }
    
    //update data
    public function updateField($id,$title,$content,$lang_id)
    {
        $data = array('title' => $title,
                      'content' => $content,
                      'language_id' => $lang_id
                      );
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        $this->update($data, $where);

    }


    /*
        delete data
    */
    public function deleteField($userstory_id)
    {
       $where = $this->getAdapter()->quoteInto('userstory_id = ?', $userstory_id);
       $this->delete($where);
    }
}
?>
