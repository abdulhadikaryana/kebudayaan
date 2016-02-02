<?php

/**
 * Model_DbTable_RelatedPoi
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel related poi
 *
 * @package DbTable Model
 */
class Model_DbTable_RelatedPoi extends Zend_Db_Table_Abstract
{
  protected $_name = 'relatedpoi';

  public function insertRelatedPoi($input)
  {
    $this->insert($input);
  }

  public function deleteRelatedPoiByPoiId($poi_id)
  {
    $where = $this->getAdapter()->quoteInto('poi_id = ?', $poi_id);
    $this->delete($where);
  }

  public function deleteSpecificRelatedPoi($poi_id, $related_id)
  {
    $where = $this->getAdapter()->quoteInto('poi_id = ?', $poi_id) .
            $this->getAdapter()->quoteInto(' AND related_poi = ?', $related_id);
    $this->delete($where);
  }

  public function getAllRelatedByPoiIdLangId($poi_id, $language_id = 1, $related = FALSE)
  {
    $select = $this->select()
            ->setIntegrityCheck(FALSE)
            ->from(array('rp' => $this->_name), array('related_poi'))
            ->join(array('pd' => 'poidescription'), 'pd.poi_id = rp.related_poi', array('name'))
            ->join(array('poi' => 'poi'), 'poi.poi_id = rp.related_poi')
            ->where('rp.poi_id = ?', $poi_id)
            ->where('pd.language_id = ?', $language_id);
    if ($related) {
      $select->order('RAND()');
      $select->limit(5);
    }

    return $this->fetchAll($select);
  }

}