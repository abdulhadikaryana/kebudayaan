<?php

class Model_DbTable_RelatedArticleNews extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'related_article_news';

    public function insertRelated($input)
    {
        $this->insert($input);
    }


    public function getByNewsId($news_id,$langId = 1)
    {
        $select = $this->select()
                ->from($this->_name)
                ->where("{$this->_name}.news_id = ?",$news_id)
				->where("{$this->_name}.language_id = ?",$langId)
                ->order("{$this->_name}.related_id ASC");
				
				
		//echo $select;
		
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

    /*
    * mengembalikan random link terkait
    * @param : poi_id
    */
    public function randomLink($news_id,$langId = 1)
    {
        $select = $this->select()
                ->from($this->_name)
                ->where("{$this->_name}.news_id = ?",$news_id)
				->where("{$this->_name}.language_id = ?",$langId)
                ->limit(6)
                ->order("RAND()");

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
   
    public function cek_existing($label,$link,$langId)
    {
        $select = $this->select()
                ->from($this->_name)
                ->where("{$this->_name}.label = ?",$label)
                ->where("{$this->_name}.link = ?",$link)
				->where("{$this->_name}.language_id = ?",$langId);
				
		//echo $select;
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
    
    public function cek_existing_forDel($label,$link,$langId = 1)
    {
        $select = $this->select()
                ->from($this->_name)
                ->where("{$this->_name}.label = ?",$label)
                ->where("{$this->_name}.link = ?",$link)
				->where("{$this->_name}.language_id = ?",$langId);
		$result = $this->fetchAll($select);
        
        if(count($result))
        {
            foreach($result as $row)
            {
                $where = $this->getAdapter()->quoteInto('related_id = ?', $row->related_id);
                $this->delete($where);
            }
            return true;
        }
        else
        {
            return false;
        }
    }

}
?>