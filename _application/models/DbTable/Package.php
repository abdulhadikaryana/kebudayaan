<?php
/**
 * Model_DbTable_Package
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel package
 *
 * @package DbTable Model
 */
class Model_DbTable_Package extends Zend_Db_Table_Abstract
{
    protected $_name = 'package';
    protected $_table = 'poitopackage';
    protected $_packageDescription = 'packagedescription';

    /**
     * Fungsi untuk melakukan insert pada tabel package
     * @return integer
     */
    public function insertPackage($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();
    }

    /**
     * Fungsi untuk melakukan update pada tabel package
     */
    public function updatePackage($input,$package_id)
    {
        $where = $this->getAdapter()->quoteInto('package_id = ?',$package_id);
        $this->update($input, $where);
    }
    
    /**
     * Fungsi untuk melakukan delete pada tabel package
     */
    public function deletePackage($package_id)
    {
        $where = $this->getAdapter()->quoteInto('package_id = ?',$package_id);
        $this->delete($where);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel package
     * @return array
     */
    public function getAll() {
        $data = $this->select()
                ->from($this->_name);
        return $data;
    }
    
    /**
     * Fungsi untuk mengambil semua data dari tabel package berdasarkan
     * package_id yang diberikan
     * @param integer $package_id
     * @return array
     */
    public function getAllById($package_id) {
        $data = $this->select()
                ->from($this->_name)
                ->where('package_id = ?', $package_id);
        return $this->fetchAll($data);
    }
    
    public function getAllWithDescByIdLangId($package_id,$language_id)
    {
        $select = $this->select()
                  ->setIntegrityCheck(FALSE)
                  ->from(array('p' => $this->_name))
                  ->join(array('pd' => $this->_packageDescription),'p.package_id = pd.package_id')
                  ->where('p.package_id = ?',$package_id)
                  ->where('pd.language_id = ?',$language_id);
        return $this->fetchRow($select);
    }
    
    /**
     * Fungsi untuk mengambil semua data dari tabel package berdasarkan name yang
     * diberikan
     * @param string $name
     * @return array
     */
    public function getAllByName($name) {
        $data = $this->select()
                ->from($this->_name)
                ->where("name LIKE '%".$name."%'");
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel package KECUALI yang mempunyai
     * packkage_id seperti yang diberikan
     * @param <type> $package_id
     * @return array
     */
    public function getAllExId($package_id) {
        $data = $this->select()
                ->from($this->_name)
                ->where('package_id != ?', $package_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil package_id yang paling terakhir
     * @return array
     */
    public function getLastId() {
        $data = $this->select()
                ->from($this->_name,array('package_id'))
                ->order('package_id DESC')
                ->limit(1,0);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil data berdasarkan parameter yang dikirim
     * yaitu package_id dan language_id
     * @param integer $package_id, $language_id
     * @return string
     */
     public function getQueryAllByLanguage($filter = 0,$param = null,$language_id = 1)
     {
        $select = $this->select()
                  ->setIntegrityCheck(FALSE)
                  ->from(array('p' => $this->_name))
                  ->join(array('pd' => $this->_packageDescription),'p.package_id = pd.package_id',array('pd.title'))
                  ->where('pd.language_id = ?',$language_id);
        if(isset($filter))
        {
            if($filter==1){$select->where("pd.title LIKE '%".$param."%'");}
        }
        $select->order('package_id DESC');
        return $select;
     }
     
     
    /**
     * Fungsi untuk mengambil data package_id, name, contact,website dari tabel
     * package berdasarkan poi_id yang diberikan
     * @param integer $poi_id
     * @return array
     */
    public function getPackageByPoi($poi_id)
    {
        $data = $this->select()
                ->from($this->_name,array('package_id','name','contact','website'))
                ->join($this->_table,"{$this->_table}.package_id = {$this->_name}.package_id",array(''))
                ->setIntegrityCheck(false)
                ->where("{$this->_table}.poi_id = ?", $poi_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data name dari tabel package berdasarkan package_id
     * yang diberikan
     * @param integer $package_id
     * @return array
     */
    public function getNameById($package_id)
    {
        $data = $this->select()
                ->from($this->_name,array('name'))
                ->where('package_id = ?', $package_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data contact berdasarkan package_id yang diberikan
     * @param integer $package_id
     * @return array
     */
    public function getContactById($package_id)
    {
        $data = $this->select()
                ->from($this->_name,array('contact'))
                ->where('package_id = ?', $package_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data website berdasarkan package_id yang diberikan
     * @param integer $package_id
     * @return array
     */
    public function getWebsiteById($package_id)
    {
        $data = $this->select()
                ->from($this->_name,array('website'))
                ->where('package_id = ?', $package_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mendapatkan data package beserta deskripsinya
     * 
     * @return Zend Select
     */
    public function getAllWithDesc( $sortingOptions = null, $langId)
    {
        $data = $this->select()
                ->from($this->_name,array('package_id', 'contact', 'website'))
                ->join($this->_packageDescription,
                    "{$this->_packageDescription}.package_id =
                        {$this->_name}.package_id")
                ->setIntegrityCheck(false)
                ->where("{$this->_packageDescription}.language_id = ?",$langId);
        $sortBy = $this->_getSortBy($sortingOptions['sort_by'],
                                    $sortingOptions['sort_order']);
        $data->order($sortBy);
        return $data;
    }

    /**
     * ADDED BY BEMBY (2010-05-22)
     * Fungsi untuk mengambil semua data dari tabel package dan
     * packageDescription berdasarkan package_id dan language_id yang diberikan
     * @param integer $package_id
     * @param integer $lang_id
     * @return array
     */
    public function getAllWithDescById($package_id, $lang_id )
    {
        $data = $this->select()
                ->from($this->_name)
                ->join($this->_packageDescription,
                    "{$this->_packageDescription}
                    .package_id = {$this->_name}.package_id")
                ->setIntegrityCheck(false)
                ->where("{$this->_packageDescription}.package_id = ?",
                    $package_id)
                ->where("{$this->_packageDescription}.language_id = ?",
                    $lang_id);
        
        $result = $this->fetchRow($data);

        return $result;
    }

    private function _getSortBy($sort = 'name',
        $sortOrder = 'DESC')
    {
        if ($sortOrder == '') {
            $sortOrder = 'DESC';
        }

        $sortBy = '';

        if($sort == 'name')
            $sortBy = "{$this->_packageDescription}.title";
        else
            $sortBy = "{$this->_packageDescription}.title";

        return $sortBy . ' ' . $sortOrder;
    }
}

?>
