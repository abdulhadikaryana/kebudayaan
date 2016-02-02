<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

class Zend_View_Helper_CheckPackageIndoTrans extends Zend_View_Helper_Abstract
{

    protected $highdes;

    public function __construct()
    {
        $this->highdes = new Model_DbTable_PackageDescription();
    }

    public function CheckPackageIndoTrans($highId, $langId)
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
