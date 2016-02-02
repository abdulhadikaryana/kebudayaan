<?php
/**
 * Model_DbTable_Blacklist
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel blacklist
 *
 * @package DbTable Model
 */
class Model_DbTable_Blacklist extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'blacklist';
    protected $true = "true";
    protected $false = "false";

    public function getAllById($id)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('blacklist_id = ?', $id);
        $return = $this->fetchAll($query);
        return $return;
    }

    /*public function isBlacklist($email) {
        $nul = 0;
        $query = $this->select()
                ->from($this->_name,array('name'))
                ->where("name LIKE '%".$email."%'");
        $report = $this->fetchAll($query);
        
        $count = count($report);

        if($count == $nul ) {
            return $this->false;
        }else {
            return $this->true;
        }
    }*/

}
?>
