<?php
/**
 * Model_DbTable_NewsDesc
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel news description
 *
 * @package DbTable Model
 */
class Model_DbTable_NewsDesc extends Zend_Db_Table_Abstract
{

//deklarasi tabel yang digunakan dalam model NewsDesc
    protected $_name = 'news_description';
    protected $_primary = array('news_id', 'language_id');

    /**
     * Fungsi untuk memasukkan data inputan ke dalam tabel newsdesc
     * @param data $input
     */
    public function insertNewsDescription($input)
    {
        $this->insert($input);
    }

    public function checkForIndo($catId, $langId = 2)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('news_id = ?', $catId)
                ->where('language_id = ?', $langId);
        $report = $this->fetchRow($query);
        if($report!=null)
            {
                return true;
        }else
            {
            return false;
        }
    }

    /**
     * Fungsi untuk mengupdate database berdasarkan news_id yang diberikan
     * @param data $input
     * @param integer $news_id
     */
    public function updateNewsDescription($input,$news_id, $languageId)
    {
        $where = $this->getAdapter()->quoteInto('news_id = ?',$news_id).
                 $this->getAdapter()->quoteInto(' AND language_id = ?',$languageId);
        $this->update($input, $where);
    }

    /**
     * Fungsi untuk menghapus data di database berdasarkan news_id yang diberikan
     * @param integer $news_id
     */
    public function deleteNewsDescription($news_id)
    {
        $where = $this->getAdapter()->quoteInto('news_id = ?',$news_id);
        $this->delete($where);
    }

    public function deleteNewsDescription2($news_id, $languageId = 2)
    {
        $where = $this->getAdapter()->quoteInto('news_id = ?',$news_id).
                 $this->getAdapter()->quoteInto(' AND language_id = ?',$languageId);
        $this->delete($where);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel newsdesc
     * @return array
     */
    public function getAll()
    {
        $data = $this->select()
                ->from($this->_name);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel newsdesc berdasarkan news_id
     * yang diberikan
     *
     * @param integer $news_id
     * @return array
     */
    public function getAllById($news_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('news_id = ?', $news_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel newsdesc KECUALI yang mempunyai
     * news_id sesuai yang diberikan
     *
     * @param integer $news_id
     * @return array
     */
    public function getAllExId($news_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('news_id != ?', $news_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel newsdesc berdasarkan title
     * yang diberikan
     *
     * @param string $title
     * @return array
     */
    public function getAllByTitle($title)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where("title LIKE '%" . $title . "%'");
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data title dari tabel newsdesc
     * @return array
     */
    public function getAllTitle()
    {
        $data = $this->select()
                ->from($this->_name, array('title'));
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data content dari tabel newsdesc berdasarkan title
     * yang diberikan
     *
     * @param string $title
     * @return array
     */
    public function getContentByTitle($title)
    {
        $data = $this->select()
                ->from($this->_name, array('content'))
                ->where("title LIKE '%" . $title . "%'");
        $report = $this->fetchRow($data);
        $return = $report->toArray();
        return $return;
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel newsdesc berdasarkan
     * language_id yang diberikan
     *
     * @param integer $lang_id
     * @return array
     */
    public function getAllByLang($lang_id = 1)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('language_id = ?', $lang_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengecek apakah suatu query sudah ada atau belum
     * @param array $select
     * @return string
     */
    public function checkQuery($select)
    {
        $result = $this->fetchRow($select);
        if (!empty($result)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Fungsi untuk mengambil data name dari tabel poi berdasarkan poi_id yang
     * diberikan
     *
     * @param integer $poiId
     * @return array
     */
    public function getTitleById($newsId, $languageId = 1)
    {
        $data = $this->select()
                ->from($this->_name, array('title'))
                ->where('news_id = ?', $newsId)
                ->where('language_id = ?', $languageId);

        $result = $this->fetchRow($data);

        return $result['title'];
    }

    public function checkDescIndo($eventId)
    {
        $query = $this->select()
                ->from($this->_name,array('content'))
                ->where('language_id = 2')
                ->where('news_id = ?',$eventId);
        $result = $this->fetchRow($query);

        $query2 = $this->select()
                ->from($this->_name,array('COUNT(language_id) AS count'))
                ->where('news_id = ?',$eventId);
        $result2 = $this->fetchRow($query2);

        if($result2['count'] > '1')
        {
            if($result['content']==' ')
            {
                return false;
            }else
            {
                return true;
            }
        }
        else
        {
            return false;
        }

    }

}

?>
