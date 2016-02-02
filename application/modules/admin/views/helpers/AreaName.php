<?php
/**
 * Zend_View_Helper_AreaName
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Zend_View_Helper_AreaName extends Zend_View_Helper_Abstract
{
    
	protected $table_area;
	
	public function __construct()
	{
		$this->table_area = new Model_DbTable_Area;
	}
	
	public function areaName($area_id) 
    {
    	$name = $this->table_area->getNameById($area_id);
        return $name['name'];
    }
}