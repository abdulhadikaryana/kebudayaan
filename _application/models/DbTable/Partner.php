<?php

class Model_DbTable_Partner
        extends Zend_Db_Table_Abstract
{
  protected $_name        = 'partner';
  protected $_description = 'partner_description';
  protected $_primary     = 'id';

  public function init()
  {
    
  }

  public function fetchWithDescription($id, $language_id)
  {
    $select = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->_name)
            ->join($this->_description,
                    "{$this->_name}.id = {$this->_description}.partner_id")
            ->where("{$this->_name}.id = ?", $id)
            ->where("{$this->_description}.language_id = ?",
            $language_id);

    $result = $this->fetchRow($select);
    return $result;
  }

  public function fetchAllWithTranslationStatus($filter, $language_id)
  {

    $select = $this->select()
            ->from($this->_name,
            array('*', "isTranslated" =>
        "(SELECT COUNT(*) FROM $this->_description WHERE partner_id = 
          partner.id && language_id = 2)"));
    
    if (null != $filter) {
      if (null != $filter['name']) {
        $select->where("{$this->_name}.name LIKE ?",
                "%{$filter['name']}%");
      }
      if (null != $filter['sort']) {
        $select->order("{$filter['sort']} {$filter['order']}");
      }
    }

    $result = $this->fetchAll($select);
    return $result;
  }
  
  public function getAllWithDesc($languageId,$limit =''){

      $query = $this->select()
              ->setIntegrityCheck(false)
              ->from($this->_name)
              ->join($this->_description,"{$this->_description}.partner_id = {$this->_name}.id")
              ->where("{$this->_description}.language_id = ?",$languageId)
              ;
              
              if( !empty($limit)){
                  $query->limit($limit, 0);
              }
              return $query;
  }
  
  public function getAllWithDescById($id,$languageId){
      $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_description)
                ->join($this->_name,"{$this->_description}.partner_id = {$this->_name}.id")
                ->where("{$this->_description}.language_id = ?",$languageId)
                ->where("{$this->_description}.id = ?", $id);
        
        $data = $this->fetchRow($query);
        return $data;
  }
  
    public function getTitleById($id,$languageId){
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_description)
                ->join($this->_name,"{$this->_description}.partner_id = {$this->_name}.id")
                ->where("{$this->_description}.partner_id = ?",$id)
                
            ;
//        echo $query->__toString();
        $data = $this->fetchAll($query);
        return $data;
    }

}

class Model_DbTable_PartnerDescription
        extends Zend_Db_Table_Abstract
{
  protected $_name    = 'partner_description';
  protected $_primary = 'id';

  const LANG_ID = '1';
  const LANG_EN = '2';

}