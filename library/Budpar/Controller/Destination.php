<?php
/**
 * Budpar_Controller_Destination
 *
 * Merupakan parent class
 *
 * @package Budpar Library
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */

class Budpar_Controller_Destination extends Budpar_Controller_Common
{
    protected $_destId;
    protected $_destTitle;
    protected $_formatDestTitle;
    protected $_isSpecialDestination;
    protected $_rate;

    /**
     * Fungsi inisialisasi
     */
    public function init()
    {
        parent::init();

        // Set layout
        $this->_helper->layout->setLayout('three-column');

        // Generate inisialisasi
        // Untuk handling search action destinasi digunakan if
        if($this->_hasParam('destId'))
        {

            $this->_generateCommon();

            if( ! $this->_request->isXmlHttpRequest())
            {                
                $this->_generateHeaderImage();
                // Use header image
                $this->view->useHeaderImage = false;
            }
        }

    }

    protected function _generateCommon()
    {
        // Param set variable
        $this->_destId = $this->_getParam('destId');

        // Model
        $destDb = new Model_DbTable_Destination;
        $destDescDb = new Model_DbTable_DestinationDescription;
        $areaToPoiDb = new Model_DbTable_AreaToPoi;

        $lang = $this->_languageId;
        if($lang==1)
        {
            $destination = $destDb->getAllByIdLang($this->_destId,
                    $this->_languageId);
        }else
        {
            $destination = $destDb->getAllByIdLangForIndo($this->_destId,
                    $this->_languageId);
        }
        if($this->_sess->userId)
        {
            $this->view->rate = $this->_rate;
        }
        //$destProvince = $areaToPoiDb->getProvinceByPoiId($this->_destId);
        $nameDest =  $destDescDb->getNameById($this->_destId, $this->_languageId);
        $taglineDest = $destDescDb->getTaglineById2($this->_destId, $this->_languageId);

        if($taglineDest!=null){
            $nameDestfull = $nameDest ." : ". $taglineDest;
        }
        else{
            $nameDestfull = $nameDest ; 
        }

        // - Set protected value variables
        $this->_destTitle = $destDescDb->getNameById($this->_destId, $this->_languageId);
        $this->_formatDestTitle = $this->view->makeUrlFormat($this->_destTitle);

        // View
        $this->view->destination = $destination;
        $this->view->destId = $this->_destId;
        $this->view->destTitle = $nameDestfull;
        $this->view->formatDestTitle = $this->_formatDestTitle;

    }

    /**
     * Fungsi untuk menentukan header image destinasi
     */
    protected function _generateHeaderImage()
    {
        // Param
        $destId = $this->_getParam('destId');

        // Model
        $destinationDb = new Model_DbTable_Destination;

        // Check jika spesial destinasi
        $this->_isSpecialDestination = $destinationDb->checkSpecialDestination($destId);
        $this->view->specialDestination = $this->_isSpecialDestination;
        if( ! $this->_isSpecialDestination)
        {
            $destinationModel = new Model_Destination;
            if($this->_languageId==2){
                $destHeaderImage = $destinationModel->getHeaderSmallIndo();
            }else{
            $destHeaderImage = $destinationModel->getHeaderSmall();
            }
            $this->view->destHeaderImage = $destHeaderImage;
            
        }
        
    }

    /**
     * Fungsi untuk generate breadcrumb destinasi
     * Menggunakan ini karena tidak efisien jika menggunakan method
     * generateBreadrumb dari parent
     *
     * @param string $pageTitle judul dari halaman yang sedang diakses
     */
    protected function _generateDescBreadcrumb($pageTitle, $languageID = null)
    {
    	if($languageID == null)
    	{
    		$languageID = $this->_languageId;
    	}
    	
        $homeLabel = $this->view->translate('id_menu_home',$languageID);
        $links = array(
                $homeLabel => $this->view->baseUrl('/'),
                $this->_destTitle =>
                $this->view->baseUrl('/destination/' . $this->_destId . '/' .
                $this->_formatDestTitle),
                $pageTitle => '',
        );

        Zend_Registry::set('breadcrumb', $links);
    }
    
    protected function disableView()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
    }

}