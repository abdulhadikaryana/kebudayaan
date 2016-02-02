<?php
/**
 * Model_DbTable_EventDesc
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel event description
 *
 * @package DbTable Model
 */
class Model_DbTable_EventDesc extends Zend_Db_Table_Abstract
{

//deklarasi untuk table yang digunakan dalam model eventdesc
    protected $_name = 'eventdesc';
    protected $_event = 'event';
    protected $_primary = array('event_id', 'language_id');

    /**
     * Fungsi untuk melakukan insert pada tabel event
     * @return array
     */
    public function insertEvent($data)
    {
       $this->insert($data);
    }

    /**
     * Fungsi untuk melakukan update pada tabel event
     * @return array
     */
    public function updateEvent($data,$event_id,$language_id = 1)
    {
       $where = $this->getAdapter()->quoteInto('event_id = ?', $event_id).$this->getAdapter()->quoteInto(' AND language_id = ?', $language_id);
       $this->update($data,$where);
    }

    public function checkForIndo($catId,$language_id = 2)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('event_id = ?', $catId)
                ->where('language_id = ?',$language_id);
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
     * Fungsi untuk melakukan delete pada tabel event
     * @return array
     */
    public function deleteEvent($event_id)
    {
       $where = $this->getAdapter()->quoteInto('event_id = ?', $event_id);
       $this->delete($where);
    }

    public function deleteEvent2($event_id, $language_id = 2 )
    {
       $where = $this->getAdapter()->quoteInto('event_id = ?', $event_id).
                $this->getAdapter()->quoteInto(' AND language_id = ?', $language_id);
       $this->delete($where);
    }


