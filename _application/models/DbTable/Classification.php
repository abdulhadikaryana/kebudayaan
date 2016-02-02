<?php
/**
 * Model_DbTable_Classification
 *
 * Kelas Model untuk melakukan fungsi2 yang berkaitan dengan
 * tabel classification
 *
 * @package DbTable Model
 */
class Model_DbTable_Classification extends Zend_Db_Table_Abstract
{
     protected $_name = 'classificationdirectory';
     
     public function getAllClassification()
     {
        $select = $this->select()
                  ->from($this->_name,array('id' => 'classification_id', 'name'));
        $result = $this->fetchAll($select)->toArray();
        return $result;
     }
        
     public function getClassificationNameById($class_id)
     {
        $select = $this->select()
                  ->from($this->_name,array('name'))
                  ->where('classification_id = ?',$class_id);
        $result = $this->fetchRow($select)->toArray();
        return $result['name'];                
     }
     
     public function setClassificationForSelectElement()
     {
        $select = $this->select()
                  ->from($this->_name,array('classification_id','name'));
        $result = $this->fetchAll($select)->toArray();
        foreach($result as $class_value)
        {
            $option_value[$class_value['classification_id']] = $class_value['name']; 
        }
        return $option_value;
     }
}