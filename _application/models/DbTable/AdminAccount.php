<?php
/**
 * Model_DbTable_AdminAccount
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel account admin
 *
 * @package Model
 */
class Model_DbTable_AdminAccount extends Zend_Db_Table_Abstract 
{
    /** deklarasi tabel yang digunakan */
    protected $_name = 'admin_account';
    protected $_role = 'admin_role';
    protected $_primary = 'admin_id';
    protected $_sequence = true;

    /**
     * Fungsi untuk memasukkan record baru ke dalam basis data admin account
     * 
     * @param array $input
     * @return int
     */
    public function insertAccount($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }
    
    /**
     * Fungsi untuk memutakhirkan record di basis data admin account sesuai 
     * masukan admin_id
     * 
     * @param array $input
     * @param int $admin_id
     */
    public function updateAccount($input, $admin_id)
    {
        $where = $this->getAdapter()->quoteInto('admin_id = ?', $admin_id);
        $this->update($input, $where);
    }
    
    /**
     * Fungsi untuk menghapus record dari basis data admin account sesuai 
     * masukan admin_id
     * 
     * @param int $admin_id
     */
    public function deleteAccount($admin_id)
    {
        $where = $this->getAdapter()->quoteInto('admin_id = ?', $admin_id);
        $this->delete($where);
    }

    /**
     * Fungsi untuk mengambil satu record admin account dimana admin_id nya 
     * sesuai dengan parameter masukan
     * 
     * @param int $admin_id
     * @return array
     */
    public function getUserInformation($admin_id)
    {
        $select = $this->select()
                  ->setIntegrityCheck(FALSE)
                  ->from(array('ac' => $this->_name))
                  ->join(array('ar' => 'admin_role'),'ar.role_id = ac.role_id',array('allowed_module'))
                  ->where('admin_id = ?', $admin_id);
        return $this->fetchRow($select);
    }
    
    /**
     * Fungsi untuk mengambil semua username admin (distinct) dari basis data 
     * admin account berdasarkan name yang diberikan (fungsi auto complete name)
     *
     * @param string $name
     * @return array
     */
    public function getAllByName($name)
    {
        $data = $this->select()
                ->distinct()
                ->from(array('a' => $this->_name), array('username'))
                ->where("a.username LIKE '%" . $name . "%'");
        return $this->fetchAll($data)->toArray();
    }

    public function getAllQuery($filter = null, $param = null)
    {
        $query = $this->select()
                ->from($this->_name)
                ->join($this->_role,"{$this->_role}.role_id = {$this->_name}.role_id")
                ->setIntegrityCheck(false);
        
        if(null != $filter){
        if (null != $filter['sort'])
        $query->order("{$filter['sort']} {$filter['order']}");
        if(null != $filter['type'])
            $query->where("{$this->_name}.role_id = ?",$filter['type']);
        if(null != $filter['username'])
            $query->where("username LIKE ?", "%{$filter['username']}%");
        }
        
        return $query;
    }

    public function getRoleById($admin_id)
    {
        $query = $this->select()
                ->from($this->_name,array(''))
                ->join($this->_role,"{$this->_role}.role_id = {$this->_name}.role_id",array('role_name'))
                ->setIntegrityCheck(false)
                ->where("{$this->_name}.admin_id = ?", $admin_id);
        $data = $this->fetchRow($query);
        return $data;
    }

    public function getAllQueryById($admin_id)
    {
        $query = $this->select()
                ->from($this->_name)
                ->join($this->_role,"{$this->_role}.role_id = {$this->_name}.role_id")
                ->setIntegrityCheck(false)
                ->where("{$this->_name}.admin_id = ?", $admin_id);
        $data = $this->fetchRow($query);
        return $data;
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel user berdasarkan username
     * dan password yang diberikan
     *
     * @param string $username
     * @param string $pass
     * @return array
     */
    public function getUserByNamePassword($username, $pass)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('username = ?', $username)
                ->where('password = ?', $pass);
        $data = $this->fetchRow($query);

        if(count($data) > 0)
            return true;
        else
            return false;
    }
    
    public function getUserByRole($role_id)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('role_id = ?',$role_id);
        $data = $this->fetchAll($query);
        return $data;
    }

}