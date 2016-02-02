<?php
/**
 * Model_DbTable_UserToBlackList
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel user to blacklist
 *
 * @package DbTable Model
 */
class Model_DbTable_UserToBlacklist extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'usertoblacklist';
    protected $_blacklist = 'blacklist';
    protected $_user = 'user';
    protected $_primary = array('blacklist_id', 'user_id');


    /**
     * Fungsi untuk mengambil semua data dari tabel usertoblacklist berdasarkan
     * user_id yang diberikan
     * @param integer $id
     * @return array
     */
    public function getAllByUserId($id)
    {
        $query = $this->select()
                ->from($this->_name, array())
                ->join($this->_blacklist,
                    "{$this->_blacklist}.blacklist_id = {$this->_name}.blacklist_id",
                    array('name'))
                ->setIntegrityCheck(false)
                ->where("{$this->_name}.user_id = ?", $id);

        $report = $this->fetchAll($query);

        return $report;
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel usertoblacklist berdasarkan
     * blacklist_id yang diberikan
     *
     * @param integer $blacklistId
     * @return array
     */
    public function getAllByBlacklistId($blacklistId)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('blacklist_id = ?', $blacklistId);
        $return = $this->fetchAll($query);
        return $return;
    }

    /**
     * Fungsi untuk mengecek apakah email di-blacklist apa tidak
     *
     * @param string $email email
     * @return true | false
     */
    public function isEmailBlacklisted($email)
    {
        $query = $this->select()
                ->from($this->_name, array())
                ->join($this->_user, "{$this->_user}.user_id = {$this->_name}.user_id",
                    array('COUNT(*)'))
                ->setIntegrityCheck(false)
                ->where("{$this->_user}.email = ?", $email)
                ->group("{$this->_name}.user_id");

        //echo $query->__toString();
        $data = $this->fetchAll($query);

        if(count($data) > 0)
            return true;
        else
            return false;
    }

}
?>
