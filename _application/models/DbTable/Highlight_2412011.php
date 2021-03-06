<?php
/**
 * Model_DbTable_Highlight
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel highlight
 *
 * @package DbTable Model
 */
class Model_DbTable_Highlight extends Zend_Db_Table_Abstract
{
    //deklarasi tabel yang digunakan dalam model highlight
    protected $_name = 'highlight_new';
    protected $_highlightdesc = 'highlightdesc_new';
    protected $_primary = 'highlight_id';

    /**
     * Fungsi untuk melakukan insert pada tabel highlight
     * @return integer
     */
    public function insertHighlight($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }
    
    /**
     * Fungsi untuk melakukan update pada tabel highlight
     * @return integer
     */
    public function updateHighlight($input,$highlight_id,$language_id = 1)
    {
        $where = $this->getAdapter()->quoteInto('highlight_id = ?',$highlight_id);
        $this->update($input, $where);
    }

    /**
     * Fungsi untuk melakukan delete pada tabel highlight
     * @return integer
     */
    public function deleteHighlight($highlight_id)
    {
        $where = $this->getAdapter()->quoteInto('highlight_id = ?',$highlight_id);
        $this->delete($where);
    }

    
    /**
     * Fungsi untuk mengambil semua data dari tabel highlight
     * @return array
     */
    public function getAll()
    {
        $data = $this->select()
                ->from($this->_name);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel highlight berdasarkan highlight_id
     * yang diberikan
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
     * Fungsi untuk mengambil semua data dari tabel highlight KECUALI yang mempunyai
     * highlight_id sesuai yang diberikan
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
     * Fungsi untuk mengambil data dari tabel highlight dan highlight description
     * berdasarkan highligh id dan language yang diberikan
     * 
     * @param integer highlight_id
     * @return array
     */
    public function getAllWithDesc($highlight_id,$language_id = 1)
    {
        $select = $this->select()
                  ->setIntegrityCheck(FALSE)
                  ->from(array('h' => $this->_name))
                  ->join(array('hd' => $this->_highlightdesc),'hd.highlight_id = h.highlight_id')
                  ->where('hd.language_id = ?',$language_id)
                  ->where('h.highlight_id = ?',$highlight_id);
        return $this->fetchRow($select);
    }
    
    
    /**
     * Fungsi untuk menggenerate query sesuai dengan parameter yang diberikan
     * 
     * @param string $filter, integer/string $param, integer $language_id
     * @return string
     */
    public function getQueryAllByLang($filter = null,$param = null,$language_id = 1)
    {
        $select = $this->select()
                  ->setIntegrityCheck(FALSE)
                  ->from(array('h' => $this->_name),array('highlight_id','type','flag','path_image'))
                  ->join(array('hd' => $this->_highlightdesc),'h.highlight_id = hd.highlight_id',array('name'))
                  ->where('hd.language_id = ?',$language_id);
        switch($filter)
        {
            case 1 : $select->where('h.type = ?',$param);
                     break;
            case 2 : $select->where("hd.name LIKE '%".$param."%'");
                     break;
        }
        $select->order('highlight_id DESC');
        return $select;
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel eventdesc berdasarkan type
     * yang diberikan
     *
     * @param integer $type
     * @return array
     */
    public function getAllByType($type)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('type = ?', $type);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data image dari tabel highlight berdasarkan
     * highlight_id yang diberikan
     *
     * @param integer $highlight_id
     * @return array
     */
    public function getImageById($highlight_id)
    {
        $data = $this->select()
                ->from($this->_name,array('path_image'))
                ->where('highlight_id = ?', $highlight_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil path_image dari tabel highlight yang di-flag
     *
     * @return array
     */
    public function getAllMainImage()
    {
        $data = $this->select()
                ->from($this->_name,array('path_image'))
                ->where('flag = 1');
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data highlight dan image dari tabel highlight
     * yang di-flag untuk tampil di depan ( mempunyai flag = 1 )
     *
     * @return array
     */
    public function getMain($language_id =1)
    {
        $data = $this->select()
                ->setIntegrityCheck(FALSE)
                ->from($this->_name,array('highlight_id', 'path_image', 'link'))
                ->join($this->_highlightdesc, "{$this->_highlightdesc}.highlight_id = {$this->_name}.highlight_id",
                 array('name', 'description', 'img_path', 'link_path'))
                ->where("{$this->_highlightdesc}.language_id = ?",$language_id)
                ->where("{$this->_name}.type = 1")
                ->where('flag = 1');
        return $this->fetchAll($data);
    }

    public function getSmallHighlight($language_id =1)
    {
        $query = $this->select()
                ->setIntegrityCheck(FALSE)
                ->from($this->_name,array('highlight_id', 'path_image', 'link'))
                ->join($this->_highlightdesc, "{$this->_highlightdesc}.highlight_id = {$this->_name}.highlight_id",
                 array('name', 'description', 'img_path', 'link_path'))
                ->where('flag = 1')
                ->where('type = 4')
                ->order('sort_order ASC')
                ->where("{$this->_highlightdesc}.language_id = ?",$language_id)
                ->limit(2,0);
        return $this->fetchAll($query);
    }

    /**
     * Fungsi untuk mendapatkan highlight_id paling terakhir dari tabel highlight
     *
     * @return array
     */
    public function getLastId()
    {
        $data = $this->select()
                ->from($this->_name,array('highlight_id'))
                ->order('highlight_id DESC')
                ->limit(1,0);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel highlight dan highlight description
     * yang di-flag untuk tampil di depan ( mempunyai flag = 1 )
     * berdasarkan type dan bahasa yang diberikan
     * @return array
     */
    public function getMainType($type, $langId)
    {
        $data = $this->select()
                ->from($this->_name)
                ->join($this->_highlightdesc, "{$this->_highlightdesc}.highlight_id = {$this->_name}.highlight_id",
                 array('name', 'description', 'img_path', 'link_path'))
                ->setIntegrityCheck(false)
                ->where("{$this->_highlightdesc}.language_id = ?", $langId)
                ->where("{$this->_name}.type = ?", $type)
                ->where("{$this->_name}.flag = 1", $type)
                ->order("{$this->_name}.sort_order ASC");
        return $this->fetchAll($data);
    }

    public function fetchMainType($type, $langId)
    {
        $query = $this->select()
                ->from($this->_name)
                ->join($this->_highlightdesc, "{$this->_highlightdesc}.highlight_id = {$this->_name}.highlight_id", array('name', 'description'))
                ->setIntegrityCheck(false)
                ->where("{$this->_highlightdesc}.language_id = ?", $langId)
                ->where("{$this->_name}.type = ?", $type);
        $report = $this->fetchRow($query);
        $return = $report->toArray();
        return $return; 
    }
    
    /**
     * Fungsi untuk mengambil data flag dari tabel highlight berdasarkan
     * highlight_id yang diberikan
     *
     * @param integer $highlight_id
     * @return array
     */
    public function getFlagById($highlight_id)
    {
        $data = $this->select()
                ->from($this->_name, array('flag'))
                ->where('highlight_id = ?', $highlight_id);
        $return = $this->fetchRow($data);
        return $return['flag'];
    }

}
?>