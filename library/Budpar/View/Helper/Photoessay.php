<?php
/**
  Budpar_View_Helper_Photoessay
  digunakan untuk query image dari tabel photo_essay image
  @param = userstory_id
  pencarian
  
  @author tajhul
 */
class Budpar_View_Helper_Photoessay extends Zend_View_Helper_Abstract 
{
    
    public function __construct() 
    {
    }
    
    public function Photoessay($userstory_id,$lang_id)
    {
        $db = new Model_DbTable_UserStoryPhotoessay();
        $img = $db->getByUserstory($userstory_id,$lang_id);
        
        return $img;
    }



}