<?php
/**
 * Model_DbTable_User
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel user
 *
 * @package DbTable Model
 */
class Model_DbTable_User extends Zend_Db_Table_Abstract
{
    /**
     * Nama tabel
     * @var String
     */
    protected $_name = 'user';
    protected $_role ='role';

    /**
     * Fungsi untuk mengambil semua data dari tabel user berdasarkan username
     * yang diberikan dan mempunyai type = 0
     * 
     * @param string $username
     * @return array
     */
    public function getUserByUsername($username)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('type = 0')
                ->where('username = ?', $username);
        $return = $this->fetchRow($query);
        return $return;
    }

    /**
     * Fungsi untuk mengambil data username dan email dari tabel user berdasarkan
     * username dan email yang diberikan
     * 
     * @param string $email
     * @param string $username
     * @return array
     */
    public function getEmail($email, $username)
    {
        $query = $this->select()
                ->from($this->_name,array('username','email'))
                ->where('username = ?', $username)
                ->where('email = ?', $email);
        $return = $this->fetchAll($query);
        return $return;
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

    /**
     * Fungsi untuk mengambil semua data dari tabel user berdasarakan email
     * dan aktivasi key untuk keperluan reset password
     *
     * @param string $email
     * @param string $activationKey
     * @return array
     */
    public function getUserByEmailActivationKey($email, $activationKey)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('email = ?', $email)
                ->where('activationkey = ?', $activationKey);
        $data = $this->fetchRow($query);

        //echo $query->__toString();

        return $data;
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel user berdasarakan email dan
     * username yang diberikan
     * 
     * @param string $email
     * @param string $username
     * @return array
     */
    public function getUser($email,$username)
    {
        if($email == null)
        {
            $query = $this->select()
                    ->from($this->_name,array('user_id','username','password',
                    'name','status','email'))
                    ->where('username = ?', $username);
            $report = $this->fetchAll($query);
            $return = $report->toArray();
            return $return;
        }else if($username == null)
        {
            $query = $this->select()
                    ->from($this->_name,array('user_id','username','password',
                    'name','status','email', 'activationkey'))
                    ->where('email = ?', $email);
            $report = $this->fetchAll($query);
            $return = $report->toArray();
            return $return;
        }else
        {
            $query = $this->select()
                    ->from($this->_name,array('user_id','username','password',
                    'name','status','email'))
                    ->where('email = ?', $email)
                    ->where('username = ?', $username);
            $report = $this->fetchAll($query);
            $return = $report->toArray();
            return $return;
        }
    }

    /**
     * Fungsi yang digunakan untuk mengecek ada tidaknya atau sudah terpakai
     * atau belum dari username atau email yang diberikan
     * 
     * @param string $username
     * @param string $email
     * @return array
     */
    public function checkIfUsernameEmailExist($username, $email)
    {
        if($username == null)
        {
            $query = $this->select()
                    ->from($this->_name,array('email'))
                    ->where('email = ?', $email);
            $report = $this->fetchAll($query);
            $return = $report->toArray();
            return $return;
        }else if($email == null)
        {
            $query = $this->select()
                    ->from($this->_name,array('username'))
                    ->where('username = ?', $username);
            $report = $this->fetchAll($query);
            $return = $report->toArray();
            return $return;
        }else
        {
            $query = $this->select()
                    ->from($this->_name,array('username','email'))
                    ->where('username = ?', $username)
                    ->where('email = ?', $email);
            $report = $this->fetchAll($query);
            $return = $report->toArray();
            return $return;
        }
    }

    /**
     * Fungsi untuk mengecek apakah sebuah username sudah active atau belum
     * 
     * @param string $username
     * @param string $email
     * @return array
     */
    public function checkIfAccountIsActivatedYet($username, $email)
    {
        $query = $this->select()
                ->from($this->_name,array('username'))
                ->where('username = ?', $username)
                ->where('email = ?', $email)
                ->where("status = 'verify'");
        $return = $this->fetchRow($query);
        return $return;
    }

    /**
     * Fungsi untuk mengambil semua data user_id yang belum active
     * 
     * @param string $email
     * @param string $key
     * @return array
     */
    public function getUnactive($email, $key)
    {
        if($key != null)
        {
            $query = $this->select()
                    ->from($this->_name,array('user_id'))
                    ->where('email = ?', $email)
                    ->where('activationkey = ?', $key);
            //echo $query->__toString();
            $report = $this->fetchRow($query);
            $return = $report->toArray();
            return $return['user_id'];
            //return 1;
        }else
        {
            $query = $this->select()
                    ->from($this->_name,array('user_id','name'))
                    ->where('email = ?', $email);
            $report = $this->fetchAll($query);
            $return = $report->toArray();
            return $return;
        }
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel user berdasarkan user_id yang
     * diberikan
     * 
     * @param integer $userId
     * @return array
     */
    public function getUserById($userId)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('user_id = ?', $userId);
        $return = $this->fetchRow($query);
        return $return;
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel user berdasarkan name yang
     * diberikan
     *
     * @param string $name
     * @return array
     */
    public function getUserByName($name)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where("name LIKE '%".$name."%'");
        $report = $this->fetchAll($query);
        $return = $report->toArray();
        return $return;
    }

    /**
     * Fungsi untuk memasukkan data ke dalam tabel user berdasarkan data inputan
     * dan activationkey yang diberikan
     * 
     * @param data $input
     * @param string $activationKey
     */
    public function insertUser($input, $activationKey)
    {   
        $data = array(
            'name'          => $input['realname'],
            'username'      => $input['username'],
            'password'      => md5($input['password']),
            'email'         => $input['email'],
            'country_id'    => $input['country'],
            'activationkey' => $activationKey,
            'status'        => 'verify',
        );

        return $this->insert($data);
    }

    /**
     * Fungsi untuk mengaktifkan account dari user_id yang diberikan
     * 
     * @param string $email email user
     */
    public function activateAccount($email, $key)
    {
        $data = array('status' => 'active');
        
        $where[] = $this->getAdapter()->quoteInto('email = ?', $email);
        $where[] = $this->getAdapter()->quoteInto('activationkey = ?', $key);
        
        $this->update($data, $where);
    }

    /**
     * Fungsi untuk mereset password sebuah account
     * 
     * @param table $tabel
     * @param string $pass
     * @param string $username
     */
    public function resetPass($pass, $userId )
    {
        $data = array(
            'password' => $pass
        );
        
        $where = $this->getAdapter()->quoteInto('user_id = ?', $userId);
        $this->update($data, $where);  
    }

    /**
     *  
     */
    public function getAdminCanReceiveEmail()
    {
        $query = $this->select()
                ->from($this->_name, array('email'))
                ->setIntegrityCheck(false)
                ->join($this->_role,"{$this->_name}.user_id = {$this->_role}.adminname", array())
                ->where("{$this->_role}.roleadmin = ?", 12)
                ->where("{$this->_name}.type <> 0");
        $report = $this->fetchAll($query);

        $result = array();
        foreach($report as $row) {
            $result[] = $row['email'];
        }

        return $result;
    }
    
    /**
     * Fungsi untuk memutakhirkan record di basis data user sesuai masukan 
     * user_id
     * 
     * @param array $input
     * @param int $user_id
     */
    public function updateUser($input, $user_id)
    {
        $where = $this->getAdapter()->quoteInto('user_id = ?', $user_id);
        $this->update($input, $where);
    }
    
    /**
     * Fungsi untuk mengambil query seluruh record user sesuai dengan filter 
     * parameter masukan 
     * 
     * @param int $filter
     * @param string $param
     * @return query 
     */
    public function getQueryAll($filter = 0, $param = null)
    {
        $query = $this->select()
                 ->from(array('u' => $this->_name), array('u.user_id', 'u.username', 'u.status'))
                 ->order('u.username ASC');
        
        switch($filter) {
            case 1 : $query->where("u.username LIKE '%" . $param . "%'");
                     break;
            case 2 : $query->where('u.status = ?', $param);
                     break;
        }
        
        return $query;
    }
}
?>
