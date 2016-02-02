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
class Form_MapCategoryForm extends Budpar_Form_Common
{
    /**
     * Fungsi inisialisasi form
     */
    public function init()
    {
        parent::init();
        $langId = Zend_Registry::get('languageId');
        if($langId == 2){
            $textisland = 'Category';            
            $textseeloc = 'See Location';
            $textselisl = 'Select Category';
        }
        else{
            $textisland = 'Kategori';            
            $textseeloc = 'Lihat Lokasi';
            $textselisl = 'Pilih Kategori';
        }
        // Form Attribute
        $this->setMethod('post');
        $this->addAttribs(array(
            'id' => 'mapLocationForm',
            'action' => '',
            'accept-charset' => 'utf-8',
        ));

        // -> Island
        $categoryDb = new Model_DbTable_Category;
        $data = $categoryDb->getAllCategoryIdNameByLangIdForSelect($this->_languageId, $textselisl);
        
        $category = $this->createElement('select', 'category');
        $category->setLabel($textisland)
               ->setMultiOptions($data)
               ->setDecorators($this->elementDecorators);
        $this->addElement($category);
      
        // -> Submit
        $submit = $this->createElement('submit', 'submitcategory');
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

