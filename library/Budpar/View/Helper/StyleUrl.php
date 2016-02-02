<?php
/**
 * Helper ScriptUrl mengembalikan base URL ditambah path ke directory script
 * tanpa karakter slash ('/') di akhir string
 */
class Budpar_View_Helper_StyleUrl extends Zend_View_Helper_Abstract 
{
    private $_base;
    
    public function __construct() 
    {
        $this->_base = ROOT_URL . Zend_Controller_Front::getInstance()->getBaseUrl().'/scripts';
    }
    
    /* bisa diappendkan otomatis */
    public function scriptUrl($str = '') 
    {
        if ($str && strpos($str, '/') !== 0) $str = '/'.$str;
        return $this->_base.$str;
    }
}