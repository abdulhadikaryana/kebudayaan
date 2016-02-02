<?php
/**
 * Helper ServerUrl mengembalikan server URL
 * tanpa karakter slash ('/') di akhir string
 */
class Zend_View_Helper_ServerUrl extends Zend_View_Helper_Abstract
{
    private $_base;

    public function __construct()
    {
        $this->_base = ROOT_URL;
    }

    /* bisa diappendkan otomatis */
    public function serverUrl($str = '')
    {
        if ($str && strpos($str, '/') !== 0) $str = '/'.$str;
        return $this->_base.$str;
    }
}