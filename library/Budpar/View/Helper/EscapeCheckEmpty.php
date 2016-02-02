<?php
/**
 * Budpar_View_Helper_EscapeCheckEmpty
 *
 * Helper untuk melakukan escape character dengan fungsi built dari Zend serta
 * melakukan pengecekan variabel kosong apa tidak. Jika kosong, gantikan dengan
 * '-'
 *
 * @package View Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Budpar_View_Helper_EscapeCheckEmpty
    extends Zend_Controller_Action_Helper_Abstract
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
     * Fungsi escapeCheckEmpty
     *
     * @param string $date tanggal yang mau diformat
     * @param integer $format jenis format yang mau dilakukan
     *
     * @return string tanggal yang sudah diformat
     */
    public function escapeCheckEmpty($input)
    {
        $output = '';

        if(empty($input))
            $output = '-';
        else
            $output = $this->view->escape($input);

        return $output;
    }
}