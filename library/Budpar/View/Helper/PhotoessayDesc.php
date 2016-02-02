<?php
/**
  Helper Category digunakan untuk memperoleh deskripsi photoessay image
  yang di request dari viewer
  
 */
class Budpar_View_Helper_PhotoessayDesc extends Zend_View_Helper_Abstract 
{
    
    public function __construct() 
    {
    }
    
    public function PhotoessayDesc($image_id,$lang_id)
    {
        $db = new Model_DbTable_UserStoryPhotoessaydesc();
        $image = $db->getByImgIdLangId($image_id,$lang_id);

        return $image['description'];
    }

}