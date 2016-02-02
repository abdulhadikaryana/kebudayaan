<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

class Zend_View_Helper_CheckNewsIndoTrans extends Zend_View_Helper_Abstract
{

    protected $newsdes;

    public function __construct()
    {
        $this->newsdes = new Model_DbTable_NewsDesc();
    }

    public function CheckNewsIndoTrans($cat_id, $langId)
    {
        $desc = $this->newsdes->checkDescIndo($cat_id, $langId);
        if($desc){
            return true;
        }else
        {
            return false;
        }
    }

}

?>
