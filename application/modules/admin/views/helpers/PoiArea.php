<?php
/**
 * Zend_View_Helper_PoiArea
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Zend_View_Helper_PoiArea extends Zend_View_Helper_Abstract
{
    
	protected $table_area;
	
	public function __construct()
	{
		$this->table_area = new Model_DbTable_Area;
	}
	
	public function PoiArea($poi_id, $langId = 1)
        {
    	return $this->table_area->getAllAreaByPoiId($poi_id, $langId);
        }
}