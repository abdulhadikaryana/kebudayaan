<?php
/**
 * Budpar_View_Helper_BaseUrl
 *
 * Helper BaseUrl mengembalikan base URL
 * tanpa karakter slash ('/') di akhir string
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Budpar_View_Helper_BaseUrl extends Zend_View_Helper_Abstract
{
    private $_base;
    
    public function __construct() 
    {
        $language = (Zend_Registry::isRegistered('language')) ?
            Zend_Registry::get('language') : '';

        $this->_base = ROOT_URL . Zend_Controller_Front::getInstance()->getBaseUrl() .
            '/' . $language;
    }
    
    public function baseUrl($str = '') 
    {
        if ($str && strpos($str, '/') !== 0) $str = '/'.$str;
        return $this->_base.$str;
    }
}