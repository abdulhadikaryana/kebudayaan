<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

class Zend_View_Helper_CheckEventIndoTrans extends Zend_View_Helper_Abstract
{

    protected $evntdes;

    public function __construct()
    {
        $this->evntdes = new Model_DbTable_EventDesc();
    }

    public function CheckEventIndoTrans($cat_id, $langId)
    {
        $desc = $this->evntdes->checkDescIndo($cat_id, $langId);
        if($desc){
            return true;
        }else
        {
            return false;
        }
    }

}

?>
