<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

class Zend_View_Helper_CheckIndoTranslation extends Zend_View_Helper_Abstract
{

    protected $poides;

    public function __construct()
    {
        $this->poides = new Model_DbTable_DestinationDescription();
    }

    public function CheckIndoTranslation($cat_id, $langId)
    {
        $desc = $this->poides->checkDescIndo($cat_id, $langId);
        if($desc){
            return true;
        }else
        {
            return false;
        }
    }

}

?>
