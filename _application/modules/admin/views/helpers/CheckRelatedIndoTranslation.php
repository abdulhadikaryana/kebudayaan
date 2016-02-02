<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

class Zend_View_Helper_CheckRelatedIndoTranslation extends Zend_View_Helper_Abstract
{

    protected $reldes;

    public function __construct()
    {
        $this->reldes = new Model_DbTable_RelatedDescription();
    }

    public function CheckRelatedIndoTranslation($cat_id, $langId)
    {
        $desc = $this->reldes->checkDescIndo($cat_id, $langId);
        if($desc){
           return true;
        }else
        {
           return false;
        }
    }

}

?>
