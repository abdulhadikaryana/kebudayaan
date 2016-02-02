<?php
/**
 * Model_DbTable_UserStoryCategory
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel user story category
 *
 * @package DbTable Model
 */

class Model_DbTable_UserStoryCategory extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'userstorycategory';
    protected $_primary = array('id');

    public function insertStory($title,$content,$language_id){
        $data = array(
                    'title'     =>$title,
                    'content'   =>$content,
                    'language_id'   =>$language_id
                );
        
        if($this->insert($data))
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }


    public function selectAllCategory($lang_id)
    {
        $data = $this->select()
                ->from($this->_name,array('id','title','content','language_id'))
                ->where("{$this->_name}.language_id = ?",$lang_id);
        $result = $this->fetchAll($data);
        
        if(count($result))
        {
            return  $result;
        }
        else
        {
            return NULL;
        }
        
    }


    public function getById($id)
    {
        $data = $this->select()
                ->from($this->_name,array('id','title'))
                ->where("{$this->_name}.id = ?",$id);
                
        $result = $this->fetchRow($data);
        
        if(count($result))
        {
            return $result;
            //return $result['title'];
        }
        else
        {
            return NULL;
        }
        
    }


    public function getByLangId($lang_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where("{$this->_name}.language_id = ?",$lang_id);
                
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
    
    public function lastID()
    {
        $data = $this->select()
                ->from($this->_name,array('id','title','language_id'))
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

    /* get by id*/
    public function paramID($id)
    {
        $data = $this->select()
                ->from($this->_name,array('id','title'))
                ->where("{$this->_name}.id = ?",$id);
                
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

}
?>
