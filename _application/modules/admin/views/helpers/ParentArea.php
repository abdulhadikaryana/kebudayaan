<?php

/**
 * Zend_View_Helper_ParentArea
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Zend_View_Helper_ParentArea extends Zend_View_Helper_Abstract
{

    protected $table_category;
    
    public function __construct()
    {
        $this->table_area = new Model_DbTable_Area;
    }
    
    public function ParentArea($area_id)
    {
        return $this->table_area->getParentIdByAreaId($area_id);
    }
}