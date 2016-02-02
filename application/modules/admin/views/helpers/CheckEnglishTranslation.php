<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

class Zend_View_Helper_ChecEnglishTranslation extends Zend_View_Helper_Abstract
{

    protected $poides;

    public function __construct()
    {
        $this->poides = new Model_DbTable_DestinationDescription();
    }

    public function CheckEnglishTranslation($cat_id, $langId)
    {
        $desc = $this->poides->checkDescEnglish($cat_id, $langId);
        if($desc){
            return true;
        }else
        {
            return false;
        }
    }

}

?>
