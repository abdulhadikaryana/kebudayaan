<?php
/**
 * Model_DbTable_HighlightDescription
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel highlight description
 *
 * @package DbTable Model
 */
class Model_DbTable_HighlightDescription extends Zend_Db_Table_Abstract
{
    //deklarasi tabel yang digunakan dalam model highlighdescription
    protected $_name = 'highlightdesc_new';
    protected $_primary = array('highlight_id','language_id');

    /**
     * Fungsi untuk melakukan insert pada tabel highlight description
     * @return integer
     */
    public function insertHighlight($input)
    {
        $this->insert($input);
    }

    public function checkForIndo($catId, $langId = 2)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('highlight_id = ?', $catId)
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
     * Fungsi untuk melakukan update tabel highlight description
     */
    public function updateHighlight($input,$highlight_id,$language_id = 1)
    {
        $where = $this->getAdapter()->quoteInto('highlight_id = ?',$highlight_id).
        $this->getAdapter()->quoteInto(' AND language_id = ?',$language_id);
        $this->update($input, $where);
    }

    /**
     * Fungsi untuk melakukan delete pada tabel highlight description
     */
    public function deleteHighlight($highlight_id)
    {
        $where = $this->getAdapter()->quoteInto('highlight_id = ?',$highlight_id);
        $this->delete($where);
    }

    public function deleteHighlight2($highlight_id, $language_id = 2)
    {
        $where = $this->getAdapter()->quoteInto('highlight_id = ?',$highlight_id).
                 $this->getAdapter()->quoteInto(' AND language_id = ?',$language_id);
        $this->delete($where);
    }

    public function deleteHighlightenglish($highlight_id, $language_id = 1)
    {
        $where = $this->getAdapter()->quoteInto('highlight_id = ?',$highlight_id).
                 $this->getAdapter()->quoteInto(' AND language_id = ?',$language_id);
        $this->delete($where);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel highlightdescription
     * @return array
     */
    public function getAll()
    {
        $data = $this->select()
                ->from($this->_name);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel highlightdescription berdasarkan
     * highligt_id yang diberikan
     * 
     * @param integer $highlight_id
     * @return array
     */
    public function getAllById($highlight_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('highlight_id = ?', $highlight_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel highlightdescription KECUALI
     * yang mempunyai highlight_id yang diberikan
     * 
     * @param integer $highlight_id
     * @return array
     */
    public function getAllExId($highlight_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('highlight_id != ?', $highlight_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel highlightdescription
     * berdasarkan highlight_id dan language_id yang diberikan
     * 
     * @param integer $highlight_id
     * @param integer $lang_id
     * @return array
     */
    public function getAllByIdLang($highlight_id, $lang_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('highlight_id = ?', $highlight_id)
                ->where('language_id = ?', $lang_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel highlightdescription berdasarkan
     * language_id yang diberikan
     * 
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
     * Fungsi untuk mengambil semua data dari tabel highlightdescription
     * berdasarkan title yang diberikan
     * 
     * @param string $title
     * @return array
     */
    public function getAllByName($title)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where("name LIKE '%" . $title . "%'");
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data title dari tabel highlightdescription berdasarkan
     * highlight_id yang diberikan
     * 
     * @param integer $highlight_id
     * @return array
     */
    public function getNameById($highlight_id)
    {
        $data = $this->select()
                ->from($this->_name,array('name'))
                ->where('highlight_id = ?', $highlight_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil data description dari tabel highlightdescription
     * berdasarkan highlight_id yang diberikan
     * 
     * @param integer $highlight_id
     * @return array
     */
    public function getDescriptionById($highlight_id)
    {
        $data = $this->select()
                ->from($this->_name,array('description'))
                ->where('highlight_id = ?', $highlight_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    public function checkDescIndo($highId)
    {
        $query = $this->select()
                ->from($this->_name,array('description'))
                ->where('language_id = 2')
                ->where('highlight_id = ?',$highId);
        $result = $this->fetchRow($query);

        $query2 = $this->select()
                ->from($this->_name,array('COUNT(language_id) AS count'))
                ->where('highlight_id = ?',$highId);
        $result2 = $this->fetchRow($query2);

        if($result2['count'] > '1')
        {
            if($result['description']==' ')
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
