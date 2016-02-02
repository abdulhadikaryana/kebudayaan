<?php
/**
  Helper tags digunakan untuk memperoleh nama user contibutor dari database
  yang di request dari viewer
  
  @author tajhul
 */
class Budpar_View_Helper_UserContributor extends Zend_View_Helper_Abstract 
{
    
    public function __construct() 
    {
    }
    
    public function userContributor($id)
    {
        $dbUser = new Model_DbTable_UserStoryContributor();
        $user_contributor = $dbUser->getByContributorId($id);
        
        return $user_contributor['nama']; //return nama user contributor
    }

}