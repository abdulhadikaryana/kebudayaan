<?php

class Admin_Model_DbTable_Article
        extends Zend_Db_Table_Abstract
{
  protected $_name        = 'article';
  protected $_description = 'article_description';
  protected $_account     = 'admin_account';
  protected $_primary     = 'id';

  public function findAll($user_id = null, $filter = null)
  {
    $select = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name, array('*'))
            ->join(array('created_by' => $this->_account),
                    "{$this->_name}.created_by = created_by.admin_id",
                    array('created_by' => 'username'))
            ->joinLeft(array('updated_by' => $this->_account),
                    "{$this->_name}.updated_by = updated_by.admin_id",
                    array('updated_by' => 'username'))
            ->joinLeft(array('apprvd_by' => $this->_account),
                    "{$this->_name}.approved_by=apprvd_by.admin_id",
                    array('approved_by' => 'username'))
            ->columns(array('isTranslated' =>
                "(SELECT COUNT(*) FROM {$this->_description}
                  WHERE article_id = {$this->_name}.id 
                    && language_id = 2)"))
            // We want order by the latest time updated
            ->order('created_at DESC')
            ->order('updated_at DESC')
            ->order('approved_at DESC');

    // We don't want to show archived articles
    if ($filter['status'] != 0 || $filter['status'] == null)
      $select->where("status != ?", 0);

    // If user_id specified, it will fetch only
    // article that belongs to a user
    if (null != $user_id)
      $select->where('created_by = ?', $user_id);

    // Handle filter
    if (null != $filter) {
      if (null != $filter['status'])
        $select->where("status = ?", $filter['status']);
      if (null != $filter['author'])
        $select->where("created_by.username LIKE ?",
                "%{$filter['author']}%");
      if (null != $filter['name'])
        $select->where("{$this->_name}.name LIKE ?",
                "%{$filter['name']}%");
    }

    $result = $this->fetchAll($select);
    return $result;
  }

  public function fetchWithDescription($article_id, $language_id)
  {
    $select = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name)
            ->join($this->_description,
                    "{$this->_name}.id = {$this->_description}.article_id")
            ->where("{$this->_name}.id = ?", $article_id)
            ->where("{$this->_description}.language_id = ?",
            $language_id)
    ;
    $result = $this->fetchRow($select);
    return $result;
  }

}

class Admin_Model_DbTable_ArticleDescription
        extends Zend_Db_Table_Abstract
{
  protected $_name    = 'article_description';
  protected $_primary = 'id';

}