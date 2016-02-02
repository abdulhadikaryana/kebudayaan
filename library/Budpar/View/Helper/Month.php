<?php
/**
 * Budpar_View_Helper_Month
 * mengembalikan nama bulan berdasarkan indeks bulan
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 *
 */
class Budpar_View_Helper_Month extends Zend_View_Helper_Abstract
{
    
    
    public function month($value,$lang_id) 
    {
        if($lang_id == 1)
        {
            switch($value)
            {
                case 1 : $nama_bulan = "January"; break;
                case 2 : $nama_bulan = "February"; break;
                case 3 : $nama_bulan = "March"; break;
                case 4 : $nama_bulan = "April"; break;
                case 5 : $nama_bulan = "May"; break;
                case 6 : $nama_bulan = "June"; break;
                case 7 : $nama_bulan = "July"; break;
                case 8 : $nama_bulan = "August"; break;
                case 9 : $nama_bulan = "September"; break;
                case 10 : $nama_bulan = "October"; break;
                case 11 : $nama_bulan = "November"; break;
                default : $nama_bulan = "December"; break;
            }            
        }
        else
        {
            switch($value)
            {
                case 1 : $nama_bulan = "Januari"; break;
                case 2 : $nama_bulan = "Februari"; break;
                case 3 : $nama_bulan = "Maret"; break;
                case 4 : $nama_bulan = "April"; break;
                case 5 : $nama_bulan = "Mei"; break;
                case 6 : $nama_bulan = "Juni"; break;
                case 7 : $nama_bulan = "Juli"; break;
                case 8 : $nama_bulan = "Agustus"; break;
                case 9 : $nama_bulan = "September"; break;
                case 10 : $nama_bulan = "Oktober"; break;
                case 11 : $nama_bulan = "November"; break;
                default : $nama_bulan = "Desember"; break;
            }            
        }

        
        return $nama_bulan;
    }
}