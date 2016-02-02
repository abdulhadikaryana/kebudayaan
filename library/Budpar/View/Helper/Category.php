<?php
/**
  Helper Category digunakan untuk memperoleh Category dari database
  yang di request dari viewer
  
  @author tajhul
 */
class Budpar_View_Helper_Category extends Zend_View_Helper_Abstract 
{
    
    public function __construct() 
    {
    }
    
    public function Category($userstory_id,$lang_id,$url,$content_category)
    {
        //request data ke Model_Usergeneratedcontent
        $getTag = new Model_Usergeneratedcontent();
        $Category = $getTag->detailCategory($userstory_id,$lang_id,$url,$content_category);
        
        return $Category;
    }

}