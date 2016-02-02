<?php
/**
 * Model_DbTable_Themes
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel themes
 *
 * @package DbTable Model
 */
class Model_DbTable_Themes extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'theme_new';
    protected $_primary = 'theme_id';

    /**
     * Fungsi untuk mengambil semua data dari tabel theme
     * @return array
     */
    public function getAll()
    {
        $data = $this->select()
                ->from($this->_name);

        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel theme yang merupakan active
     * theme
     * @return array
     */
    public function getActiveTheme()
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('flag = 1');
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data theme_name dari tabel theme berdasarkan
     * theme_id yang diberikan
     * @param integer $id
     * @return array
     */
    public function getNameById($id)
    {
        $data = $this->select()
                ->from($this->_name,array('theme_name'))
                ->where('theme_id = ?', $id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil semua data name dari tabel theme
     * @return array
     */
    public function getAllName()
    {
        $data = $this->select()
                ->from($this->_name,array('theme_name'));
        return $this->fetchAll($data);
    }

}
?>
