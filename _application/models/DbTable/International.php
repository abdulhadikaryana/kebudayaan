<?php
/**
 * Model_DbTable_International
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel international
 *
 * @package DbTable Model
 */
class Model_DbTable_International extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'international';
    protected $_table = 'internationaldescription';

    /**
     * Fungsi untuk mengambil semua data dari tabel international
     * @return array
     */
    public function getAll()
    {
        $data = $this->select()
                ->from($this->_name);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel international berdasarkan
     * international_id yang diberikan
     *
     * @param integer $international_id
     * @return array
     */
    public function getAllById($international_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('international_id = ?', $international_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel international KECUALI yang
     * mempunyai international_id seperti yang diberikan
     *
     * @param integer $international_id
     * @return array
     */
    public function getAllExId($international_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('international_id != ?', $international_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel international berdasarkan
     * name yang diberikan
     *
     * @param string $name
     * @return array
     */
    public function getAllByName($name)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where("name LIKE '%".$name."%'");
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data international_id yang paling terakhir
     *
     * @return array
     */
    public function getLastId()
    {
        $data = $this->select()
                ->from($this->_name,array('international_id'))
                ->order('international_id DESC')
                ->limit(1,0);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil semua data name dari tabel international
     *
     * @return array
     */
    public function getAllName()
    {
        $data = $this->select()
                ->from($this->_name,array('name'));
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel international dan tabel
     * internationaldescription berdasarkan language_id yang diberikan
     *
     * @param integer $lang_id
     * @return array
     */
    public function getAllWithDesc($lang_id = 1)
    {
        $data = $this->select()
                ->from($this->_name)
                ->join($this->_table,"{$this->_table}.international_id = {$this->_name}.international_id")
                ->setIntegrityCheck(false)
                ->where("{$this->_table}.language_id = ?", $lang_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel international dan tabel
     * internationaldescription berdasarkan language_id dan international_id
     * yang diberikan
     *
     * @param integer $international_id
     * @param integer $lang_id
     * @return array
     */
    public function getAllWithDescById($international_id, $lang_id = 1)
    {
        $data = $this->select()
                ->from($this->_name)
                ->join($this->_table,"{$this->_table}.international_id = {$this->_name}.international_id")
                ->setIntegrityCheck(false)
                ->where("{$this->_table}.international_id = ?", $international_id)
                ->where("{$this->_table}.language_id = ?", $lang_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data country dari tabel international
     *
     * @return array
     */
    public function getAllCountry()
    {
        $data = $this->select()
                ->from($this->_name,array('country'));
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data cpuntry dari tabel international
     * berdasarkan international_id dan atau name yang diberikan
     *
     * @param string $name
     * @param integer $id
     * @return array
     */
    public function getCountryByNameId($name, $id)
    {
        if($id==null)
        {
            $data = $this->select()
                    ->from($this->_name,array('country'))
                    ->where("name LIKE '%".$name."%'");
            $report = $this->fetchRow($data);
            $return = $report->toArray();
            return $return;
        }else if($name == null)
        {
            $data = $this->select()
                    ->from($this->_name,array('country'))
                    ->where('international_id = ?', $id);
            $report = $this->fetchRow($data);
            $return = $report->toArray();
            return $return;
        }else
        {
            $data = $this->select()
                    ->from($this->_name,array('country'))
                    ->where("name LIKE '%".$name."%'")
                    ->where('international_id = ?', $id);
            $report = $this->fetchRow($data);
            $return = $report->toArray();
            return $return;
        }
    }

    /**
     * Fungsi untuk mengambil semua data kocation dari tabel international
     * berdasarkan international_id dan atau name yang diberikan
     *
     * @param string $name
     * @param integer $id
     * @return array
     */
    public function getLocationByNameId($name, $id)
    {
        if($id==null)
        {
            $data = $this->select()
                    ->from($this->_name,array('location'))
                    ->where("name LIKE '%".$name."%'");
            $report = $this->fetchRow($data);
            $return = $report->toArray();
            return $return;
        }else if($name == null)
        {
            $data = $this->select()
                    ->from($this->_name,array('location'))
                    ->where('international_id = ?', $id);
            $report = $this->fetchRow($data);
            $return = $report->toArray();
            return $return;
        }else
        {
            $data = $this->select()
                    ->from($this->_name,array('location'))
                    ->where("name LIKE '%".$name."%'")
                    ->where('international_id = ?', $id);
            $report = $this->fetchRow($data);
            $return = $report->toArray();
            return $return;
        }
    }

    /**
     * Fungsi untuk mengambil data start_date dan end_date berdasarkan
     * international_id yang diberikan
     *
     * @param integer $id
     * @return array
     */
    public function getStartDateEndEventById($id)
    {
        $data = $this->select()
                ->from($this->_name,array('start_date','end_date'))
                ->where('international_id = ?', $id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil sejumlah data event terakhir
     * @param integer $num
     * @return array
     */
    public function getLatestEvent($num)
    {
        $data = $this->select()
                ->from($this->_name)
                ->order('start_date DESC')
                ->limit($num,0);
        return $this->fetchAll($data);
    }

}
?>