<?php
/**
 * Model_DbTable_UserStoryPhotoessay
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel user story
 *
 * @package DbTable Model
 */

class Model_DbTable_UserStoryPhotoessay extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'userstoryphotoessay';
    protected $_desc = 'userstoryphotoessay_desc';
    protected $_primary = array('id');
    
//    public function insertData($filename,$description,$userstory_id,$lang_id)
    public function insertData(array $data)
    {

        $this->insert($data);
        return $this->_db->lastInsertId();
    }

    /*
	Select all data
    */
    public function selectAll(){
        $data = $this->select()
                ->from($this->_name,array('id','description','file','userstory_id'));

        $result = $this->fetchAll($data);
        
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }
    }


    /*
    	Fungsi untuk menampilkan data userstoryphotoessay berdasarkan userstory_id
    */
    public function getByUserstory($userstory_id,$lang_id){
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id','file','userstory_id'))
                ->join($this->_desc,"{$this->_desc}.userstoryphotoessay_id = {$this->_name}.id",array('description'))
                ->where("{$this->_name}.userstory_id = ?",$userstory_id)
                ->group('file');

        $result = $this->fetchAll($data);
        
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }
    }

    /*
	Fungsi untuk menampilkan data descripsi file berdasarkan image_id
    */
    public function getDesc($image_id,$lang_id){
        $data = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,array('id','file','userstory_id'))
                ->join($this->_desc,"{$this->_desc}.userstoryphotoessay_id = {$this->_name}.id",array('description'))
                ->where("{$this->_name}.id = ?",$image_id)
                ->where("{$this->_desc}.language_id = ?",$lang_id);

        $result = $this->fetchRow($data);
        
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }
    }

    /*
        update desckrispi img photo essay berdasarkan  img id
    */
    public function updateDesc($image_id,$description)
    {
        $data = array(
                      'description' => $description
                      );

        $where = $this->getAdapter()->quoteInto('id = ?', $image_id);
        $this->update($data, $where);
    
    }

    //hapus image
    public function removeImage($image_id)
    {
       $where = $this->getAdapter()->quoteInto('id = ?', $image_id);
       $this->delete($where);
    }

}
?>
