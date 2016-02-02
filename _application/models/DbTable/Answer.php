<?php

class Model_DbTable_Answer
        extends Zend_Db_Table_Abstract
{
  protected $_name    = 'pollinganswer';
  protected $_polling = 'pollingquestion';
  protected $_primary = 'answer_id';

  public function getAnswersName($polling_id, $text = null)
  {
    $select = $this->select()->from($this->_name, array('answer'))
            ->where("polling_id = ?", $polling_id);
    if (null != $text)
      $select->where("answer = ?", $text);

    return $this->getAdapter()->fetchCol($select);
  }

  public function getAllWithResult($poling_id)
  {
    $count = $this->select()->from($this->_name, array('SUM(total)'))
            ->where("polling_id = ?", $poling_id);

    $select = $this->select()->
            setIntegrityCheck(false)
            ->from($this->_name,
                   array('answer', 'answer_id',
                'total', 'percent' => "CONCAT(((total / ($count)) * 100), '%')"))
            ->where("{$this->_name}.polling_id = ?", $poling_id)
            ->join("{$this->_polling}",
                   "{$this->_name}.polling_id = {$this->_polling}.polling_id");
    $result   = $this->fetchAll($select);
    return $result;
  }

}