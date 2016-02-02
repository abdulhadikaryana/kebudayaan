<?php
/**
 * Model_DbTable_LogAdmin
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel log admin
 * 
 * @package Model
 */
class Model_DbTable_LogAdmin extends Zend_Db_Table_Abstract
{
    /** deklarasi tabel yang digunakan */
    protected $_name = 'logadmin';

    /**
     * Fungsi untuk memasukkan record baru ke dalam basis data log admin
     * 
     * @param array $data
     * @return int
     */
    public function insertLog($data)
    {
        $this->insert($data);
        return $this->_db->lastInsertId();
    }

    /**
     * Fungsi untuk mengambil query seluruh record log sesuai dengan filter
     * parameter masukan
     * 
     * @param int $filter
     * @param int $param1
     * @param int $param2 (hanya untuk filter date)
     * @return query
     */
    public function getQueryAll($filter = null, $param1 = null)
    {
        $query = $this->select()
                 ->setIntegrityCheck(FALSE)
                 ->from(array('l' => $this->_name))
                 ->join(array('a' => 'admin_account'), 'a.admin_id = l.user_id', array('a.username'))
                 ->order('l.date DESC');
        
        if(null != $filter){
            if(null != $filter['a.username'])
                $query->where("a.username LIKE ?", "%{$filter['a.username']}%");
            if(null != $filter['content_id'])
                $query->where ("content_id = ?",$filter['content_id']);

        }
        
        
//        switch($filter) {
//            case 1 : $query->where("a.username LIKE '%" . $param1 . "%'");
//                     break;
//            case 2 : $query->where("l.module = ?", $param1);
//                     break;
//            case 3 : $process_date = TRUE;
//                     break;
//        }
//        kondisi if ditambah false
//        if ($process_date = FALSE) {
//            if (($param1 != null) && ($param2 != null)) {
//                $query->where("DATE(l.date) BETWEEN '" . $param1 . "' AND '" . $param2 . "'");    
//            } 
//            elseif (($param1 != null) && ($param2 == null)) {
//                $query->where("DATE(l.date) >= '" . $param1 . "'");
//            } 
//            elseif (($param2 != null) && ($param1 == null)) {
//                $query->where("DATE(l.date) <= '" . $param2 . "'");
//            }
//        }     
        
        return $query;
    }
}
?>
