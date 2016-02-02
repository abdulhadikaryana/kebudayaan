<?php
/**
 * Zend_View_Helper_PoiName
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Zend_View_Helper_PoiName extends Zend_View_Helper_Abstract
{
    
	protected $table_destination;
	
	public function __construct()
	{
		$this->table_destination = new Model_DbTable_DestinationDescription;
	}
	
	public function poiName($poi_id) 
    {
    	$name = $this->table_destination->getPoiNameByIdLangId($poi_id,1);
        return $name;
    }
}