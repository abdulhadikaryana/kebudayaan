<?php
/**
 * Zend_View_Helper_AreaType
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Zend_View_Helper_AreaType extends Zend_View_Helper_Abstract
{
    
	protected $table_area;
	
	public function __construct()
	{
		$this->table_area = new Model_DbTable_Area;
	}
	
	public function areaType($area_id) 
    {
    	return $this->table_area->getAreaTypeById($area_id);
    }
}