<?php
/**
 * Model_DbTable_UserStoryPhotoessaydesc
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel user story
 *
 * @package DbTable Model
 */

class Model_DbTable_UserStoryPhotoessaydesc extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'userstoryphotoessay_desc';
    protected $_photoessay = 'userstoryphotoessay';
    protected $_primary = array('userstoryphotoessay_id');

    public function insertData(array $data)
    {
        $this->insert($data);
    }

    /*
        update berdasarkan  userstoryphotoessay_id & language_id
    */
    public function updateDataMultiClause($userstoryphotoessay_id,$lang_id,$data)
    {

/*        $where = array();
        $where = $this->getAdapter()->quoteInto('userstoryphotoessay_id = ?', $userstoryphotoessay_id);
        $where = $this->getAdapter()->quoteInto('language_id = ?', $lang_id);*/

        $where['userstoryphotoessay_id = ?'] = $userstoryphotoessay_id;
        $where['language_id = ?'] = $lang_id;
        $this->update($data, $where);

        $this->update($data, $where);
    }


    /*
    	Fungsi untuk menampilkan data userstoryphotoessay berdasarkan userstoryphotoessay_id dan language id
    */
    public function getByImgIdLangId($userstoryphotoessay_id,$lang_id){
        $data = $this->select()
                ->from($this->_name,array('description'))
                ->where("{$this->_name}.userstoryphotoessay_id = ?",$userstoryphotoessay_id)
                ->where("{$this->_name}.language_id = ?",$lang_id)
                ;
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

}
?>
