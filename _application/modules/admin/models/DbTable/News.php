<?php

class Admin_Model_DbTable_News
        extends Zend_Db_Table_Abstract
{
  protected $_name        = 'news';
  protected $_description = 'news_description';
  protected $_account     = 'admin_account';
  protected $_primary     = 'id';

  const STATUS_ARCHIVED = 0;
  const STATUS_DRAFT    = 1;
  const STATUS_PENDING  = 2;
  const STATUS_PUBLISH  = 3;
  const LANGUAGE_ID     = 1;
  const LANGUAGE_EN     = 2;

  public function findAllWithDescription($language_id, $filter = null,
          $user_id = null)
  {
    $select = $this->select()->setIntegrityCheck(false)
            ->from($this->_name)
            ->join($this->_description,
                    "{$this->_name}.id = 
                    {$this->_description}.news_id",
                    array('title', 'content', 'language_id'))
            ->columns(array('isTranslated' => "(
              SELECT COUNT(*) 
              FROM {$this->_description} 
              WHERE news_id = {$this->_name}.id 
              AND language_id = 2)"))
            ->joinLeft(array('created_by' => $this->_account),
                    "{$this->_name}.created_by = created_by.admin_id",
                    array('created_by' => 'username'))
            ->joinLeft(array('updated_by' => $this->_account),
                    "{$this->_name}.updated_by = updated_by.admin_id",
                    array('updated_by' => 'username'))
            ->joinLeft(array('approved_by' => $this->_account),
                    "{$this->_name}.approved_by = approved_by.admin_id",
                    array('approved_by' => 'username'))
            ->where("{$this->_description}.language_id = ?",
            $language_id)
    ;

    if (null != $user_id)
      $select->where('created_by = ?', $user_id);

    if (null == $filter['status']
            || self::STATUS_ARCHIVED != $filter['status'])
      $select->where("status != ?", self::STATUS_ARCHIVED);

    if (null != $filter) {
      if (null != $filter['title'])
        $select->where("title LIKE ?", "%{$filter['title']}%");
      if (null != $filter['status'])
        $select->where("status = ?", $filter['status']);
      if (null != $filter['sort'])
        $select->order("{$filter['sort']} {$filter['order']}");
    }

    $result = $this->fetchAll($select);
    return $result;
  }

  public function findStatusesCount($user_id = null)
  {
    $select = $this->select()
            ->from($this->_name,
            array(
        'archived' => "SUM(status = 0)",
        'draft'    => "SUM(status = 1)",
        'pending'  => "SUM(status = 2)",
        'publish'  => "SUM(status = 3)"));

    if (null != $user_id)
      $select->where("created_by = ?", $user_id);

    $result = $this->fetchRow($select);

    return $result;
  }

  public function findWithDescription($news_id, $language_id)
  {
    $select = $this->select()->setIntegrityCheck(false)
            ->from($this->_name)
            ->join($this->_description,
                    "{$this->_name}.id = {$this->_description}.news_id")
            ->where("{$this->_name}.id = ?", $news_id)
            ->where("{$this->_description}.language_id = ?",
            $language_id)
    ;

    $result = $this->fetchRow($select);
    return $result;
  }

}

class Admin_Model_DbTable_NewsDescription
        extends Zend_Db_Table_Abstract
{
  protected $_name    = 'news_description';
  protected $_primary = 'id';

}