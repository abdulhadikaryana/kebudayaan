<?php
/**
 * Model_DbTable_PoiToEvent
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel poi to event
 *
 * @package DbTable Model
 */
class Model_DbTable_PoiToEvent extends Zend_Db_Table_Abstract
{
    protected $_name = 'poitoevent';

    /**
     * Fungsi untuk melakukan insert pada tabel event
     * @return array
     */
    public function insertEvent($data)
    {
       $this->insert($data);
    }

    /**
     * Fungsi untuk melakukan delete semua event(sesuai event id) pada tabel event
     * @return array
     */
    public function deleteAllEvent($event_id)
    {
       $where = $this->getAdapter()->quoteInto('event_id = ?', $event_id);
       $this->delete($where);
    }

    /**
     * Fungsi untuk melakukan delete event dan poi id tertentu pada tabel event
     * @return array
     */
    public function deleteEvent($event_id,$poi_id)
    {
       $where = $this->getAdapter()->quoteInto('event_id = ?', $event_id).
                $this->getAdapter()->quoteInto(' AND poi_id = ?', $poi_id);
       $this->delete($where);
    }
    
    /**
     * Fungsi untuk melakukan delete semua event yang terhubung 
     * dengan sebuah destinasi pada tabel event
     * @return array
     */
    public function deleteAllEventByPoiId($poi_id)
    {
        $where = $this->getAdapter()->quoteInto('poi_id = ?',$poi_id);
        $this->delete($where);
    }
    
    /**
     * Fungsi untuk mengambil semua destination yang terhubung 
     * dengan sebuah event
     * @return array
     */
    public function getAllPoiNameByEventId($event_id,$language_id = 1)
    {
        $select = $this->select()
                  ->setIntegrityCheck(FALSE)
                  ->from(array('pte' => $this->_name),array())
                  ->join(array('pd' => 'poidescription'),'pd.poi_id = pte.poi_id',array('poi_id','name'))
                  ->where('pte.event_id = ?',$event_id)
                  ->where('pd.language_id = ?',$language_id);
        return $this->fetchAll($select);
    }
    /**
     * Fungsi untuk mendapatkan related event berdasarkan poi id
     * @return array
     */
    public function getRelatedEventByPoiId($poi_id, $language_id = 1)
    {
        $date = date("Y-m-d");
        $select = $this->select()
                ->setIntegrityCheck(FALSE)
                ->from(array('pte' => $this->_name),array())
                ->join(array('ed' => 'eventdesc'), 'ed.event_id = pte.event_id',array('event_id','name'))
                ->join(array('e' => 'event'), 'ed.event_id = e.event_id',array('date_end'))
                ->where('pte.poi_id = ?',$poi_id)
                ->where('ed.language_id = ?',$language_id)
                ->where("(date(e.date_end) > '" .$date. "')");
        return $this->fetchAll($select);
    }
    
    /**
     * Fungsi untuk menghitung jumlah destination yang terhubung 
     * dengan sebuah event
     * @return array
     */
    public function countRelatedPoiByEventId($event_id)
    {
        $select =  $this->select()
                   ->from($this->_name,array('COUNT(poi_id) AS amount'))
                   ->where('event_id = ?',$event_id);
        $amount = $this->fetchRow($select);
        return $amount['amount'];
    }
}