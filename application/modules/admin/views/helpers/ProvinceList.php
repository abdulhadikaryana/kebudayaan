<?php

/**
 * Zend_View_Helper_ProvinceList
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Zend_View_Helper_ProvinceList extends Zend_View_Helper_Abstract
{

    protected $table_area;
    
    public function __construct()
    {
        $this->table_area = new Model_DbTable_Area;
    }
    
    public function ProvinceList($area_id)
    {
        return $this->table_area->setChildAreaForSelectElement($area_id);
    }
}