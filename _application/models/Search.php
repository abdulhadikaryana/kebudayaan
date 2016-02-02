<?php
/**
 * Model_Search
 *
 * Model untuk melakukan fungsi2 yang berkaitan dengan
 * category
 *
 * @package Model
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Model_Search extends Zend_Db_Table_Abstract
{

    //public function __construct()
    //{
    //    parent::__construct();
    //}
    
    public function test()
    {
        $query = $this->select()
                    ->from('news');
        
        //return $this->fet;        
        //return $this->fetchAll($query);        
        
        
        //return $param .' dari model ';
    }



}
?>
