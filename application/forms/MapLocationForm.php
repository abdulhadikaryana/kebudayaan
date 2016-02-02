<?php
/**
 * Form_MapLocationForm
 *
 * Form untuk memilih lokasi di halaman map
 *
 * @package Form
 * @copyright Copyright (c) 2010 Sangkuriang Studio
 * @author Sangkuriang Studio <www.sangkuriangstudio.com>
 */
class Form_MapLocationForm extends Budpar_Form_Common
{
    /**
     * Fungsi inisialisasi form
     */
    public function init()
    {
        parent::init();
        $langId = Zend_Registry::get('languageId');
        if($langId == 2){
            $textisland = 'Island';
            $textprov= 'Province';
            $textseeloc = 'See Location';
            $textselisl = 'Select Island';
        }
        else{
            $textisland = 'Pulau';
            $textprov= 'Provinsi';
            $textseeloc = 'Lihat Lokasi';
            $textselisl = 'Pilih Pulau';
        }
        // Form Attribute
        $this->setMethod('post');
        $this->addAttribs(array(
            'id' => 'mapLocationForm',
            'action' => '',
            'accept-charset' => 'utf-8',
        ));

        // -> Island
        $areaDb = new Model_DbTable_Area;
        $islandData = $areaDb->getAllAreaChildByParent(0,$textselisl);
        
        $island = $this->createElement('select', 'island');
        $island->setLabel($textisland)
               ->setMultiOptions($islandData)
               ->setDecorators($this->elementDecorators);
        $this->addElement($island);

        // -> Province
        $province = $this->createElement('select', 'province');
        $province->setLabel($textprov)
                 ->setDecorators(
                        array(
                            'ViewHelper',
                            'Errors',
                            array(array('data' => 'HtmlTag'), array('tag' => 'td', 'id' => 'subarea')),
                            array('Label', array('tag' => 'td')),
                            array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
                        )
                   );
        $this->addElement($province);

        // -> Submit
        $submit = $this->createElement('submit', 'submitarea');
        $submit->setLabel($textseeloc)
               ->setDecorators($this->buttonDecorators);
        $submit->setAttrib('class', 'button button-grey');
        $this->addElement($submit);
    }

    /**
     * Fungsi untuk load default decorator
     */
    public function loadDefaultDecorators()
    {
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
            'Form',
        ));
    }
}

