<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

class Zend_View_Helper_CheckMaterialIndoTrans extends Zend_View_Helper_Abstract
{

    protected $catdes;

    public function __construct()
    {
        $this->catdes = new Model_DbTable_MaterialDescription();
    }

    public function CheckMaterialIndoTrans($cat_id, $langId)
    {
        $desc = $this->catdes->checkDescIndo($cat_id, $langId);
        if($desc){
            return true;
        }else
        {
            return false;
        }
    }

}

?>
