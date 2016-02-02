<?php

/**
 * Model_DbTable_Article
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel article
 *
 * @package DbTable Model
 */
class Model_DbTable_Article
        extends Zend_Db_Table_Abstract
{
  //put your code here
  protected $_name        = 'article';
  protected $_description = 'article_description';
  protected $_primary     = 'id';

  const ARCHIVED = 0;
  const DRAFT    = 1;
  const PENDING  = 2;
  const PUBLISH  = 3;

  public function findAll($language_id = 1, $category = 1,
          $limit = null)
  {
    $select = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name)
            ->join($this->_description,
                    "{$this->_name}.id = {$this->_description}.article_id")
            ->where("{$this->_description}.language_id = ?",
                    $language_id)
            ->where("{$this->_name}.category = ?", $category)
            ->where("{$this->_name}.status = ?", self::PUBLISH)
            ->order("{$this->_name}.created_at");
    if (null != $limit)
      $select->limit($limit);

    $result = $this->fetchAll($select);
    return $result;
  }

  public function findWithDescription($id, $language_id)
  {
    $select = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name, array('*'))
            ->join($this->_description,
                    "{$this->_name}.id = {$this->_description}.article_id")
            ->where("{$this->_description}.id = ?", $id)

    ;
    $result = $this->fetchAll($select);
    return $result;
  }

  public function getTitleById($id, $lang_id)
  {
    $title = $this->select()->from($this->_name)
            ->setIntegrityCheck(false)
            ->join($this->_description,
                    "{$this->_description}.article_id = {$this->_name}.id")
            ->where("{$this->_name}.id = ?", $id)
            ->where("{$this->_description}.language_id = ?", $lang_id)
            ->limit(1)
    ;
    $title = $this->fetchAll($title)->current();
    return $title['title'];
  }

}
?>