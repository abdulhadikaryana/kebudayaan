<?php
/**
 * Model_DbTable_Language
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel language
 *
 * @package DbTable Model
 */
class Model_DbTable_Language extends Zend_Db_Table_Abstract
{
    //deklarasi tabel yang digunakan dalam model language
    protected $_name = 'language';

    /**
     * Fungsi untuk mengambil semua data dari tabel language
     * @return array
     */
    public function getAll()
    {
        $data = $this->select()
                ->from($this->_name);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data language_id, language_name dan language_text dari tabel language
     * @return array
     */
    public function getAllLang()
    {
        $data = $this->select()
                ->from($this->_name,array('language_id','language_name','language_text'));
        return $this->fetchAll($data);
    }


    /**
     * Fungsi untuk mengambil semua data dari tabel language berdasarkan
     * language_id yang diberikan
     * 
     * @param integer $lang_id
     * @return array
     */
    public function getAllById($lang_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('language_id = ?', $lang_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel language KECUALI yang mempunyai
     * language_id sesuai yang diberikan
     * 
     * @param integer $lang_id
     * @return array
     */
    public function getAllExId($lang_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('language_id != ?', $lang_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data language_text dan language_id dari tabel
     * language
     * 
     * @return array
     */
    public function getAllTextId()
    {
        $data = $this->select()
                ->from($this->_name,array('language_text','language_id'));
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data language_naem dari tabel language
     * @return array
     */
    public function getAllName()
    {
        $data = $this->select()
                ->from($this->_name,array('language_name'));
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data language_name berdasarkan urutan
     * language_name
     * 
     * @return array
     */
    public function getLangNameArray()
    {
        $name = $this->getAll();
        $language = array();
        //$unallowedLanguage = array('es', 'kr', 'de', 'fr','ar');

		$unallowedLanguage = array('es', 'kr', 'ar');
		
	 	foreach($name as $row)
        {	
			if(!in_array($row['language_name'], $unallowedLanguage))
			{
				$language[$row['language_name']] = $row['language_text'];
			}
        }

        return $language;
    }

    /**
     * Fungsi untuk mengambil data language_id dan name dan disimpan dalam cache
     * @return array
     */
    public function getLangNameArrayWithCache()
    {
        // set up cache
        $cache = Zend_Registry::get('cache');

        $lang = null;

        // dibedakan key cache tiap bahasa
        $key = 'language' ;
        // cek apakah categori disimpan di dalam cache
        // jika belum simpan disana
        if (!($lang = $cache->load($key))) {
            $lang = $this->getLangNameArray();
            $cache->save($lang, $key);
        }

        return $lang;
    }

    /**
     * Fungsi untuk mengambil data language_name dari tabel language berdasarkan
     * language_id yang diberikan
     * 
     * @param integer $lang_id
     * @return array
     */
    public function getNameById($lang_id)
    {
        $data = $this->select()
                ->from($this->_name,array('language_name','language_text'))
                ->where('language_id = ?', $lang_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil data language_text dari tabel language berdasarkan
     * language_id yang diberikan
     * 
     * @param integer $lang_id
     * @return array
     */
    public function getTextById($lang_id)
    {
        $data = $this->select()
                ->from($this->_name,array('language_text'))
                ->where('language_id = ?', $lang_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel language berdasarkan
     * language_name yang diberikan
     * 
     * @param string $lang_name
     * @return array
     */
    public function getAllByName($lang_name)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where("language_name LIKE '%" . $lang_name . "%'");
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data language_id dan language_text yang digunakan
     * sebagai menu bahasa
     *
     * @return array
     */
    public function getMenuBahasa()
    {
        $data = $this->select()
                ->from($this->_name,array('language_id','language_text'));
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil language_name english
     * @return array
     */
    public function getEnglish()
    {
        $data = $this->select()
                ->from($this->_name,array('language_name'))
                ->where("language_name = 'en' ");
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data language_id berdasarkan language_name yang
     * diberikan
     * @param string $name
     * @return array
     */
    public function getIdByName($name)
    {
        $query = $this->select()
                ->from($this->_name,array('language_id', 'language_text'))
                ->where('language_name = ? ', $name);
        return $this->fetchRow($query);
    }

}
?>
