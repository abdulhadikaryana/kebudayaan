<?php
/**
 * Model_DbTable_Role
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel role
 *
 * @package DbTable Model
 */
class Model_DbTable_Role extends Zend_Db_Table_Abstract
{
    protected $_name = 'role';

    /**
     * Fungsi untuk mengambil jumlah data admin yang mempunyai user_id seperti
     * yang diberikan
     * @param integer $user_id
     * @return array
     */
    public function checkUserExist($user_id)
    {
        $select = $this->select()
                  ->from($this->_name,array('COUNT(adminname) AS admin'))
                  ->where('adminname = ?',$user_id);
        $admin = $this->fetchRow($select);
        return $admin;
    }
}
