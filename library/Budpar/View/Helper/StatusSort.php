<?php

/**
 * Zend_View_Helper_StatusSort
 * 
 * Helper untuk menambahkan gambar turun/naik di tabel yang 
 * menandakan sorting berdasarkan apa
 * 
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Budpar_View_Helper_StatusSort extends Zend_View_Helper_Abstract
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
     * Fungsi utama
     *
     * @param string $status status sorting
     *
     * @return string html
     */
    function statusSort($status)
    {
        $html = '';
        if($status == 'desc') {
            $html = '<span class="turun"></span>';
        }
        else if($status == 'asc') {
            $html = '<span class="naik"></span>';
        }
        
        return $html;
    }
}