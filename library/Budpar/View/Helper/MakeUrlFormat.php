<?php
/**
 * Budpar_View_Helper_MakeUrlFormat
 *
 * Helper untuk membuat string menjadi format Url
 * sehingga lebih enak dibaca
 * contoh: Nangroe Aceh Darussalam => nangroe-aceh-darussalam
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Budpar_View_Helper_MakeUrlFormat
{
    /**
     * view untuk Zend
     * @var object
     */
    public $view;
    
    /**
     * Fungsi untuk menge-set view dari Zend
     * @param Zend_View_Interface $view
     */
    public function setView(Zend_View_Interface $view) {
        $this->view = $view;
    }
    
    /**
     * Fungsi untuk membuat format Url
     * @param string $string
     * @return string
     */
    public function makeUrlFormat($string)
    {
        $string = $this->view->HtmlDecode($string);
        $string = strtolower($string);
    
        $pattern[1] = "/\s/"; // karakter spasi
        $pattern[2] = "/[^A-Za-z0-9]/"; //karakter bukan huruf dan angka
        $pattern[3] = "/-+-/"; // dua karakter "-" berurutan
        $pattern[4] = "/-$/"; // karakter "-" yg terletak di belakang kalimat

        $replace[1] = "-";
        $replace[2] = "-";
        $replace[3] = "-";
        $replace[4] = "";

        $result = preg_replace($pattern, $replace, $string);
        
        return trim($result);
    }
}

