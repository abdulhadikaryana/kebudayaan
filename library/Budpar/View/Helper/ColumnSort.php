<?php

/**
 * Zend_View_Helper_ColumnSort
 * 
 * Helper untuk membuat kolom biasa jadi bisa disorting dengan menambahkan gambar
 * dan membuat title-nya menjadi link
 * 
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Budpar_View_Helper_ColumnSort extends Zend_View_Helper_Abstract
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
     * Fungsi utama untuk sorting
     *
     * @param array $sorter komponen sorting
     * @param array $options settingan sorting
     *
     * @return string 
     */
    function columnSort($sorter, $options) {
        
        $html = '';

        // Menampilkan nama kolom
        $html .= '<a href="' . $this->view->url($sorter) . '#firstsection' . '">';
        $html .= $options['title'];
        $html .= '</a>';

        // Menampilkan gambar sorting
        if($sorter['sortby'] == $options['param']) {
            $html .= '<span class="img-sort">' .
                            $this->view->statusSort($sorter['sortorder']) .
                     '</span>';
        }

        return $html;
    }
}