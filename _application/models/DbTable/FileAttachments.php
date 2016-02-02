<?php

class Model_DbTable_FileAttachments extends Zend_Db_Table_Abstract {

  protected $_name = 'poi_file_attachments';
  
  public function getByPoiId($poi_id) {
    $select = $this->select()->from($this->_name)->where("poi_id = $poi_id");
    $result = $this->fetchAll($select);
    return $result->toArray();
  }

}