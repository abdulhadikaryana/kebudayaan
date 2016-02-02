<?php
/**
 * Budpar_View_Helper_MiceUrl
 *
 * Helper MiceUrl mengembalikan base URL untuk sub situs Mice
 * tanpa karakter slash ('/') di akhir string
 *
 * @package Helper
 * @copyright Copyright (c) 2011 Sangkuriang International
 * @author Sangkuriang Studio <www.sangkuriang.co.id>
 *
 */
class Budpar_View_Helper_MiceUrl extends Zend_View_Helper_Abstract
{
    private $_base;
    
    public function __construct() 
    {
        $language = (Zend_Registry::isRegistered('language')) ?
            Zend_Registry::get('language') : '';

        $this->_base = ROOT_URL . Zend_Controller_Front::getInstance()->getBaseUrl() .
            '/mice/' . $language;
    }
    
    public function miceUrl($str = '') 
    {
        if ($str && strpos($str, '/') !== 0) $str = '/'.$str;
        return $this->_base.$str;
    }
}