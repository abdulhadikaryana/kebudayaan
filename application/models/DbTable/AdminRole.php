<?php
/**
 * Model_DbTable_AdminRole
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel role admin
 * 
 * @package DbTable Model
 */
class Model_DbTable_AdminRole extends Zend_Db_Table_Abstract 
{
    /** The default table name */
    protected $_name = 'admin_role';
    protected $_primary = 'role_id';
    protected $_sequence = true;

    /**
     * Fungsi untuk memasukkan record baru ke dalam basis data admin role
     * 
     * @param array $input
     * @return int
     */
    public function insertRole($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();    
    }
    
    /**
     * Fungsi untuk memutakhirkan record di basis data admin role sesuai masukan 
     * role_id
     * 
     * @param array $input
     * @param int $role_id
     */
    public function updateRole($input, $role_id)
    {
        $where = $this->getAdapter()->quoteInto('role_id = ?', $role_id);
        $this->update($input, $where);
    }
    
    /**
     * Fungsi untuk menghapus record dari basis data admin role sesuai masukan 
     * role_id
     * 
     * @param int $role_id
     */
    public function deleteRole($role_id)
    {
        $where = $this->getAdapter()->quoteInto('role_id = ?', $role_id);
        $this->delete($where);
    }
    
    /**
     * 
     */
    public function getAllRole()
    {
        $select = $this->select()
                  ->from($this->_name);
        return $this->fetchAll($select);
    }

    /**
     * Fungsi untuk mengambil query seluruh record admin role
     *
     * @return query
     */
    public function getQueryAll()
    {
        $select = $this->select()
                  ->from(array('ar' => $this->_name), array('ar.role_id', 'ar.role_name'))
                  ->order('ar.role_name ASC');
        
        return $select;
    }
    
    /**
     * Fungsi untuk mengambil satu record admin role dimana role_id nya sesuai
     * dengan parameter masukan
     * 
     * @param int $role_id
     * @return array
     */
    public function getRoleById($role_id)
    {
        $select = $this->select()
                  ->from(array('ar' => $this->_name))
                  ->where("ar.role_id = ?", $role_id);
        
        return $this->fetchRow($select);
    }
    
    /**
     * 
     */
    public function getCountAll()
    {
        $query = $this->select()
                 ->from($this->_name,array('COUNT(role_id) AS count'));
        
        $count = $this->fetchRow($query);
        $return = $count->toArray();
        return $return['count'];
    }
}