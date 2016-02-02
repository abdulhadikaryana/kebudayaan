<?php
/**
 * Zend_View_Helper_DateConverter
 *
 * Helper untuk melakukan formatting tanggal dan waktu
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Zend_View_Helper_DateConverter extends Zend_Controller_Action_Helper_Abstract
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
     * Fungsi dateConverter
     *
     * @param string $date tanggal yang mau diformat
     * @param integer $format jenis format yang mau dilakukan
     *
     * @return string tanggal yang sudah diformat
     */
    public function dateConverter($date, $format = "tanggal")
    {
        $translate = Zend_Registry::get('Zend_Translate');
        $langId = Zend_Registry::get('languageId');
        if ($format == 'tanggal-waktu') {
            if($langId==1){
                $at= 'pukul';
            }else{                
                $at = 'at';
            }
            //$rule = 'j M Y \a\t H:i';
            $ruleTgl = 'j M Y ';
            $ruleJam = ' H:i';
            $newFormat1 = date($ruleTgl, strtotime($date));
            $newFormat2 = date($ruleJam, strtotime($date));
            return $newFormat1 . strtolower($at) . $newFormat2;
        } elseif ($format == 'waktu') {
            $rule = 'H:i';
        } else {
            $rule = 'j M Y';
        }
        $newFormat = date($rule, strtotime($date));
        return $newFormat;
    }
}