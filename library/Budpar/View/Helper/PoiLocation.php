<?php
/**
 * Budpar_View_Helper_PoiLocation
 * 
 * Digunakan sebagai helper untuk
 * mendapatkan area-area dari suatu poi
 * 
 * @package Helper
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Budpar_View_Helper_PoiLocation 
    extends Zend_Controller_Action_Helper_Abstract
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
     * Fungsi untuk mendapatkan area-area dari suatu poi
     *
     * @param object $area object DB kelas area
     * @param integer $poiId id dari poi yg ingin dilihat areanya
     * 
     * @return string lokasi area
     */
    public function poiLocation($areaDb, $poiId)
    {
        // query ke db
        $result = $areaDb->getAllAreaByPoiId($poiId, Zend_Registry::get('languageId'));
        
        // inisialiasi string pesan untuk tiap jenis area
        $islandMsg = "";
        $provinceMsg = "";
        $cityMsg = "";
        
        // looping
        foreach($result as $area) {
            // jika tipenya island
            if($area['area_type'] == 0){
                $islandMsg .= $this->addAndCheckIfEmpty($islandMsg, $area['name']);
            }else if($area['area_type'] == 1){ // jika tipenya adalah provinsi
                $provinceMsg .= $this->addAndCheckIfEmpty($provinceMsg, $area['name']);
            }else if($area['area_type'] == 2){ // jika tipenya adalah kota/kabupaten
                $cityMsg .= $this->addAndCheckIfEmpty($cityMsg, $area['name']);
            }   
        }
        $langId = Zend_Registry::get('languageId');
        if($langId==1){
        $html = '<h3>Lokasi</h3>';
        }else{
            $html = '<h3>Location</h3><p>';
        }
        if ( ! empty($islandMsg)) {
            $html .= $islandMsg;
        }

        if ( ! empty($provinceMsg)) {
            $html .= ' &raquo; ' . $provinceMsg;
        }

        if ( ! empty($cityMsg)) {
            $html .= ' &raquo; ' . $cityMsg . '</p>';
        }

    	return $html;
    }
    
    
    /**
     * Fungsi untuk memformat string tampilan area apakah ada lebih dari satu area 
     * untuk satu tipe (island/provinsi/kota)
     * 
     * Misalkan poiId 34 memiliki area kota ada dua maka bentuknya akan menjadi
     * "jakarta selatan, jakarta barat" (ada komanya)
     *
     * @param $input string message
     * @param $areaName string nama area
     */
    private function addAndCheckIfEmpty($input, $areaName)
    {
        // jika inputnya kosong berarti blum ada area
        // maka ditambahin
        if(empty($input))
            $input = $areaName;
        else // jika tidak kosong, artinya dia punya lebih dari satu area
            $input = ", ".$areaName;
            
        return $input;
    }
}

