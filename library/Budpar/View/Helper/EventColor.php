<?php

/**
 * Helper untuk mengembalikan warna HEX yang nantinya digunakan
 * di teks grid calendar
 *
 */
class Budpar_View_Helper_EventColor
{
    function eventColor($kategori) {
        
        $hexColor = '';
        if($kategori == 1)
        {
            // biru tua
            $hexColor = "#336699";
        }
        else if($kategori == 2)
        {
            // hijau
            $hexColor = "#329262";
        }
        else if($kategori == 3)
        {
            // kuning emas
            $hexColor = "#A78905";
        }
        else if($kategori == 4)
        {
            // merah
            $hexColor = "#CC3333";
        }
        else if($kategori == 5)
        {
            // jingga
            $hexColor = "#DD5511";
        }
        else if($kategori == 6)
        {
            // ungu
            $hexColor = "#6633CC";
        }
        else if($kategori == 7)
        {
            // abu-abu
            $hexColor = "#627487";
        }
        
        return $hexColor;
    }
}