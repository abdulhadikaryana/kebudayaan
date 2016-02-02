<?php
/**
 * Budpar_View_Helper_ImageUrl
 *
 * Helper untuk mengembalikan path ke folder images
 *
 * @package View Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Budpar_View_Helper_ImageUrl extends Zend_View_Helper_Abstract
{
    private $_base;

    /**
     * Constructor
     */
    public function __construct() 
    {
        $this->_base = ROOT_URL . Zend_Controller_Front::getInstance()->getBaseUrl() .
            '/media/images';
    }

    /**
     * Fungsi utama
     * 
     * @param string $str url tambahan
     * @return string
     */
    public function imageUrl($str = '')
    {
        if ($str && strpos($str, '/') !== 0) $str = '/'.$str;
        return $this->_base.$str;
    }
}