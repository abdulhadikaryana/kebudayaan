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
    		$row->category = $data['category'];
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
	
	public function getEssayList($paramsArr, $query = FALSE)
	{
		$query = $this->select()
				 ->setIntegrityCheck(FALSE)
				 ->from(array('pe' => $this->_name))
				 ->join(array('pei' => 'photoessay_image'), 
			 	   'pei.photoessay_id = pe.photoessay_id',
			 	    array('pei.file', 'pei.description as caption', 'COUNT(pei.image_id) as jumlah'))
		 	     ->order('pe.publishdate DESC')
		 	     ->group('pe.photoessay_id');
  		
  		if(is_array($paramsArr))
  		{
  			foreach($paramsArr as $field => $param)
  			{
  				$query->where($field .' = ?', $param);
			}
  		}
  		
		if($query == FALSE)
  		{
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
  		else
  		{
  			return $query;
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
    
    public function getDateList()
    {
    	$select = $this->select()
    			  ->from(array('pe' => $this->_name), 
				  	array('DATE_FORMAT(pe.publishdate,"%M, %Y") as formated_date', 'pe.publishdate'))
    			  ->group('MONTH(pe.publishdate)')
    			  ->group('YEAR(pe.publishdate)')
    			  ->order('pe.publishdate');
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


    public function searchData($keyword){
		$query = $this->select()
				 ->setIntegrityCheck(FALSE)
				 ->from(array('pe' => $this->_name))
				 ->join(array('pei' => 'photoessay_image'),'pei.photoessay_id = pe.photoessay_id',array('pei.file', 'pei.description as caption', 'COUNT(pei.image_id) as jumlah'))
//		 	     ->order('pe.publishdate DESC')
		 	     ->group('pe.photoessay_id');

        $key = explode(' ',$keyword);

        if(is_array($key))
        {
            if(count($key) > 1)
            {
                    $string = '';
                    $string2 = '';
                    for($i=0;$i<sizeof($key);$i++)
                    {
                        if($i != sizeof($key) - 1)
                        {
                            $string .= "pe.title like '%$key[$i]%' OR ";
                            $string2 .= "pei.description like '%$key[$i]%' OR ";
                        }
                        else
                        {
                            $string .= "pe.title like '%$key[$i]%'";
                            $string2 .= "pei.description like '%$key[$i]%'";
                        }
                    }
                    $query->where('('.$string.'');
                    $query->orWhere(''.$string2.')');
            }
            else
            {
                    $string = "pe.title like '%$keyword%'";
                    $string2 = "pei.description like '%$keyword%'";

                    $query->where('('.$string.'');
                    $query->orWhere(''.$string2.')');
            }
        }else{
            $string = "pe.title like '%$keyword%'";
            $string2 = "pei.description like '%$keyword%'";

            $query->where('('.$string.'');
            $query->orWhere(''.$string2.')');
        }

        $string_order = " ORDER BY CASE WHEN $string THEN 0 WHEN $string2 THEN 1 ELSE 2 END";
        $query .= $string_order;

        $q = $this->_db->query($query);
        $result = $q->fetchAll();

        if(empty($result))
        {
            return false;
        }
        return $result;
    }

}