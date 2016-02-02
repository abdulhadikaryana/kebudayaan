<?php
/**
 * Budpar_View_Helper_Breadcrumb
 *
 * Helper untuk membuat breadcrumb dengan menggunakan Zend_Registry untuk
 * menyimpan data link dan url-nya. Format data yang digunakan
 * array(
 *   [Nama_Link_1] => 'Full_Url_link_1',
 *   [Nama_Link_2] => 'Fill_Url_link_2',
 *   ...
 * )
 */
class Budpar_View_Helper_Breadcrumb extends Zend_View_Helper_Abstract
{
    private $links = null;
    
    /**
     * Constructor
     */
    public function __construct() 
    {
        $this->links = (Zend_Registry::isRegistered('breadcrumb')) ?
            Zend_Registry::get('breadcrumb') : null;
    }
    
    /**
     * Fungsi untuk membuat breadcrumb
     * 
     * @return string
     */
    public function breadcrumb()
    {
        $ret = '';
        $first = true;
        $i = 0;
        $n = count($this->links);
        if ($this->links) foreach ($this->links as $key => $value) {
            $i++;
            if ($first) {
                $first = false;
            } else {
                $ret .= ' &raquo; ';
            }
            if ($i == $n) {
                $ret .= '<span id="current">' . $key . '</span>';
            } else {
                $ret .= '<a href="' . $value . '">' . $key . '</a>';
            }
        }
        return $ret;
    }
}