<?php

/**
 * Budpar_View_Helper_FlashMessage
 * 
 * Helper yang memeriksa tipe flash message dan mengembalikan class css yang 
 * bersesuaian dengan tipe flash message ke viewer.
 * Tipe 1: Success -> Warna hijau
 * Tipe 2: Error -> Warna Merah
 * Tipe 3: Warning -> Warna Kuning
 * Other: 'Mengamankan' flash message yang belum dikategorikan 1, 2, atau 3
 *        dianggap Info -> Warna Biru
 *        (Harus segera diganti menjadi tipe 1, 2, atau 3)
 *
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Budpar_View_Helper_FlashMessage extends Zend_View_Helper_Abstract
{   
    public function flashMessage($string)
    {
        $part = explode("\\", $string);
        if ($part[0] == '1') {
            $message = "<p class='msg-ok'>" . $part[1] . "</p>";
        } else if ($part[0] == '2') {
            $message = "<p class='msg-error'>" . $part[1] . "</p>";
        } else if ($part[0] == '3') {
            $message = "<p class='msg-atten'>" . $part[1] . "</p>";
        } else {
            $message = "<p class='msg-info'>" . $part[0] . "</p>";
        }
        return $message;
    }
}