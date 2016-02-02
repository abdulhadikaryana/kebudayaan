<?php

class Model_DbTable_Polling
        extends Zend_Db_Table_Abstract
{
  protected $_name    = 'pollingquestion';
  protected $_answer  = 'pollinganswer';
  protected $_primary = 'polling_id';

  public function getAll()
  {
    $select = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name)
            ->join(array('answer' => $this->_answer),
                   "{$this->_name}.polling_id = answer.polling_id",
                   array(
                'total' => '(SUM(answer.total))'
            ))
            ->group("{$this->_name}.polling_id")
            ->order("{$this->_name}.showstatus DESC");

    $result = $this->fetchAll($select);
    return $result;
  }

  public function getActivePolling()
  {
    $select = $this->select()->from($this->_name)->where('showstatus = ?',
                                                         1);
    return $this->fetchRow($select);
  }

}

