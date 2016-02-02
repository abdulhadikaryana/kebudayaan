<?php
/**
 * Model_DbTable_Mail
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel mail
 */
class Model_DbTable_Mail extends Zend_Db_Table_Abstract
{
    /** deklarasi tabel yang digunakan */
    protected $_name = 'mail';

    /**
     * Fungsi untuk memasukkan record baru ke dalam basis data mail
     * 
     * @param array $input
     * @return int
     */
    public function insertMail($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }
    
    /**
     * Fungsi untuk memutakhirkan record di basis data mail sesuai masukan 
     * mail_id
     * 
     * @param array $input
     * @param int $mail_id
     */
    public function updateMail($input, $mail_id)
    {
        $where = $this->getAdapter()->quoteInto('mail_id = ?', $mail_id);
        $this->update($input, $where);
    }
    
    /**
     * Fungsi untuk menghapus record dari basis data mail sesuai masukan mail_id
     * 
     * @param int $mail_id
     */
    public function deleteMail($mail_id)
    {
        $where = $this->getAdapter()->quoteInto('mail_id = ?', $mail_id);
        $this->delete($where);
    }
    
    /**
     * Fungsi untuk mengambil semua record dimana recipient nya sesuai dengan 
     * parameter masukan dan kemudian mengurutkannya berdasarkan tanggal terbaru 
     * 
     * @param string $to
     * @return query
     */
    public function getAllMailByRecipient($to)
    {
        $select = $this->select()
                  ->from(array('m' => $this->_name))
                  ->where("SUBSTRING(m.to, LOCATE('".$to."', m.to), LENGTH('".$to."')) = ?", $to)
                  ->order("m.date DESC");
                  
        return $select;
    }
    
    /**
     * Fungsi untuk mengambil satu record mail dimana recipient nya sesuai 
     * dengan parameter masukan
     * 
     * @param int $mail_id
     * @return array
     */
    public function getMailById($mail_id)
    {
        $select = $this->select()
                  ->from(array('m' => $this->_name))
                  ->where("m.mail_id = ?", $mail_id);
                  
        return $this->fetchRow($select);
    }
}
?>
