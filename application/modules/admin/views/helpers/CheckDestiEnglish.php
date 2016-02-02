<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

class Zend_View_Helper_CheckDestiEnglish extends Zend_View_Helper_Abstract
{

    protected $poides;

    public function __construct()
    {
        $this->poides = new Model_DbTable_DestinationDescription();
    }

    public function CheckDestiEnglish($cat_id, $langId)
    {
        $desc = $this->poides->checkDescEnglish($cat_id, $langId);
        if($desc){
            echo "Edit";
        }else
        {
            echo "Create";
        }
    }

}

?>
