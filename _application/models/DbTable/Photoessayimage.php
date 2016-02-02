<?php 

class Model_DbTable_Photoessayimage extends Zend_Db_Table_Abstract
{
    protected $_name = 'photoessay_image';
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
			$row->description = $data['description'];
			$row->sort_id = $data['sort_id'];
			$row->save();
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function deleteRow($imageID)
	{
        $where = $this->getAdapter()->quoteInto('image_id = ?', $imageID);
        $this->delete($where);
	}
	
	public function deleteRowByPhotoessayID($essayID)
	{
        $where = $this->getAdapter()->quoteInto('photoessay_id = ?', $essayID);
        $this->delete($where);        
	}
	
	public function getImageByImageID($id)
	{
		$query = $this->select()
				 ->from(array('pi' => $this->_name))
				 ->where('pi.image_id = ?', $id);
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
	
	public function getImageByEssayID($essayID)
	{
		$query = $this->select()
				 ->from(array('pi' => $this->_name))
				 ->where('pi.photoessay_id = ?', $essayID)
				 ->order('pi.sort_id');
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
}