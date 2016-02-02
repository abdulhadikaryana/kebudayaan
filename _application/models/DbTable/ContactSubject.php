<?php
/**
 * Model_DbTable_ContactSubject
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel contact subject
 *
 * @package DbTable Model
 */
class Model_DbTable_ContactSubject extends Zend_Db_Table_Abstract
{
    //put your code here
    protected $_name ='contactsubject';
    protected $_primary = 'contactSubjectId';

    
    public function getAllForForm($languageId = 1)
    {
        $query = $this->select()
                ->from($this->_name)
                ->where('language_id = ?', $languageId);
        $report = $this->fetchAll($query);
        $langId = Zend_Registry::get('languageId');
        if($langId == 2){ // english
            $textsel = '-- Choose Related Subject --';
        }else{
            $textsel = '-- Pilih Subyek yang Berkaitan --';
        }
        $value[''] = $textsel;
        foreach ($report as $tempData)
        {

            $value[$tempData['contactSubjectId']] = $tempData['name'];
        }
        return $value;
    }

    /**
     * Fungsi untuk mendapatkan subject name berdasarkan ID
     *
     * @param integer $contactSubjectId
     * @return string nama subject
     */
    public function getNameById($contactSubjectId, $langId = 1)
    {
        $query = $this->select()
                ->from($this->_name, array('name'))
                ->where('contactSubjectId = ?', $contactSubjectId)
                ->where('language_id = ?',$langId);

        $data = $this->fetchRow($query);

        return $data['name'];
    }

}
?>
