<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

class Zend_View_Helper_CheckRegionalIndo extends Zend_View_Helper_Abstract
{

    protected $catdes;

    public function __construct()
    {
        $this->catdes = new Model_DbTable_Regional();
    }

    public function CheckRegionalIndo($cat_id, $langId)
    {
        $desc = $this->catdes->checkDescIndo($cat_id, $langId);
//        if($desc){
//            echo "Edit";
//        }else
//        {
//            echo "Create";
//        }
        return $desc;
    }

}

?>
