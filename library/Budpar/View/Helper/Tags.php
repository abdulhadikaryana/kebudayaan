<?php
/**
  Helper tags digunakan untuk memperoleh tag dari database
  yang di request dari viewer
  
  @author tajhul
 */
class Budpar_View_Helper_Tags extends Zend_View_Helper_Abstract 
{
    
    public function __construct() 
    {
    }
    
    public function tags($userstory_id,$lang_id,$url)
    {
        //request data ke Model_Usergeneratedcontent
        $getTag = new Model_Usergeneratedcontent();
        $tags = $getTag->detailTags($userstory_id,$lang_id,$url);

        return $tags;
    }

}