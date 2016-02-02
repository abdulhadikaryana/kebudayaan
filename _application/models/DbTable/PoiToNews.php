<?php
/**
 * Model_DbTable_PoiToNews
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel poi to news
 *
 * @package DbTable Model
 */
class Model_DbTable_PoiToNews extends Zend_Db_Table_Abstract
{
    protected $_name = 'poitonews';
    protected $_poidesc = 'poidescription';

    /**
     * Fungsi untuk memasukkan data ke dalam tabel poitonews
     * @param data $input
     */
    public function insertPoiNews($input)
    {
        $this->insert($input);
    }

    /**
     * Fungsi untuk menghapus data dari tabel berdasarkan news_id dan poi_id
     * yang diberikan
     * @param integer $news_id
     * @param integer $poi_id
     */
    public function deletePoiNews($news_id,$poi_id)
    {
        $where = $this->getAdapter()->quoteInto('news_id = ?',$news_id).
        $this->getAdapter()->quoteInto(' AND poi_id = ?',$poi_id);
        $this->delete($where);
    }    

    public function deleteAllPoiNewsByNewsId($news_id)
    {
        $where = $this->getAdapter()->quoteInto('news_id = ?', $news_id);
        $this->delete($where);
    }
    
    public function deleteAllNewsByPoiId()
    {
        $where = $this->getAdapter()->quoteInto('poi_id = ?',$poi_id);
        $this->delete($where);
    }
    
    /**
     * Fungsi untuk mengambil data poi_id dan name berdasarkan news_id dan
     * language_id yang diberikan
     * @param integer $news_id
     * @param integer $language_id
     * @return array
     */
    public function getAllPoiByNewsId($news_id,$language_id = 1)
    {
        $select = $this->select()
                  ->setIntegrityCheck(FALSE)
                  ->from(array('pn' => $this->_name),array('poi_id'))
                  ->join(array('pd' => $this->_poidesc),'pn.poi_id = pd.poi_id',array('name'))
                  ->where('pd.language_id = ?',$language_id)
                  ->where('news_id = ?',$news_id);
        return $this->fetchAll($select)->toArray();
    }
    
    public function countPoiNewsByNewsId($news_id)
    {
        $select = $this->select()
                  ->from($this->_name,array('COUNT(news_id) as amount'))
                  ->where('news_id = ?',$news_id);
        $amount = $this->fetchRow($select)->toArray();
        return $amount['amount'];
    }
    
}