    /**
     * Fungsi untuk mengambil semua data dari tabel eventdesc
     * @return array
     */
    public function getAll()
    {
        $data = $this->select()
                ->from($this->_name);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel eventdesc berdasarkan event_id
     * yang diberikan
     *
     * @param integer $event_id
     * @return array
     */
    public function getAllById($event_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('event_id = ?', $event_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel
     * @param integer $event_id
     * @return array
     */
    public function getAllExId($event_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('event_id != ?', $event_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel eventdesc KECUALI yang mempunyai
     * event_id sesuai yang diberikan
     *
     * @param integer $event_id
     * @param integer $lang_id
     * @return array
     */
    public function getAllByIdLang($event_id, $lang_id)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where('event_id = ?', $event_id)
                ->where('language_id = ?', $lang_id);
        return $this->fetchAll($data);
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel eventdesc berdasarkan language_id
     * yang diberikan
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
     * Fungsi untuk mengambil data name dari tabel poi berdasarkan poi_id yang
     * diberikan
     *
     * @param integer $poiId
     * @return array
     */
    public function getNameById($eventId,$languageId)
    {
        $data = $this->select()
                ->from($this->_name, array('name'))
                ->where('event_id = ?', $eventId)
                ->where('language_id = ?', $languageId);

        $result = $this->fetchRow($data);

        return $result['name'];
    }

    /**
     * Fungsi untuk mengambil data description dari tabel eventdesc berdasarkan
     * event_id yang diberikan
     *
     * @param integer $event_id
     * @return array
     */
    public function getDescriptionById($event_id)
    {
        $data = $this->select()
                ->from($this->_name, array('description'))
                ->where('event_id = ?', $event_id);
        $return = $this->fetchRow($data);
        return $return;
    }

    /**
     * Fungsi untuk mengambil semua data dari tabel eventdesc berdasarkan name
     * yang diberikan
     *
     * @param string $name
     * @return array
     */
    public function getAllByName($name)
    {
        $data = $this->select()
                ->from($this->_name)
                ->where("name LIKE '%" . $name . "%'");
        return $this->fetchAll($data);
    }

    public function getEventsInDay($startDate, $endDate, $languageId)
    {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name, array('event_id', 'name', 'description'))
                ->join($this->_event,
                        "{$this->_event}.event_id = {$this->_name}.event_id",
                        array('main_pics', 'date_start', 'date_end', 'category'))
                ->where("{$this->_name}.language_id = ?", $languageId)
                ->where("{$this->_event}.date_start <= ?", $startDate)
                ->where("{$this->_event}.date_end >= ?", $endDate)
                ->order("{$this->_event}.date_start DESC");

        return $this->fetchAll($query);
    }

    /**
     * Fungsi untuk mengambil data event_id , name, description dari tabel
     * eventdesc, serta main_pics, date_start, date_end, dan category dari tabel
     * event berdasarkan kondisi yang diperlukan
     * 
     * @param date $startDate
     * @param date $endDate
     * @param integer $langId
     * @return array
     */
    public function getEvent($startDate, $endDate, $langId)
    {

        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name, array('event_id', 'name', 'description'))
                ->join($this->_event,
                        "{$this->_event}.event_id = {$this->_name}.event_id",
                        array('main_pics', 'date_start', 'date_end', 'category'))
                ->where("{$this->_name}.language_id = ?", $langId)
                ->order("{$this->_event}.date_start DESC");
        if ($startDate == $endDate)
        {
            $query->where("? BETWEEN {$this->_event}.date_start AND {$this->_event}.date_end ", $startDate);
        } else
        {
            $query->where("{$this->_event}.date_start BETWEEN ? AND ?", $startDate, $endDate);
        }
        return $this->fetchAll($query);
    }
    
    /**
     * Fungsi untuk mengambil report dari sebuah event berdasarkan event id
     * @param integer $langId
     * @param integer $event_id
     * @return array
     */
    public function getEventReport($event_id,$language_id)
    {
        $select = $this->select()
                  ->from($this->_name,array('report'))
                  ->where('language_id = ?',$language_id)
                  ->where('event_id = ?',$event_id);
        return $this->fetchRow($select);
    }
    
    /**
     * Fungsi untuk mengambil data event berdasarkan start_date dan language_id
     * yang diperlukan
     * 
     * @param integer $langId
     * @param date $startDate
     * @return array
     */
    public function getEventByStartDate($startDate, $langId, $sortingOptions = null)
    {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name)
                ->join($this->_event,
                        "{$this->_event}.event_id = {$this->_name}.event_id")
                ->where("{$this->_name}.language_id = ?", $langId)
                ->where("(? BETWEEN {$this->_event}.date_start AND {$this->_event}.date_end ", $startDate)
                ->orWhere("{$this->_event}.date_start > ?)", $startDate)
                ->order("{$this->_event}.date_start ASC");

        $result = $this->fetchAll($query);
        if(count($result)>0)
        {
            $lowest_date = $result[0]['date_start'];
            $sql = $this->select()
                    ->setIntegrityCheck(false)
                    ->from($this->_event,array('event_id','date_start','date_end','main_pics','category'))
                    ->join($this->_name,
                            "{$this->_event}.event_id = {$this->_name}.event_id",
                            array('name','description','report'))
                    ->order("{$this->_event}.date_start ASC")
					->where("{$this->_name}.language_id = ?", $langId)
                    ->where("{$this->_event}.date_start >= ?", $lowest_date);

            $sortBy = $this->_getSortBy($sortingOptions['sort_by'],
                                    $sortingOptions['sort_order']);

            $query->order($sortBy);

            return $this->fetchAll($sql);
        }else
        {
            return array();
        }

    }

    /**
     * Fungsi untuk mendukung sorting
     *
     * @param string $sort field sorting
     * @param string $sortOrder urutan sorting
     *
     * @return string gabungan antara $sort dan $sortOrder
     */
    private function _getSortBy($sort = 'name',
        $sortOrder = 'DESC')
    {
        if ($sortOrder == '') {
            $sortOrder = 'DESC';
        }

        $sortBy = '';

        if($sort == 'name')
            $sortBy = "{$this->_td}.name";
        else
            $sortBy = "{$this->_td}.name";

        return $sortBy . ' ' . $sortOrder;
    }


    public function checkDescIndo($eventId)
    {
        $query = $this->select()
                ->from($this->_name,array('description'))
                ->where('language_id = 2')
                ->where('event_id = ?',$eventId);
        $result = $this->fetchRow($query);

        $query2 = $this->select()
                ->from($this->_name,array('COUNT(language_id) AS count'))
                ->where('event_id = ?',$eventId);
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


    //get eventdesc by id
    public function getEvenDesctById($event_id)
    {
        $query = $this->select()
                ->from($this->_name,array('event_id','language_id','name','description','report'))
                ->where("{$this->_name}.event_id = ?",$event_id)
                //->distinct('event_id');
                ->group('event_id');

        $result = $this->fetchAll($query);
        if(count($result))
        {
            //$event = '';
            //foreach($result as $row)
            //{
            //   $event .= $row->name .'<br />';
            //}
            
            return $result;
        }
        else
        {
            return NULL;
        }        
    }

    //get eventdesc by id
    public function getEvenName($event_id,$lang_id)
    {
        $query = $this->select()
                ->from($this->_name,array('event_id','language_id','name'))
                ->where("{$this->_name}.event_id = ?",$event_id)
                ->where("{$this->_name}.language_id = ?",$lang_id);
                //->group('event_id');
    
        $result = $this->fetchRow($query);
        if(count($result))
        {
            return $result;
        }
        else
        {
            return NULL;
        }        
    }

}

?>