<?php

class Model_DbTable_RelatedArticlePoi extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'related_article_poi';

    public function insertRelated($input)
    {
        $this->insert($input);
    }

    public function getByPoiId($poi_id,$langId = 1)
    {
        $select = $this->select()
                ->from($this->_name)
                ->where("{$this->_name}.poi_id = ?",$poi_id)
                ->where("{$this->_name}.language_id = ?",$langId)
                ->order("{$this->_name}.related_id ASC");

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
    public function randomLink($poi_id)
    {
        $select = $this->select()
                ->from($this->_name)
                ->where("{$this->_name}.poi_id = ?",$poi_id)
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
            return true;
        }
        else
        {
            return false;
        }
    }

}
?>