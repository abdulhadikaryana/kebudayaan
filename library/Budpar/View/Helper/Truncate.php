<?php
/**
 * Budpar_View_Helper_Truncate
 *
 * Helper untuk mengambil sebagian content (truncate) dan juga
 * melakukan pembersihan content yang diambil dari tag2 HTML
 *
 * @package View Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Budpar_View_Helper_Truncate extends Zend_Controller_Action_Helper_Abstract
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
     * Fungsi truncate
     *
     * @param string $fullcontent
     * @param integer $character batasan karakter yg mau di-truncate
     *
     * @return string hasil yang sudah di-truncate
     */
    public function truncate($fullcontent, $character = 85)
    {
        $custom = new Budpar_Custom_Common;

        return $custom->truncate($fullcontent, $character);
    }
}
