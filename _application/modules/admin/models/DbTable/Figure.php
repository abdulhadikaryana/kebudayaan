<?php



class Admin_Model_DbTable_Figure

        extends Zend_Db_Table_Abstract

{

  protected $_name        = 'figure';

  protected $_description = 'figure_description';

  protected $_account     = 'admin_account';

  protected $_primary     = 'id';



  const STATUS_ARCHIVED = 0;

  const STATUS_DRAFT    = 1;

  const STATUS_PENDING  = 2;

  const STATUS_PUBLISH  = 3;



  public function findAll($filter = null, $user_id = null)

  {

    $select = $this->select()->setIntegrityCheck(false)

            ->from($this->_name, array('*'))

            ->join(array('created_by' => $this->_account),

                    "{$this->_name}.created_by = created_by.admin_id",

                    array(

                'created_by' => 'username'))

            ->joinLeft(array('updated_by' => $this->_account),

                    "{$this->_name}.updated_by = updated_by.admin_id",

                    array('updated_by' => "username"))

            ->joinLeft(array('approved_by' => $this->_account),

                    "{$this->_name}.approved_by = approved_by.admin_id",

                    array("approved_by" => "username"))

            ->columns(array('isTranslated' =>

        "(SELECT COUNT(*) FROM {$this->_description} 

          WHERE figure_id = {$this->_name}.id and language_id = 2)"))



    ;



    if (null != $user_id)

      $select->where("created_by = ?", $user_id);



    if ($filter['status'] != 0 || $filter['status'] == null)

      $select->where("{$this->_name}.status != ?",

              self::STATUS_ARCHIVED);



    if (null != $filter) {

      if (null != $filter['name'])

        $select->where("{$this->_name}.name LIKE ?",

                "%{$filter['name']}%");

      if (null != $filter['status'])

        $select->where("{$this->_name}.status = ?", $filter['status']);

      if (isset($filter['sort']) &&

              null != $filter['sort']) {

        if ($filter['sort'] == 'date') {

          $select->order(array(

              "{$this->_name}.created_at {$filter['sort_order']}",

              "{$this->_name}.approved_at {$filter['sort_order']}",

              "{$this->_name}.updated_at {$filter['sort_order']}",

          ));

        } else

          $select->order("{$filter['sort']} {$filter['sort_order']}");

      }

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



  public function findWithDescription($figure_id, $language_id)

  {

    $select = $this->select()

            ->setIntegrityCheck(false)

            ->from($this->_name)

            ->join($this->_description,

                    "{$this->_name}.id = {$this->_description}.figure_id")

            ->where("{$this->_name}.id = ?", $figure_id)

            ->where("{$this->_description}.language_id = ?",

            $language_id);



    $result = $this->fetchRow($select);

    return $result;

  }



}



class Admin_Model_DbTable_FigureDescription

        extends Zend_Db_Table_Abstract

{

  protected $_name    = 'figure_description';

  protected $_primary = 'id';



}