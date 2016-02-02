<?php
/**
 * Model_DbTable_Directory
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel directory
 *
 * @package DbTable Model
 */
class Model_DbTable_Directory extends Zend_Db_Table_Abstract
{

    //deklarasi tabel yang digunakan dalam model directory
    protected $_name = 'directory';
    protected $_area = 'area';
    protected $_primary = 'id_dir';
    /**
     * Fungsi untuk mengambil data hotel(nama,alamat,telpon) dari tabel directory
     * berdasarkan poi_id yang diberikan
     * 
     * @param integer $area_id
     * @param integer $tipe_direktory
     * @return array
     */
    public function getHotelById($area_id,$tipe_direktory = 1)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('area_id = ?', $area_id)
                ->where('tipe_direktory = 1');

        return $query;
    }

    /**
     * Fungsi untuk mengambil data travel agent(nama,alamat,telpon) dari tabel directory
     * berdasarkan poi_id yang diberikan
     * 
     * @param integer $area_id
     * @param integer $tipe_direktory
     * @return array
     */
    public function getTravelAgent($area_id,$tipe_direktory = 3)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('area_id = ?', $area_id)
                ->where('tipe_direktory = 3');
        return $query;
    }

    /**
     * Fungsi untuk mengambil data restaurant(nama,alamat,telpon) dari tabel directory
     * berdasarkan poi_id yang diberikan
     * 
     * @param integer $area_id
     * @param integer $tipe_direktory
     * @return array
     */
    public function getRestaurant($area_id,$tipe_direktory = 2)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('area_id = ?', $area_id)
                ->where('tipe_direktory = 2');
        return $query;
    }

    /**
     * Fungsi untuk mengambil data Souvenir Shop(nama,alamat,telpon) dari tabel directory
     * berdasarkan poi_id yang diberikan
     * 
     * @param integer $area_id
     * @param integer $tipe_direktory
     * @return array
     */
    public function getSouvenir($area_id,$tipe_direktory = 4)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('area_id = ?', $area_id)
                ->where('tipe_direktory = 4');
        return $query;
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel directory
     * @return array
     */
    public function getAll()
    {
        $data = $this->select()
                ->from($this->_name);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel directory berdasarkan id_dir
     * yang diberikan
     * 
     * @param integer $id_dir
     * @return array
     */
    public function getAllById($id_dir)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('id_dir = ?', $id_dir);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel directory berdasarkan tipe_direktory
     * yang diberikan
     * 
     * @param integer $tipe_direktory
     * @return array
     */
    public function getAllByTipe($tipe_direktory)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('tipe_direktory = ?', $tipe_direktory);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data hotel dari tabel direktory berdasarkan
     * area_id, star, dan tipe_direktory yang diberikan
     * 
     * @param integer $area_id
     * @param integer $star
     * @param integer $tipe_direktory
     * @return array
     */
    public function getHotelByIdStar($area_id,$star,$tipe_direktory = 1)
    {
        $data = $this->select()
                ->from($this->_name,array('nama','alamat','telpon','fax','email',
                                          'website','contact_person'))
                ->where('area_id = ?', $area_id)
                ->where('star = ?', $star)
                ->where('tipe_direktory = 1');
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data Embassy Office dari tabel directory
     * @param integer $tipe_direktory
     * @return array
     */
    public function getEmbassyOffice($tipe_direktory = 5)
    {
        $query = $this->select()
                ->from($this->_name,array('nama','alamat','telpon','fax','email',
                                          'website','contact_person'))
                ->where('tipe_direktory = 5');
        
        return $query;
    }

    /**
     * Fungsi untuk melakukan pencarian directory berdasarkan tipe_direktory,
     * name(direktory)dan nama(area) sesuai yang diberikan
     * @param integer $type
     * @param string $nameDir
     * @param string $areaName
     * @return array
     */
    public function getSearch($type = 0, $nameDir = '', $areaName = '')
    {
        // baseline query
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name, array('star','nama','alamat','telpon','fax','email','website','contact_person'))
                ->join($this->_area,"{$this->_area}.area_id = {$this->_name}.area_id",
                        array(''));

        // Cek parameter dan gunakan paramter jika tidak kosong
        if($type != 0){
            $where = $this->getAdapter()->quoteInto(
                    "{$this->_name}.tipe_direktory = ?", $type);
            $query->where($where);
        }

        if(!empty($areaName))
        {
            $where = $this->getAdapter()->quoteInto(
                    "{$this->_area}.name LIKE ?", '%'.$areaName.'%');
            $query->where($where);
        }
        if(!empty($nameDir))
        {
            $where = $this->getAdapter()->quoteInto(
                    "{$this->_name}.nama LIKE ?", '%'.$nameDir.'%');
            $query->where($where);
        }

        $query->group("{$this->_name}.id_dir");

        //echo $query->__toString();
        return $query;

    }

}

?>
