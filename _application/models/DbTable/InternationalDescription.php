<?php
/**
 * Model_DbTable_InternationalDescription
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel international description
 *
 * @package DbTable Model
 */
class Model_DbTable_InternationalDescription extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'internationaldescription';
    protected $_table = 'international';

    /**
     * Fungsi untuk mengambil semua data dari tabel internationaldescription
     * 
     * @return array
     */
    public function getAll()
    {
        $data = $this->select()
                ->from($this->_name);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel internationakdescription
     * berdasarkan international_id yang diberikan
     * 
     * @param integer $id
     * @return array
     */
    public function getAllById($id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('international_id = ?', $id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel internationadescription
     * berdasarkan internation_id yang diberikan
     * 
     * @param integer $id
     * @return array
     */
    public function getAllExId($id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('international_id != ?', $id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mendapatkan international_id yang paling terakhir
     * 
     * @return array
     */
    public function getLastId()
    {
        $data = $this->select()
                ->from($this->_name,array('international_id'))
                ->order('internatinal_id DESC')
                ->limit(1,0);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel internationaldescription
     * berdasarkan international_id dan language_id yang diberikan
     * 
     * @param integer $id
     * @param integer $lang_id
     * @return array
     */
    public function getAllByIdLang($id, $lang_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('international_id != ?', $id)
                ->where('language_id = ?', $lang_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data berdasarkan language_id yang diberikan
     * @param integer $lang_id
     * @return array
     */
    public function getAllByLang($lang_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('language_id = ?', $lang_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data berdasarkan title yang diberikan
     * @param string $title
     * @return array
     */
    public function getAllByName($title)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where("title LIKE '%".$title."%'");
        return $this->fetchAll($data);
    }

}
?>
