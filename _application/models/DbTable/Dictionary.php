<?php
/**
 * Model_DbTable_Dictionary
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel dictionary
 *
 * @package DbTable Model
 */
class Model_DbTable_Dictionary extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'dictionary';
    protected $_table = 'language';

    /**
     * FUngsi untuk mengambil semua data dari tabel dictionary
     * @return array
     */
    public function getAll()
    {
        $data = $this->select()
                ->from($this->_name);
        return $this->fetchAll($data);
    }

    public function getAllById($work_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('work_id = ?', $work_id);
        return $this->fetchAll($data);
    }

    public function getNameLang($langId)
    {
        $data = $this->select()
                ->from($this->_table,array('language_name'))
                ->where('language_id = ?', $langId)
                ->setIntegrityCheck(false);
        $return = $this->fetchRow($data);
        return $return;
    }

    public function getDesc($langName)
    {
        //$name = $this->getNameLang($langId);
        $data = $this->select()
                ->from($this->_name,array('word_id', $langName));
       // return $name->language_name;
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data language_name berdasarkan urutan
     * language_id
     *
     * @return array
     */
    public function getDictionaryArray($langName)
    {
        $dictionaryFromDb = $this->getDesc($langName);
        $dictionary = array();
        foreach($dictionaryFromDb as $row)
        {
            $dictionary[$row['word_id']] = $row[$langName];
        }
        return $dictionary;
    }
}
?>
