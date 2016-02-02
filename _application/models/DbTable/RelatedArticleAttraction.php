<?php

class Model_DbTable_RelatedArticleAttraction extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'related_article_attraction';

    public function insertRelated($input)
    {
        if($this->insert($input))
        {
            return true;            
        }
        else
        {
           return false; 
        }
    }
    
    public function getByArticleId($article_id,$langId = 1)
    {
        $select = $this->select()
                ->from($this->_name)
                ->where("{$this->_name}.article_id = ?",$article_id)
				->where("{$this->_name}.language_id = ?",$langId)
                ->order("related_id ASC");

        $result = $this->fetchAll($select);
        
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }
        
    }

    public function getByArticleId2($article_id)
    {
        $select = $this->select()
                ->from($this->_name)
                ->where("{$this->_name}.article_id = ?",$article_id);
        $result = $this->fetchAll($select);
        
        if(count($result))
        {
            return $result->toArray();
        }
        else
        {
            return NULL;
        }
    }

    public function cek_existing($label,$link)
    {
        $select = $this->select()
                ->from($this->_name)
                ->where("{$this->_name}.label = ?",$label)
                ->where("{$this->_name}.link = ?",$link);
        $result = $this->fetchAll($select);
        
        if(count($result))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function cek_existing_forDel($label,$link)
    {
        $select = $this->select()
                ->from($this->_name)
                ->where("{$this->_name}.label = ?",$label)
                ->where("{$this->_name}.link = ?",$link);
        $result = $this->fetchAll($select);
        
        if(count($result))
        {
            foreach($result as $row)
            {
                $where = $this->getAdapter()->quoteInto('related_id = ?', $row->related_id);
                $this->delete($where);
            }
            //return true;
        }
        else
        {
            return false;
        }
    }
    
    /*
        delete data
    */
    public function delRelated($related_id)
    {
       $where = $this->getAdapter()->quoteInto('related_id = ?', $related_id);
       if($this->delete($where))
       {
            return true;
       }
       else
       {
            return false;
       }
    }

}
?>