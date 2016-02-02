<?php

class Model_DbTable_EssayCategory extends Zend_Db_Table_Abstract
{
    protected $_name = 'essaycategory';
    protected $_primary = 'essaycategory_id';
	
	public function getAll()
	{
		$select = $this->select()
				  ->from(array('ec' => $this->_name));
  		$result = $this->fetchAll($select);
		if(sizeof($result) > 0)
		{
			return $result->toArray();
		}
	}
	
	public function getTitleByID($id)
	{
		$select = $this->select()
				  ->from(array('ec' => $this->_name))
				  ->where('ec.essaycategory_id = ?', $id);
  		$result = $this->fetchRow($select)->toArray();
		if(sizeof($result) > 0)
		{
			return $result['title'];
		}
	}
		
}