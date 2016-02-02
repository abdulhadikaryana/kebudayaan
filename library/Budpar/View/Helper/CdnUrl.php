<?php
/**
 * Budpar_View_Helper_CdnUrl
 *
 * Helper BaseUrl mengembalikan root URL
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Budpar_View_Helper_CdnUrl extends Zend_View_Helper_Abstract
{
    private $_base;

    public function __construct()
    {
        $this->_base = 'http://cdn.indonesia.travel';
        //$this->_base = 'http://indonesia.travel/public';
    }

    public function CdnUrl($str = '')
    {
        if ($str && strpos($str, '/') !== 0) $str = '/'.$str;
        return $this->_base.$str;
    }
}
