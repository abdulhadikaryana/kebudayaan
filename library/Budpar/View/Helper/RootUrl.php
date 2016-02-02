<?php
/**
 * Budpar_View_Helper_RootUrl
 *
 * Helper BaseUrl mengembalikan root URL
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Budpar_View_Helper_RootUrl extends Zend_View_Helper_Abstract
{
    private $_base;

    public function __construct()
    {
        $this->_base = ROOT_URL . Zend_Controller_Front::getInstance()->getBaseUrl();
    }

    public function rootUrl($str = '')
    {
        if ($str && strpos($str, '/') !== 0) $str = '/'.$str;
        return $this->_base.$str;
    }
}