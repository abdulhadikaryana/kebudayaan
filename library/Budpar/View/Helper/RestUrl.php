<?php
/**
 * Budpar_View_Helper_RestUrl
 *
 * Helper untuk mendapatkan url setelah root url dan bahasa
 * 
 * Contoh jika url-nya saat ini 'http://localhost/budpar2010/public/en/news/index'
 * maka hasil dari helper ini adalah 'news/index'
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Budpar_View_Helper_RestUrl extends Zend_View_Helper_Abstract
{
    /**
     * Variabel view Zend
     * @var Zend_View_Interface
     */
    public $view;

    /**
     * Fungsi untuk mengeset view
     *
     * @param Zend_View_Interface $view
     */
    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }
    
    public function restUrl()
    {
        // Mendapatkan url sekarang
        //$currentUrl = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
        $currentUrl = "http://".$_SERVER['HTTP_HOST'].Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();

        // Explode dengan root url untuk mendapatkan url setelah root url
        $url = explode ($this->view->rootUrl(), $currentUrl);

        // Jika ada isinya
        if(count($url) > 1)
        {
            if(strlen($url[1]) > 0) {
                // 3 untuk jumlah karakter language di url
                // seperti '/en', '/fr' jadi kita ambil setelahnya
                $url = substr($url[1], 3);
            } else {
                $url = '';
            }
        }
        else
        {
            $url = '';
        }

        return $url;


    }
}