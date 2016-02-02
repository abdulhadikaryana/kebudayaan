<?php
/**
  Helper TagDetails digunakan untuk memperoleh tag dari database
  yang di request dari viewer
  
  @author tajhul
 */
class Budpar_View_Helper_TagDetails extends Zend_View_Helper_Abstract 
{
    
    public function __construct() 
    {
    }
    
    public function tagDetails($userstory_id,$lang_id,$url)
    {
        //request data ke Model_Usergeneratedcontent
        $model = new Model_Usergeneratedcontent();
        $tag = $model->tagLinkUsercontributorDetail($userstory_id,$lang_id,$url);
        
        return $tag;
    }

}