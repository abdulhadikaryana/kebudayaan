<?php
/**
 * Model_DbTable_Regional
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel regional
 *
 * @package DbTable Model
 */
class Model_DbTable_Regional extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'regionalinformation';

    /**
     * Fungsi  untuk melakukan insert pada tabel regional information
     */
    public function insertArea($input)
    {
        $this->insert($input);
        return $this->_db->lastInsertId();        
    }

    public function checkForIndo($catId,$langId = 2)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('area_id = ?', $catId)
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
     * Fungsi  untuk melakukan update pada tabel regional information
     */
    public function updateArea($area_id,$input,$language_id)
    {
        $where = $this->getAdapter()->quoteInto('area_id = ?',$area_id).
                 $this->getAdapter()->quoteInto(' AND language_id = ?', $language_id);
        $this->update($input, $where);
    }
    
    /**
     * Fungsi  untuk melakukan delete pada tabel regional information
     */
    public function deleteArea($area_id)
    {
        $where = $this->getAdapter()->quoteInto('area_id = ?', $area_id);
        $this->delete($where);        
    }

    public function deleteArea2($area_id, $language_id = 2)
    {
        $where = $this->getAdapter()->quoteInto('area_id = ?', $area_id).
                 $this->getAdapter()->quoteInto(' AND language_id = ?', $language_id);
        $this->delete($where);
    }
    
    /**
     * Fungsi  untuk mengambil semua data dari tabel regionalinformation
     * @return array
     */
    public function getAll()
    {
        $data = $this->select()
                ->from($this->_name);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel regionalinformation berdasarkan
     * area_id yang diberikan
     * @param integer $area_id
     * @return array
     */
    public function getAllById($area_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('area_id = ?', $area_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel regionalinformation KECUALI
     * yang mempunyai area_id seperti yang diberikan
     * 
     * @param integer $area_id
     * @return array
     */
    public function getAllExId($area_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('area_id != ?', $area_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel regionalinformation berdasarkan
     * language_id yang diberikan
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
     * Fungsi untuk mengambil semua data dari tabel regionalinformation
     * berdasarkan area_id dan language_id yang diberikan
     * 
     * @param integer $area_id
     * @param integer $lang_id
     * @return array
     */
    public function getAllByIdLang($area_id, $lang_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('area_id = ?', $area_id)
                ->where('language_id = ?', $lang_id);
        return $this->fetchRow($data);
    }

    /**
     * Fungsi untuk mengambil semua data area_id,language_id, area_name,
     * regional_descripition
     * @return array
     */
    public function getAllIdLangNameDescription()
    {
        $data = $this->select()
                ->from($this->_name,array('area_id','language_id','area_name',
                                          'regional_description'));
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel regionalinformation berdasarkan
     * area_name yang diberikan
     * 
     * @param string $area_name
     * @return array
     */
    public function getAllByName($area_name)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where("area_name LIKE '%" . $area_name . "%'");
        return $this->fetchAll($data);  
    }

    /**
     * Fungsi untuk mengambil semua data name dari tabel regionalinformation
     * yang mempunyai language_id = 1
     * @return array
     */
    public function getAllNameByLang()
    {
        $data = $this->select()
                ->from($this->_name,array('name'))
                ->where('language_id = 1');
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil data history dari tabel regionalinformation
     * berdasarkan area_id dan language_id yang diberikan
     * 
     * @param integer $area_id
     * @param integer $lang_id
     * @return array
     */
    public function getHistoryByIdLang($area_id, $lang_id)
    {
        $data = $this->select()
                ->from($this->_name,array('history'))
                ->where('area_id = ?', $area_id)
                ->where('language_id = ?', $lang_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil data regional_description dari tabel
     * regionalinformation berdasarkan area_id dan language_id yang diberikan
     *
     * @param integer $area_id
     * @param integer $lang_id
     * @return array
     */
    public function getDescriptionByIdLang($area_id, $lang_id)
    {
        $data = $this->select()
                ->from($this->_name,array('regional_description'))
                ->where('area_id = ?', $area_id)
                ->where('language_id = ?', $lang_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil data people_and_custom dari tabel regionalinformation
     * berdasarkan area_id dan language_id yang diberikan
     *
     * @param integer $area_id
     * @param integer $lang_id
     * @return array
     */
    public function getPeopleByIdLang($area_id, $lang_id)
    {
        $data = $this->select()
                ->from($this->_name,array('people_and_custom'))
                ->where('area_id = ?', $area_id)
                ->where('language_id = ?', $lang_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil data entry dari tabel regionalinformation
     * berdasarkan area_id dan language_id yang diberikan
     *
     * @param integer $area_id
     * @param integer $lang_id
     * @return array
     */
    public function getEntryByIdLang($area_id, $lang_id)
    {
        $data = $this->select()
                ->from($this->_name,array('entry'))
                ->where('area_id = ?', $area_id)
                ->where('language_id = ?', $lang_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil data cuisine dari tabel regionalinformation
     * berdasarkan area_id dan language_id yang diberikan
     *
     * @param integer $area_id
     * @param integer $lang_id
     * @return array
     */
    public function getCuisineByIdLang($area_id, $lang_id)
    {
        $data = $this->select()
                ->from($this->_name,array('cuisine'))
                ->where('area_id = ?', $area_id)
                ->where('language_id = ?', $lang_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil data tourism_office dari tabel regionalinformation
     * berdasarkan area_id dan language_id yang diberikan
     *
     * @param integer $area_id
     * @param integer $lang_id
     * @return array
     */
    public function getTourismOfficeByIdLang($area_id, $lang_id)
    {
        $data = $this->select()
                ->from($this->_name,array('tourism_office'))
                ->where('area_id = ?', $area_id)
                ->where('language_id = ?', $lang_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    public function checkDescIndo($catId,$langId=2)
    {
        $query = $this->select()
                ->from($this->_name,array('regional_description'))
                ->where('language_id = ?',$langId)
                ->where('area_id = ?',$catId);
        $result = $this->fetchRow($query);

        $query2 = $this->select()
                ->from($this->_name,array('COUNT(language_id) AS count'))
                ->where('area_id = ?',$catId);
        $result2 = $this->fetchRow($query2);

        if($result2['count'] > '1')
        {
            if($result['regional_description']==' ')
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
