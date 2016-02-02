<?php
/**
 * Model_DbTable_Admin
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel admin
 * 
 * @package Model
 */
class Model_DbTable_Admin extends Zend_Db_Table_Abstract
{
	/** The default table name */
	protected $_name = 'admin';

    /**
     * Fungsi untuk mendeklarasikan role
     */
	public function getRoleList()
	{
		$role = array('role1','role2','role3');
	}

    /**
     * fungsi untuk menentukan role tiap user
     * 
     * @param integer $user
     * @return array
     */
	public function getRole($user)
	{
		switch ($user)
		{
			case 'user1' : return 'role1';
						   break;
			case 'user2' : return 'role2';
						   break;
			case 'user3' : return 'role3';
						   break;
		}
	}

    /**
     * Fungsi untuk menunjukkan jika suatu role itu telah ada
     * 
     * @param integer $role
     * @return boolean
     */
	public function isRoleExist($role)
	{
		return TRUE;
	}

    /**
     * Fungsi untuk menentukan role admin untuk tiap user
     * 
     * @param integer $role
     * @return array
     */
	public function  getDenyList($role)
	{   
		$deny1 = array('destination,news');		
		$deny2 = array('poi');		
		$deny3 = array('news');		
		switch ($role)
		{
			case 'role1' : return $deny1();
						   break;
			case 'role2' : return $deny2();
						   break;
			case 'role3' : return $deny3();
						   break;
		}
	}
}

