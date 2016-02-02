<?php
/**
 * Zend_View_Helper_AreaChild
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Zend_View_Helper_AreaChild extends Zend_View_Helper_Abstract
{
    
	protected $table_area;
	
	public function __construct()
	{
		$this->table_area = new Model_DbTable_Area;
	}
	
	public function AreaChild($parent_id,$language_id = 1,$param = '') 
    {
    	$child_list = $this->table_area->getAllAreaChildIdNameByParent($parent_id,$param,$language_id);
        return $child_list;
    }
}