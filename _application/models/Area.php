<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Area
 *
 * @author BackpackerMania
 */
class Model_Area {
    //put your code here
    private $_languageId;

    /**
     * Constructor
     */
    function __Construct()
    {
        $this->_languageId = Zend_Registry::get('languageId');
    }

    private function getMainAreaContentForSelectForm()
    {
        $areaDb = new Model_DbTable_Area;
        $areasearch = $areaDb->getAreaNameByParentLanguage(0, $this->_languageId);

        $areainput = array("" => "--Choose Island--");
        foreach ($areasearch as $row) {
            $areainput[$row['area_id']] = $row['area_name'];
        }

        return $areainput;
    }

}
?>
