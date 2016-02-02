<?php
/**
 * Zend_View_Helper_ClassificationList
 * Input : tourism operator id
 * Output : related tourism operator name
 * 
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Zend_View_Helper_ClassificationList extends Zend_View_Helper_Abstract
{
    
	protected $table_classtotourism;
	protected $table_classification;
    
	public function __construct()
	{
		$this->table_classtotourism = new Model_DbTable_ClassificationToTourismOperator;
        $this->table_classification = new Model_DbTable_Classification;
        
	}
	
	public function ClassificationList($tourism_id)
    {
        $list = $this->table_classtotourism->getAllClassByTourismId($tourism_id);
        /*convert to a non assoc. array*/
        $classification_id = array();
        foreach($list as $class_id)
        {
            $class_name = $this->table_classification->getClassificationNameById($class_id['class']);
            array_push($classification_id,$class_name);           
        }
        return $classification_id;
    }
}