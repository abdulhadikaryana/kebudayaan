<?php
/**
 * Zend_View_Helper_NewsMeta
 *
 * Helper untuk menampilkan meta dari news
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Zend_View_Helper_NewsMeta extends Zend_Controller_Action_Helper_Abstract
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

    /**
     * Fungsi metaNews
     *
     * @param string $publishDate tanggal news dibuat
     *
     * @return string html untuk meta
     */
    public function newsMeta($publishDate, $customMsg = 'Posted on ')
    {
        $langId = Zend_Registry::get('languageId');
        if($langId==1){
                $customMsg= 'Ditulis ';
            }else{                
                $customMsg = 'Posted on ' ;
            }
        $html = $customMsg .
                    $this->view->dateConverter($publishDate, 'tanggal-waktu');

        return $html;
    }
}