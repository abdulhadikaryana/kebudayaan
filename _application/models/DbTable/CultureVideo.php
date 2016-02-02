<?php

class Model_DbTable_CultureVideo extends Zend_Db_Table_Abstract {

  protected $_name = 'poivideos';

  public function findByCultureId($poi_id) {
    $select = $this->select()->where('poi_id = ?', $poi_id);
    $row = $this->fetchAll($select);
    return $row->toArray();
  }

  public function deleteByCultureId($poi_id) {
    $this->delete("poi_id = $poi_id");
  }

}