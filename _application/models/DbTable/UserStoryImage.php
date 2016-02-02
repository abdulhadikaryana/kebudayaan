<?php
/*
    UserStoryImage,
 *  untuk menampung image untuk front end travelers stories
 *
 */

class Model_DbTable_UserStoryImage extends Zend_Db_Table_Abstract
{
    protected $_name = 'userstory_image';
    protected $_primary = array('id');

    public function insertData(array $data){

        $this->insert($data);
        return $this->_db->lastInsertId();
    }
    
    public function getDataNew($type = ''){
        $data = $this->select()
                ->from($this->_name)->where("{$this->_name}.type = ?",$type)->order('id DESC')->limit(1);

        $result = $this->fetchRow($data);

        if(count($result) > 0)
        {
            return $result['file'];
        }
        return false;

    }
}
?>
