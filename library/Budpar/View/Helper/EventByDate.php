<?php
/**
 * People Helper
 * 
 * Digunakan sebagai helper untuk
 * membuat string menjadi format Url
 * sehingga lebih enak dibaca
 * contoh: Nangroe Aceh Darussalam => nangroe-aceh-darussalam
 * @author Budi Irawan (deerawan@gmail.com)
 * @package user helper
 */
class Zend_View_Helper_EventByDate {
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
    
    public function eventByDate($eventDescDb, $date, $languageId)
    {
        $dateStart = $date." 23:59:59";
        $events = $eventDescDb->getEventsInDay($dateStart, $date, $languageId);
       
        return $events;
    }
}

