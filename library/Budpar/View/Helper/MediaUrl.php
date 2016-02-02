<?php
/**
 * Helper MediaUrl mengembalikan base URL ditambah path ke directory file2 gambar dan atau flash
 * tanpa karakter slash ('/') di akhir string
 */
class Budpar_View_Helper_MediaUrl extends Zend_View_Helper_Abstract 
{
    private $_base;
    
    public function __construct() 
    {
        $this->_base = Zend_Controller_Front::getInstance()->getBaseUrl().'/media';
    }
    
    /* bisa diappendkan otomatis */
    public function mediaUrl($str = '') 
    {
        if ($str && strpos($str, '/') !== 0) $str = '/'.$str;
        return $this->_base.$str;
    }
}