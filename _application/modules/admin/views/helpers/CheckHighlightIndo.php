<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

class Zend_View_Helper_CheckHighlightIndo extends Zend_View_Helper_Abstract
{

    protected $highdes;

    public function __construct()
    {
        $this->highdes = new Model_DbTable_HighlightDescription();
    }

    public function CheckHighlightIndo($highId, $langId)
    {
        $desc = $this->highdes->checkDescIndo($highId);
        if($desc){
            echo "Edit";
        }else
        {
            echo "Create";
        }
    }

}

?>
