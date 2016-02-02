<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

class Zend_View_Helper_CheckHighlightIndoTrans extends Zend_View_Helper_Abstract
{

    protected $highdes;

    public function __construct()
    {
        $this->highdes = new Model_DbTable_HighlightDescription();
    }

    public function CheckHighlightIndoTrans($highId, $langId)
    {
        $desc = $this->highdes->checkDescIndo($highId);
        if($desc){
           return true;
        }else
        {
           return false;
        }
    }

}

?>
