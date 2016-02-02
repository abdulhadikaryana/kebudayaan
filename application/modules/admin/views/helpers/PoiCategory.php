<?php

/**
 * Zend_View_Helper_PoiCategory
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Zend_View_Helper_PoiCategory extends Zend_View_Helper_Abstract
{

    protected $table_category;
    
    public function __construct()
    {
        $this->table_category = new Model_DbTable_CategoryToPoi;
    }
    
    public function PoiCategory($poi_id, $language_id)
    {
        return $this->table_category->getCategoryByPoiId($poi_id, $language_id);
    }
}