<?php
/**
 * Zend_View_Helper_CurrentUrl
 *
 * Helper BaseUrl mengembalikan Current URL
 * Digunakan sebagai 'action' pada form yang memanggil diri sendiri
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Budpar_View_Helper_CurrentUrl extends Zend_View_Helper_Abstract
{
    public function currentUrl() 
    {
	 $pageURL = 'http';
         if(isset($_SERVER["HTTPS"]))
         {
    		 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
         }
		 $pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 return $pageURL;    
    }
}