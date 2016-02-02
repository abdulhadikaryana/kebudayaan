<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

class Zend_View_Helper_CheckNewsIndo extends Zend_View_Helper_Abstract
{

    protected $newsdes;

    public function __construct()
    {
        $this->newsdes = new Model_DbTable_NewsDesc();
    }

    public function CheckNewsIndo($cat_id, $langId)
    {
        $desc = $this->newsdes->checkDescIndo($cat_id, $langId);
        if($desc){
            echo "Edit";
        }else
        {
            echo "Create";
        }
    }

}

?>
