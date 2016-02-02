<?php

class Model_DbTable_Photoessay extends Zend_Db_Table_Abstract
{
    protected $_name = 'photoessay';
    protected $_table = 'photoessay_id';
    
    public function insertRow($data)
    {
    	$row = $this->createRow($data);
    	$row->save();
    	return $this->_db->lastInsertId();
    }
    
    public function updateRow($id, $data)
    {
    	$row = $this->find($id)->current();
    	if($row)
    	{
    		$row->title = $data['title'];
    		$row->description = $data['description'];
    		$row->publishdate = $data['publishdate'];
    		$row->save();
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }
	
	public function deleteRowByID($id)
	{
        $where = $this->getAdapter()->quoteInto('photoessay_id = ?', $id);
        $this->delete($where);        
	}
	
	public function getEssayByID($id)
	{
		$query = $this->select()
			     ->setIntegrityCheck(FALSE)
		      	 ->from(array('pe' => $this->_name))
				 ->where('pe.photoessay_id = ?', $id);
 		$result = $this->fetchRow($query);
 		if(sizeof($result) > 0)
 		{
 			return $result->toArray();
 		}
 		else
 		{
 			return null;
 		}
	}
	
	public function getEssayList()
	{
		$query = $this->select()
				 ->setIntegrityCheck(FALSE)
				 ->from(array('pe' => $this->_name))
				 ->join(array('pei' => 'photoessay_image'), 
			 	   'pei.photoessay_id = pe.photoessay_id',
			 	    array('pei.file', 'pei.description as caption', 'COUNT(pei.image_id) as jumlah'))
		 	     ->order('pei.sort_id')
		 	     ->group('pe.photoessay_id');
		$result = $this->fetchAll($query);
 		if(sizeof($result) > 0)
 		{
 			return $result->toArray();
 		}
 		else
 		{
 			return null;
 		}
	}
	
    public function getQueryAllByLanguage($type,$param,$language_id = 1)
    {
        $select = $this->select()
                ->from(array('pe' => $this->_name));
        switch($type)
        {
            case 1 : $select->where("pe.area_name LIKE '%".$param."%'");
                break;
        }
        $select->order('photoessay_id DESC');
        return $select;
    }
    
    public function getLatestEssayTitle($amount = 3)
    {
    	$select = $this->select()
    			  ->from(array('pe' => $this->_name), array('pe.photoessay_id' ,'pe.title', 'pe.publishdate'))
    			  ->limit($amount)
    			  ->order('pe.photoessay_id DESC');
 		$result = $this->fetchAll($select);
 		
		 if(sizeof($result) > 0)
 		{
 			return $result->toArray();
 		}
 		else
 		{
 			return null;
 		}
    }
}