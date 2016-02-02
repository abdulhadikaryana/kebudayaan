<?php

class Admin_Model_DbTable_Account extends Zend_Db_Table_Abstract
{
  protected $_name = 'admin_account';

  public function getUserPassword($admin_id)
  {
    $select = $this->select()->from($this->_name, array('password'))
            ->where("{$this->_name}.admin_id = ?", $admin_id);
    $result = $this->getAdapter()->fetchOne($select);
    return $result;
  }

}