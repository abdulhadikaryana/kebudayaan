<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

class Zend_View_Helper_CheckRelatedIndo extends Zend_View_Helper_Abstract
{

    protected $reldes;

    public function __construct()
    {
        $this->reldes = new Model_DbTable_RelatedDescription();
    }

    public function CheckRelatedIndo($id, $langId)
    {
        $desc = $this->reldes->checkDescIndo($id, $langId);
        if($desc){
            echo "Edit";
        }else
        {
            echo "Create";
        }
    }

}

?>
