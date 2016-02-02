<?php
/**
 * Model_DbTable_PackageDescription
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel package description
 *
 * @package DbTable Model
 */
class Model_DbTable_PackageDescription extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'packagedescription';
    protected $_table = 'package';
    
    /**
     * Fungsi untuk melakukan insert pada tabel package description
     * @return array
     */
    public function insertPackage($input)
    {
        $this->insert($input);
    }

    public function checkForIndo($catId,$langId=2)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('package_id = ?', $catId)
                ->where('language_id = ?',$langId);
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
     * Fungsi untuk melakukan update pada tabel package description
     * @return array
     */
    public function updatePackage($input,$package_id,$language_id )
    {
        $where = $this->getAdapter()->quoteInto('package_id = ?',$package_id).
                 $this->getAdapter()->quoteInto(' AND language_id = ?',$language_id);
        $this->update($input, $where);
    }
    
    /**
     * Fungsi untuk melakukan delete pada tabel package description
     * @return array
     */
    public function deletePackage1($package_id)
    {
        $where = $this->getAdapter()->quoteInto('package_id = ?',$package_id);
        $this->delete($where);
    }

    public function deletePackage2($package_id, $language_id = 2)
    {
        $where = $this->getAdapter()->quoteInto('package_id = ?',$package_id).
                 $this->getAdapter()->quoteInto(' AND language_id = ?',$language_id);
        $this->delete($where);
    }
    
    /**
     * Fungsi untuk mengambil semua data dari tabel packagedescription
     * @return array
     */
    public function getAll()
    {
        $data = $this->select()
                ->from($this->_name);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel packagedescription berdasarkan
     * package_id yang diberikan
     * @param integer $package_id
     * @return array
     */
    public function getAllById($package_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('package_id = ?', $package_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel packagedescription KECUALI
     * yang mempunyai package_id seperti yang diberikan
     * @param integer $package_id
     * @return array
     */
    public function getAllExId($package_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('package_id != ?', $package_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel packagedescription berdasarkan
     * language_id yang diberikan
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
     * Fungsi untuk mengambil semua data dari tabel packagedescription berdasarkan
     * language_id dan package_id yang diberikan
     * @param integer $id
     * @param integer $lang_id
     * @return array
     */
    public function getAllByIdLang($id, $lang_id = 1)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('package_id = ?', $id)
                ->where('language_id = ?', $lang_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data title yang mempunyai language_id = 1
     * @param integer $lang
     * @return array
     */
    public function getAllTitle($lang = 1)
    {
        $data = $this->select()
                ->from($this->_name,array('title'))
                ->where('language_id = ?', $lang);
        return $this->fetchAll($data);
    }

    /**
     * ADDED BY BEMBY (2010-05-22)
     * Fungsi untuk mengambil data title dari tabel packageDescription
     * berdasarkan package_id dan language_id yang diberikan
     * @param integer $package_id
     * @param integer $lang_id
     * @return array
     */
    public function getTitleById($package_id, $lang_id = 1)
    {
        $data = $this->select()
                ->from($this->_name, array('title'))
                ->where('package_id = ?', $package_id)
                ->where('language_id = ?', $lang_id);

        $result = $this->fetchRow($data);

        return $result['title'];
    }

    public function checkDescIndo($highId)
    {
        $query = $this->select()
                ->from($this->_name,array('description'))
                ->where('language_id = 2')
                ->where('package_id = ?',$highId);
        $result = $this->fetchRow($query);

        $query2 = $this->select()
                ->from($this->_name,array('COUNT(language_id) AS count'))
                ->where('package_id = ?',$highId);
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
