<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Zend_View_Helper_CheckDestiIndo extends Zend_View_Helper_Abstract {

  protected $poides;

  public function __construct() {
    $this->poides = new Model_DbTable_DestinationDescription();
  }

  public function CheckDestiIndo($cat_id, $langId) {
    $desc = $this->poides->checkDescIndo($cat_id, $langId);
    return $desc;
  }

}

?>
